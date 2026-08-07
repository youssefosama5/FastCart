let checkoutCart = [];

document.addEventListener('DOMContentLoaded', () => {
    loadOrderSummary();

    const form = document.getElementById('checkout-form');
    if (form) {
        form.addEventListener('submit', handlePlaceOrder);
    }
});

async function loadOrderSummary() {
    const summaryEl = document.getElementById('order-summary');
    const placeOrderBtn = document.getElementById('place-order-btn');
    if (!summaryEl) return;

    try {
        const res = await fetch(ROOT + 'action/get_cart.php', { credentials: 'same-origin' });
        const data = await res.json();

        if (data.needLogin) {
            summaryEl.innerHTML = `<p class="checkout-msg">Please log in first to complete your order. <a href="${ROOT}pages/login.php">Login</a></p>`;
            if (placeOrderBtn) placeOrderBtn.disabled = true;
            return;
        }

        checkoutCart = data.items || [];

        if (checkoutCart.length === 0) {
            summaryEl.innerHTML = `<p class="checkout-msg">Your cart is empty. <a href="${ROOT}pages/shop.php">Go shopping first</a></p>`;
            if (placeOrderBtn) placeOrderBtn.disabled = true;
            return;
        }

        renderOrderSummary();
    } catch (e) {
        summaryEl.innerHTML = '<p class="checkout-msg">There was a problem loading your order data</p>';
        if (placeOrderBtn) placeOrderBtn.disabled = true;
    }
}

function renderOrderSummary() {
    const summaryEl = document.getElementById('order-summary');
    if (!summaryEl) return;

    let itemsHtml = '<h3>order summary</h3>';
    checkoutCart.forEach(item => {
        itemsHtml += `
            <div class="summary-item">
                <div class="name">
                    <figure><img src="${item.img}" alt="" /></figure>
                    <div>
                        <p class="m-0">${item.title}</p>
                        <span class="qty">qty: ${item.qun}</span>
                    </div>
                </div>
                <span>$${item.price * item.qun}</span>
            </div>`;
    });

    const total = checkoutCart.reduce((acc, curr) => acc + curr.price * curr.qun, 0);
    itemsHtml += `
        <div class="summary-total">
            <span>total</span>
            <span>$${total}</span>
        </div>`;

    summaryEl.innerHTML = itemsHtml;
}

async function handlePlaceOrder(e) {
    e.preventDefault();

    if (checkoutCart.length === 0) return;

    const placeOrderBtn = document.getElementById('place-order-btn');
    if (placeOrderBtn) {
        placeOrderBtn.disabled = true;
        placeOrderBtn.textContent = 'Placing your order...';
    }

    const payment = document.querySelector('input[name="payment"]:checked');

    const orderData = {
        full_name: document.getElementById('ch-name')?.value || '',
        phone: document.getElementById('ch-phone')?.value || '',
        address: document.getElementById('ch-address')?.value || '',
        city: document.getElementById('ch-city')?.value || '',
        postal_code: document.getElementById('ch-postal')?.value || '',
        payment_method: payment ? payment.value : 'cash',
    };

    try {
        const data = await postToServer('place_order.php', orderData);

        if (data.needLogin) {
            showToast('Please log in first to complete your order');
            setTimeout(() => { window.location.href = ROOT + 'pages/login.php'; }, 1200);
            return;
        }

        if (data.success) {
            updateHeaderCounts(data.cartCount, undefined);
            showToast(data.message || 'Your order has been placed successfully, it will arrive soon');
            setTimeout(() => { window.location.href = ROOT + 'index.php'; }, 1500);
        } else {
            showToast(data.message || 'Something went wrong, please try again');
            if (placeOrderBtn) {
                placeOrderBtn.disabled = false;
                placeOrderBtn.textContent = 'place order';
            }
        }
    } catch (err) {
        showToast('There was a problem connecting to the server');
        if (placeOrderBtn) {
            placeOrderBtn.disabled = false;
            placeOrderBtn.textContent = 'place order';
        }
    }
}
