@extends('layouts.app')

@section('title', 'Cart')
@section('menu-title', 'Your Cart')

@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="cart-page-container">
        <h1 class="cart-title">Your Cart</h1>

        <div class="cart-items" id="cartItemsContainer">
            <!-- Cart items rendered by cart.js -->
        </div>

        <div class="cart-summary">
            <p><strong>Total:</strong> €<span id="cartTotal">0.00</span></p>
        </div>

        <h2 class="info-title">Fill in your information</h2>
        <div class="user-info-form">
            <label for="naam">Naam:</label>
            <input type="text" id="naam" value="{{ $klantData['naam'] ?? '' }}" required>

            <label for="adres">Adres:</label>
            <input type="text" id="adres" value="{{ $klantData['adres'] ?? '' }}" required>

            <label for="woonplaats">Woonplaats:</label>
            <input type="text" id="woonplaats" value="{{ $klantData['woonplaats'] ?? '' }}" required>

            <label for="telefoonnummer">Telefoonnummer:</label>
            <input type="text" id="telefoonnummer" value="{{ $klantData['telefoonnummer'] ?? '' }}" required>

            <label for="emailadres">Emailadres:</label>
            <input type="email" id="emailadres" value="{{ $klantData['emailadres'] ?? '' }}" required>
        </div>

        <div class="cart-buttons">
            <button class="btn-back" onclick="window.location.href='{{ route('bestel') }}'">Back to Bestel</button>
            <button id="placeOrderBtn" class="btn-order">Place Order</button>
        </div>
    </div>
@endsection

@section('refrence')
    <link rel="stylesheet" href="{{ asset('css/cart.css') }}">
    <script src="{{ asset('js/cart.js') }}" defer></script>
@endsection
