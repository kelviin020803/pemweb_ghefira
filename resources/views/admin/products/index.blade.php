@extends('admin.layout')

@section('title', 'Kelola Produk')
@section('header', 'Kelola Produk')

@section('content')
<!-- Add Product Button -->
<div class="mb-6">
    <a href="{{ route('admin.products.create') }}" class="inline-flex items-center px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 font-medium">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Produk
    </a>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Brand</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Kategori</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Harga</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stok</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($products as $product)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gray-200 rounded-lg mr-3 flex items-center justify-center">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" class="w-full h-full object-cover rounded-lg">
                                @else
                                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                            </div>
                            <span class="font-medium">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $product->brand }}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-gray-100 rounded text-sm">{{ $product->category }}</span>
                    </td>
                    <td class="px-6 py-4 font-semibold">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        <form action="{{ route('admin.products.stock', $product) }}" method="POST" class="flex items-center space-x-2">
                            @csrf
                            @method('PATCH')
                            <input type="number" name="stock" value="{{ $product->stock }}"
                                   class="w-20 px-2 py-1 border rounded text-center {{ $product->stock <= 5 ? 'border-red-500 bg-red-50' : '' }}">
                            <button type="submit" class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 text-sm">
                                Update
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}"
                               class="text-blue-600 hover:text-blue-700 font-medium">
                                Edit
                            </a>
                            <form action="{{ route('admin.products.delete', $product) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700 font-medium">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        Belum ada produk
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="px-6 py-4 border-t">
        {{ $products->links() }}
    </div>
</div>
@endsection
