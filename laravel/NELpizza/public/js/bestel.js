let cart = [];
let total = 0;
let currentPizza = {};
let basePrice = 0;
let selectedIngredients = [];

// Open modal
function openModal(imageSrc, pizzaName, pizzaDescription, pizzaPrice, pizzaId, pizzaIngredients) {
    currentPizza = {
        pizza_id: pizzaId,
        name: pizzaName || 'Unknown Pizza',
        description: pizzaDescription || 'No description available.',
        price: parseFloat(pizzaPrice) || 0,
        imageUrl: imageSrc || ''
    };

    basePrice = currentPizza.price;
    selectedIngredients = [...pizzaIngredients];

    // Set modal fields
    document.getElementById('pizzaModalImage').src = currentPizza.imageUrl;
    document.getElementById('pizzaModalName').textContent = currentPizza.name;
    document.getElementById('pizzaModalDescription').textContent = currentPizza.description;

    buildIngredientList(pizzaIngredients);

    // Reset size to "Medium" = 1
    document.getElementById('pizza-size').value = "1";  // Medium size is default

    // Update and display price
    updateModalPrice();

    // Add an event listener to update price when the size changes
    document.getElementById('pizza-size').addEventListener('change', updateModalPrice);

    // Add event listeners for each ingredient checkbox to update price dynamically
    const ingredientCheckboxes = document.querySelectorAll('#ingredient-list input[type="checkbox"]');
    ingredientCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener('change', updateModalPrice);  // Recalculate price on ingredient change
    });

    // Show modal
    document.getElementById('pizzaModalOverlay').classList.add('active');
}

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

        checkbox.addEventListener('change', () => {
            updateModalPrice();
        });

        label.appendChild(checkbox);
        label.appendChild(
            document.createTextNode(
                ` ${ingredient.naam} (+€${parseFloat(ingredient.prijs).toFixed(2)})`
            )
        );

        ingredientListDiv.appendChild(label);
    });
}

function updateModalPrice() {
    let sumIngredients = 0;

    // Calculate the price of selected ingredients
    const ingredientCheckboxes = document.querySelectorAll('#ingredient-list input[type="checkbox"]');
    ingredientCheckboxes.forEach((cb) => {
        if (cb.checked) {
            sumIngredients += parseFloat(cb.dataset.price);
        }
    });

    // Calculate the subtotal (base price + ingredient prices)
    let subtotal = basePrice + sumIngredients;

    // Get the selected pizza size (Medium = 1, Small = 0.8, Large = 1.2)
    const sizeMultiplier = parseFloat(document.getElementById('pizza-size').value);

    // Calculate the final price considering the size
    const finalPrice = subtotal * sizeMultiplier;

    // Update the final price in the modal
    currentPizza.price = finalPrice;
    document.getElementById('pizzaModalPrice').textContent = `€${finalPrice.toFixed(2)}`;
}

function closeModal() {
    document.getElementById('pizzaModalOverlay').classList.remove('active');
}

function addToCartFromModal() {
    const ingredientCheckboxes = document.querySelectorAll('#ingredient-list input[type="checkbox"]');
    let chosenIngredients = [];

    // Get selected ingredients
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

function addToCart(pizza_id, name, description, price, imageUrl, sizeMultiplier, chosenIngredients) {
    const existingItemIndex = cart.findIndex(item =>
        item.pizza_id === pizza_id &&
        item.sizeMultiplier === sizeMultiplier &&
        JSON.stringify(item.chosenIngredients) === JSON.stringify(chosenIngredients)
    );

    if (existingItemIndex >= 0) {
        cart[existingItemIndex].quantity += 1;
    } else {
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

    total += parseFloat(price);
    updateCart();
}

function updateCart() {
    const cartList = document.getElementById('cart-list');
    const cartTotal = document.getElementById('cart-total');
    cartList.innerHTML = '';
    total = 0;

    cart.forEach((item, index) => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;

        const listItem = document.createElement('li');
        listItem.innerHTML = `
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
        cartList.appendChild(listItem);
    });

    cartTotal.textContent = total.toFixed(2);
}

function removeFromCart(index) {
    total -= cart[index].price * cart[index].quantity;
    cart.splice(index, 1);
    updateCart();
}

function sizeText(multiplier) {
    if (multiplier === 0.8) return 'Small';
    if (multiplier === 1)   return 'Medium';
    if (multiplier === 1.2) return 'Large';
    
    return 'Unknown';
}

async function placeOrder() {
    if (cart.length === 0) {
        alert("Your cart is empty!");
        return;
    }

    try {
        const response = await fetch('/order', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute('content')
            },
            body: JSON.stringify({ cart })
        });

        if (!response.ok) {
            throw new Error("Error placing order.");
        }

        const data = await response.json();
        alert(data.message);

        // Empty the cart after placing order
        cart = [];
        total = 0;
        updateCart();
    } catch (error) {
        console.error(error);
        alert("Something went wrong while placing the order.");
    }
}
