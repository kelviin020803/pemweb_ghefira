@extends('layout')

@section('title', 'Detail Pesanan')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8 flex justify-between items-center">
        <div>
            <a href="{{ route('user.orders') }}" class="text-pink-600 hover:text-pink-700 text-sm">← Kembali ke Riwayat</a>
            <h1 class="text-3xl font-bold text-gray-800 mt-2">Detail Pesanan</h1>
            <p class="text-gray-600">Order ID: <span class="font-mono text-pink-600">#{{ $order->uuid }}</span></p>
        </div>
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
        <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $statusColors[$order->status] }}">
            {{ $statusLabels[$order->status] }}
        </span>
    </div>

    <!-- Order Progress -->
    @if($order->status != 'cancelled')
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Status Pesanan</h3>
        <div class="relative">
            <div class="flex items-center justify-between">
                <!-- Step 1: Pending -->
                <div class="flex flex-col items-center relative z-10">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ in_array($order->status, ['pending', 'processing', 'completed']) ? 'bg-pink-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <span class="text-xs mt-2 text-center">Pesanan Dibuat</span>
                </div>

                <!-- Line 1 -->
                <div class="flex-1 h-1 mx-2 {{ in_array($order->status, ['processing', 'completed']) ? 'bg-pink-600' : 'bg-gray-200' }}"></div>

                <!-- Step 2: Processing -->
                <div class="flex flex-col items-center relative z-10">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ in_array($order->status, ['processing', 'completed']) ? 'bg-pink-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>
                    <span class="text-xs mt-2 text-center">Dikonfirmasi</span>
                </div>

                <!-- Line 2 -->
                <div class="flex-1 h-1 mx-2 {{ $order->status == 'completed' ? 'bg-pink-600' : 'bg-gray-200' }}"></div>

                <!-- Step 3: Completed -->
                <div class="flex flex-col items-center relative z-10">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center {{ $order->status == 'completed' ? 'bg-green-600 text-white' : 'bg-gray-200 text-gray-500' }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <span class="text-xs mt-2 text-center">Selesai</span>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Product Info -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Produk</h3>
        <div class="flex items-center gap-4">
            @if($order->product->image_path)
                <img src="{{ asset('storage/' . $order->product->image_path) }}"
                     alt="{{ $order->product->name }}"
                     class="w-24 h-24 object-cover rounded-lg">
            @else
                <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                    <span class="text-gray-400 text-3xl">📦</span>
                </div>
            @endif
            <div class="flex-1">
                <h4 class="font-semibold text-gray-800 text-lg">{{ $order->product->name }}</h4>
                <p class="text-gray-500">{{ $order->product->description }}</p>
                <p class="text-pink-600 font-semibold mt-1">Rp {{ number_format($order->product->price, 0, ',', '.') }}</p>
            </div>
            <div class="text-right">
                <p class="text-gray-500">Jumlah: <span class="font-semibold text-gray-800">{{ $order->quantity }}</span></p>
            </div>
        </div>
    </div>

    <!-- Order Summary -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h3>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-gray-500">Subtotal</span>
                <span>Rp {{ number_format($order->product->price * $order->quantity, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-500">Ongkos Kirim</span>
                <span>Rp 0</span>
            </div>
            <div class="border-t pt-3 flex justify-between">
                <span class="font-semibold text-gray-800">Total</span>
                <span class="text-xl font-bold text-pink-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    <!-- Customer Info -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pemesan</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">Nama</p>
                <p class="font-medium">{{ $order->customer_name }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">Email</p>
                <p class="font-medium">{{ $order->customer_email }}</p>
            </div>
            <div class="md:col-span-2">
                <p class="text-sm text-gray-500">Alamat</p>
                <p class="font-medium">{{ $order->shipping_address }}</p>
            </div>
        </div>
    </div>

    <!-- Timeline -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Aktivitas</h3>
        <div class="space-y-4">
            <div class="flex items-start gap-3">
                <div class="w-3 h-3 mt-1.5 rounded-full bg-pink-600"></div>
                <div>
                    <p class="font-medium">Pesanan dibuat</p>
                    <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            @if($order->confirmed_at)
            <div class="flex items-start gap-3">
                <div class="w-3 h-3 mt-1.5 rounded-full bg-blue-600"></div>
                <div>
                    <p class="font-medium">Pesanan dikonfirmasi admin</p>
                    <p class="text-sm text-gray-500">{{ $order->confirmed_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            @endif

            @if($order->status == 'completed')
            <div class="flex items-start gap-3">
                <div class="w-3 h-3 mt-1.5 rounded-full bg-green-600"></div>
                <div>
                    <p class="font-medium">Pesanan selesai</p>
                    <p class="text-sm text-gray-500">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            @endif

            @if($order->status == 'cancelled')
            <div class="flex items-start gap-3">
                <div class="w-3 h-3 mt-1.5 rounded-full bg-red-600"></div>
                <div>
                    <p class="font-medium">Pesanan dibatalkan</p>
                    <p class="text-sm text-gray-500">{{ $order->updated_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Admin Notes -->
    @if($order->admin_notes)
    <div class="bg-blue-50 rounded-xl p-6 mb-6">
        <h3 class="text-lg font-semibold text-blue-800 mb-2">Catatan dari Admin</h3>
        <p class="text-blue-700">{{ $order->admin_notes }}</p>
    </div>
    @endif

    <!-- Actions -->
    <div class="flex gap-4">
        @if($order->status == 'pending')
            <form action="{{ route('user.orders.cancel', $order) }}" method="POST"
                  onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')"
                  class="flex-1">
                @csrf
                @method('PATCH')
                <button type="submit" class="w-full bg-red-100 text-red-700 px-6 py-3 rounded-lg hover:bg-red-200 transition font-semibold">
                    Batalkan Pesanan
                </button>
            </form>
        @endif

        <a href="{{ route('products') }}" class="flex-1 bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 transition font-semibold text-center">
            Belanja Lagi
        </a>
    </div>
</div>
@endsection
