@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin: auto;">
    <h2 style="text-align: center; margin-bottom: 20px;">Bewerk Ingrediënten voor {{ $pizza->naam }}</h2>

    {{-- Succesbericht --}}
    @if (session('success'))
        <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    {{-- Huidige Ingrediënten --}}
    <div style="margin-bottom: 20px;">
        <h4>Huidige Ingrediënten:</h4>
        <ul id="current-ingredients">
            @foreach ($pizza->ingredients as $ingredient)
                <li data-id="{{ $ingredient->id }}">{{ $ingredient->naam }}</li>
            @endforeach
        </ul>
    </div>

    {{-- Alle Ingrediënten --}}
    <div>
        <h4>Alle Ingrediënten:</h4>
        <div id="ingredient-options" style="display: flex; flex-wrap: wrap; gap: 10px;">
            @foreach ($allIngredients as $ingredient)
                <div
                    class="ingredient-item"
                    data-id="{{ $ingredient->id }}"
                    style="padding: 10px; border: 1px solid #ddd; border-radius: 5px; cursor: pointer; text-align: center; width: 120px; background-color: {{ $pizza->ingredients->contains($ingredient->id) ? '#d4edda' : '#f8f9fa' }};"
                    onclick="toggleIngredient(this)"
                >
                    <p style="margin: 0;">{{ $ingredient->naam }}</p>
                    <p style="margin: 0; font-size: 12px;">€{{ number_format($ingredient->prijs, 2) }}</p>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Opslaan --}}
    <form action="{{ route('pizza.update', $pizza->id) }}" method="POST" style="margin-top: 20px;">
        @csrf
        <input type="hidden" name="ingredients" id="ingredients">
        <button type="submit" style="padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px;">Opslaan</button>
    </form>
</div>

<script>
    function toggleIngredient(element) {
        const ingredientId = element.getAttribute('data-id');
        const currentIngredients = new Set(
            Array.from(document.getElementById('current-ingredients').children).map(li => li.getAttribute('data-id'))
        );

        if (currentIngredients.has(ingredientId)) {
            // Verwijderen
            currentIngredients.delete(ingredientId);
            element.style.backgroundColor = '#f8f9fa';
        } else {
            // Toevoegen
            currentIngredients.add(ingredientId);
            element.style.backgroundColor = '#d4edda';
        }

        // Update hidden input
        document.getElementById('ingredients').value = Array.from(currentIngredients).join(',');
    }
</script>
@endsection
