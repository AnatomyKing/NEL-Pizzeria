@extends('layouts.app')

@section('title', 'Home')
@section('menu-title', 'Welcome to Stonks Pizza')

@section('content')
    {{-- Success & Error Messages --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Best-Sellers Section --}}
    <div class="best-sellers">
        <h2>Onze best verkochte pizza</h2>
        
        <div class="pizza-gallery">
            <!-- Example "hard-coded" pizzas with modals -->
            <div class="pizza-item" onclick="openModal('/images/m.png', 'Pizza Margherita', '€8,50')">
                <img src="/images/m.png" alt="Pizza Margherita">
                <p>Pizza Margherita</p>
            </div>
            <div class="pizza-item" onclick="openModal('/images/p.png', 'Pizza Pepperoni', '€9,00')">
                <img src="/images/p.png" alt="Pizza Pepperoni">
                <p>Pizza Pepperoni</p>
            </div>
            <div class="pizza-item" onclick="openModal('/images/h.png', 'Pizza Hawaï', '€8,75')">
                <img src="/images/h.png" alt="Pizza Hawaï">
                <p>Pizza Hawaï</p>
            </div>
            <div class="pizza-item" onclick="openModal('/images/f.png', 'Pizza Funghi', '€9,25')">
                <img src="/images/f.png" alt="Pizza Funghi">
                <p>Pizza Funghi</p>
            </div>
            <div class="pizza-item" onclick="openModal('/images/q.png', 'Pizza Quattro Formaggi', '€10,00')">
                <img src="/images/q.png" alt="Pizza Quattro Formaggi">
                <p>Pizza Quattro Formaggi</p>
            </div>
            <div class="pizza-item" onclick="openModal('/images/s.png', 'Pizza Salami', '€8,50')">
                <img src="/images/s.png" alt="Pizza Salami">
                <p>Pizza Salami</p>
            </div>
        </div>
    </div>

    {{-- Modal Overlay --}}
    <div class="modal-overlay" id="pizzaModalOverlay" onclick="closeModal()">
        <div class="modal-content" onclick="event.stopPropagation()">
            <button class="close-button" onclick="closeModal()">×</button>
            <div class="modal-image">
                <img id="pizzaModalImage" src="" alt="">
            </div>
            <div class="modal-details">
                <h3 id="pizzaModalName"></h3>
                <p id="pizzaModalPrice"></p>
            </div>
        </div>
    </div>

    {{-- Actual "pizzas" from the database (or static) to order --}}
    @if(isset($pizzas) && $pizzas->count() > 0)
    <div class="order-section">
        <h2>Bestel Nu</h2>
        <form action="{{ route('bestel.store') }}" method="POST" oninput="calculateTotal()">
            @csrf

            <h3>Jouw Gegevens</h3>
            <div class="form-group">
                <label for="naam">Naam:</label>
                <input type="text" name="naam" id="naam" required>

                <label for="adres">Adres:</label>
                <input type="text" name="adres" id="adres" required>

                <label for="woonplaats">Woonplaats:</label>
                <input type="text" name="woonplaats" id="woonplaats" required>

                <label for="telefoon">Telefoon:</label>
                <input type="text" name="telefoon" id="telefoon" required>

                <label for="email">E-mail:</label>
                <input type="email" name="email" id="email" required>
            </div>

            <h3>Kies Je Pizza's</h3>
            <div class="pizza-gallery">
                @foreach ($pizzas as $pizza)
                    <div class="pizza-item">
                        <img src="/images/{{ $pizza->image ?? 'placeholder.png' }}" alt="{{ $pizza->naam }}">
                        <h4>{{ $pizza->naam }}</h4>
                        <p class="pizza-price" data-price="{{ $pizza->prijs }}">
                            Prijs: €{{ number_format($pizza->prijs, 2, ',', '.') }}
                        </p>
                        <label for="quantity_{{ $pizza->id }}">Aantal:</label>
                        <input type="number" name="pizzas[{{ $pizza->id }}]" id="quantity_{{ $pizza->id }}"
                               class="pizza-quantity" min="0" value="0">
                    </div>
                @endforeach
            </div>

            <div class="total-price">
                Totaal: €<span id="total-price">0.00</span>
            </div>

            <button type="submit" class="btn btn-primary">
                Bestel nu
            </button>
        </form>
    </div>
    @else
        <p class="no-pizzas">Er zijn geen pizza's in de database.</p>
    @endif
@endsection
