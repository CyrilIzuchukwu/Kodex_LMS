$(document).ready(function() {
    // Add to cart button click handler with event delegation
    $(document).on('click', '#add-to-cart', function(e) {
        e.preventDefault();
        const $button = $(this);
        const courseId = $button.data('course');
        const originalBtnHTML = $button.html();

        // Disable button to prevent multiple clicks
        $button.html(`
            <span class="flex items-center justify-center gap-2 z-10 relative">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span>Processing...</span>
            </span>
        `).prop('disabled', true);

        $.ajax({
            url: `/user/cart/add/${courseId}`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'X-Requested-With': 'XMLHttpRequest'
            },
            success: function(response) {
                if (response.success) {
                    // Update cart count
                    updateCartCount(response.cartCount);
                    iziToast.success({ ...iziToastSettings, message: response.message || 'Course added to cart successfully!' });
                } else {
                    iziToast.error({ ...iziToastSettings, message: response.message || 'Failed to add course to cart.' });
                }
                // Reset button
                $button.prop('disabled', false).html(originalBtnHTML);
            },
            error: function(xhr) {
                console.error('Add to cart error:', xhr.responseJSON);
                iziToast.error({ ...iziToastSettings, message: xhr.responseJSON?.message || 'An error occurred. Please try again.' });
                $button.prop('disabled', false).html(originalBtnHTML);
            }
        });
    });

    // Function to update cart count using jQuery
    function updateCartCount(count) {
        $('#cart-count').text(count);
    }

    // Initial cart count fetch
    $.ajax({
        url: '/user/cart/count',
        type: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        success: function(response) {
            if (response.success) {
                updateCartCount(response.cartCount);
            } else {
                console.error('Cart count fetch error:', response);
            }
        },
        error: function(xhr) {
            console.error('Cart count fetch error:', xhr.responseJSON);
        }
    });
});
