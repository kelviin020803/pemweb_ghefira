@extends('layout')

@section('title', 'Home - Fashion Brand')

@section('content')
<!-- Hero Section -->
<div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="text-center">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">
                Elevate Your Style
            </h1>
            <p class="text-xl md:text-2xl mb-8 text-purple-100">
                Premium streetwear & lifestyle fashion untuk generasi modern
            </p>
            <a href="/products" class="inline-block bg-white text-purple-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition transform hover:scale-105">
                Shop Now
            </a>
        </div>
    </div>
</div>

<!-- Category Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <h2 class="text-3xl font-bold text-center mb-12">Shop by Category</h2>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
        <!-- Shoes Category -->
        <a href="/products?category=Shoes" class="group">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-xl">
                <div class="bg-gradient-to-br from-red-400 to-pink-600 h-48 flex items-center justify-center">
                    <!-- Shoe/Sneaker Icon -->
                    <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21.5 10.5c-.14 0-.27.01-.4.02C21.03 10.22 20.79 10 20.5 10h-1c-.28 0-.5.22-.5.5s.22.5.5.5h.59c-.84.5-2.59 1-4.59 1-1.7 0-3.7-.38-5.5-1.68-2.09-1.5-4.03-1.82-5.5-1.82-1.04 0-1.86.16-2.34.29-.39.11-.66.47-.66.88v2.41c0 .65.67 1.12 1.33.91.85-.27 2.34-.64 4.01-.27 1.94.43 4.16 1.78 6.66 1.78 3.42 0 5.82-1.31 6.93-2.03.34.56.54 1.21.54 1.91 0 .83-.67 1.5-1.5 1.5H4.5C3.67 16 3 15.33 3 14.5c0-.65.42-1.2 1-1.41V11.5c-1.71.37-3 1.89-3 3.7 0 2.1 1.69 3.8 3.77 3.8h15.46c2.08 0 3.77-1.7 3.77-3.8 0-2.09-1.69-3.7-2.5-4.7z"/>
                    </svg>
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-bold text-lg group-hover:text-purple-600 transition">Shoes</h3>
                    <p class="text-sm text-gray-500">Sneakers & Footwear</p>
                </div>
            </div>
        </a>

        <!-- Hoodie Category -->
        <a href="/products?category=Hoodie" class="group">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-xl">
                <div class="bg-gradient-to-br from-blue-400 to-indigo-600 h-48 flex items-center justify-center">
                    <!-- Hoodie/Sweater Icon -->
                    <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M15.45 2.11L12 3.5 8.55 2.11c-.38-.15-.81-.15-1.2 0L2 4.22v4.28c0 .83.67 1.5 1.5 1.5H5v10c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V10h1.5c.83 0 1.5-.67 1.5-1.5V4.22l-5.35-2.11c-.39-.15-.81-.15-1.2 0zM10 20H7V9h3v11zm7 0h-3V9h3v11zm2-12h-1.5H17V6.5l-5 2-5-2V8H5.5H4V5.45l4.55-1.82L12 5.13l3.45-1.5L20 5.45V8z"/>
                    </svg>
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-bold text-lg group-hover:text-purple-600 transition">Hoodies</h3>
                    <p class="text-sm text-gray-500">Streetwear Essentials</p>
                </div>
            </div>
        </a>

        <!-- Bag Category -->
        <a href="/products?category=Bag" class="group">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-xl">
                <div class="bg-gradient-to-br from-green-400 to-teal-600 h-48 flex items-center justify-center">
                    <!-- Backpack/Bag Icon -->
                    <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 8v12c0 1.1-.9 2-2 2H6c-1.1 0-2-.9-2-2V8c0-1.86 1.28-3.41 3-3.86V3c0-.55.45-1 1-1h8c.55 0 1 .45 1 1v1.14c1.72.45 3 2 3 3.86zM8 4v.05h8V4H8zm7 6h-2v2h-2v-2H9v-2h2V6h2v2h2v2z"/>
                    </svg>
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-bold text-lg group-hover:text-purple-600 transition">Bags</h3>
                    <p class="text-sm text-gray-500">Backpacks & Accessories</p>
                </div>
            </div>
        </a>

        <!-- Jacket Category -->
        <a href="/products?category=Jacket" class="group">
            <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105 hover:shadow-xl">
                <div class="bg-gradient-to-br from-yellow-400 to-orange-600 h-48 flex items-center justify-center">
                    <!-- Jacket Icon -->
                    <svg class="w-20 h-20 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 3h-4c0-1.1-.9-2-2-2h-6c-1.1 0-2 .9-2 2H3c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h4v-2H5c-1.1 0-2-.9-2-2V7c0-1.1.9-2 2-2h2v14c0 1.1.9 2 2 2h6c1.1 0 2-.9 2-2V5h2c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2h-2v2h4c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 19V3h6v16H9z"/>
                    </svg>
                </div>
                <div class="p-4 text-center">
                    <h3 class="font-bold text-lg group-hover:text-purple-600 transition">Jackets</h3>
                    <p class="text-sm text-gray-500">Outerwear Collection</p>
                </div>
            </div>
        </a>
    </div>
