
let currentCart = [];

document.addEventListener('DOMContentLoaded', () => renderCart(true));

async function renderCart(showLoading = false) {
    const container = document.getElementById('cart-content');
    if (!container) return;

    if (showLoading) {
        container.innerHTML = '<p class="mt-3">Loading...</p>';
    }

    try {
        const res = await fetch(ROOT + 'action/get_cart.php', { credentials: 'same-origin' });
        const data = await res.json();

        if (data.needLogin) {
            container.innerHTML = `<p class="mt-3">Please log in first to see your cart. <a href="${ROOT}pages/login.php">Login</a></p>`;
            return;
        }

        renderCartItems(data.items || []);
    } catch (e) {
        container.innerHTML = '<p class="mt-3">There was a problem loading your cart</p>';
    }
}

function renderCartItems(cart) {
    const container = document.getElementById('cart-content');
    if (!container) return;

    currentCart = cart;

    if (cart.length === 0) {
        container.innerHTML = '<p class="mt-3">No items in cart</p>';
        return;
    }

    let itemsHtml = '';
    cart.forEach(item => {
        itemsHtml += `
            <div class="item-cart">
                <figure>
                    <img src="${item.img}" alt="" />
                </figure>
                <div class="details">
                    <div class="head-det d-flex align-items-center justify-content-between w-100">
                        <h3>${item.title}</h3>
                        <span class="fs-3">$${item.price}</span>
                    </div>
                    <div class="edit d-flex align-items-center w-100 justify-content-between">
                        <div class="quantity gap-3 d-flex align-items-center">
                            <button type="button" class="qty-btn" data-action="decrease" data-id="${item.id}">-</button>
                            <p class="m-0 fs-4">${item.qun}</p>
                            <button type="button" class="qty-btn" data-action="increase" data-id="${item.id}">+</button>
                        </div>
                        <button type="button" class="del" data-action="remove" data-id="${item.id}"><i class="fa-solid fa-trash"></i></button>
                    </div>
                </div>
            </div>`;
    });

    const total = cart.reduce((acc, curr) => acc + curr.price * curr.qun, 0);

    container.innerHTML = `
        <div class="items-cart">
            <div class="items1">${itemsHtml}</div>
            <div class="total">
                <h2>check out</h2>
                <p class="fs-4">total: $${total}</p>
                <div class="btns">
                    <button type="button" class="btn-success btn me-3" id="checkout-btn">checkout</button>
                    <button type="button" class="btn-danger btn" id="clear-cart-btn">clear cart</button>
                </div>
            </div>
        </div>`;

    attachCartEvents();
}

function recalcAndUpdateTotal() {
    const totalEl = document.querySelector('.total p.fs-4');
    if (!totalEl) return;
    const total = currentCart.reduce((acc, curr) => acc + curr.price * curr.qun, 0);
    totalEl.textContent = `total: $${total}`;
}

function attachCartEvents() {
    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', () => {
            window.location.href = ROOT + 'pages/checkout.php';
        });
    }

    document.querySelectorAll('.qty-btn').forEach(btn => {
        btn.addEventListener('click', async () => {
            const res = await fetch(ROOT + 'action/cart_update.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({
                    product_id: btn.dataset.id,
                    op: btn.dataset.action,
                }).toString(),
            });
            const data = await res.json();
            if (data.success) {
                // Instead of re-rendering the whole page (which used to cause the
                // flicker and move the footer), just update the quantity and total in place
                const item = currentCart.find(i => String(i.id) === String(btn.dataset.id));
                if (item) item.qun = data.quantity;

                const qtyEl = btn.closest('.quantity')?.querySelector('p');
                if (qtyEl) qtyEl.textContent = data.quantity;

                recalcAndUpdateTotal();
            }
        });
    });

    document.querySelectorAll('[data-action="remove"]').forEach(btn => {
        btn.addEventListener('click', async () => {
            const res = await fetch(ROOT + 'action/cart_remove.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ product_id: btn.dataset.id }).toString(),
            });
            const data = await res.json();
            if (data.success) {
                updateHeaderCounts(data.cartCount, undefined);
                renderCart();
            }
        });
    });

    const clearBtn = document.getElementById('clear-cart-btn');
    if (clearBtn) {
        clearBtn.addEventListener('click', async () => {
            const res = await fetch(ROOT + 'action/cart_clear.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: '',
            });
            const data = await res.json();
            if (data.success) {
                updateHeaderCounts(data.cartCount, undefined);
                renderCart();
            }
        });
    }
}
