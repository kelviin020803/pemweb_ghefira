@extends('admin.layout')

@section('title', 'Kelola Pesanan')
@section('header', 'Kelola Pesanan')

@section('content')
<!-- Filter & Search -->
<div class="bg-white rounded-lg shadow mb-6 p-4">
    <form action="{{ route('admin.orders') }}" method="GET" class="flex flex-wrap gap-4">
        <div class="flex-1 min-w-64">
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari order ID, nama customer, atau produk..."
                   class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
        </div>
        <div>
            <select name="status" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-pink-500">
                <option value="all">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Menunggu</option>
                <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Diproses</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Selesai</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
            </select>
        </div>
        <button type="submit" class="px-6 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700">
            Filter
        </button>
    </form>
</div>

<!-- Orders Table -->
<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Produk</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Qty</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <span class="font-mono text-sm text-pink-600">#{{ substr($order->uuid, 0, 8) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="font-medium">{{ $order->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $order->phone }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $order->product->name }}</td>
                    <td class="px-6 py-4">{{ $order->quantity }}</td>
                    <td class="px-6 py-4 font-semibold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'processing' => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800',
                            ];
                            $statusLabels = [
                                'pending' => 'Menunggu',
                                'processing' => 'Diproses',
                                'completed' => 'Selesai',
                                'cancelled' => 'Dibatalkan',
                            ];
                        @endphp
                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $statusColors[$order->status] }}">
                            {{ $statusLabels[$order->status] }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-500">{{ $order->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('admin.orders.show', $order) }}"
                           class="text-pink-600 hover:text-pink-700 font-medium">
                            Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-6 py-8 text-center text-gray-500">
                        Tidak ada pesanan ditemukan
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="px-6 py-4 border-t">
        {{ $orders->appends(request()->query())->links() }}
    </div>
</div>
@endsection