</div>

<!-- Featured Products Section -->
<div class="bg-gray-100 py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-3xl font-bold text-center mb-12">Featured Products</h2>
        <div id="featuredProducts" class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Will be populated by JavaScript -->
        </div>
        <div class="text-center mt-12">
            <a href="/products" class="inline-block bg-purple-600 text-white px-8 py-3 rounded-lg font-semibold hover:bg-purple-700 transition">
                View All Products
            </a>
        </div>
    </div>
</div>

<!-- Features Section -->
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="text-center">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"></path>
                    <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"></path>
                </svg>
            </div>
            <h3 class="font-bold text-lg mb-2">Free Shipping</h3>
            <p class="text-gray-600">Free delivery for orders over Rp 500,000</p>
        </div>
        <div class="text-center">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="font-bold text-lg mb-2">Authentic Products</h3>
            <p class="text-gray-600">100% original guaranteed</p>
        </div>
        <div class="text-center">
            <div class="bg-purple-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L11 4.323V3a1 1 0 011-1zm-5 8.274l-.818 2.552c-.25.78.409 1.54 1.215 1.54.5 0 .953-.252 1.205-.68l.242-.409a1 1 0 011.73 1.013l-.242.408a3.988 3.988 0 01-3.396 1.918c-1.82 0-3.193-1.674-2.62-3.384l.814-2.533A1 1 0 015.382 10h2.236a1 1 0 01.95.684z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <h3 class="font-bold text-lg mb-2">24/7 Support</h3>
            <p class="text-gray-600">Dedicated customer service</p>
        </div>
    </div>
</div>

<script>
// Check authentication status
function checkAuth() {
    const token = localStorage.getItem('token');
    const authButtons = document.getElementById('authButtons');

    if (token) {
        authButtons.innerHTML = `
            <span class="text-gray-700">Welcome!</span>
            <button onclick="logout()" class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                Logout
            </button>
        `;
    } else {
        authButtons.innerHTML = `
            <a href="/login" class="text-gray-700 hover:text-purple-600 transition">Login</a>
            <a href="/register" class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                Register
            </a>
        `;
    }
}

// Logout function
function logout() {
    localStorage.removeItem('token');
    window.location.href = '/login';
}

// Load featured products
async function loadFeaturedProducts() {
    try {
        const response = await fetch('/api/products?per_page=3');
        const data = await response.json();

        const container = document.getElementById('featuredProducts');

        if (data.data && data.data.length > 0) {
            container.innerHTML = data.data.map(product => `
                <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition hover:scale-105">
                    <div class="h-64 bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                        <span class="text-4xl font-bold text-gray-400">${product.name.charAt(0)}</span>
                    </div>
                    <div class="p-6">
                        <span class="text-xs font-semibold text-purple-600 uppercase">${product.brand}</span>
                        <h3 class="font-bold text-xl mt-2 mb-2">${product.name}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">${product.description}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-2xl font-bold text-purple-600">Rp ${Number(product.price).toLocaleString('id-ID')}</span>
                            <span class="text-sm text-gray-500">Stock: ${product.stock}</span>
                        </div>
                        <a href="/products?category=${product.category}" class="block mt-4 text-center bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 transition">
                            View Details
                        </a>
                    </div>
                </div>
            `).join('');
        }
    } catch (error) {
        console.error('Error loading products:', error);
    }
}

// Initialize
checkAuth();
loadFeaturedProducts();
</script>
@endsection
