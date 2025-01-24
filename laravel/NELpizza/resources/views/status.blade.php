@extends('layouts.app')

@section('title', 'Order Status')

@section('refrence')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link rel="stylesheet" href="{{ asset('css/status.css') }}">
<script src="{{ asset('js/status.js') }}" defer></script>
@endsection

@section('menu-title', 'Order Status')

@section('content')
<main class="main-wrapper">
  <div class="container">
    <div id="ordersContainer">
      <!-- Orders will be rendered here by the JS code -->
    </div>
    <div id="noOrdersMessage" class="no-orders-message" style="display:none;">
      Nog geen bestelling om te volgen!
    </div>
  </div>
</main>
@endsection
