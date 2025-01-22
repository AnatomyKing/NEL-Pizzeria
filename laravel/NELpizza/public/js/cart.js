// public/js/cart.js

document.addEventListener('DOMContentLoaded', () => {
    renderCart();
    document.getElementById('placeOrderBtn').addEventListener('click', placeOrder);
});

/**
 * Render cart items from localStorage into the page.
 */
function renderCart() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    const cartItemsContainer = document.getElementById('cartItemsContainer');
    cartItemsContainer.innerHTML = '';

    let total = 0;

    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;

        let ingredientList = item.chosenIngredients
            .filter(ing => ing.quantity > 0)  // Show only selected ingredients
            .map(ing => `${ing.name} (x${ing.quantity})`)
            .join(', ');

        const div = document.createElement('div');
        div.classList.add('cart-item');
        div.innerHTML = `
            <img src="${item.imageUrl}" alt="${item.name}" class="cart-item-image">
            <div class="cart-item-info">
                <h4>${item.name}</h4>
                <p>Quantity: ${item.quantity}</p>
                <p>Ingredients: ${ingredientList}</p>
                <p>Item total: €${itemTotal.toFixed(2)}</p>
                <button class="remove-btn" onclick="removeItem(${index})">Remove</button>
            </div>
        `;
        cartItemsContainer.appendChild(div);
    });

    document.getElementById('cartTotal').textContent = total.toFixed(2);
}

/**
 * Remove a single item from the cart, by index.
 */
function removeItem(index) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart.splice(index, 1);
    localStorage.setItem('cart', JSON.stringify(cart));
    renderCart();
}

/**
 * Convert numeric multiplier to text
 */
function sizeText(multiplier) {
    if (multiplier === 0.8) return 'Small';
    if (multiplier === 1)   return 'Medium';
    if (multiplier === 1.2) return 'Large';
    return 'Unknown';
}

/**
 * Called when user clicks "Place Order"
 * Sends cart & user info to /bestel
 */
async function placeOrder() {
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart.length === 0) {
        alert("Your cart is empty!");
        return;
    }

    // Collect user info from the form
    const naam           = document.getElementById('naam').value.trim();
    const adres          = document.getElementById('adres').value.trim();
    const woonplaats     = document.getElementById('woonplaats').value.trim();
    const telefoonnummer = document.getElementById('telefoonnummer').value.trim();
    const emailadres     = document.getElementById('emailadres').value.trim();

    // Basic validation
    if (!naam || !adres || !woonplaats || !telefoonnummer || !emailadres) {
        alert("Please fill in all fields!");
        return;
    }

    try {
        const response = await fetch('/bestel', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify({
                cart,
                naam,
                adres,
                woonplaats,
                telefoonnummer,
                emailadres
            })
        });

        if (!response.ok) {
            throw new Error("Error placing order");
        }

        const data = await response.json();
        alert(data.message);

        // Clear cart
        localStorage.removeItem('cart');

        // Redirect to /bestel or success page
        window.location.href = '/bestel';
    } catch (error) {
        console.error(error);
        alert("Something went wrong while placing the order.");
    }
}
