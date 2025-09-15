// Process Checkout
function handleFormSubmission(formId, buttonId, buttonText) {
    const form = document.getElementById(formId);
    const button = document.getElementById(buttonId);

    button.addEventListener('click', function(e) {
        // Show preloader
        button.innerHTML = `
            <span class="flex items-center justify-center gap-2 z-10 relative">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span>Processing...</span>
            </span>
        `;
        button.disabled = true;

        // Check form validity
        if (!form.checkValidity()) {
            form.reportValidity();
            button.innerHTML = buttonText;
            button.disabled = false;
            e.preventDefault();
            return;
        }

        // Submit form after brief delay for animation
        setTimeout(() => form.submit(), 500);
    });
}

// Initialize form submission handlers
handleFormSubmission('process-checkout-form', 'process-checkout-button', 'Proceed to Checkout');
