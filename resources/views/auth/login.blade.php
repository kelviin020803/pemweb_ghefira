@extends('layout')

@section('title', 'Login - GlamStyle Fashion')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-pink-50 to-purple-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-xl p-8">
            <!-- Logo -->
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold bg-gradient-to-r from-pink-600 to-purple-600 bg-clip-text text-transparent">
                    ✨ GLAMSTYLE ✨
                </h2>
                <p class="text-gray-600 mt-2">Selamat datang kembali! Silakan login</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
            <div class="mb-4 p-4 rounded-lg bg-red-100 text-red-700">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
            @endif

            @if(session('success'))
            <div class="mb-4 p-4 rounded-lg bg-green-100 text-green-700">
                {{ session('success') }}
            </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ old('email') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                        placeholder="email@contoh.com"
                    >
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                    <input
                        type="password"
                        name="password"
                        id="password"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-pink-500 focus:border-transparent transition"
                        placeholder="••••••••"
                    >
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="h-4 w-4 text-pink-600 focus:ring-pink-500 border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                </div>

                <button
                    type="submit"
                    class="w-full bg-gradient-to-r from-pink-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:from-pink-700 hover:to-purple-700 transition transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2"
                >
                    Login
                </button>
            </form>

            <!-- Register Link -->
            <p class="text-center mt-6 text-gray-600">
                Belum punya akun?
                <a href="{{ route('register') }}" class="text-pink-600 font-semibold hover:text-pink-700 transition">Daftar Sekarang</a>
            </p>
        </div>
    </div>
</div>
@endsection
