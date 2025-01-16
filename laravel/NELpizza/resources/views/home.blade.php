@extends('layouts.app')

@section('title', 'Home')

@section('refrence')
<link rel="stylesheet" href="{{ asset('css/home.css') }}">
{{-- <script src="{{ asset('js/home.js') }}" defer></script> --}}
@endsection

@section('menu-title', 'Welcome to Stonks Pizza')

@section('content')
<div class="pizza-ad-grid">
    <!-- Pizza 1 -->
    <div class="pizza-ad-card">
        <img src="/images/m.png" alt="Pizza Margherita">
        <div class="pizza-ad-info">
            <h3>Pizza Margherita</h3>
        </div>
    </div>

    <!-- Pizza 2 -->
    <div class="pizza-ad-card">
        <img src="/images/p.png" alt="Pizza Pepperoni">
        <div class="pizza-ad-info">
            <h3>Pizza Pepperoni</h3>
        </div>
    </div>

    <!-- Pizza 3 -->
    <div class="pizza-ad-card">
        <img src="/images/h.png" alt="Pizza Hawaï">
        <div class="pizza-ad-info">
            <h3>Pizza Hawaï</h3>
        </div>
    </div>

    <!-- Pizza 4 -->
    <div class="pizza-ad-card">
        <img src="/images/f.png" alt="Pizza Funghi">
        <div class="pizza-ad-info">
            <h3>Pizza Funghi</h3>
        </div>
    </div>

    <!-- Pizza 5 -->
    <div class="pizza-ad-card">
        <img src="/images/q.png" alt="Pizza Quattro Formaggi">
        <div class="pizza-ad-info">
            <h3>Pizza Quattro Formaggi</h3>
        </div>
    </div>

    <!-- Pizza 6 -->
    <div class="pizza-ad-card">
        <img src="/images/s.png" alt="Pizza Salami">
        <div class="pizza-ad-info">
            <h3>Pizza Salami</h3>
        </div>
    </div>
</div>
@endsection
