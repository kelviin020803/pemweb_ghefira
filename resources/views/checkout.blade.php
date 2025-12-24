@extends('layout')

@section('content')
<h2>Checkout</h2>
<input id="quantity" placeholder="Quantity">
<input id="address" placeholder="Shipping Address">
<input id="phone" placeholder="Phone">
<button onclick="checkout()">Checkout</button>
@endsection
