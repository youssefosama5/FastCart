document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('contact-form');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const submitBtn = form.querySelector('button[type="submit"]');
        if (submitBtn) submitBtn.disabled = true;

        try {
            const data = await postToServer('contact_submit.php', {
                name: document.getElementById('c-name')?.value || '',
                email: document.getElementById('c-email')?.value || '',
                subject: document.getElementById('c-subject')?.value || '',
                message: document.getElementById('c-message')?.value || '',
            });

            if (data.success) {
                showToast(data.message || 'Your message has been sent successfully, we will get back to you soon');
                form.reset();
            } else {
                showToast(data.message || 'Something went wrong, please try again');
            }
        } catch (err) {
            showToast('There was a problem connecting to the server');
        } finally {
            if (submitBtn) submitBtn.disabled = false;
        }
    });
});
