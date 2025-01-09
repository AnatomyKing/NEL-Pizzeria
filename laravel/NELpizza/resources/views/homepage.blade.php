@extends('layouts.app')

@section('title', 'Example Page')
@section('screen-title')
@section('menu-title', 'Example Menu')

@section('content')
<style>
    /* ----- Grid Layout ----- */
    .pizza-gallery {
        display: grid;
        grid-template-columns: repeat(3, 1fr); /* 3 columns */
        gap: 20px;
        max-width: 900px;       /* optional: limit overall width */
        margin: 0 auto;         /* center the grid container */
        padding: 20px 0;        /* some vertical spacing */
    }

    /* ----- Individual Pizza Item ----- */
    .pizza-item {
        text-align: center;
        cursor: pointer;                    /* visually indicates clickability */
        transition: transform 0.3s;
    }

    .pizza-item img {
        width: 100px;       /* smaller by default */
        height: auto;
        transition: transform 0.3s;
        border-radius: 8px; /* slightly rounded corners */
    }

    /* Enlarge only the image on hover */
    .pizza-item:hover img {
        transform: scale(1.1);
    }

    /* ----- Modal Overlay + Content ----- */
    .modal-overlay {
        display: none;                   /* hidden by default */
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5); /* semi-transparent black overlay */
        justify-content: center;
        align-items: center;
        z-index: 9999;                  /* ensure it sits on top of the page */
    }

    .modal-overlay.active {
        display: flex;                  /* show when active */
    }

    .modal-content {
        background-color: #fff;
        width: 90%;
        max-width: 600px;
        display: flex;
        flex-wrap: wrap;        /* wrap for smaller screens */
        padding: 20px;
        border-radius: 8px;
        position: relative;
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
    }

    /* Larger image on the left, text on the right on bigger screens */
    .modal-image {
        flex: 1 1 300px;
        max-width: 300px;
        margin-right: 20px;
        text-align: center;
    }
    .modal-image img {
        width: 100%;
        height: auto;
        border-radius: 8px;
    }

    .modal-details {
        flex: 1 1 200px;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .modal-details h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }
    .modal-details p {
        margin-bottom: 10px;
        font-size: 1.2rem;
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
