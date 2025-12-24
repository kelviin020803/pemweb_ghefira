<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $orders = Order::with(['user', 'product'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return response()->json($orders);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'shipping_address' => 'required|string',
            'phone' => 'required|string',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check stock
        if ($product->stock < $request->quantity) {
            return response()->json([
                'error' => 'Insufficient stock. Available: ' . $product->stock
            ], 400);
        }

        try {
            DB::beginTransaction();

            $totalPrice = $product->price * $request->quantity;

            $order = Order::create([
                'user_id' => auth()->id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'total_price' => $totalPrice,
                'shipping_address' => $request->shipping_address,
                'phone' => $request->phone,
            ]);

            // PENTING: Reduce stock otomatis!
            $product->decrement('stock', $request->quantity);

            DB::commit();

            return response()->json([
                'message' => 'Order created successfully',
                'order' => $order->load(['user', 'product'])
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create order'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        // If cancelled, return stock
        if ($request->status === 'cancelled' && $order->status !== 'cancelled') {
            $order->product->increment('stock', $order->quantity);
        }

        $order->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Order updated successfully',
            'order' => $order->load(['user', 'product'])
        ]);
    }

    public function destroy($id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        // Return stock if not completed
        if ($order->status !== 'completed') {
            $order->product->increment('stock', $order->quantity);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }
}
