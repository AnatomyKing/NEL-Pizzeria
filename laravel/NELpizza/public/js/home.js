let cart = [];
let total = 0;

function addToCart(name, price) {
    // Add item to cart
    cart.push({ name, price });
    total += price;

    // Update the cart display
    updateCart();
}

function updateCart() {
    const cartList = document.getElementById('cart-list');
    const cartTotal = document.getElementById('cart-total');

    // Clear the cart list
    cartList.innerHTML = '';

    // Add each item to the cart list
    cart.forEach((item, index) => {
        const listItem = document.createElement('li');
        listItem.innerHTML = `
            ${item.name} - €${item.price.toFixed(2)}
            <button onclick="removeFromCart(${index})" style="background:none;border:none;color:red;cursor:pointer;">x</button>
        `;
        cartList.appendChild(listItem);
    });

    // Update the total price
    cartTotal.textContent = total.toFixed(2);
}

function removeFromCart(index) {
    // Remove the item from the cart
    total -= cart[index].price;
    cart.splice(index, 1);

    // Update the cart display
    updateCart();
}
