@extends('admin.layout')

@section('title', 'Tambah Produk')
@section('header', 'Tambah Produk Baru')

@section('content')
<div class="max-w-2xl">
    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Produk *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 @error('name') border-red-500 @enderror"
                           placeholder="Contoh: Air Jordan 1 Retro High">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Brand *</label>
                        <input type="text" name="brand" value="{{ old('brand') }}" required
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500"
                               placeholder="Contoh: Nike">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kategori *</label>
                        <select name="category" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500">
                            <option value="">Pilih Kategori</option>
                            <option value="Shoes" {{ old('category') == 'Shoes' ? 'selected' : '' }}>Shoes</option>
                            <option value="Hoodie" {{ old('category') == 'Hoodie' ? 'selected' : '' }}>Hoodie</option>
                            <option value="T-Shirt" {{ old('category') == 'T-Shirt' ? 'selected' : '' }}>T-Shirt</option>
                            <option value="Jacket" {{ old('category') == 'Jacket' ? 'selected' : '' }}>Jacket</option>
                            <option value="Pants" {{ old('category') == 'Pants' ? 'selected' : '' }}>Pants</option>
                            <option value="Accessories" {{ old('category') == 'Accessories' ? 'selected' : '' }}>Accessories</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp) *</label>
                        <input type="number" name="price" value="{{ old('price') }}" required min="0"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500"
                               placeholder="Contoh: 2500000">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Stok *</label>
                        <input type="number" name="stock" value="{{ old('stock', 0) }}" required min="0"
                               class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500"
                               placeholder="Contoh: 10">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500"
                              placeholder="Deskripsi produk...">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Gambar Produk</label>
                    <input type="file" name="image" accept="image/*"
                           class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500">
                    <p class="text-sm text-gray-500 mt-1">Format: JPEG, PNG, JPG, GIF. Maks: 2MB</p>
                </div>
            </div>

            <div class="flex items-center space-x-4 mt-8">
                <button type="submit" class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 font-medium">
                    Simpan Produk
                </button>
                <a href="{{ route('admin.products') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
