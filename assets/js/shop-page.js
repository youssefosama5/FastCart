document.addEventListener('DOMContentLoaded', () => {
    initCartAndFav();
    initShopFilter();
});

function initShopFilter() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const products = document.querySelectorAll('.product');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            filterButtons.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const category = btn.dataset.filter;

            products.forEach(product => {
                const show = (category === 'all' || product.dataset.category === category);
                if (show) {
                    product.style.removeProperty('display');
                } else {
                    product.style.setProperty('display', 'none', 'important');
                }
            });
        });
    });
}
