// Initialize cleave js
document.addEventListener('DOMContentLoaded', () => {
    const phoneNumberInput = document.getElementById('phoneNumber');
    if (phoneNumberInput && typeof Cleave !== 'undefined') {
        new Cleave('#phoneNumber', {
            numericOnly: true,
            blocks: [0, 3, 0, 4, 4],
            delimiters: ['(', ')', ' ', '-', ' '],
            maxLength: 16
        });
    }
});

// Register Student Modal Trigger
document.addEventListener('DOMContentLoaded', () => {
    // Element references
    const elements = {
        addStudentModal: document.getElementById('addStudentModal'),
        addStudentBtn: document.getElementById('addStudentBtn'),
        closeAddModal: document.getElementById('closeAddModal'),
        cancelAddStudent: document.getElementById('cancelAddStudent'),
        cancelDelete: document.getElementById('cancelDelete'),
        confirmDelete: document.getElementById('confirmDelete'),
        courseDropdown: document.getElementById('courseDropdown'),
        dropdownMenu: document.getElementById('dropdownMenu'),
        dropdownIcon: document.getElementById('dropdownIcon'),
        selectedCourse: document.getElementById('selectedCourse'),
        dropdownOptions: document.querySelectorAll('.dropdown-option'),
    };

    // Modal functions
    const modal = {
        open(modalElement) {
            if (!modalElement) return;
            modalElement.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
            setTimeout(() => {
                const modalContent = modalElement.querySelector('.modal-content');
                modalContent?.classList.add('show');
            }, 10);
        },
        close(modalElement) {
            if (!modalElement) return;
            const modalContent = modalElement.querySelector('.modal-content');
            modalContent?.classList.remove('show');
            setTimeout(() => {
                modalElement.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            }, 300);
        }
    };

    // Event Listeners
    // Add Student Modal
    elements.addStudentBtn?.addEventListener('click', () => modal.open(elements.addStudentModal));
    elements.closeAddModal?.addEventListener('click', () => modal.close(elements.addStudentModal));
    elements.cancelAddStudent?.addEventListener('click', () => modal.close(elements.addStudentModal));

    // Dropdown functionality
    elements.courseDropdown?.addEventListener('click', (e) => {
        e.stopPropagation();
        const isOpen = !elements.dropdownMenu.classList.contains('hidden');
        elements.dropdownMenu.classList.toggle('hidden', isOpen);
        elements.dropdownIcon.style.transform = isOpen ? 'rotate(0deg)' : 'rotate(180deg)';
    });

    elements.dropdownOptions.forEach(option => {
        option.addEventListener('click', () => {
            elements.selectedCourse.textContent = option.dataset.value;
            elements.dropdownMenu.classList.add('hidden');
            elements.dropdownIcon.style.transform = 'rotate(0deg)';
        });
    });

    // Close dropdown on the outside click
    document.addEventListener('click', () => {
        elements.dropdownMenu.classList.add('hidden');
        elements.dropdownIcon.style.transform = 'rotate(0deg)';
    });

    // Close modals with an ESC key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            modal.close(elements.addStudentModal);
        }
    });
});

