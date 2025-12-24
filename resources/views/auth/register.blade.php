@extends('layout')

@section('content')
<h2>Register</h2>
<input id="name" placeholder="Name">
<input id="email" placeholder="Email">
<input id="password" type="password" placeholder="Password">
<button onclick="register()">Register</button>
@endsection
