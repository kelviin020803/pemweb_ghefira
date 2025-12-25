@extends('layout')

@section('title', 'Checkout - Fashion Brand')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold">Checkout</h1>
            <p class="text-gray-600 mt-2">Complete your purchase</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Product Details -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold mb-4">Product Details</h2>
                <div id="productDetails" class="space-y-4">
                    <div class="animate-pulse">
                        <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                    </div>
                </div>
            </div>

            <!-- Shipping Form -->
            <div class="bg-white rounded-xl shadow-lg p-6">
                <h2 class="text-xl font-bold mb-4">Shipping Information</h2>

                <div id="alert" class="hidden mb-4 p-4 rounded-lg"></div>

                <form id="checkoutForm" onsubmit="submitOrder(event)" class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                        <input type="number" id="quantity" min="1" value="1" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Shipping Address</label>
                        <textarea id="address" required rows="3"
                            placeholder="Jl. Contoh No. 123, Jakarta..."
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500"></textarea>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Phone Number</label>
                        <input type="tel" id="phone" required
                            placeholder="081234567890"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500">
                    </div>

                    <div class="border-t pt-4">
                        <div class="flex justify-between items-center mb-4">
                            <span class="text-lg font-semibold">Total Price:</span>
                            <span id="totalPrice" class="text-2xl font-bold text-purple-600">Rp 0</span>
                        </div>

                        <button type="submit" id="submitBtn"
                            class="w-full bg-gradient-to-r from-purple-600 to-blue-600 text-white px-6 py-3 rounded-lg font-semibold hover:from-purple-700 hover:to-blue-700 transition transform hover:scale-105">
                            Place Order
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-8 text-center">
        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
            </svg>
        </div>
        <h3 class="text-2xl font-bold mb-2">Order Placed!</h3>
        <p class="text-gray-600 mb-6">Your order has been successfully placed</p>
        <div id="orderDetails" class="bg-gray-50 p-4 rounded-lg mb-6 text-left">
            <!-- Order details will be inserted here -->
        </div>
        <button onclick="window.location.href='/home'"
            class="w-full bg-purple-600 text-white px-6 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
            Back to Home
        </button>
    </div>
</div>

<script>
let productData = null;
let checkoutData = null;

async function loadCheckoutData() {
    const token = localStorage.getItem('token');
    if (!token) {
        alert('Please login first');
        window.location.href = '/login';
        return;
    }

    const data = sessionStorage.getItem('checkoutData');
    if (!data) {
        alert('No product selected');
        window.location.href = '/products';
        return;
    }

    checkoutData = JSON.parse(data);

    try {
        const response = await fetch(`/api/products`);
        const result = await response.json();
        productData = result.data.find(p => p.id == checkoutData.productId);

        if (!productData) {
            alert('Product not found');
            window.location.href = '/products';
            return;
        }

        // Update UI
        document.getElementById('quantity').value = checkoutData.quantity;
        document.getElementById('quantity').max = productData.stock;

        displayProductDetails();
        updateTotalPrice();

        document.getElementById('quantity').addEventListener('input', updateTotalPrice);

    } catch (error) {
        console.error('Error loading product:', error);
        alert('Failed to load product details');
    }
}

function displayProductDetails() {
    const container = document.getElementById('productDetails');
    container.innerHTML = `
        <div class="border-b pb-4">
            <div class="flex justify-between items-start mb-2">
                <div class="flex-1">
                    <span class="text-xs font-semibold text-purple-600 uppercase">${productData.brand}</span>
                    <h3 class="font-bold text-lg">${productData.name}</h3>
                    <p class="text-sm text-gray-600">${productData.category}</p>
                </div>
            </div>
            <p class="text-sm text-gray-600 mt-2">${productData.description}</p>
        </div>
        <div class="flex justify-between items-center">
            <span class="text-gray-700">Price per item:</span>
            <span class="text-xl font-bold text-purple-600">Rp ${Number(productData.price).toLocaleString('id-ID')}</span>
        </div>
        <div class="flex justify-between items-center text-sm">
            <span class="text-gray-600">Available stock:</span>
            <span class="font-semibold text-green-600">${productData.stock} items</span>
        </div>
    `;
}

function updateTotalPrice() {
    const quantity = parseInt(document.getElementById('quantity').value) || 1;
    if (quantity > productData.stock) {
        document.getElementById('quantity').value = productData.stock;
        return;
    }
    const total = productData.price * quantity;
    document.getElementById('totalPrice').textContent = `Rp ${Number(total).toLocaleString('id-ID')}`;
}

async function submitOrder(event) {
    event.preventDefault();

    const token = localStorage.getItem('token');
    const submitBtn = document.getElementById('submitBtn');
    const alert = document.getElementById('alert');

    submitBtn.disabled = true;
    submitBtn.textContent = 'Processing...';

    const orderData = {
        product_id: productData.id,
        quantity: parseInt(document.getElementById('quantity').value),
        shipping_address: document.getElementById('address').value,
        phone: document.getElementById('phone').value
    };

    try {
        const response = await fetch('/api/orders', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'Authorization': `Bearer ${token}`
            },
            body: JSON.stringify(orderData)
        });

        const data = await response.json();

        if (response.ok) {
            // Clear checkout data
            sessionStorage.removeItem('checkoutData');

            // Show success modal
            showSuccessModal(data.order);

        } else {
            alert.className = 'mb-4 p-4 rounded-lg bg-red-100 text-red-700';
            alert.textContent = data.error || data.message || 'Failed to place order';
            alert.classList.remove('hidden');

            submitBtn.disabled = false;
            submitBtn.textContent = 'Place Order';
        }

    } catch (error) {
        console.error('Error placing order:', error);
        alert.className = 'mb-4 p-4 rounded-lg bg-red-100 text-red-700';
        alert.textContent = 'An error occurred. Please try again.';
        alert.classList.remove('hidden');

        submitBtn.disabled = false;
        submitBtn.textContent = 'Place Order';
    }
}

function showSuccessModal(order) {
    const modal = document.getElementById('successModal');
    const orderDetails = document.getElementById('orderDetails');

    orderDetails.innerHTML = `
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-600">Order ID:</span>
                <span class="font-mono font-semibold">${order.uuid}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Product:</span>
                <span class="font-semibold">${order.product.name}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Quantity:</span>
                <span class="font-semibold">${order.quantity}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Total:</span>
                <span class="font-bold text-purple-600">Rp ${Number(order.total_price).toLocaleString('id-ID')}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Status:</span>
                <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">${order.status}</span>
            </div>
        </div>
    `;

    modal.classList.remove('hidden');
}

// Initialize
loadCheckoutData();
</script>
@endsection
