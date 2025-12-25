<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
    // User Dashboard / Profile
    public function dashboard()
    {
        $user = Auth::user();
        $orders = Order::where('user_id', $user->id)
            ->with('product')
            ->latest()
            ->paginate(10);

        $totalOrders = Order::where('user_id', $user->id)->count();
        $pendingOrders = Order::where('user_id', $user->id)->where('status', 'pending')->count();
        $completedOrders = Order::where('user_id', $user->id)->where('status', 'completed')->count();

        return view('user.dashboard', compact('user', 'orders', 'totalOrders', 'pendingOrders', 'completedOrders'));
    }

    // Order History
    public function orders(Request $request)
    {
        $query = Order::where('user_id', Auth::id())
            ->with('product');

        // Filter by status if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->latest()->paginate(10);

        return view('user.orders', compact('orders'));
    }

    // Order Detail
    public function showOrder(Order $order)
    {
        // Make sure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('product');
        return view('user.order-detail', compact('order'));
    }

    // Cancel Order (only if pending)
    public function cancelOrder(Order $order)
    {
        // Make sure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Only pending orders can be cancelled
        if ($order->status !== 'pending') {
            return redirect()->back()->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses.');
        }

        // Return stock
        $order->product->increment('stock', $order->quantity);

        // Update order status
        $order->update([
            'status' => 'cancelled',
            'admin_notes' => 'Dibatalkan oleh customer',
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan.');
    }

    // Checkout Page
    public function checkout(Product $product)
    {
        if ($product->stock <= 0) {
            return redirect()->back()->with('error', 'Produk tidak tersedia.');
        }

        return view('user.checkout', compact('product'));
    }

    // Process Order
    public function placeOrder(Request $request, Product $product)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $product->stock,
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email',
            'shipping_address' => 'required|string|min:10',
            'phone' => 'required|string|min:10',
        ]);

        // Check stock again
        if ($product->stock < $request->quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }

        // Create order
        $order = Order::create([
            'uuid' => Str::uuid(),
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'total_price' => $product->price * $request->quantity,
            'status' => 'pending',
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'shipping_address' => $request->shipping_address,
            'phone' => $request->phone,
        ]);

        // Reduce stock
        $product->decrement('stock', $request->quantity);

        // Redirect to success page with WhatsApp
        return redirect()->route('user.order.success', $order);
    }

    // Order Success Page
    public function orderSuccess(Order $order)
    {
        // Make sure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('product', 'user');
        return view('user.order-success', compact('order'));
    }

    // Generate WhatsApp Message and Redirect
    public function redirectToWhatsApp(Order $order)
    {
        // Make sure user owns this order
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $order->load('product', 'user');

        // Admin WhatsApp number
        $adminPhone = '6281230527933';

        // Build message
        $message = "🛒 *PESANAN BARU - GLAMSTYLE*\n\n";
        $message .= "📋 *Detail Pesanan:*\n";
        $message .= "Order ID: #{$order->uuid}\n";
        $message .= "Tanggal: " . $order->created_at->format('d M Y H:i') . "\n\n";

        $message .= "👤 *Data Customer:*\n";
        $message .= "Nama: {$order->customer_name}\n";
        $message .= "Email: {$order->customer_email}\n";
        $message .= "No. HP: {$order->phone}\n";
        $message .= "Alamat: {$order->shipping_address}\n\n";

        $message .= "📦 *Produk:*\n";
        $message .= "Nama: {$order->product->name}\n";
        $message .= "Brand: {$order->product->brand}\n";
        $message .= "Jumlah: {$order->quantity} pcs\n";
        $message .= "Harga: Rp " . number_format($order->product->price, 0, ',', '.') . "\n";
        $message .= "*Total: Rp " . number_format($order->total_price, 0, ',', '.') . "*\n\n";

        $message .= "💳 *Silakan transfer ke:*\n";
        $message .= "Bank BNI: 03983692279\n";
        $message .= "A/N: Ghefira S\n\n";

        $message .= "📸 Setelah transfer, mohon kirim bukti pembayaran ke chat ini.\n\n";
        $message .= "Terima kasih telah berbelanja! 🙏";

        // URL encode message
        $encodedMessage = urlencode($message);

        // WhatsApp URL
        $waUrl = "https://wa.me/{$adminPhone}?text={$encodedMessage}";

        return redirect($waUrl);
    }
}
