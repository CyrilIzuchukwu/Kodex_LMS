$(document).ready(function() {
    // Initialize Cleave.js for a phone number
    if ($('#phone_number').length && typeof Cleave !== 'undefined') {
        new Cleave('#phone_number', {
            numericOnly: true,
            blocks: [0, 3, 0, 4, 4],
            delimiters: ['(', ')', ' ', '-', ' '],
            maxLength: 16
        });
    }

    // Modal handling
    const modals = {
        addInstructor: $('#addInstructorModal'),
    };

    function openModal(modal) {
        modal.removeClass('hidden').find('.modal-content').addClass('show');
        $('body').addClass('overflow-hidden');
    }

    function closeModal(modal) {
        modal.find('.modal-content').removeClass('show');
        setTimeout(() => {
            modal.addClass('hidden');
            $('body').removeClass('overflow-hidden');
        }, 300);
    }

    // Modal triggers
    $('#addInstructorBtn').on('click', () => openModal(modals.addInstructor));
    $('#closeAddModal, #cancelAddInstructor').on('click', () => closeModal(modals.addInstructor));

    // Dropdown functionality
    const $dropdownMenu = $('#dropdownMenu');
    const $dropdownIcon = $('#dropdownIcon');
    const $selectedCourse = $('#selectedCourse');

    $('#courseDropdown').on('click', (e) => {
        e.stopPropagation();
        const isOpen = !$dropdownMenu.hasClass('hidden');
        $dropdownMenu.toggleClass('hidden', isOpen);
        $dropdownIcon.css('transform', isOpen ? 'rotate(0deg)' : 'rotate(180deg)');
    });

    $('.dropdown-option').on('click', function() {
        $selectedCourse.text($(this).data('value'));
        $dropdownMenu.addClass('hidden');
        $dropdownIcon.css('transform', 'rotate(0deg)');

        // Handle filter status
        const selectedValue = $(this).data('value');
        const statusParam = selectedValue === 'Active Users' ? 'active' :
            selectedValue === 'Blocked Users' ? 'blocked' : '';
        updateUrlWithStatus(statusParam);
    });

    // Close dropdown on the outside click
    $(document).on('click', () => {
        $dropdownMenu.addClass('hidden');
        $dropdownIcon.css('transform', 'rotate(0deg)');
    });

    // Close modals on an Escape key
    $(document).on('keydown', (e) => {
        if (e.key === 'Escape') {
            closeModal(modals.addInstructor);
            $dropdownMenu.addClass('hidden');
            $dropdownIcon.css('transform', 'rotate(0deg)');
        }
    });

    // Profile photo preview
    $('#profile_photo_instructor').on('change', function() {
        if (this.files.length > 0) {
            const reader = new FileReader();
            reader.onload = (e) => $('#profile_photo_preview_instructor').attr('src', e.target.result);
            reader.readAsDataURL(this.files[0]);
        }
    });

    // Form submission
    const $registerForm = $('#save-instructor-form');
    const $saveBtn = $('#saveInstructor');
    const fields = ['full_name_instructor', 'phone_number', 'address_instructor', 'email_instructor', 'password_instructor', 'course'];
    const optionalFields = ['profile_photo_instructor', 'biography_instructor'];
    const iziToastSettings = { position: 'topRight', timeout: 5000 };
    const originalBtnHTML = $saveBtn.html();

    $saveBtn.on('click', (e) => {
        e.preventDefault();
        $('.text-red-500').remove();
        $saveBtn.html(`
            <span class="flex items-center justify-center gap-2 z-10 relative">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span>Processing...</span>
            </span>
        `).prop('disabled', true);

        // Validate fields
        let isValid = true;
        fields.forEach(field => {
            let errorMessage = '';
            const $input = $(`[name="${field}"]`);
            const value = $input.val()?.trim();
            const displayField = field.replace('_instructor', '').replace('_', ' ');

            if (!value || value === '') {
                errorMessage = `The ${displayField} field is required.`;
                if (field === 'course') {
                    errorMessage = 'Please select a course.';
                }
                $input.after(`<p class="text-red-500 text-xs mt-1" id="${field}-error">${errorMessage}</p>`);
                $input.attr('aria-describedby', `${field}-error`);
                isValid = false;
            } else if (field === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                errorMessage = 'Please enter a valid email address.';
                $input.after(`<p class="text-red-500 text-xs mt-1" id="${field}-error">${errorMessage}</p>`);
                $input.attr('aria-describedby', `${field}-error`);
                isValid = false;
            }
        });

        // Validate profile photo
        const $profilePhoto = $('#profile-photo');
        if ($profilePhoto[0].files.length > 0) {
            const file = $profilePhoto[0].files[0];
            const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!validImageTypes.includes(file.type)) {
                $profilePhoto.after('<p class="text-red-500 text-xs mt-1" id="profile-photo-error">Please upload a valid image file (JPEG, PNG, or GIF).</p>');
                $profilePhoto.attr('aria-describedby', 'profile-photo-error');
                isValid = false;
            }
        }

        if (!isValid) {
            $saveBtn.prop('disabled', false).html(originalBtnHTML);
            return;
        }

        // AJAX submission
        $.ajax({
            url: $registerForm.attr('action'),
            method: 'POST',
            data: new FormData($registerForm[0]),
            processData: false,
            contentType: false,
            headers: { 'X-CSRF-TOKEN': $('input[name="_token"]').val(), 'Accept': 'application/json' },
            success: (data) => {
                if (data.success) {
                    iziToast.success({ ...iziToastSettings, message: data.message });
                    setTimeout(() => window.location.href = data.redirect, 3000);
                }
            },
            error: (xhr) => {
                $saveBtn.prop('disabled', false).html(originalBtnHTML);
                const errors = xhr.responseJSON?.errors;
                if (errors) {
                    Object.entries(errors).forEach(([field, messages]) => {
                        const $input = $(`[name="${field}"]`) || $('#profile-photo');
                        if ($input.length) {
                            $input.after(`<p class="text-red-500 text-xs mt-1" id="${field}-error">${messages[0]}</p>`);
                            $input.attr('aria-describedby', `${field}-error`);
                        }
                    });
                } else {
                    iziToast.error({ ...iziToastSettings, message: xhr.responseJSON?.message || 'An error occurred. Please try again.' });
                }
            }
        });
    });

    // Remove error styling on input or change
    fields.concat(optionalFields).forEach(field => {
        const $input = $(`[name="${field}"]`) || $(`#${field}`);
        $input.on('input change', () => {
            $(`#${field}-error`).remove();
            $input.removeAttr('aria-describedby');
        });
    });

    // Filter functionality
    const currentStatus = new URLSearchParams(window.location.search).get('status');
    if (currentStatus) {
        $selectedCourse.text(currentStatus === 'active' ? 'Active Users' : 'Blocked Users');
    }

    function updateUrlWithStatus(status) {
        const url = new URL(window.location.href);
        if (status) {
            url.searchParams.set('status', status);
        } else {
            url.searchParams.delete('status');
        }
        url.searchParams.delete('page');
        window.location.href = url.toString();
    }

    $('#allButton').on('click', (e) => {
        e.preventDefault();
        $selectedCourse.text('Status');
        updateUrlWithStatus('');
    });
});
