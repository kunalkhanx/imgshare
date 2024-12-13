import 'flowbite';


document.querySelectorAll('form.confirm').forEach(form => {
    form.addEventListener('submit', function(event) {
        // Get the prompt message from the data-prompt attribute
        const promptMessage = this.getAttribute('data-prompt');

        // Show the confirmation dialog
        const confirmed = window.confirm(promptMessage);

        // If the user clicks "Cancel", prevent form submission
        if (!confirmed) {
            event.preventDefault();
        }
    });
});