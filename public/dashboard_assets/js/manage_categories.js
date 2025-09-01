$(document).ready(function() {
    // Modal handling
    const modals = {
        add: $('#add-modal'),
        edit: $('#edit-modal'),
        delete: $('#delete-modal')
    };

    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const contentContainer = document.getElementById('content-container');
    let searchTimeout = null;

    // Debounced Search
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(() => {
            const query = searchInput.value.trim();
            if (query.length >= 2 || query.length === 0) {
                performSearch(query);
            }
        }, 500);
    });

    // Function to load content via AJAX
    function loadContent(url) {
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newContent = doc.getElementById('content-container');

                if (newContent) {
                    contentContainer.innerHTML = newContent.innerHTML;
                    window.history.pushState({}, '', url);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }

    // Perform search by building URL and loading content
    function performSearch(query) {
        const url = new URL(window.location.href);
        url.searchParams.set('search', query);
        url.searchParams.delete('page');
        loadContent(url.toString());
    }

    // Handle pagination clicks via AJAX
    $(document).on('click', '#pagination a', function(e) {
        e.preventDefault();
        loadContent(this.href);
    });

    // Open modal with animation
    function openModal(modal) {
        modal.removeClass('hidden').removeClass('opacity-0');
        modal.find('.modal-content').removeClass('scale-95').addClass('scale-100');
        $('body').addClass('overflow-hidden');
    }

    // Close modal with animation
    function closeModal(modal) {
        modal.addClass('opacity-0');
        modal.find('.modal-content').removeClass('scale-100').addClass('scale-95');
        setTimeout(() => {
            modal.addClass('hidden');
            $('body').removeClass('overflow-hidden');
        }, 300);
    }

    // Toggle preloader
    function togglePreloader(button, show) {
        button.prop('disabled', show);
        button.find('.submit-text').toggleClass('hidden', show);
        button.find('.preloader').toggleClass('hidden', !show);
    }

    // Show an error message
    function showError(input, message) {
        const errorElement = input.next('.error-message');
        errorElement.text(message).removeClass('hidden');
        input.addClass('border-red-500').removeClass('border-gray-300 focus:border-[#E68815]');
    }

    // Clear errors
    function clearErrors(form) {
        form.find('.error-message').addClass('hidden').text('');
        form.find('input, select').removeClass('border-red-500').addClass('border-gray-300');
    }

    // Validate add/edit form
    function validateForm(form) {
        let isValid = true;
        const nameInput = form.find('input[name="name"]');
        const statusSelect = form.find('select[name="status"]');

        if (!nameInput.val().trim()) {
            showError(nameInput, 'Category name is required');
            isValid = false;
        } else if (nameInput.val().length > 255) {
            showError(nameInput, 'Category name must be less than 255 characters');
            isValid = false;
        }

        if (!statusSelect.val()) {
            showError(statusSelect, 'Status is required');
            isValid = false;
        }

        return isValid;
    }

    // Validate delete form
    function validateDeleteForm(form) {
        const categoryId = form.attr('action').split('/').pop();
        if (!categoryId || isNaN(categoryId)) {
            iziToast.error({
                ...iziToastSettings,
                message: 'Invalid category ID'
            });
            return false;
        }
        return true;
    }

    // Handle AJAX form submission
    function handleFormSubmission(form, successCallback, isDelete = false) {
        form.on('submit', function(e) {
            e.preventDefault();
            const $this = $(this);
            const submitButton = $this.find('button[type="submit"]');

            clearErrors($this);

            // Validate based on form type
            if (isDelete) {
                if (!validateDeleteForm($this)) return;
            } else {
                if (!validateForm($this)) return;
            }

            togglePreloader(submitButton, true);

            $.ajax({
                url: $this.attr('action'),
                method: $this.find('input[name="_method"]').val() || $this.attr('method'),
                data: $this.serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    togglePreloader(submitButton, false);
                    // Check for success status in response
                    if (response.success) {
                        iziToast.success({
                            ...iziToastSettings,
                            message: response.message
                        });
                        successCallback(response);
                        setTimeout(() => {
                            if (response.redirect) {
                                window.location.href = response.redirect;
                            } else {
                                location.reload();
                            }
                        }, 3000);
                    } else {
                        iziToast.error({
                            ...iziToastSettings,
                            message: response.message
                        });
                    }
                },
                error: function(xhr) {
                    togglePreloader(submitButton, false);
                    const errors = xhr.responseJSON?.errors;
                    if (errors && !isDelete) {
                        if (errors.name) {
                            showError($this.find('input[name="name"]'), errors.name[0]);
                        }
                        if (errors.status) {
                            showError($this.find('select[name="status"]'), errors.status[0]);
                        }
                    } else {
                        iziToast.error({
                            ...iziToastSettings,
                            message: xhr.responseJSON?.message
                        });
                    }
                }
            });
        });
    }

    // Handle edit modal open
    $(document).on('click', '.open-edit-modal', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const $this = $(this);
        const categoryName = $this.data('category-name');
        const categoryId = $this.data('category-id');
        const categoryStatus = $this.data('category-status');
        const editForm = $('#edit-form');

        editForm.attr('action', `/admin/categories/${categoryId}`);
        $('#edit-category-name').val(categoryName);
        $('#edit-category-status').val(categoryStatus);
        clearErrors(editForm);
        openModal(modals.edit);
    });

    // Handle delete modal open
    $(document).on('click', '.open-delete-modal', function(e) {
        e.preventDefault();
        e.stopPropagation();

        const $this = $(this);
        const categoryId = $this.data('category-id');

        $('#delete-form').attr('action', `/admin/categories/${categoryId}`);
        openModal(modals.delete);
    });

    // Close dropdowns when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.relative').length) {
            $('.dropdown-menu').addClass('hidden');
        }
    });

    // Open add modal
    $(document).on('click', '#open-add-modal', function(e) {
        e.preventDefault();
        clearErrors($('#add-form'));
        $('#add-category-status').val('active');
        openModal(modals.add);
    });

    // Close modals
    $('#close-add-modal, #cancel-add-modal').on('click', () => closeModal(modals.add));
    $('#close-edit-modal, #cancel-edit-modal').on('click', () => closeModal(modals.edit));
    $('#cancel-delete').on('click', () => closeModal(modals.delete));

    // Close modals on Escape key
    $(document).on('keydown', function(e) {
        if (e.key === 'Escape') {
            Object.values(modals).forEach(closeModal);
            $('.dropdown-menu').addClass('hidden');
        }
    });

    // Form submissions
    handleFormSubmission($('#add-form'), function() {
        closeModal(modals.add);
    });

    handleFormSubmission($('#edit-form'), function() {
        closeModal(modals.edit);
    });

    handleFormSubmission($('#delete-form'), function() {
        closeModal(modals.delete);
    }, true);
});
