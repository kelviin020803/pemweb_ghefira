@extends('layout')

@section('title', 'Checkout - ' . $product->name)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <a href="{{ route('products') }}" class="text-pink-600 hover:text-pink-700 text-sm">← Kembali ke Produk</a>
        <h1 class="text-3xl font-bold text-gray-800 mt-2">Checkout</h1>
    </div>

    @if($errors->any())
    <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-700">
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
    @endif

    <form action="{{ route('user.checkout.post', $product) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        @csrf

        <!-- Left Column - Product & Form -->
        <div class="space-y-6">
            <!-- Product Summary -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Produk</h2>
                <div class="flex items-center gap-4">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}"
                             alt="{{ $product->name }}"
                             class="w-24 h-24 object-cover rounded-lg">
                    @else
                        <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                            <span class="text-gray-400 text-3xl">📦</span>
                        </div>
                    @endif
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $product->name }}</h3>
                        <p class="text-pink-600 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                        <p class="text-sm text-gray-500">Stok: {{ $product->stock }}</p>
                    </div>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Informasi Pemesan</h2>
                <div class="space-y-4">
                    <div>
                        <label for="customer_name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text"
                               name="customer_name"
                               id="customer_name"
                               value="{{ old('customer_name', auth()->user()->name) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="customer_email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email"
                               name="customer_email"
                               id="customer_email"
                               value="{{ old('customer_email', auth()->user()->email) }}"
                               required
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">Nomor HP/WhatsApp</label>
                        <input type="tel"
                               name="phone"
                               id="phone"
                               value="{{ old('phone') }}"
                               required
                               placeholder="08xxxxxxxxxx"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                    </div>
                    <div>
                        <label for="shipping_address" class="block text-sm font-medium text-gray-700 mb-1">Alamat Pengiriman</label>
                        <textarea name="shipping_address"
                                  id="shipping_address"
                                  rows="3"
                                  required
                                  placeholder="Alamat lengkap termasuk kecamatan, kota, kode pos"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">{{ old('shipping_address') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column - Order Summary -->
        <div>
            <div class="bg-white rounded-xl shadow-lg p-6 sticky top-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Ringkasan Pesanan</h2>

                <!-- Quantity -->
                <div class="mb-4">
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Jumlah</label>
                    <select name="quantity"
                            id="quantity"
                            onchange="updateTotal()"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent">
                        @for($i = 1; $i <= min(10, $product->stock); $i++)
                            <option value="{{ $i }}" {{ old('quantity', 1) == $i ? 'selected' : '' }}>{{ $i }}</option>
                        @endfor
                    </select>
                </div>

                <div class="space-y-3 border-t pt-4">
                    <div class="flex justify-between text-gray-600">
                        <span>Harga Satuan</span>
                        <span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Jumlah</span>
                        <span id="qty-display">1</span>
                    </div>
                    <div class="flex justify-between text-gray-600">
                        <span>Ongkos Kirim</span>
                        <span class="text-green-600">Gratis</span>
                    </div>
                    <div class="border-t pt-3 flex justify-between">
                        <span class="font-semibold">Total</span>
                        <span id="total-display" class="text-xl font-bold text-pink-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Payment Info -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h3 class="font-medium text-gray-800 mb-2">Metode Pembayaran</h3>
                    <p class="text-sm text-gray-600">Transfer Bank (konfirmasi via WhatsApp)</p>
                    <div class="mt-2 text-sm">
                        <p><span class="text-gray-500">Bank:</span> BNI</p>
                        <p><span class="text-gray-500">No. Rek:</span> 03983692279</p>
                        <p><span class="text-gray-500">A/N:</span> Ghefira S</p>
                    </div>
                </div>

                <button type="submit"
                        class="w-full mt-6 bg-gradient-to-r from-pink-600 to-purple-600 text-white py-4 rounded-lg font-semibold hover:from-pink-700 hover:to-purple-700 transition transform hover:scale-105">
                    Buat Pesanan & Hubungi Admin
                </button>

                <p class="text-xs text-gray-500 text-center mt-4">
                    Dengan membuat pesanan, Anda akan diarahkan ke WhatsApp admin untuk konfirmasi pembayaran
                </p>
            </div>
        </div>
    </form>
</div>

<script>
    const price = {{ $product->price }};

    function updateTotal() {
        const qty = document.getElementById('quantity').value;
        const total = price * qty;

        document.getElementById('qty-display').textContent = qty;
        document.getElementById('total-display').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }
</script>
@endsection
