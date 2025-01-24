document.addEventListener("DOMContentLoaded", () => {
    const steps = ["besteld", "bereiden", "inoven", "uitoven", "onderweg", "bezorgd"];

    const ordersContainer = document.getElementById('ordersContainer');
    const noOrdersMessage = document.getElementById('noOrdersMessage');

    // Load local orders
    let orders = JSON.parse(localStorage.getItem('orders')) || [];

    // Remove duplicates from localStorage
    const uniqueOrdersMap = new Map();
    orders.forEach(order => {
        // key = order.id, value = order object
        uniqueOrdersMap.set(order.id, order);
    });
    orders = Array.from(uniqueOrdersMap.values());
    localStorage.setItem('orders', JSON.stringify(orders));

    // Helper to save local orders
    function saveOrders() {
        localStorage.setItem('orders', JSON.stringify(orders));
    }

    // 1) Validate orders: check which ones still exist on the server
    // 2) If an order does not exist, remove it from local
    async function validateOrders() {
        if (orders.length === 0) return;

        // Make a single call, passing all order IDs
        const ids = orders.map(o => o.id);
        let serverStatuses = {};
        try {
            const response = await fetch(`/order/statuses`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ ids }),
            });

            if (response.ok) {
                serverStatuses = await response.json();
            } else {
                // if there's an error, we'll do nothing special here
            }
        } catch (error) {
            console.error("Error fetching statuses:", error);
            return;
        }

        // Now remove any local order whose ID is NOT in serverStatuses keys
        for (let i = orders.length - 1; i >= 0; i--) {
            const orderId = orders[i].id;
            if (!serverStatuses.hasOwnProperty(orderId)) {
                orders.splice(i, 1);
            }
        }

        // Also update local status for the orders that do exist
        orders.forEach(order => {
            if (serverStatuses[order.id]) {
                order.status = serverStatuses[order.id];
            }
        });

        saveOrders();
    }

    // Render the orders in the DOM
    function renderOrders() {
        ordersContainer.innerHTML = '';

        if (orders.length === 0) {
            noOrdersMessage.style.display = "block";
            return;
        } else {
            noOrdersMessage.style.display = "none";
        }

        for (const order of orders) {
            const statusIndex = steps.indexOf(order.status);

            const orderDiv = document.createElement('div');
            orderDiv.classList.add('order-item');
            orderDiv.innerHTML = `
                <div class="order-title">Order #${order.id} - ${order.naam}</div>
                <div class="steps-wrapper">
                    <div class="steps" data-id="${order.id}">
                        ${steps.map((step, idx) => `
                            <span class="step ${idx <= statusIndex ? 'active' : ''}">
                                ${step}
                            </span>
                        `).join('')}
                    </div>
                    <div class="buttons">
                        <button 
                            class="btn btn-cancel" 
                            data-id="${order.id}"
                            ${order.status !== 'besteld' ? 'disabled' : ''}
                        >
                            Annuleer
                        </button>
                    </div>
                </div>
            `;
            ordersContainer.appendChild(orderDiv);
        }

        attachButtonListeners();
    }

    // Attach listener to Annuleer button
    function attachButtonListeners() {
        const cancelButtons = document.querySelectorAll('.btn-cancel');
        cancelButtons.forEach(btn => {
            btn.addEventListener('click', () => {
                const orderId = btn.getAttribute('data-id');
                cancelOrder(orderId);
            });
        });
    }

    // Send 'geannuleerd' status to server, then remove from local
    async function cancelOrder(orderId) {
        try {
            const response = await fetch(`/order/status/${orderId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ status: 'geannuleerd' }),
            });

            if (!response.ok) {
                console.error("Error canceling order:", response.statusText);
                return;
            }

            // Remove from local after successful cancellation
            orders = orders.filter(order => order.id != orderId);
            saveOrders();
            renderOrders();
        } catch (error) {
            console.error("Error canceling the order:", error);
        }
    }

    // Periodically fetch updated statuses in one go
    async function fetchOrderStatuses() {
        if (orders.length === 0) return;
        
        // Single bulk request
        const ids = orders.map(o => o.id);
        try {
            const response = await fetch(`/order/statuses`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ ids }),
            });
            
            if (!response.ok) {
                console.error(`Failed to fetch statuses. HTTP status = ${response.status}`);
                return;
            }

            const data = await response.json();
            // data is like { "1":"besteld", "2":"inoven", ... }

            // Update each local order if found
            // If an order is not in data at all, it's presumably missing or canceled
            for (let i = orders.length - 1; i >= 0; i--) {
                const o = orders[i];
                if (data[o.id]) {
                    if (data[o.id] === 'geannuleerd') {
                        // If it's canceled on the server, remove it locally
                        orders.splice(i, 1);
                    } else {
                        // Otherwise update local status
                        o.status = data[o.id];
                    }
                } else {
                    // Not present in the response => it doesn't exist on the server
                    orders.splice(i, 1);
                }
            }

            saveOrders();
            renderOrders();
        } catch (error) {
            console.error("Error fetching order statuses:", error);
        }
    }

    // Initial steps on page load:
    // 1) Validate orders (remove those not existing on server)
    // 2) Render
    // 3) Setup interval to refresh statuses
    (async () => {
        await validateOrders();
        renderOrders();
        setInterval(fetchOrderStatuses, 10000); // every 10 seconds
    })();
});