// Register
document.addEventListener('DOMContentLoaded', function () {
    const saveBtn = document.getElementById('saveStudent');
    const registerForm = document.getElementById('save-student-form');
    const fields = ['full_name', 'phone', 'address', 'email', 'password'];
    const optionalFields = ['profile_photo', 'biography'];

    // Define iziToast settings (adjust as needed)
    const iziToastSettings = {
        position: 'topRight',
        timeout: 5000
    };

    if (saveBtn && registerForm) {
        const originalBtnHTML = saveBtn.innerHTML;

        // Profile photo preview
        const profilePhoto = document.getElementById('profile-photo');
        const profilePhotoPreview = document.getElementById('profile-photo-preview');
        profilePhoto.addEventListener('change', function () {
            if (this.files.length > 0) {
                const file = this.files[0];
                const reader = new FileReader();
                reader.onload = function (e) {
                    profilePhotoPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        saveBtn.addEventListener('click', function (event) {
            event.preventDefault();

            // Clear existing error messages
            document.querySelectorAll('.text-red-500').forEach(el => el.remove());

            // Disable button and show loading state
            saveBtn.innerHTML = `
                <span class="flex items-center justify-center gap-2 z-10 relative">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span>Processing...</span>
                </span>
            `;
            saveBtn.disabled = true;

            // Validate required fields
            let isValid = true;

            fields.forEach(field => {
                const input = document.querySelector(`[name="${field}"]`);
                const value = input.value.trim();
                let errorMessage = '';

                if (value === '') {
                    errorMessage = `The ${field.replace('_', ' ')} field is required.`;
                } else if (field === 'email' && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                    errorMessage = 'Please enter a valid email address.';
                }

                if (errorMessage) {
                    const errorElement = document.createElement('p');
                    errorElement.className = 'text-red-500 text-xs mt-1';
                    errorElement.textContent = errorMessage;
                    errorElement.id = `${field}-error`;
                    input.setAttribute('aria-describedby', `${field}-error`);
                    input.parentNode.appendChild(errorElement);
                    isValid = false;
                }
            });

            // Validate profile photo
            if (profilePhoto.files.length > 0) {
                const file = profilePhoto.files[0];
                const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validImageTypes.includes(file.type)) {
                    const errorElement = document.createElement('p');
                    errorElement.className = 'text-red-500 text-xs mt-1';
                    errorElement.textContent = 'Please upload a valid image file (JPEG, PNG, or GIF).';
                    errorElement.id = 'profile-photo-error';
                    profilePhoto.setAttribute('aria-describedby', 'profile-photo-error');
                    profilePhoto.parentNode.appendChild(errorElement);
                    isValid = false;
                }
            }

            if (!isValid) {
                saveBtn.disabled = false;
                saveBtn.innerHTML = originalBtnHTML;
                return;
            }

            // Submit form data via AJAX
            const formData = new FormData(registerForm);

            // Debug FormData contents
            for (let [key, value] of formData.entries()) {
                console.log(`${key}: ${value instanceof File ? value.name : value}`);
            }

            fetch(registerForm.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    'Accept': 'application/json'
                }
            })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => Promise.reject(err));
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        iziToast.success({ ...iziToastSettings, message: data.message });
                        setTimeout(() => window.location.href = data.redirect, 3000);
                    }
                })
                .catch(error => {
                    saveBtn.disabled = false;
                    saveBtn.innerHTML = originalBtnHTML;

                    if (error.errors) {
                        Object.entries(error.errors).forEach(([field, messages]) => {
                            const input = document.querySelector(`[name="${field}"]`) || document.getElementById('profile-photo');
                            if (input) {
                                const errorElement = document.createElement('p');
                                errorElement.className = 'text-red-500 text-xs mt-1';
                                errorElement.textContent = messages[0];
                                errorElement.id = `${field}-error`;
                                input.setAttribute('aria-describedby', `${field}-error`);
                                input.parentNode.appendChild(errorElement);
                            }
                        });
                    } else {
                        iziToast.error({
                            ...iziToastSettings,
                            message: error.message || 'An error occurred. Please try again.'
                        });
                    }
                });
        });

        // Remove error styling on input
        fields.concat(optionalFields).forEach(field => {
            const input = document.querySelector(`[name="${field}"]`) || document.getElementById(field);
            if (input) {
                input.addEventListener('input', function () {
                    const errorElement = document.getElementById(`${field}-error`);
                    if (errorElement) {
                        errorElement.remove();
                        input.removeAttribute('aria-describedby');
                    }
                });
            }
        });
    }
});

// Filter
document.addEventListener('DOMContentLoaded', function() {
    // Status dropdown functionality
    const dropdownMenu = document.getElementById('dropdownMenu');
    const dropdownIcon = document.getElementById('dropdownIcon');
    const selectedCourse = document.getElementById('selectedCourse');
    const dropdownOptions = document.querySelectorAll('.dropdown-option');
    const allButton = document.getElementById('allButton');

    // Get current URL parameters
    const urlParams = new URLSearchParams(window.location.search);
    const currentStatus = urlParams.get('status');

    // Set an initially selected status if present in URL
    if (currentStatus) {
        selectedCourse.textContent = currentStatus === 'active' ? 'Active Users' : 'Blocked Users';
    }

    // Handle option selection
    dropdownOptions.forEach(option => {
        option.addEventListener('click', function() {
            const selectedValue = this.getAttribute('data-value');
            selectedCourse.textContent = selectedValue;
            dropdownMenu.classList.add('hidden');
            dropdownIcon.classList.remove('rotate-180');

            // Determine the status parameter value
            let statusParam = '';
            if (selectedValue === 'Active Users') {
                statusParam = 'active';
            } else if (selectedValue === 'Blocked Users') {
                statusParam = 'blocked';
            }

            // Update URL with the new status parameter
            updateUrlWithStatus(statusParam);
        });
    });

    // Function to update URL with status parameter
    function updateUrlWithStatus(status) {
        const url = new URL(window.location.href);

        if (status) {
            url.searchParams.set('status', status);
        } else {
            url.searchParams.delete('status');
        }

        // Reset pagination to page 1 when filtering
        url.searchParams.delete('page');

        window.location.href = url.toString();
    }

    // Add an event listener to the "All" button to clear the filter
    if (allButton) {
        allButton.addEventListener('click', function(e) {
            e.preventDefault();
            selectedCourse.textContent = 'Status';
            updateUrlWithStatus('');
        });
    }
});
