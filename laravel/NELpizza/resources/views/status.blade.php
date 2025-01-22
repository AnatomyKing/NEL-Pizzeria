@extends('layouts.app')

@section('title', 'status')
@section('refrence')
<link rel="stylesheet" href="{{ asset('css/status.css') }}">
<script src="{{ asset('js/status.js') }}" defer></script>
@endsection
@section('menu-title', 'Contact Information')

<main class="main-wrapper">
  <div class="steps-wrapper">
    <div class="steps">
      <span class="step active">1</span>
      <span class="step">2</span>
      <span class="step">3</span>
      <span class="step">4</span>
      <div class="progress-bar">
        <span class="progress"></span>
      </div>
    </div>
    <div class="buttons">
      <button class="btn btn-prev" id="btn-prev" disabled>Previous</button>
      <button class="btn btn-next" id="btn-next">Next</button>
    </div>
  </div>
</main>