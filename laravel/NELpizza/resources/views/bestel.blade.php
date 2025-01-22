{{-- resources/views/bestel.blade.php --}}
@extends('layouts.app')

@section('title', 'Bestel')

@section('refrence')
    <link rel="stylesheet" href="{{ asset('css/bestel.css') }}">
    <script src="{{ asset('js/bestel.js') }}" defer></script>
@endsection

@section('menu-title', 'Welcome to Stonks Pizza')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="main-container">
        <!-- Pizza Section -->
        <div class="pizza-section">
            <h2>Our Menu</h2>
            <div class="pizza-gallery">
                @foreach($pizzas as $pizza)
                    <div class="pizza-item"
                         onclick="openModal(
                             '{{ route('pizza.image', $pizza->id) }}',
                             '{{ $pizza->naam }}',
                             '{{ $pizza->beschrijving }}',
                             {{ $pizza->prijs }},
                             {{ $pizza->id }},
                             {{ json_encode($pizza->ingredients) }}
                         )">
                        <img src="{{ route('pizza.image', $pizza->id) }}" alt="{{ $pizza->naam }}">
                        <h3>{{ $pizza->naam }}</h3>
                        <p class="description">{{ $pizza->beschrijving }}</p>
                        <p class="price">€{{ number_format($pizza->prijs, 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Shopping Cart (Summary) -->
        <div class="shopping-cart">
            <h2>Shopping Cart</h2>
            <ul id="cart-list"></ul>
            <p><strong>Total:</strong> €<span id="cart-total">0.00</span></p>
            <button class="order-button" onclick="window.location.href='{{ route('cart') }}'">
                Go to cart
            </button>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal-overlay" id="pizzaModalOverlay" onclick="closeModal()">
        <div class="modal-content" onclick="event.stopPropagation()">
            <button class="close-button" onclick="closeModal()">×</button>
            <div class="modal-image">
                <img id="pizzaModalImage" src="" alt="">
            </div>
            <div class="modal-details">
                <h3 id="pizzaModalName"></h3>
                <p id="pizzaModalDescription"></p>

                <!-- Ingredient List -->
                <div id="ingredient-list"></div>

                <!-- Pizza Size Selection -->
                <label for="pizza-size">Select Size:</label>
                <select id="pizza-size">
                    <option value="1">Medium</option>
                    <option value="0.8">Small (-20%)</option>
                    <option value="1.2">Large (+20%)</option>
                </select>

                <p id="pizzaModalPrice"></p>

                <button class="add-to-cart-button" onclick="addToCartFromModal()">
                    Add to Cart
                </button>
            </div>
        </div>
    </div>
@endsection
