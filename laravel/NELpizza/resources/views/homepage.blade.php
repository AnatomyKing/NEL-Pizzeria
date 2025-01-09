@extends('layouts.app')

@section('title', 'Example Page')

@section('screen-title')

@section('menu-title', 'Example Menu')

@section('content')
<div class="best-sellers">
    <h2>Onze best verkochte pizza</h2>
    <div class="pizza-gallery">
        <div class="pizza-item">
            <img src="/images/m.png" alt="Pizza Margherita">
            <p>Pizza Margherita</p>
        </div>
        <div class="pizza-item">
            <img src="/images/p.png" alt="Pizza Pepperoni">
            <p>Pizza Pepperoni</p>
        </div>
        <div class="pizza-item">
            <img src="/images/h.png" alt="Pizza Hawaï">
            <p>Pizza Hawaï</p>
        </div>
        <div class="pizza-item">
            <img src="/images/f.png" alt="Pizza Funghi">
            <p>Pizza Funghi</p>
        </div>
        <div class="pizza-item">
            <img src="/images/q.png" alt="Pizza Quattro Formaggi">
            <p>Pizza Quattro Formaggi</p>
        </div>
        <div class="pizza-item">
            <img src="/images/s.png" alt="Pizza Salami">
            <p>Pizza Salami</p>
        </div>
    </div>
</div>
@endsection
