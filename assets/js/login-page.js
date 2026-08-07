document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.eye').forEach(eyeBtn => {
        eyeBtn.addEventListener('click', () => {
            const passInputs = document.querySelectorAll('.pass');
            const eyeButtons = document.querySelectorAll('.eye');
            const showing = passInputs[0] && passInputs[0].type === 'text';

            passInputs.forEach(pass => {
                pass.type = showing ? 'password' : 'text';
            });
            eyeButtons.forEach(e => {
                e.innerHTML = showing
                    ? '<i class="fa-solid fa-eye-slash"></i>'
                    : '<i class="fa-solid fa-eye"></i>';
            });
        });
    });
});
