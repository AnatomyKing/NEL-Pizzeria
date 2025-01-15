@extends('layouts.app')

@section('content')
<div class="bestel-container" style="max-width: 800px; margin: auto; font-family: Arial, sans-serif; padding: 20px; border-radius: 15px; background-color: #f8f9fa; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">
    <h2 style="text-align: center; font-size: 24px; margin-bottom: 20px; color: #333; text-transform: uppercase;">Bestelpagina</h2>

    {{-- Success message --}}
    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; animation: fadeIn 1s;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
        <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 20px; animation: fadeIn 1s;">
            <ul style="list-style-type: none; padding-left: 0; margin: 0;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Order Form --}}
    <form action="{{ route('bestel.store') }}" method="POST" oninput="calculateTotal()" style="padding: 20px; border: 1px solid #ddd; border-radius: 15px; background-color: #fff;">
        @csrf

        <h3 style="font-size: 18px; margin-bottom: 15px; color: #555;">Jouw Gegevens</h3>
        <div style="display: flex; flex-direction: column; gap: 10px;">
            <div>
                <label for="naam" style="font-weight: bold; display: block;">Naam:</label>
                <input type="text" name="naam" id="naam" required style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 100%;">
            </div>
            <div>
                <label for="adres" style="font-weight: bold; display: block;">Adres:</label>
                <input type="text" name="adres" id="adres" required style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 100%;">
            </div>
            <div>
                <label for="woonplaats" style="font-weight: bold; display: block;">Woonplaats:</label>
                <input type="text" name="woonplaats" id="woonplaats" required style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 100%;">
            </div>
            <div>
                <label for="telefoon" style="font-weight: bold; display: block;">Telefoon:</label>
                <input type="text" name="telefoon" id="telefoon" required style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 100%;">
            </div>
            <div>
                <label for="email" style="font-weight: bold; display: block;">E-mail:</label>
                <input type="email" name="email" id="email" required style="padding: 8px; border: 1px solid #ddd; border-radius: 5px; width: 100%;">
            </div>
        </div>

        <h3 style="font-size: 18px; margin: 20px 0 15px; color: #555;">Kies Je Pizza's</h3>
        <div class="pizza-gallery" style="max-height: 400px; overflow-y: auto; display: flex; flex-wrap: wrap; gap: 10px; padding: 10px; border: 1px solid #ddd; border-radius: 10px; background-color: #fff;">
            @if($pizzas->count() > 0)
                @foreach ($pizzas as $pizza)
                    <div class="pizza-item" style="width: 180px; border: 1px solid #ddd; padding: 10px; border-radius: 10px; text-align: center; background: #fff; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                        <img src="/images/{{ $pizza->image ?? 'placeholder.png' }}" alt="{{ $pizza->naam }}" style="width: 100%; border-radius: 10px; margin-bottom: 10px;">

                        <h4 style="font-size: 16px; color: #333; margin-bottom: 10px;">{{ $pizza->naam }}</h4>
                        <p class="pizza-price" data-price="{{ $pizza->prijs }}" style="font-size: 14px; color: #777; margin-bottom: 10px;">
                            Prijs: €{{ number_format($pizza->prijs, 2, ',', '.') }}
                        </p>

                        <label for="quantity_{{ $pizza->id }}" style="font-size: 12px; color: #555; margin-bottom: 5px; display: block;">Aantal:</label>
                        <input type="number" name="pizzas[{{ $pizza->id }}]" id="quantity_{{ $pizza->id }}" class="pizza-quantity" min="0" value="0" style="width: 50px; padding: 5px; text-align: center; border: 1px solid #ddd; border-radius: 5px;">
                    </div>
                @endforeach
            @else
                <p style="color: #888; font-size: 14px; text-align: center;">Er zijn geen pizza's in de database.</p>
            @endif
        </div>

        {{-- Display total price --}}
        <div style="margin-top: 20px; font-size: 16px; font-weight: bold; color: #333;">
            Totaal: €<span id="total-price">0.00</span>
        </div>

        <button type="submit" style="margin-top: 20px; padding: 10px 20px; font-size: 16px; color: #fff; background-color: #007bff; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s ease;">
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

        const price = parseFloat(priceElement.getAttribute('data-price')) || 0;
        const quantity = parseInt(quantityElement.value) || 0;

        total += price * quantity;
    });

    document.getElementById('total-price').textContent = total.toFixed(2).replace('.', ',');
}
</script>

{{-- Animations --}}
<style>
    .pizza-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }
</style>
@endsection
