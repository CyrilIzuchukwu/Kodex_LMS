@extends('layouts.admin')
@section('content')
    <!-- Breadcrumb Navigation -->
    <div class="mb-6">
        <nav class="bg-white rounded-[20px] md:rounded-[30px] shadow-sm px-4 md:px-6 py-3 flex items-center justify-start w-full">
            <ol class="flex items-center space-x-2 md:space-x-3 text-sm md:text-base font-medium text-[#141B34]">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-[#E68815] transition-colors duration-200 flex items-center">
                        <svg class="w-5 h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-7 7v-10"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
                <li>
                    <span class="text-[#E68815] font-semibold">Payment Methods</span>
                </li>
            </ol>
        </nav>
    </div>

    <!-- Main Content Card -->
    <div class="bg-white rounded-3xl border border-gray-100 overflow-hidden">
        <!-- Header Section -->
        <div class="px-8 py-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-6">
                <div class="text-gray-900">
                    <h1 class="text-3xl font-bold mb-2">Payment Methods</h1>
                    <p class="text-gray-500 text-lg">Manage your payment processing methods</p>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="p-8" id="content-container">
            @if($gateways->count())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8" id="gateways-container">
                    @foreach($gateways as $gateway)
                        <!-- Payment Gateway Card -->
                        <div class="group relative bg-white rounded-2xl border border-gray-200 p-6" data-gateway-id="{{ $gateway->id }}">
                            <!-- Card Header -->
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex items-center space-x-4">
                                    <!-- Gateway Image -->
                                    <div class="relative">
                                        <div class="w-16 h-16 rounded-2xl overflow-hidden shadow-sm flex items-center justify-center">
                                            <img src="{{ $gateway->icon }}" alt="{{ $gateway->name }}" class="w-full h-full object-cover">
                                        </div>
                                    </div>
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex items-center space-x-2">
                                    <!-- Edit Button with Tooltip -->
                                    <div class="relative">
                                        <button class="open-edit-modal p-2 rounded-full hover:bg-gray-200 transition-colors duration-150" data-gateway-name="{{ $gateway->name }}" data-gateway-id="{{ $gateway->id }}" data-gateway-status="{{ $gateway->status }}" data-gateway-image="{{ $gateway->image }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <!-- Gateway Name -->
                            <div class="mb-4">
                                <h3 class="gateway-name text-xl font-bold text-gray-800 mb-2">{{ $gateway->name }}</h3>
                                <p class="text-gray-500 text-sm">Payment Processing Gateway</p>
                            </div>

                            <!-- Status & Actions -->
                            <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                                <span class="inline-flex items-center h-10 px-2 sm:px-3 py-1 rounded-full text-xs sm:text-sm font-medium {{ $gateway->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <i class="uil uil-circle mr-1 text-xs"></i>
                                    {{ ucfirst($gateway->status) }}
                                </span>

                                <div class="text-right">
                                    <div class="text-xs text-gray-400 uppercase tracking-wide font-semibold">Gateway</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div id="pagination">
                    {{ $gateways->links('vendor.pagination.tailwind') }}
                </div>
            @else
                <!-- Empty State -->
                <div id="no-gateways" class="flex flex-col items-center justify-center py-12 sm:py-20">
                    <div class="relative mb-6 sm:mb-8">
                        <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl bg-[#E68815] flex items-center justify-center">
                            <svg class="w-10 h-10 sm:w-12 sm:h-12 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                        </div>
                        <div class="absolute -top-2 -right-2 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gradient-to-br from-yellow-400 to-orange-400 flex items-center justify-center">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                        </div>
                    </div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-700 mb-4 text-center">No Payment Gateways</h2>
                    <p class="text-gray-500 text-base sm:text-lg text-center max-w-xs sm:max-w-md mb-6 sm:mb-8 px-4">Get started by adding your first payment gateway to begin processing payments.</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Edit Gateway Modal -->
    <div id="edit-modal" class="fixed inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex justify-center z-[9999] overflow-y-auto pt-2 md:pt-4 pb-2 md:pb-4 hidden">
        <div class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-[90vw] sm:w-[80vw] md:w-[65vw] lg:w-[60vw] xl:w-[50vw] p-3 md:p-6 lg:p-6 space-y-3 z-[10000] self-start mt-2 md:mt-4 mb-2 md:mb-4 mx-2">
            <!-- Modal Header -->
            <div class="bg-[#E68815] px-4 sm:px-8 py-4 sm:py-6 rounded-t-3xl relative">
                <button id="close-edit-modal" class="absolute top-2 sm:top-4 right-2 sm:right-4 w-8 sm:w-10 h-8 sm:h-10 rounded-full bg-white/20 hover:bg-white/30 text-gray-900 flex items-center justify-center transition-colors">
                    <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>

                <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4 text-gray-900">
                    <div class="w-10 sm:w-12 h-10 sm:h-12 rounded-2xl bg-white/20 flex items-center justify-center">
                        <svg class="w-6 sm:w-7 h-6 sm:h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>

                    <div>
                        <h3 class="text-xl sm:text-2xl font-bold">Edit Payment Gateway</h3>
                        <p class="text-gray-100 text-sm sm:text-base">Update gateway information</p>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="edit-form" method="POST" enctype="multipart/form-data" class="p-4 sm:p-8">
                @csrf
                @method('PUT')

                <div class="space-y-4 sm:space-y-6">
                    <!-- Gateway Name -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="edit-gateway-name">Gateway Name *</label>
                        <input name="name" type="text" id="edit-gateway-name" class="w-full px-3 sm:px-4 py-2 sm:py-3 text-gray-700 border border-gray-300 rounded-xl text-sm sm:text-base" placeholder="e.g. Stripe, PayPal, Razorpay" autocomplete="off">
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>

                    <!-- Gateway Image -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="edit-image-input">Gateway Logo</label>
                        <div class="flex flex-col sm:flex-row items-center space-y-3 sm:space-y-0 sm:space-x-4">
                            <div class="w-16 sm:w-20 h-16 sm:h-20 rounded-xl border-2 border-dashed border-gray-300 flex items-center justify-center bg-gray-50 overflow-hidden" id="edit-image-preview">
                                <svg class="w-6 sm:w-8 h-6 sm:h-8 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>

                            <div class="flex-1 w-full">
                                <input name="image" type="file" accept="image/*" id="edit-image-input" class="w-full px-3 sm:px-4 py-2 sm:py-3 text-gray-700 border border-gray-300 rounded-xl text-sm sm:text-base">
                                <p class="text-xs sm:text-sm text-gray-500 mt-1">PNG, JPG up to 2MB (leave empty to keep current)</p>
                            </div>
                        </div>
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>

                    <!-- Status -->
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700" for="edit-gateway-status">Status *</label>
                        <select name="status" id="edit-gateway-status" class="w-full text-gray-700 px-3 sm:px-4 py-2 sm:py-3 border border-gray-300 rounded-xl text-sm sm:text-base">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        <span class="text-red-500 text-xs sm:text-sm hidden error-message"></span>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 mt-6 sm:mt-8">
                    <button type="button" id="cancel-edit-modal" class="flex-1 px-4 sm:px-6 py-2 sm:py-3 border border-gray-300 text-gray-700 rounded-xl hover:bg-gray-50 font-semibold transition-colors text-sm sm:text-base">
                        Cancel
                    </button>

                    <button type="submit" class="flex-1 bg-[#E68815] hover:to-purple-700 text-white px-4 sm:px-6 py-2 sm:py-3 rounded-xl font-semibold flex items-center justify-center text-sm sm:text-base">
                        <span class="submit-text">Update Gateway</span>
                        <span class="preloader hidden flex items-center space-x-2">
                        <svg class="animate-spin h-4 sm:h-5 w-4 sm:w-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                            <span>Updating...</span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Modal Elements
            const editModal = document.getElementById('edit-modal');
            const closeEditModalBtn = document.getElementById('close-edit-modal');
            const cancelEditModalBtn = document.getElementById('cancel-edit-modal');
            const editForm = document.getElementById('edit-form');
            const editImageInput = document.getElementById('edit-image-input');
            const editImagePreview = document.getElementById('edit-image-preview');

            // Helper Functions
            function openModal(modal) {
                modal.classList.remove('hidden', 'opacity-0');
                modal.querySelector('.modal-content').classList.remove('scale-95');
            }

            function hideModal(modal) {
                modal.classList.add('opacity-0');
                modal.querySelector('.modal-content').classList.add('scale-95');
                setTimeout(() => {
                    modal.classList.add('hidden');
                }, 300);
            }

            function showPreloader(button) {
                button.querySelector('.submit-text').classList.add('hidden');
                button.querySelector('.preloader').classList.remove('hidden');
                button.disabled = true;
            }

            function hidePreloader(button) {
                button.querySelector('.submit-text').classList.remove('hidden');
                button.querySelector('.preloader').classList.add('hidden');
                button.disabled = false;
            }

            function showError(input, message) {
                const errorElement = input.nextElementSibling;
                errorElement.textContent = message;
                errorElement.classList.remove('hidden');
                input.classList.add('border-red-500');
            }

            function clearErrors(form) {
                form.querySelectorAll('.error-message').forEach(error => {
                    error.classList.add('hidden');
                    error.textContent = '';
                });
                form.querySelectorAll('input, select').forEach(input => {
                    input.classList.remove('border-red-500');
                });
            }

            // Image Preview Handler
            function handleImagePreview(input, preview) {
                input.addEventListener('change', function () {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function (e) {
                            preview.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-full h-full object-cover rounded-xl">`;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        preview.innerHTML = `
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        `;
                    }
                });
            }

            // Close Edit Modal
            closeEditModalBtn.addEventListener('click', () => hideModal(editModal));
            cancelEditModalBtn.addEventListener('click', () => hideModal(editModal));

            // Open Edit Modal
            document.querySelectorAll('.open-edit-modal').forEach(button => {
                button.addEventListener('click', () => {
                    clearErrors(editForm);
                    const gatewayId = button.dataset.gatewayId;
                    const gatewayName = button.dataset.gatewayName;
                    const gatewayStatus = button.dataset.gatewayStatus;
                    const gatewayImage = button.dataset.gatewayImage;

                    editForm.action = `/admin/payment-methods/${gatewayId}/update`;
                    editForm.querySelector('#edit-gateway-name').value = gatewayName;
                    editForm.querySelector('#edit-gateway-status').value = gatewayStatus;
                    editImagePreview.innerHTML = gatewayImage ?
                        `<img src="${gatewayImage}" alt="Preview" class="w-full h-full object-cover rounded-xl">` :
                            `<svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        `;

                    openModal(editModal);
                });
            });

            // Handle Image Preview
            handleImagePreview(editImageInput, editImagePreview);

            // Handle Edit Form Submission
            editForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const submitButton = this.querySelector('button[type="submit"]');
                showPreloader(submitButton);
                clearErrors(this);

                const formData = new FormData(this);
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-HTTP-Method-Override': 'PUT'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        hidePreloader(submitButton);
                        if (data.success) {
                            hideModal(editModal);
                            window.location.reload();
                        } else {
                            if (data.errors) {
                                Object.keys(data.errors).forEach(field => {
                                    const input = editForm.querySelector(`[name="${field}"]`);
                                    showError(input, data.errors[field][0]);
                                });
                            }
                        }
                    })
                    .catch(error => {
                        hidePreloader(submitButton);
                        console.error('Error:', error);
                    });
            });
        });
    </script>
@endpush
