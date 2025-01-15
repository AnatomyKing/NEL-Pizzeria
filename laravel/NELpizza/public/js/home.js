let cart = [];
let total = 0;

function addToCart(name, description, price, imageUrl) {
    cart.push({ name, description, price, imageUrl });
    total += price;
    updateCart();
}

function updateCart() {
    const cartList = document.getElementById('cart-list');
    const cartTotal = document.getElementById('cart-total');
    cartList.innerHTML = '';

    cart.forEach((item, index) => {
        const listItem = document.createElement('li');
        listItem.innerHTML = `
            <img src="${item.imageUrl}" alt="${item.name}" style="width:50px; height:50px; border-radius:5px; margin-right:10px;">
            <span>${item.name} - €${item.price.toFixed(2)}</span>
            <button onclick="removeFromCart(${index})" style="background:none;border:none;color:red;cursor:pointer;">x</button>
        `;
        cartList.appendChild(listItem);
    });

    cartTotal.textContent = total.toFixed(2);
}

function removeFromCart(index) {
    total -= cart[index].price;
    cart.splice(index, 1);
    updateCart();
}
