@extends('layout')

@section('title', 'Riwayat Pesanan')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Pesanan</h1>
            <p class="text-gray-600">Lihat semua riwayat pembelian kamu</p>
        </div>
        <a href="{{ route('user.dashboard') }}" class="text-pink-600 hover:text-pink-700">
            ← Kembali ke Dashboard
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-lg p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
            <select name="status" class="rounded-lg border-gray-300 focus:ring-pink-500 focus:border-pink-500">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
            <button type="submit" class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700">
                Filter
            </button>
            @if(request()->has('status'))
                <a href="{{ route('user.orders') }}" class="text-gray-600 hover:text-gray-800 py-2">
                    Reset Filter
                </a>
            @endif
        </form>
    </div>

    <!-- Orders List -->
    <div class="space-y-4">
        @forelse($orders as $order)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <div class="p-6">
                    <div class="flex flex-wrap justify-between items-start gap-4">
                        <!-- Order Info -->
                        <div class="flex items-center gap-4">
                            @if($order->product->image_path)
                                <img src="{{ asset('storage/' . $order->product->image_path) }}"
                                     alt="{{ $order->product->name }}"
                                     class="w-20 h-20 object-cover rounded-lg">
                            @else
                                <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-gray-400 text-2xl">📦</span>
                                </div>
                            @endif
                            <div>
                                <p class="font-mono text-sm text-pink-600">#{{ substr($order->uuid, 0, 8) }}</p>
                                <h3 class="font-semibold text-gray-800">{{ $order->product->name }}</h3>
                                <p class="text-sm text-gray-500">{{ $order->quantity }} x Rp {{ number_format($order->product->price, 0, ',', '.') }}</p>
                            </div>
                        </div>

                        <!-- Price & Status -->
                        <div class="text-right">
                            <p class="text-xl font-bold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                            @php
                                $statusColors = [
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                ];
                                $statusLabels = [
                                    'pending' => 'Menunggu Konfirmasi',
                                    'processing' => 'Sedang Diproses',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ];
                            @endphp
                            <span class="inline-block mt-2 px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$order->status] }}">
                                {{ $statusLabels[$order->status] }}
                            </span>
                        </div>
                    </div>

                    <!-- Order Details -->
                    <div class="mt-4 pt-4 border-t flex flex-wrap justify-between items-center gap-4">
                        <div class="text-sm text-gray-500">
                            <p>Dipesan: {{ $order->created_at->format('d M Y, H:i') }}</p>
                            @if($order->confirmed_at)
                                <p>Dikonfirmasi: {{ $order->confirmed_at->format('d M Y, H:i') }}</p>
                            @endif
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('user.orders.show', $order) }}"
                               class="bg-pink-600 text-white px-4 py-2 rounded-lg hover:bg-pink-700 transition">
                                Lihat Detail
                            </a>
                            @if($order->status == 'pending')
                                <form action="{{ route('user.orders.cancel', $order) }}" method="POST"
                                      onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-red-100 text-red-700 px-4 py-2 rounded-lg hover:bg-red-200 transition">
                                        Batalkan
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">📦</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">Belum Ada Pesanan</h3>
                <p class="text-gray-500 mb-4">Kamu belum pernah melakukan pemesanan</p>
                <a href="{{ route('products') }}" class="inline-block bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 transition">
                    Mulai Belanja
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $orders->links() }}
    </div>
</div>
@endsection
