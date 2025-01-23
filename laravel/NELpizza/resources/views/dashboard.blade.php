@extends('layouts.app')  {{-- or <x-app-layout> if using Laravel's default layout --}}

@section('title', 'Dashboard')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@section('menu-title', 'User Dashboard')

@section('content')
    <div class="dashboard-container">
        <h2 class="dashboard-title">Your Klant Info</h2>

        @if(session('status'))
            <div class="status-message">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('dashboard.update') }}" class="dashboard-form">
            @csrf
            <div class="form-group">
                <label for="naam">Naam:</label>
                <input type="text" name="naam" id="naam" value="{{ old('naam', $klant->naam) }}" required>
            </div>
            <div class="form-group">
                <label for="adres">Adres:</label>
                <input type="text" name="adres" id="adres" value="{{ old('adres', $klant->adres) }}" required>
            </div>
            <div class="form-group">
                <label for="woonplaats">Woonplaats:</label>
                <input type="text" name="woonplaats" id="woonplaats" value="{{ old('woonplaats', $klant->woonplaats) }}" required>
            </div>
            <div class="form-group">
                <label for="telefoonnummer">Telefoonnummer:</label>
                <input type="text" name="telefoonnummer" id="telefoonnummer" value="{{ old('telefoonnummer', $klant->telefoonnummer) }}" required>
            </div>
            <div class="form-group">
                <label for="emailadres">Emailadres:</label>
                <input type="email" name="emailadres" id="emailadres" value="{{ old('emailadres', $klant->emailadres) }}" required>
            </div>
            <button type="submit" class="btn btn-save">Save</button>
        </form>
    </div>
@endsection
