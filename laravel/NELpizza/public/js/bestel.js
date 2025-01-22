// public/js/bestel.js

// Load existing cart from localStorage
let cart = JSON.parse(localStorage.getItem('cart')) || [];
let total = 0;
let currentPizza = {};
let basePrice = 0;
let selectedIngredients = [];

// Open the modal to configure a pizza
function openModal(imageSrc, pizzaName, pizzaDescription, pizzaPrice, pizzaId, pizzaIngredients) {
    currentPizza = {
        pizza_id: pizzaId,
        name: pizzaName || 'Unknown Pizza',
        description: pizzaDescription || 'No description available.',
        price: parseFloat(pizzaPrice) || 0,
        imageUrl: imageSrc ? imageSrc : '/images/default.png'
    };

    basePrice = currentPizza.price;
    selectedIngredients = [...pizzaIngredients];

    // Set modal fields
    document.getElementById('pizzaModalImage').src = currentPizza.imageUrl;
    document.getElementById('pizzaModalName').textContent = currentPizza.name;
    document.getElementById('pizzaModalDescription').textContent = currentPizza.description;

    buildIngredientList(pizzaIngredients);

    // Reset size to "Medium" (multiplier = 1)
    document.getElementById('pizza-size').value = "1";

    // Update the modal price
    updateModalPrice();

    // Re-attach event listeners
    document.getElementById('pizza-size').addEventListener('change', updateModalPrice);
    const ingredientCheckboxes = document.querySelectorAll('#ingredient-list input[type="checkbox"]');
    ingredientCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', updateModalPrice);
    });

    // Show the modal
    document.getElementById('pizzaModalOverlay').classList.add('active');
}

// Build the checkboxes for the pizza’s ingredients
function buildIngredientList(pizzaIngredients) {
    const ingredientListDiv = document.getElementById('ingredient-list');
    ingredientListDiv.innerHTML = '';

    pizzaIngredients.forEach((ingredient) => {
        const label = document.createElement('label');
        label.style.display = 'block';

        const checkbox = document.createElement('input');
        checkbox.type = 'checkbox';
        checkbox.checked = true;
        checkbox.value = ingredient.id;
        checkbox.dataset.price = ingredient.prijs;
        checkbox.dataset.name = ingredient.naam;

        label.appendChild(checkbox);
        label.appendChild(
            document.createTextNode(
                `${ingredient.naam} (+€${parseFloat(ingredient.prijs).toFixed(2)})`
            )
        );

        ingredientListDiv.appendChild(label);
    });
}

// Update the modal price based on base price, ingredients, and size
function updateModalPrice() {
    let sumIngredients = 0;

    // Sum up checked ingredients
    const ingredientCheckboxes = document.querySelectorAll('#ingredient-list input[type="checkbox"]');
    ingredientCheckboxes.forEach((cb) => {
        if (cb.checked) {
            sumIngredients += parseFloat(cb.dataset.price);
        }
    });

    let subtotal = basePrice + sumIngredients;
    const sizeMultiplier = parseFloat(document.getElementById('pizza-size').value);
    const finalPrice = subtotal * sizeMultiplier;

    currentPizza.price = finalPrice;
    document.getElementById('pizzaModalPrice').textContent = `€${finalPrice.toFixed(2)}`;
}

// Close the pizza config modal
function closeModal() {
    document.getElementById('pizzaModalOverlay').classList.remove('active');
}

// Add the configured pizza to cart
function addToCartFromModal() {
    const ingredientCheckboxes = document.querySelectorAll('#ingredient-list input[type="checkbox"]');
    let chosenIngredients = [];

    // Gather selected ingredients
    ingredientCheckboxes.forEach((cb) => {
        if (cb.checked) {
            chosenIngredients.push({
                id: cb.value,
                name: cb.dataset.name,
                price: parseFloat(cb.dataset.price)
            });
        }
    });

    const sizeMultiplier = parseFloat(document.getElementById('pizza-size').value);

    addToCart(
        currentPizza.pizza_id,
        currentPizza.name,
        currentPizza.description,
        currentPizza.price,
        currentPizza.imageUrl,
        sizeMultiplier,
        chosenIngredients
    );

    closeModal();
}

// Actually push the item into the cart array
function addToCart(pizza_id, name, description, price, imageUrl, sizeMultiplier, chosenIngredients) {
    // Check if exact same pizza (same size & same ingredients) is in cart
    const existingIndex = cart.findIndex(item =>
        item.pizza_id === pizza_id &&
        item.sizeMultiplier === sizeMultiplier &&
        JSON.stringify(item.chosenIngredients) === JSON.stringify(chosenIngredients)
    );

    if (existingIndex >= 0) {
        // Increase quantity
        cart[existingIndex].quantity += 1;
    } else {
        // Add as new
        cart.push({
            pizza_id,
            name,
            description,
            price: parseFloat(price),
            imageUrl,
            quantity: 1,
            sizeMultiplier,
            chosenIngredients
        });
    }

    updateCartTotal();
    saveCart();
    renderCart();
}

// Update the small cart summary on /bestel
function renderCart() {
    const cartList = document.getElementById('cart-list');
    if (!cartList) return; // If the element doesn't exist, skip

    cartList.innerHTML = '';

    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        const li = document.createElement('li');
        li.innerHTML = `
            <img src="${item.imageUrl}" alt="${item.name}" 
                 style="width:50px; height:50px; border-radius:5px; margin-right:10px;">
            <span>
                ${item.name} (x${item.quantity}) - €${itemTotal.toFixed(2)}
                <br/>
                Size: ${sizeText(item.sizeMultiplier)}
            </span>
            <button onclick="removeFromCart(${index})"
                    style="background:none; border:none; color:red; cursor:pointer;">
                x
            </button>
        `;
        cartList.appendChild(li);
    });
}

// Remove a single item from cart
function removeFromCart(index) {
    cart.splice(index, 1);
    updateCartTotal();
    saveCart();
    renderCart();
}

// Helper function to convert numeric multiplier to text
function sizeText(multiplier) {
    if (multiplier === 0.8) return 'Small';
    if (multiplier === 1)   return 'Medium';
    if (multiplier === 1.2) return 'Large';
    return 'Unknown';
}

// Recalculate total for the summary
function updateCartTotal() {
    total = 0;
    for (let item of cart) {
        total += item.price * item.quantity;
    }
    const cartTotalEl = document.getElementById('cart-total');
    if (cartTotalEl) {
        cartTotalEl.textContent = total.toFixed(2);
    }
}

// Save cart to localStorage
function saveCart() {
    localStorage.setItem('cart', JSON.stringify(cart));
}

// On page load, restore the cart and render summary
document.addEventListener('DOMContentLoaded', () => {
    cart = JSON.parse(localStorage.getItem('cart')) || [];
    renderCart();
    updateCartTotal();
});
