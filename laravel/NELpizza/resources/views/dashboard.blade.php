@extends('layouts.app')  {{-- or <x-app-layout> if using Laravel's default layout --}}

@section('title', 'Dashboard')
@section('menu-title', 'User Dashboard')

@section('content')
    <h2>Your Klant Info</h2>

    @if(session('status'))
        <div style="color: green;">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('dashboard.update') }}">
        @csrf
        <div>
            <label for="naam">Naam:</label>
            <input type="text" name="naam" id="naam" value="{{ old('naam', $klant->naam) }}" required>
        </div>
        <div>
            <label for="adres">Adres:</label>
            <input type="text" name="adres" id="adres" value="{{ old('adres', $klant->adres) }}" required>
        </div>
        <div>
            <label for="woonplaats">Woonplaats:</label>
            <input type="text" name="woonplaats" id="woonplaats" value="{{ old('woonplaats', $klant->woonplaats) }}" required>
        </div>
        <div>
            <label for="telefoonnummer">Telefoonnummer:</label>
            <input type="text" name="telefoonnummer" id="telefoonnummer" value="{{ old('telefoonnummer', $klant->telefoonnummer) }}" required>
        </div>
        <div>
            <label for="emailadres">Emailadres:</label>
            <input type="email" name="emailadres" id="emailadres" value="{{ old('emailadres', $klant->emailadres) }}" required>
        </div>
        <button type="submit">Save</button>
    </form>
@endsection
