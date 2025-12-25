<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    // Dashboard Admin
    public function dashboard()
    {
        $totalOrders = Order::count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $completedOrders = Order::where('status', 'completed')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $totalProducts = Product::count();
        $totalUsers = User::where('role', 'user')->count();

        $recentOrders = Order::with(['user', 'product'])
            ->latest()
            ->take(10)
            ->get();

        $lowStockProducts = Product::where('stock', '<=', 5)->get();

        return view('admin.dashboard', compact(
            'totalOrders',
            'pendingOrders',
            'completedOrders',
            'totalRevenue',
            'totalProducts',
            'totalUsers',
            'recentOrders',
            'lowStockProducts'
        ));
    }

    // ==================== ORDERS ====================

    public function orders(Request $request)
    {
        $query = Order::with(['user', 'product']);

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('uuid', 'like', "%{$search}%")
                  ->orWhereHas('user', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%");
                  })
                  ->orWhereHas('product', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $orders = $query->latest()->paginate(15);

        return view('admin.orders.index', compact('orders'));
    }

    public function showOrder(Order $order)
    {
        $order->load(['user', 'product']);
        return view('admin.orders.show', compact('order'));
    }

    public function confirmOrder(Request $request, Order $order)
    {
        $order->update([
            'status' => 'processing',
            'admin_notes' => $request->admin_notes,
            'confirmed_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dikonfirmasi!');
    }

    public function completeOrder(Order $order)
    {
        $order->update([
            'status' => 'completed',
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil diselesaikan!');
    }

    public function cancelOrder(Request $request, Order $order)
    {
        // Return stock
        $order->product->increment('stock', $order->quantity);

        $order->update([
            'status' => 'cancelled',
            'admin_notes' => $request->admin_notes ?? 'Dibatalkan oleh admin',
        ]);

        return redirect()->back()->with('success', 'Pesanan berhasil dibatalkan dan stok dikembalikan.');
    }

    // ==================== PRODUCTS ====================

    public function products()
    {
        $products = Product::latest()->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        return view('admin.products.create');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'brand', 'category', 'price', 'stock', 'description']);
        $data['slug'] = Str::slug($request->name);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image_path'] = $imagePath;
        }

        Product::create($data);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function editProduct(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'brand', 'category', 'price', 'stock', 'description']);
        $data['slug'] = Str::slug($request->name);

        // Handle remove image checkbox
        if ($request->has('remove_image') && $product->image_path) {
            Storage::disk('public')->delete($product->image_path);
            $data['image_path'] = null;
        }

        // Handle new image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image_path'] = $imagePath;
        }

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Produk berhasil diupdate!');
    }

    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock' => 'required|integer|min:0',
        ]);

        $product->update(['stock' => $request->stock]);

        return redirect()->back()->with('success', 'Stok berhasil diupdate!');
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Produk berhasil dihapus!');
    }

    // ==================== USERS ====================

    public function users()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }
}
