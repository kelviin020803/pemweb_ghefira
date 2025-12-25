@extends('admin.layout')

@section('title', 'Edit Produk')
@section('header', 'Edit Produk: ' . $product->name)

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brand *</label>
                        <input type="text" name="brand" value="{{ old('brand', $product->brand) }}" required
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
                        <select name="category" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500">
                            <option value="Shoes" {{ old('category', $product->category) == 'Shoes' ? 'selected' : '' }}>Shoes</option>
                            <option value="Hoodie" {{ old('category', $product->category) == 'Hoodie' ? 'selected' : '' }}>Hoodie</option>
                            <option value="T-Shirt" {{ old('category', $product->category) == 'T-Shirt' ? 'selected' : '' }}>T-Shirt</option>
                            <option value="Jacket" {{ old('category', $product->category) == 'Jacket' ? 'selected' : '' }}>Jacket</option>
                            <option value="Pants" {{ old('category', $product->category) == 'Pants' ? 'selected' : '' }}>Pants</option>
                            <option value="Accessories" {{ old('category', $product->category) == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) *</label>
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required min="0"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok *</label>
                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required min="0"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500">{{ old('description', $product->description) }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                    @if($product->image_path)
                        <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                            <img src="{{ asset('storage/' . $product->image_path) }}" class="w-40 h-40 object-cover rounded-lg mb-2">
                            <p class="text-sm text-gray-500 mb-2">Gambar saat ini</p>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="remove_image" value="1" class="rounded border-gray-300 text-pink-600 focus:ring-pink-500">
                                <span class="ml-2 text-sm text-red-600">Hapus gambar ini</span>
                            </label>
                        </div>
                    @endif
                    <input type="file" name="image" accept="image/*"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500">
                    <p class="text-sm text-gray-500 mt-1">Upload gambar baru (kosongkan jika tidak ingin mengubah)</p>
                </div>
            </div>

            <div class="flex items-center space-x-4 mt-8">
                <button type="submit" class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 font-medium">
                    Update Produk
                </button>
                <a href="{{ route('admin.products') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
