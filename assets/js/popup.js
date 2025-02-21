document.addEventListener('DOMContentLoaded', function() {
    const formContainer = document.querySelector('.form-container');
    const backdrop = document.querySelector('.backdrop');
    const openFormButton = document.querySelector('#openFormButton');
    const closeFormButton = document.querySelector('#closeFormButton');

    openFormButton.addEventListener('click', function() {
        formContainer.style.display = 'block';
        backdrop.style.display = 'block';
    });

    closeFormButton.addEventListener('click', function() {
        formContainer.style.display = 'none';
        backdrop.style.display = 'none';
    });

    backdrop.addEventListener('click', function() {
        formContainer.style.display = 'none';
        backdrop.style.display = 'none';
    });
});
