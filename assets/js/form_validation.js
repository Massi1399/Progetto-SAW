(() => {
    // Fetch all the forms we want to apply custom Bootstrap validation styles to (in our case the registration and login forms)
    const forms = document.querySelectorAll('.needs-validation')
    
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
        }

        form.classList.add('was-validated')
        }, false)
    })
})();   //IIFE (Immediately Invoked Function Expression)