@extends('admin.layout')

@section('title', 'Detail Pesanan')
@section('header', 'Detail Pesanan #' . substr($order->uuid, 0, 8))

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Order Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Informasi Pesanan</h3>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-500">Order ID</p>
                    <p class="font-mono font-semibold">{{ $order->uuid }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Tanggal Order</p>
                    <p class="font-semibold">{{ $order->created_at->format('d M Y H:i') }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Status</p>
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
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $statusColors[$order->status] }}">
                        {{ $statusLabels[$order->status] }}
                    </span>
                </div>
                @if($order->confirmed_at)
                <div>
                    <p class="text-sm text-gray-500">Dikonfirmasi Pada</p>
                    <p class="font-semibold">{{ $order->confirmed_at->format('d M Y H:i') }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Product Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Detail Produk</h3>
            <div class="flex items-center space-x-4 p-4 bg-gray-50 rounded-lg">
                <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                    @if($order->product->image_path)
                        <img src="{{ asset('storage/' . $order->product->image_path) }}" class="w-full h-full object-cover rounded-lg">
                    @else
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-lg">{{ $order->product->name }}</p>
                    <p class="text-gray-500">{{ $order->product->brand }} • {{ $order->product->category }}</p>
                    <p class="text-pink-600 font-semibold">Rp {{ number_format($order->product->price, 0, ',', '.') }} x {{ $order->quantity }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm text-gray-500">Total</p>
                    <p class="text-xl font-bold text-pink-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <!-- Customer Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Informasi Customer</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-500">Nama</span>
                    <span class="font-semibold">{{ $order->user->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Email</span>
                    <span class="font-semibold">{{ $order->user->email }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">No. HP</span>
                    <span class="font-semibold">{{ $order->phone }}</span>
                </div>
                <div>
                    <span class="text-gray-500">Alamat Pengiriman:</span>
                    <p class="font-semibold mt-1 p-3 bg-gray-50 rounded">{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>

        @if($order->admin_notes)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Catatan Admin</h3>
            <p class="text-gray-700">{{ $order->admin_notes }}</p>
        </div>
        @endif
    </div>

    <!-- Actions Sidebar -->
    <div class="space-y-6">
        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Aksi</h3>

            @if($order->status === 'pending')
                <!-- Confirm Order -->
                <form action="{{ route('admin.orders.confirm', $order) }}" method="POST" class="mb-4">
                    @csrf
                    @method('PATCH')
                    <div class="mb-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Catatan (opsional)</label>
                        <textarea name="admin_notes" rows="2" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500" placeholder="Catatan untuk customer..."></textarea>
                    </div>
                    <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                        ✓ Konfirmasi Pesanan
                    </button>
                </form>

                <!-- Cancel Order -->
                <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Stok akan dikembalikan.')">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="admin_notes" value="Dibatalkan oleh admin">
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                        ✗ Batalkan Pesanan
                    </button>
                </form>
            @elseif($order->status === 'processing')
                <form action="{{ route('admin.orders.complete', $order) }}" method="POST" class="mb-4">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium">
                        ✓ Selesaikan Pesanan
                    </button>
                </form>

                <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                        ✗ Batalkan Pesanan
                    </button>
                </form>
            @else
                <p class="text-gray-500 text-center py-4">
                    Pesanan sudah {{ $order->status === 'completed' ? 'selesai' : 'dibatalkan' }}
                </p>
            @endif
        </div>

        <!-- Contact Customer -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold mb-4">Hubungi Customer</h3>
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->phone) }}"
               target="_blank"
               class="flex items-center justify-center w-full px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 font-medium">
                <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                WhatsApp
            </a>
        </div>

        <!-- Back Button -->
        <a href="{{ route('admin.orders') }}" class="block text-center text-gray-600 hover:text-gray-800">
            ← Kembali ke Daftar Pesanan
        </a>
    </div>
</div>
@endsection
