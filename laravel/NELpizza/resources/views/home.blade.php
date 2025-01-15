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
        <h2>Our Best Pizzas</h2>
        <div class="pizza-gallery">
            <!-- Example Pizza Items -->
            @foreach($pizzas as $pizza)
            <div class="pizza-item" onclick="addToCart('{{ $pizza->naam }}', {{ $pizza->prijs }})">
                <img src="/images/{{ $pizza->image ?? 'placeholder.png' }}" alt="{{ $pizza->naam }}">
                <p>{{ $pizza->naam }}</p>
                <p class="price">€{{ number_format($pizza->prijs, 2) }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Shopping Cart -->
    <div class="shopping-cart">
        <h2>Shopping Cart</h2>
        <ul id="cart-list">
            <!-- Cart items will appear here -->
        </ul>
        <p><strong>Total:</strong> €<span id="cart-total">0.00</span></p>
        <button class="order-button">Order Now</button>
    </div>
</div>
@endsection