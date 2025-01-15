@extends('layouts.app')

@section('title', 'Home')
@section('refrence')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<script src="{{ asset('js/home.js') }}" defer></script>
@endsection
@section('menu-title', 'Welcome to Stonks Pizza')

@section('content')
<div class="main-container">
    <!-- Pizza Section -->
    <div class="pizza-section">
        <h2>Our Menu</h2>
        <div class="pizza-gallery">
            @foreach($pizzas as $pizza)
            <div class="pizza-item" onclick="addToCart('{{ $pizza->naam }}', '{{ $pizza->beschrijving }}', {{ $pizza->prijs }}, '{{ $pizza->image_url }}')">
                <img src="{{ $pizza->image_url }}" alt="{{ $pizza->naam }}">
                <h3>{{ $pizza->naam }}</h3>
                <p class="description">{{ $pizza->beschrijving }}</p>
                <p class="price">€{{ number_format($pizza->prijs, 2) }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Shopping Cart -->
    <div class="shopping-cart">
        <h2>Shopping Cart</h2>
        <ul id="cart-list"></ul>
        <p><strong>Total:</strong> €<span id="cart-total">0.00</span></p>
        <button class="order-button">Order Now</button>
    </div>
</div>
@endsection
