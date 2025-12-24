@extends('layout')

@section('content')
<h2>Category</h2>
<button onclick="loadProducts('bags')">Bags</button>
<button onclick="loadProducts('shoes')">Shoes</button>

<div id="product-list" class="grid"></div>
@endsection
