@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-4">Dashboard</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Customer Information Form -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Klantinformatie</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('klant.save') }}" method="POST">
                @csrf

                <!-- Naam -->
                <div class="mb-3">
                    <label for="naam" class="form-label">Naam</label>
                    <input type="text" class="form-control" id="naam" name="naam"
                        value="{{ old('naam', $klant->naam ?? '') }}"
                        placeholder="Voer uw naam in" required>
                </div>

                <!-- Adres -->
                <div class="mb-3">
                    <label for="adres" class="form-label">Adres</label>
                    <input type="text" class="form-control" id="adres" name="adres"
                        value="{{ old('adres', $klant->adres ?? '') }}"
                        placeholder="Voer uw adres in" required>
                </div>

                <!-- Woonplaats -->
                <div class="mb-3">
                    <label for="woonplaats" class="form-label">Woonplaats</label>
                    <input type="text" class="form-control" id="woonplaats" name="woonplaats"
                        value="{{ old('woonplaats', $klant->woonplaats ?? '') }}"
                        placeholder="Voer uw woonplaats in" required>
                </div>

                <!-- Telefoonnummer -->
                <div class="mb-3">
                    <label for="telefoonnummer" class="form-label">Telefoonnummer</label>
                    <input type="text" class="form-control" id="telefoonnummer" name="telefoonnummer"
                        value="{{ old('telefoonnummer', $klant->telefoonnummer ?? '') }}"
                        placeholder="Voer uw telefoonnummer in" required>
                </div>

                <!-- E-mail -->
                <div class="mb-3">
                    <label for="emailadres" class="form-label">E-mailadres</label>
                    <input type="email" class="form-control" id="emailadres" name="emailadres"
                        value="{{ old('emailadres', $klant->emailadres ?? '') }}"
                        placeholder="Voer uw e-mailadres in" required>
                </div>

                <!-- Submit -->
                <div class="text-center">
                    <button type="submit" class="btn btn-success">Opslaan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Order Form -->
    <div class="card shadow-sm">
        <div class="card-header bg-secondary text-white">
            <h4 class="mb-0">Plaats een Bestelling</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('order.store') }}" method="POST">
                @csrf

                <!-- Adres -->
                <div class="mb-3">
                    <label for="adres" class="form-label">Adres</label>
                    <input type="text" class="form-control" id="adres" name="adres"
                        placeholder="Voer uw afleveradres in" required>
                </div>

                <!-- Woonplaats -->
                <div class="mb-3">
                    <label for="woonplaats" class="form-label">Woonplaats</label>
                    <input type="text" class="form-control" id="woonplaats" name="woonplaats"
                        placeholder="Voer uw woonplaats in" required>
                </div>

                <!-- Telefoonnummer -->
                <div class="mb-3">
                    <label for="telefoonnummer" class="form-label">Telefoonnummer</label>
                    <input type="text" class="form-control" id="telefoonnummer" name="telefoonnummer"
                        placeholder="Voer uw telefoonnummer in" required>
                </div>

                <!-- Submit -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Plaats Bestelling</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
