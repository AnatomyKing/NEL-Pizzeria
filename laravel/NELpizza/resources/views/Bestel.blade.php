@extends('layouts.app')

@section('content')
<div class="best-sellers" style="max-width: 800px; margin: auto; font-family: Arial, sans-serif;">
    <h2 style="text-align: center; font-size: 24px; margin-bottom: 20px; color: #333;">Bestelpagina</h2>

    {{-- Success message --}}
    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
            <ul style="list-style-type: none; padding-left: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Order Form --}}
    <form action="{{ route('bestel.store') }}" method="POST" oninput="calculateTotal()" style="background: #f9f9f9; padding: 20px; border: 1px solid #ddd; border-radius: 10px;">
        @csrf

        <h3 style="font-size: 20px; margin-bottom: 15px; color: #555;">Jouw Gegevens</h3>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <label for="naam">Naam:</label>
            <input type="text" name="naam" id="naam" required style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">

            <label for="adres">Adres:</label>
            <input type="text" name="adres" id="adres" required style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">

            <label for="woonplaats">Woonplaats:</label>
            <input type="text" name="woonplaats" id="woonplaats" required style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">

            <label for="telefoon">Telefoon:</label>
            <input type="text" name="telefoon" id="telefoon" required style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">

            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required style="padding: 10px; border: 1px solid #ddd; border-radius: 5px;">
        </div>

        <h3 style="font-size: 20px; margin: 20px 0 15px; color: #555;">Kies Je Pizza's</h3>
        @if($pizzas->count() > 0)
            <div class="pizza-gallery" style="display: flex; flex-wrap: wrap; gap: 20px;">
                @foreach ($pizzas as $pizza)
                    <div class="pizza-item" style="width: 200px; border: 1px solid #ddd; padding: 10px; border-radius: 10px; text-align: center; background: #fff;">
                        {{-- Placeholder or Pizza image --}}
                        <img src="/images/{{ $pizza->image ?? 'placeholder.png' }}" alt="{{ $pizza->naam }}" style="width: 100%; border-radius: 10px; margin-bottom: 10px;">

                        <h4 style="font-size: 18px; color: #333; margin-bottom: 10px;">{{ $pizza->naam }}</h4>
                        <p class="pizza-price" data-price="{{ $pizza->prijs }}" style="font-size: 16px; color: #777;">
                            Prijs: €{{ number_format($pizza->prijs, 2, ',', '.') }}
                        </p>

                        <label for="quantity_{{ $pizza->id }}" style="font-size: 14px; color: #555;">Aantal:</label>
                        <input type="number" name="pizzas[{{ $pizza->id }}]" id="quantity_{{ $pizza->id }}" class="pizza-quantity" min="0" value="0" style="width: 60px; padding: 5px; text-align: center; margin-top: 5px; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                @endforeach
            </div>
        @else
            <p style="color: #888; font-size: 16px; text-align: center;">Er zijn geen pizza's in de database.</p>
        @endif

        {{-- Display total price --}}
        <div style="margin-top: 20px; font-size: 18px; font-weight: bold; color: #333;">
            Totaal: €<span id="total-price">0.00</span>
        </div>

        <button type="submit" style="margin-top: 20px; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #007bff; border: none; border-radius: 5px; cursor: pointer;">
            Bestel nu
        </button>
    </form>
</div>

{{-- Optional JavaScript to update total price in real time --}}
<script>
function calculateTotal() {
    let total = 0.0;
    const pizzaItems = document.querySelectorAll('.pizza-item');

    pizzaItems.forEach(item => {
        const priceElement = item.querySelector('.pizza-price');
        const quantityElement = item.querySelector('.pizza-quantity');

        if (!priceElement || !quantityElement) return;

        // Retrieve numeric values
        const price = parseFloat(priceElement.getAttribute('data-price')) || 0;
        const quantity = parseInt(quantityElement.value) || 0;

        total += price * quantity;
    });

    document.getElementById('total-price').textContent = total.toFixed(2).replace('.', ',');
}
</script>
@endsection
