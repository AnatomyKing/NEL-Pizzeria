@extends('layouts.app')

@section('title', 'Home')

@section('refrence')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
<script src="{{ asset('js/home.js') }}" defer></script>
@endsection

@section('menu-title', 'Welcome to Stonks Pizza')

@section('content')
<div class="page-container">
    <!-- Banner Section -->
    <div class="header-section">
        <h1 class="banner-text">ONZE MEEST VERKOCHTE PIZZAS</h1>
    </div>

    <!-- Pizza Offerings -->
    <div class="pizza-offerings">
        <div class="pizza-card">
            <img src="{{ asset('images/f.png') }}" alt="Pizza F">
            <div class="pizza-info">
                <h3>Pizza Funghi</h3>
            </div>
        </div>
        <div class="pizza-card">
            <img src="{{ asset('images/h.png') }}" alt="Pizza H">
            <div class="pizza-info">
                <h3>Pizza Hawaï</h3>
            </div>
        </div>
        <div class="pizza-card">
            <img src="{{ asset('images/m.png') }}" alt="Pizza M">
            <div class="pizza-info">
                <h3>Pizza Margherita</h3>
            </div>
        </div>
    </div>

    <!-- Patterns Section -->
    <div class="patterns-section">
        <div class="zigzag-pattern"></div>
        <div class="wave-pattern"></div>
    </div>

    <!-- Centered Pizza Image -->
    <div class="pizza-image">
        <img src="{{ asset('images/pizzalarge.png') }}" alt="Pizza">
    </div>
</div>
@endsection
