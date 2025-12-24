@extends('layout')

@section('content')
<h2>Products</h2>

<div class="grid" id="product-list">
    <!-- product akan di-render lewat JS -->
</div>

<script>
    // ambil category dari query param
    const params = new URLSearchParams(window.location.search);
    const category = params.get('category');

    // panggil function di app.js
    loadProducts(category);
</script>
@endsection
