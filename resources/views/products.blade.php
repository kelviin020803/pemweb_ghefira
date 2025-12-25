@extends('layout')

@section('title', 'Produk - GlamStyle Fashion')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold mb-4 bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">Koleksi Kami</h1>
        <p class="text-gray-600">Temukan fashion premium untuk gaya hidup kamu</p>
    </div>

    <!-- Product Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
        @forelse($products as $product)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-xl">
                @if($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}"
                         alt="{{ $product->name }}"
                         class="h-64 w-full object-cover">
                @else
                    <div class="h-64 bg-gradient-to-br from-pink-200 to-purple-200 flex items-center justify-center">
                        <span class="text-5xl font-bold text-white">{{ substr($product->name, 0, 1) }}</span>
                    </div>
                @endif
                <div class="p-6">
                    <div class="flex justify-between items-start mb-2">
                        <span class="text-xs font-semibold text-pink-600 uppercase">{{ $product->brand }}</span>
                        <span class="text-xs px-2 py-1 bg-pink-100 rounded-full text-pink-600">{{ $product->category }}</span>
                    </div>
                    <h3 class="font-bold text-lg mb-2 text-gray-800 line-clamp-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                    <div class="flex justify-between items-center mb-4">
                        <span class="text-xl font-bold text-pink-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="text-sm {{ $product->stock > 0 ? 'text-green-600' : 'text-red-600' }} font-semibold">
                            {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Habis' }}
                        </span>
                    </div>
                    @if($product->stock > 0)
                        @auth
                            <a href="{{ route('user.checkout', $product) }}"
                               class="block w-full bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 text-white px-4 py-2 rounded-lg transition font-semibold text-center">
                                Beli Sekarang
                            </a>
                        @else
                            <a href="{{ route('login') }}"
                               class="block w-full bg-gradient-to-r from-pink-600 to-purple-600 hover:from-pink-700 hover:to-purple-700 text-white px-4 py-2 rounded-lg transition font-semibold text-center">
                                Login untuk Beli
                            </a>
                        @endauth
                    @else
                        <button disabled class="w-full bg-gray-400 text-white px-4 py-2 rounded-lg font-semibold cursor-not-allowed">
                            Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">Belum Ada Produk</h3>
                <p class="text-gray-500">Produk segera hadir!</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
