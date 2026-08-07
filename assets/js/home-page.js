document.addEventListener('DOMContentLoaded', () => {
    initScrollButtons();
    initCartAndFav();
    initCountdowns();
});

function initScrollButtons() {
    const buttons = document.querySelectorAll('.scroll-btn');
    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            const targetId = btn.dataset.target;
            const dir = btn.dataset.dir;
            const container = document.getElementById(targetId);
            if (!container) return;
            const amount = 350;
            container.scrollBy({
                left: dir === 'left' ? -amount : amount,
                behavior: 'smooth',
            });
        });
    });
}

function initCountdowns() {
    const countdowns = document.querySelectorAll('[data-countdown]');
    if (!countdowns.length) return;

    const targetTime = new Date().getTime() + 1000 * 60 * 60 * 24 * 3; // 3 days from now

    function render() {
        const timeLeft = targetTime - new Date().getTime();
        const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
        const hours = Math.floor((timeLeft / (1000 * 60 * 60)) % 24);
        const minutes = Math.floor((timeLeft / (1000 * 60)) % 60);
        const seconds = Math.floor((timeLeft / 1000) % 60);

        countdowns.forEach(el => {
            el.innerHTML =
                `<span>${days}</span>:<span>${hours}</span>:<span>${minutes}</span>:<span>${seconds}</span>`;
        });
    }

    render();
    setInterval(render, 1000);
}
