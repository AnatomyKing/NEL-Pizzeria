@extends('layouts.app')
{{-- Ensure you have resources/views/layout.blade.php or change this to your layout --}}

@section('content')
<div class="best-sellers">
    <h2>ONZE BEST VERKOCHTE PIZZA’S</h2>

    {{-- Success message --}}
    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Validation errors --}}
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Order Form --}}
    <form action="{{ route('bestel.store') }}" method="POST" oninput="calculateTotal()">
        @csrf

        <h3>JOUW GEGEVENS</h3>
        <div>
            <label for="naam">Naam:</label>
            <input type="text" name="naam" id="naam" required>
        </div>
        <div>
            <label for="adres">Adres:</label>
            <input type="text" name="adres" id="adres" required>
        </div>
        <div>
            <label for="woonplaats">Woonplaats:</label>
            <input type="text" name="woonplaats" id="woonplaats" required>
        </div>
        <div>
            <label for="telefoon">Telefoon:</label>
            <input type="text" name="telefoon" id="telefoon" required>
        </div>
        <div>
            <label for="email">E-mail:</label>
            <input type="email" name="email" id="email" required>
        </div>

        <h3>KIES JE PIZZA'S</h3>

        @if($pizzas->count() > 0)
            <div class="pizza-gallery" style="display: flex; flex-wrap: wrap; gap: 20px;">
                @foreach ($pizzas as $pizza)
                    <div class="pizza-item" style="width: 200px; border: 1px solid #ccc; padding: 10px;">
                        {{-- If you have an image column or path in the DB, adjust accordingly --}}
                        @if(isset($pizza->image))
                            <img src="/images/{{ $pizza->image }}"
                                 alt="{{ $pizza->naam }}"
                                 style="width: 100%;">
                        @else
                            {{-- Fallback image or no image --}}
                            <img src="/images/placeholder.png"
                                 alt="{{ $pizza->naam }}"
                                 style="width: 100%;">
                        @endif

                        <h4>{{ $pizza->naam }}</h4>
                        <p class="pizza-price" data-price="{{ $pizza->prijs }}">
                            Prijs: €{{ number_format($pizza->prijs, 2, ',', '.') }}
                        </p>

                        <label>Aantal:</label>
                        <input type="number"
                               name="pizzas[{{ $pizza->id }}]"
                               class="pizza-quantity"
                               min="0" value="0" style="width: 60px;">
                    </div>
                @endforeach
            </div>
        @else
            <p>Er zijn geen pizza's in de database.</p>
        @endif

        {{-- Display total price --}}
        <div style="margin-top: 20px;">
            <strong>Totaal:</strong> €<span id="total-price">0.00</span>
        </div>

        <button type="submit" style="margin-top: 10px;">Bestel nu</button>
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

  document.getElementById('total-price').textContent = total.toFixed(2);
}
</script>
@endsection
