@extends('layout')

@section('title', 'Pesanan Berhasil')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12">
    <div class="max-w-lg w-full text-center">
        <!-- Success Icon -->
        <div class="mb-8">
            <div class="w-24 h-24 bg-green-100 rounded-full mx-auto flex items-center justify-center">
                <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
        </div>

        <!-- Message -->
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Pesanan Berhasil Dibuat! 🎉</h1>
        <p class="text-gray-600 mb-8">
            Terima kasih telah berbelanja di GlamStyle. Pesanan kamu sudah kami terima dan menunggu konfirmasi admin.
        </p>

        <!-- Order Info -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8 text-left">
            <div class="border-b pb-4 mb-4">
                <p class="text-sm text-gray-500">Order ID</p>
                <p class="font-mono text-lg text-pink-600">#{{ $order->uuid }}</p>
            </div>

            <div class="flex items-center gap-4 mb-4">
                @if($order->product->image_path)
                    <img src="{{ asset('storage/' . $order->product->image_path) }}"
                         alt="{{ $order->product->name }}"
                         class="w-16 h-16 object-cover rounded-lg">
                @else
                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                        <span class="text-2xl">📦</span>
                    </div>
                @endif
                <div>
                    <h3 class="font-semibold">{{ $order->product->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $order->quantity }} item</p>
                </div>
            </div>

            <div class="flex justify-between items-center pt-4 border-t">
                <span class="font-semibold">Total Pembayaran</span>
                <span class="text-xl font-bold text-pink-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
            </div>
        </div>

        <!-- WhatsApp Instruction -->
        <div class="bg-green-50 rounded-xl p-6 mb-8 text-left">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-green-800 mb-2">Langkah Selanjutnya</h3>
                    <p class="text-green-700 text-sm mb-3">
                        Silakan hubungi admin kami via WhatsApp untuk konfirmasi pembayaran. Klik tombol di bawah untuk langsung terhubung dengan admin.
                    </p>
                    <a href="{{ route('user.orders.whatsapp', $order) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700 transition">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                        Hubungi Admin via WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <!-- Bank Transfer Info -->
        <div class="bg-gray-50 rounded-xl p-6 mb-8 text-left">
            <h3 class="font-semibold text-gray-800 mb-3">Informasi Pembayaran</h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">Bank</span>
                    <span class="font-medium">BNI</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">No. Rekening</span>
                    <span class="font-medium font-mono">03983692279</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Atas Nama</span>
                    <span class="font-medium">Ghefira S</span>
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex gap-4">
            <a href="{{ route('user.orders.show', $order) }}"
               class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg hover:bg-gray-200 transition font-semibold">
                Lihat Detail Pesanan
            </a>
            <a href="{{ route('products') }}"
               class="flex-1 bg-pink-600 text-white px-6 py-3 rounded-lg hover:bg-pink-700 transition font-semibold">
                Lanjut Belanja
            </a>
        </div>
    </div>
</div>
@endsection
