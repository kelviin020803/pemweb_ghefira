<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show', 'byCategory']]);
    }

    // ===============================
    // GET ALL PRODUCTS (PUBLIC)
    // ===============================
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 12);

        $products = Product::latest()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('brand', 'like', "%{$search}%");
            })
            ->paginate($perPage);

        return response()->json($products);
    }

    // ===============================
    // GET PRODUCT BY SLUG (PUBLIC)
    // ===============================
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    // ===============================
    // CREATE PRODUCT
    // ===============================
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'brand' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Product::create([
            'brand' => $request->brand,
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image_path' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Product berhasil ditambahkan',
            'data' => $product
        ], 201);
    }

    // ===============================
    // UPDATE PRODUCT (REPLACE DATA)
    // ===============================
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'brand' => 'sometimes|string|max:255',
            'name' => 'sometimes|string|max:255',
            'category' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'description' => 'sometimes|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }

            $product->image_path = $request->file('image')->store('products', 'public');
        }

        $product->update($request->only([
            'brand',
            'name',
            'category',
            'price',
            'stock',
            'description',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Product berhasil diupdate',
            'data' => $product->fresh()
        ]);
    }

    // ===============================
    // ✅ ADD STOCK (INI YANG KAMU BUTUH)
    // ===============================
    public function addStock(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'stock' => 'required|integer|min:1'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $product = Product::findOrFail($id);

        // TAMBAH STOCK, BUKAN REPLACE
        $product->increment('stock', $request->stock);

        return response()->json([
            'success' => true,
            'message' => 'Stock berhasil ditambahkan',
            'current_stock' => $product->stock
        ]);
    }

    // ===============================
    // DELETE PRODUCT
    // ===============================
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'Product berhasil dihapus'
        ]);
    }

    // ===============================
    // BY CATEGORY (PUBLIC)
    // ===============================
    public function byCategory($category)
    {
        $products = Product::where('category', $category)
            ->where('stock', '>', 0)
            ->latest()
            ->paginate(12);

        return response()->json($products);
    }
}
