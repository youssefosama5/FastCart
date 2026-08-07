const ROOT = window.APP_ROOT || '';

// ---------- generic call to action/*.php files ----------
async function postToServer(action, data = {}) {
    const body = new URLSearchParams(data);
    const res = await fetch(ROOT + 'action/' + action, {
        method: 'POST',
        credentials: 'same-origin', // important so the session (login) cookie is sent with every request
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: body.toString(),
    });
    return res.json();
}

function updateHeaderCounts(cartCount, favCount) {
    const cartCountEl = document.querySelector('a[href*="cart.php"] .num');
    const favCountEl = document.querySelector('a[href*="fav.php"] .num');
    if (cartCountEl && cartCount !== undefined && cartCount !== null) cartCountEl.textContent = cartCount;
    if (favCountEl && favCount !== undefined && favCount !== null) favCountEl.textContent = favCount;
}


function showToast(message) {
    const container = document.getElementById('toast-container');
    if (!container) return;
    const toast = document.createElement('div');
    toast.className = 'toast-msg';
    toast.textContent = message;
    container.appendChild(toast);
    requestAnimationFrame(() => toast.classList.add('show'));
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => toast.remove(), 300);
    }, 2500);
}


async function addToCart(productId, title) {
    try {
        const data = await postToServer('cart_add.php', { product_id: productId });

        if (data.needLogin) {
            showToast('Please log in first to add to cart');
            setTimeout(() => { window.location.href = ROOT + 'pages/login.php'; }, 1200);
            return data;
        }
        if (!data.success) {
            showToast(data.message || 'Something went wrong, please try again');
            return data;
        }

        showToast(data.message || 'Product added to cart');
        updateHeaderCounts(data.cartCount, undefined);
        return data;
    } catch (e) {
        showToast('There was a problem connecting to the server');
    }
}


async function addToFav(productId, title, btn) {
    try {
        const data = await postToServer('fav_toggle.php', { product_id: productId });

        if (data.needLogin) {
            showToast('Please log in first to add to favorites');
            setTimeout(() => { window.location.href = ROOT + 'pages/login.php'; }, 1200);
            return data;
        }
        if (!data.success) {
            showToast(data.message || 'Something went wrong, please try again');
            return data;
        }

        if (btn) btn.classList.toggle('active', !!data.added);
        showToast(data.message || (data.added ? 'Product added to favorites' : 'Product removed from favorites'));
        updateHeaderCounts(undefined, data.favCount);
        return data;
    } catch (e) {
        showToast('There was a problem connecting to the server');
    }
}


function initCartAndFav() {
    document.querySelectorAll('.add-cart-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            addToCart(btn.dataset.id, btn.dataset.title);
        });
    });

    document.querySelectorAll('.add-fav-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            addToFav(btn.dataset.id, btn.dataset.title, btn);
        });
    });
}
