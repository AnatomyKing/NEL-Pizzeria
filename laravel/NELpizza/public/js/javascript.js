// public/js/javascript.js

document.addEventListener('DOMContentLoaded', () => {
    console.log('JavaScript loaded!');

    // ---------- MODAL LOGIC ----------
    window.openModal = function(imageSrc, pizzaName, pizzaPrice) {
        // Update modal content
        document.getElementById('pizzaModalImage').src = imageSrc;
        document.getElementById('pizzaModalName').textContent = pizzaName;
        document.getElementById('pizzaModalPrice').textContent = pizzaPrice;

        // Show modal
        document.getElementById('pizzaModalOverlay').classList.add('active');
    };

    window.closeModal = function() {
        // Hide modal
        document.getElementById('pizzaModalOverlay').classList.remove('active');
    };

    // ---------- ORDER CALCULATION ----------
    window.calculateTotal = function() {
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

        const totalPriceEl = document.getElementById('total-price');
        if (totalPriceEl) {
            totalPriceEl.textContent = total.toFixed(2).replace('.', ',');
        }
    };
});
