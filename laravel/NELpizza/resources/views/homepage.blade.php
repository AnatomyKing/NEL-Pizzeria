@extends('layouts.app')
@section('content')
<canvas id="canvas"></canvas>
<div class="parent">
    <div class="div1">
        <a href="/anatomyworld">
            <img src="{{ asset('images/travel_to_anatomy_world.png') }}" alt="Travel to Anatomy World">
        </a>
    </div>
    <div class="div2">
        <a >
            <img src="{{ asset('images/travel_to_harambe_world_comingsoon.png') }}" alt="Travel to Harambe World">
        </a>
    </div>
    <div class="anatomybolDiv" id="anatomybolDiv">
    </div>
    <div class="harambebolDiv" id="harambebolDiv">
    </div>
</div>

<div id="chatbot-open-container">
  <img src="/images/any.gif" id="open-chat-button" alt="Chat Icon">
  <img src="/images/anystill.png" id="close-chat-button" style="display: none" alt="Close Icon">
</div>


<!-- Floating prompt box -->
<div id="prompt-container">
    <input type="text" id="prompt-input" placeholder="Type a message...">
    <button id="prompt-send-button">Send</button>
</div>

<!-- Floating message display -->
<div id="terminal-container">
  <img src="{{ asset('images/anyphone.png') }}" alt="Anyphone" id="terminal-image">
  <div id="message-display">
    <!-- Messages will be displayed here -->
  </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/home/background.js') }}"></script>
<script src="{{ asset('js/home/universemodels.js') }}"></script>
<script src="{{ asset('js/home/chatbot.js') }}"></script>
<script src="{{ asset('js/mentor/fakehacker.js') }}"></script>
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/home/universe.css') }}">
<link rel="stylesheet" href="{{ asset('css/home/chatbot.css') }}">
<link rel="stylesheet" href="{{ asset('css/mentor/fakehacker.css') }}">
@endsection