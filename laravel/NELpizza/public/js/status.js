document.addEventListener("DOMContentLoaded", () => {
  const steps = ["initieel", "betaald", "bereiden", "inoven", "onderweg", "bezorgd"];
  const ordersContainer = document.getElementById('ordersContainer');
  const noOrdersMessage = document.getElementById('noOrdersMessage');

  let orders = JSON.parse(localStorage.getItem('orders')) || [];

  function renderOrders() {
      ordersContainer.innerHTML = '';

      if (orders.length === 0) {
          noOrdersMessage.style.display = "block";
          return;
      } else {
          noOrdersMessage.style.display = "none";
      }

      orders.forEach(order => {
          const orderDiv = document.createElement('div');
          orderDiv.classList.add('order-item');
          orderDiv.innerHTML = `
              <div class="order-title">Order #${order.id} - ${order.naam}</div>
              <div class="steps-wrapper">
                  <div class="steps" data-id="${order.id}">
                      ${steps.map((step, index) => `
                          <span class="step ${index <= order.statusIndex ? 'active' : ''}">${step}</span>
                      `).join('')}
                      <div class="progress-bar">
                          <span class="progress" style="width: ${(order.statusIndex / (steps.length - 1)) * 100}%;"></span>
                      </div>
                  </div>
                  <div class="buttons">
                      <button class="btn btn-prev" data-id="${order.id}" ${order.statusIndex === 0 ? 'disabled' : ''}>Previous</button>
                      <button class="btn btn-next" data-id="${order.id}" ${order.statusIndex === steps.length - 1 ? 'disabled' : ''}>Next</button>
                  </div>
              </div>
          `;
          ordersContainer.appendChild(orderDiv);
      });

      attachButtonListeners();
  }

  function attachButtonListeners() {
      document.querySelectorAll('.btn-prev').forEach(button => {
          button.addEventListener('click', (e) => {
              const orderId = e.target.getAttribute('data-id');
              updateOrderStatus(orderId, 'prev');
          });
      });

      document.querySelectorAll('.btn-next').forEach(button => {
          button.addEventListener('click', (e) => {
              const orderId = e.target.getAttribute('data-id');
              updateOrderStatus(orderId, 'next');
          });
      });
  }

  function updateOrderStatus(orderId, direction) {
      const orderIndex = orders.findIndex(order => order.id == orderId);
      if (orderIndex !== -1) {
          let newIndex = orders[orderIndex].statusIndex;
          newIndex = direction === "next" ? newIndex + 1 : newIndex - 1;
          if (newIndex >= 0 && newIndex < steps.length) {
              orders[orderIndex].statusIndex = newIndex;
              saveOrders();
              renderOrders();
              sendStatusToServer(orderId, steps[newIndex]);
          }
      }
  }

  function saveOrders() {
      localStorage.setItem('orders', JSON.stringify(orders));
  }

  async function sendStatusToServer(orderId, status) {
      try {
          await fetch(`/order/status/${orderId}`, {
              method: "POST",
              headers: {
                  "Content-Type": "application/json",
                  "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              },
              body: JSON.stringify({ status }),
          });
      } catch (error) {
          console.error("Error:", error);
      }
  }

  renderOrders();
});
