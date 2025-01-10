@extends('layouts.app')

@section('title', 'Example Page')
@section('screen-title')
@section('menu-title', 'Example Menu')

@section('content')
<!-- Example: optionally link a modern Google Font -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" />

<style>
    /* ----- Global Styles / Font ----- */
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        background: #f5f5f5; /* Light gray background for a modern feel */
    }

    h2 {
        font-weight: 700;
        color: #222;
        text-align: center;
        margin-top: 40px;
    }

    /* ----- Main Container for "Best Sellers" ----- */
    .best-sellers {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 20px;
    }

/* ----- Grid Layout ----- */
.pizza-gallery {
    display: grid;
    grid-template-columns: repeat(3, 1fr); /* exactly 3 columns */
    gap: 30px;
    margin-top: 30px;
    margin-bottom: 50px;
}


    /* ----- Individual Pizza Item ----- */
    .pizza-item {
        background-color: #fff;
        text-align: center;
        cursor: pointer;
        transition: transform 0.3s, box-shadow 0.3s;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
    }

    .pizza-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.08);
    }

    .pizza-item img {
        width: 100px;
        height: auto;
        margin-bottom: 10px;
        border-radius: 8px;
        transition: transform 0.3s;
    }

    .pizza-item:hover img {
        transform: scale(1.1);
    }

    .pizza-item p {
        font-size: 1.1rem;
        margin: 10px 0 0 0;
        font-weight: 500;
        color: #444;
    }

    /* ----- Modal Overlay + Content ----- */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6); /* slightly darker overlay */
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }

    .modal-overlay.active {
        display: flex;
    }

    .modal-content {
        background-color: #fff;
        width: 90%;
        max-width: 600px;
        display: flex;
        flex-wrap: wrap;
        padding: 20px;
        border-radius: 12px;
        position: relative;
        box-shadow: 0 2px 10px rgba(0,0,0,0.15);
    }

    /* Close button in top-right corner */
    .close-button {
        position: absolute;
        top: 10px;
        right: 20px;
        background: transparent;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #777;
        transition: color 0.2s;
    }

    .close-button:hover {
        color: #333;
    }

    /* Larger image on the left, text on the right on bigger screens */
    .modal-image {
        flex: 1 1 300px;
        max-width: 300px;
        margin-right: 20px;
        text-align: center;
        margin-bottom: 20px; /* space for smaller screens */
    }
    .modal-image img {
        width: 100%;
        height: auto;
        border-radius: 12px;
    }

    .modal-details {
        flex: 1 1 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .modal-details h3 {
        font-size: 1.7rem;
        margin-bottom: 10px;
        font-weight: 700;
        color: #222;
    }
    .modal-details p {
        margin-bottom: 10px;
        font-size: 1.2rem;
        color: #666;
    }
</style>

<div class="best-sellers">
    <h2>Onze best verkochte pizza</h2>
    <div class="pizza-gallery">
        <!-- Pizza 1 -->
        <div class="pizza-item"
             onclick="openModal('/images/m.png', 'Pizza Margherita', '€8,50')">
            <img src="/images/m.png" alt="Pizza Margherita">
            <p>Pizza Margherita</p>
        </div>

        <!-- Pizza 2 -->
        <div class="pizza-item"
             onclick="openModal('/images/p.png', 'Pizza Pepperoni', '€9,00')">
            <img src="/images/p.png" alt="Pizza Pepperoni">
            <p>Pizza Pepperoni</p>
        </div>

        <!-- Pizza 3 -->
        <div class="pizza-item"
             onclick="openModal('/images/h.png', 'Pizza Hawaï', '€8,75')">
            <img src="/images/h.png" alt="Pizza Hawaï">
            <p>Pizza Hawaï</p>
        </div>

        <!-- Pizza 4 -->
        <div class="pizza-item"
             onclick="openModal('/images/f.png', 'Pizza Funghi', '€9,25')">
            <img src="/images/f.png" alt="Pizza Funghi">
            <p>Pizza Funghi</p>
        </div>

        <!-- Pizza 5 -->
        <div class="pizza-item"
             onclick="openModal('/images/q.png', 'Pizza Quattro Formaggi', '€10,00')">
            <img src="/images/q.png" alt="Pizza Quattro Formaggi">
            <p>Pizza Quattro Formaggi</p>
        </div>

        <!-- Pizza 6 -->
        <div class="pizza-item"
             onclick="openModal('/images/s.png', 'Pizza Salami', '€8,50')">
            <img src="/images/s.png" alt="Pizza Salami">
            <p>Pizza Salami</p>
        </div>
    </div>
</div>

<!-- ===== Modal HTML ===== -->
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

<script>
    function openModal(imageSrc, pizzaName, pizzaPrice) {
        // Update modal content
        document.getElementById('pizzaModalImage').src = imageSrc;
        document.getElementById('pizzaModalName').textContent = pizzaName;
        document.getElementById('pizzaModalPrice').textContent = pizzaPrice;

        // Show modal
        document.getElementById('pizzaModalOverlay').classList.add('active');
    }

    function closeModal() {
        // Hide modal
        document.getElementById('pizzaModalOverlay').classList.remove('active');
    }
</script>
@endsection
