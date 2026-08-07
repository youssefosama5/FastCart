document.addEventListener('DOMContentLoaded', () => renderFav(true));

async function renderFav(showLoading = false) {
    const container = document.getElementById('fav-content');
    if (!container) return;

    if (showLoading) {
        container.innerHTML = '<p class="text-center">Loading...</p>';
    }

    try {
        const res = await fetch(ROOT + 'action/get_fav.php', { credentials: 'same-origin' });
        const data = await res.json();

        if (data.needLogin) {
            container.innerHTML = `<p class="text-center" style="margin-bottom:5em">Please log in first to see your favorites. <a href="${ROOT}pages/login.php">Login</a></p>`;
            return;
        }

        renderFavItems(data.items || []);
    } catch (e) {
        container.innerHTML = '<p class="text-center">There was a problem loading your favorites</p>';
    }
}

function renderFavItems(fav) {
    const container = document.getElementById('fav-content');
    if (!container) return;

    if (fav.length === 0) {
        container.innerHTML = '<p class="text-center" style="margin-bottom:5em">No items in fav</p>';
        return;
    }

    let itemsHtml = '<div class="items-fav">';
    fav.forEach(item => {
        itemsHtml += `
            <div class="item-fav d-flex align-items-center justify-content-evenly flex-column">
                <figure>
                    <img src="${item.img}" alt="" />
                </figure>
                <h3 class="m-0">${item.title}</h3>
                <span>$${item.price}</span>
                <div class="btn1">
                    <button type="button" class="btn btn-outline-success me-3" data-action="move-to-cart" data-id="${item.id}"><i class="fa-solid fa-cart-shopping"></i></button>
                    <button type="button" class="btn btn-outline-danger" data-action="remove-fav" data-id="${item.id}"><i class="fa-solid fa-trash"></i></button>
                </div>
            </div>`;
    });
    itemsHtml += '</div>';
    itemsHtml += '<button type="button" class="btn btn-danger" id="clear-fav-btn" style="margin-top:3em">clear fav</button>';

    container.innerHTML = itemsHtml;
    attachFavEvents();
}

function attachFavEvents() {
    document.querySelectorAll('[data-action="move-to-cart"]').forEach(btn => {
        btn.addEventListener('click', async () => {
            const titleEl = btn.closest('.item-fav')?.querySelector('h3');
            await addToCart(btn.dataset.id, titleEl ? titleEl.textContent : '');
        });
    });

    document.querySelectorAll('[data-action="remove-fav"]').forEach(btn => {
        btn.addEventListener('click', async () => {
            const res = await fetch(ROOT + 'action/fav_remove.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: new URLSearchParams({ product_id: btn.dataset.id }).toString(),
            });
            const data = await res.json();
            if (data.success) {
                updateHeaderCounts(undefined, data.favCount);
                renderFav();
            }
        });
    });

    const clearBtn = document.getElementById('clear-fav-btn');
    if (clearBtn) {
        clearBtn.addEventListener('click', async () => {
            const res = await fetch(ROOT + 'action/fav_clear.php', {
                method: 'POST',
                credentials: 'same-origin',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: '',
            });
            const data = await res.json();
            if (data.success) {
                updateHeaderCounts(undefined, data.favCount);
                renderFav();
            }
        });
    }
}
