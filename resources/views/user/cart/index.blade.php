@extends('layouts.user')
@section('content')
    <div class="px-2 md:px-3">
        <nav class="bg-white rounded-[20px] md:rounded-[30px] shadow-sm px-4 md:px-6 py-4 flex items-center justify-start w-full">
            <ol class="flex items-center space-x-3 md:space-x-4 text-sm md:text-base font-semibold text-[#141B34]">
                <li>
                    <a href="{{ route('user.dashboard') }}" class="hover:text-[#E68815] transition-colors duration-200 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7m-7 7v-10"></path>
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
                <li>
                    <a href="{{ route('user.courses') }}" class="hover:text-[#E68815] transition-colors duration-200 flex items-center">
                        Courses
                    </a>
                </li>
                <li>
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </li>
                <li>
                    <span class="text-[#E68815] font-semibold">Your Cart</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container mx-auto px-2 py-8">
        <!-- Cart Content -->
        @if($cartItems->count())
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="lg:col-span-2 flex flex-col min-h-[600px]">
                    @foreach($cartItems as $cart)
                        <div class="bg-white rounded-2xl border border-[#E1E1E1] p-5 mb-4 flex flex-col md:flex-row items-start md:items-center gap-4 hover:scale-[1.02] transition-transform duration-200 shadow-sm hover:bg-gray-50">
                            <div class="w-full md:w-40 h-40 rounded-lg overflow-hidden">
                                <img src="{{ $cart->course->media?->image_url }}" alt="{{ $cart->course->title }}" class="w-full h-full object-cover object-center">
                            </div>

                            <div class="flex-1">
                                <h3 class="text-xl font-semibold text-[#1B1B1B] line-clamp-2">{{ $cart->course->title }}</h3>

                                <p class="inline-block bg-[#F5F5F5] text-[#1B1B1B] px-3 py-1.5 rounded-full text-sm font-medium mt-2 shadow-sm">
                                    {{ $cart->course->category->name }}
                                </p>

                                <div class="flex items-center mt-3 mb-3">
                                    <img class="w-6 h-6 rounded-full mr-2" src="{{ $cart->course->profile && $cart->course->profile->profile_photo_path ? asset($cart->course->profile->profile_photo_path) : asset('dashboard_assets/images/client/default.png') }}" alt="Instructor image">
                                    <a class="text-[#5D5D5D] font-medium text-sm hover:underline">
                                        {{ $cart->course->profile?->user->name ?? 'Not Assigned' }}
                                    </a>
                                </div>
                                <p class="text-gray-900 font-semibold text-base">₦ {{ number_format($cart->course->price, 2) }}</p>
                            </div>

                            <button id="remove-item-{{ $cart->id }}" onclick="showModal('deleteModal', {{ $cart->id }})" class="text-[#E30800] bg-red-100/50 px-3 py-1.5 rounded-full hover:text-red-700 text-sm font-medium flex items-center gap-1.5" data-cart="{{ $cart->id }}">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4M3 7h18"></path>
                                </svg>
                                Remove
                            </button>
                        </div>
                    @endforeach
                    <div class="mt-6">
                        <a href="{{ route('user.courses') }}" class="inline-block bg-transparent border border-[#E68815] text-[#E68815] hover:bg-[#E68815] hover:text-white py-3 px-8 rounded-[100px] font-semibold text-base transition-colors shadow-sm hover:shadow-md">
                            Return to Courses
                        </a>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-white rounded-2xl p-6 shadow-sm flex flex-col sticky top-4 max-h-[calc(100vh-2rem)] overflow-y-auto">
                    <!-- Header -->
                    <div class="flex items-center space-x-2 mb-4">
                        <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                            <svg class="uil-shopping-cart w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h2 class="font-medium text-[18px] leading-[100%] tracking-[-0.02em] text-[#1B1B1B]">
                            Order Summary
                        </h2>
                    </div>

                    <form id="process-checkout-form" action="{{ route('user.cart.checkout') }}" method="POST">
                        @csrf

                        <input type="hidden" name="amount" id="amount" value="{{ $total }}">

                        <div class="space-y-4 text-base text-gray-600 flex-1">
                            <div class="flex justify-between">
                                <span class="text-[#5D5D5D] font-medium">Subtotal</span>
                                <span class="font-semibold text-[#262626] subtotal">₦ {{ number_format($subtotal, 2) }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-[#5D5D5D] font-medium">VAT (7.5%)</span>
                                <span class="font-semibold text-[#262626] vat">₦ {{ number_format($charges, 2) }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-[#5D5D5D] font-medium">Discount</span>
                                <span class="font-semibold text-[#262626] discount">-₦ {{ number_format($discount, 2) ?? 0.00 }}</span>
                            </div>

                            <div class="flex justify-between pt-4 border-t border-gray-300">
                                <span class="font-semibold text-[#5D5D5D]">Total</span>
                                <span class="font-bold text-xl text-[#1B1B1B] total">₦ {{ number_format($total, 2) }}</span>
                            </div>

                            <!-- Coupon Code -->
                            <div class="mt-6">
                                <label for="coupon" class="text-sm font-medium text-[#5D5D5D] mb-2 block">Coupon Code</label>
                                <div class="flex gap-3">
                                    <input type="text" id="coupon" name="coupon" placeholder="Enter coupon code" class="w-full border border-gray-300 rounded-[100px] px-4 py-2.5 text-sm focus:ring-2 focus:ring-[#E68815] focus:border-transparent" value="{{ old('applied_coupon', $applied_coupon ?? '') }}">
                                    <button type="button" id="apply-coupon" class="bg-[#E68815] hover:bg-[#ffad48] text-white px-5 py-2.5 rounded-[100px] font-medium text-sm transition">Apply</button>
                                </div>
                            </div>

                            <!-- Payment Methods -->
                            <div class="mt-6">
                                <h3 class="text-base font-semibold text-[#1B1B1B] mb-3">Payment Method</h3>
                                <div class="space-y-3">
                                    @foreach($gateways as $gateway)
                                        <label class="flex items-center gap-2">
                                            <input type="radio" name="payment_method" value="{{ $gateway->name }}" class="text-[#E68815] focus:ring-[#E68815] w-5 h-5" data-gateway="{{ $gateway->name }}" {{ old('payment_method') ? 'checked' : '' }}>
                                            <span class="flex items-center gap-2 text-sm font-medium text-[#5D5D5D]">
                                                <img class="w-6 h-6 rounded-full" src="{{ $gateway->icon }}" alt="{{ $gateway->name }}">
                                                {{ $gateway->name }}
                                            </span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="mt-6">
                                <label class="flex items-center gap-2">
                                    <input type="checkbox" name="terms" class="text-[#E68815] focus:ring-[#E68815] w-5 h-5" value="1" {{ old('terms') ? 'checked' : '' }}>
                                    <span class="text-sm font-medium text-[#5D5D5D]">I agree to the <a href="/terms" class="text-[#E68815] hover:underline">Terms and Conditions</a></span>
                                </label>
                            </div>
                        </div>

                        <button id="process-checkout-button" type="submit" class="mt-6 w-full block bg-[#E68815] hover:bg-[#ffad48] text-white font-semibold py-3.5 rounded-[100px] text-center transition shadow-sm hover:shadow-md">
                            Proceed to Checkout
                        </button>
                    </form>
                </div>
            </div>
        @else
            <section class="flex items-center justify-center min-h-[50vh]">
                <div class="p-8 max-w-md text-center">
                    <div class="w-20 h-20 rounded-full bg-[#F5CE9F] flex items-center justify-center mb-6 mx-auto">
                        <svg class="w-12 h-12 text-[#8C530D]" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-semibold text-[#444444] mb-4">Your Cart is Empty</h2>
                    <p class="text-base text-[#1B1B1B] mb-6">You haven't added any courses to your cart yet. Browse our courses to find something you love!</p>
                    <a href="{{ route('user.courses') }}" class="inline-block bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-8 rounded-[100px] font-semibold text-base transition-colors shadow-sm hover:shadow-md">Explore Courses</a>
                </div>
            </section>
        @endif
    </div>

    <!-- Delete Modal -->
    <div id="deleteModal" class="fixed hidden inset-0 bg-black bg-opacity-75 backdrop-blur-sm flex items-center justify-center z-[9999] p-4 opacity-0 transition-all duration-300 ease-in-out">
        <div class="modal-content bg-white rounded-[20px] md:rounded-[30px] shadow-lg w-full max-w-sm md:max-w-md h-auto p-4 md:p-6 flex flex-col items-center justify-center z-[10000] transform scale-95 transition-transform duration-300 ease-in-out">
            <img src="{{ asset('dashboard_assets/images/img/gradient.png') }}" alt="delete" class="w-12 h-12 md:w-16 md:h-16 mb-4">
            <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4 text-center">Remove Item?</h2>
            <p class="text-gray-600 mb-6 text-center text-xs md:text-sm">
                Are you sure you want to remove this item from your cart? This action cannot be undone.
            </p>
            <form id="remove-form" action="{{ route('user.cart.remove') }}" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="cart_id" id="cart_id">
                <div class="flex justify-center gap-3 w-full">
                    <button type="button" onclick="closeModal('deleteModal')" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300 transition-colors text-xs md:text-sm">
                        Cancel
                    </button>
                    <button type="submit" id="delete-account" class="flex-1 px-4 md:px-6 py-2 md:py-3 rounded-full bg-[#E30800] text-white hover:bg-red-600 transition-colors text-xs md:text-sm flex items-center justify-center">
                        <span class="submit-text">Remove</span>
                        <span class="preloader flex items-center justify-center gap-2 hidden">
                            <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                            </svg>
                            Processing...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const showError = (message) => {
            iziToast.error({ ...iziToastSettings, message });
        };

        const showSuccess = (message) => {
            iziToast.success({ ...iziToastSettings, message });
        };

        // Modal functionality
        function showModal(modalId, cartId) {
            const modal = document.getElementById(modalId);
            const cartInput = document.getElementById('cart_id');
            cartInput.value = cartId;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.classList.remove('opacity-0');
            modal.querySelector('.modal-content').classList.remove('scale-95');
        }

        function closeModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.classList.add('opacity-0');
            modal.querySelector('.modal-content').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
        }

        // Form submission with preloader
        function handleFormSubmission() {
            const form = document.getElementById('remove-form');
            const button = document.getElementById('delete-account');

            button.addEventListener('click', function(e) {
                // Show preloader
                button.querySelector('.submit-text').classList.add('hidden');
                button.querySelector('.preloader').classList.remove('hidden');
                button.disabled = true;

                // Check form validity
                if (!form.checkValidity()) {
                    form.reportValidity();
                    button.querySelector('.submit-text').classList.remove('hidden');
                    button.querySelector('.preloader').classList.add('hidden');
                    button.disabled = false;
                    e.preventDefault();
                    return;
                }

                // Submit form after brief delay for animation
                setTimeout(() => form.submit(), 500);
            });
        }

        // Initialize form submission handler
        handleFormSubmission();

        // Coupon application functionality
        const applyCouponBtn = document.getElementById('apply-coupon');
        const couponInput = document.getElementById('coupon');
        const subtotalEl = document.querySelector('.subtotal');
        const vatEl = document.querySelector('.vat');
        const discountEl = document.querySelector('.discount');
        const totalEl = document.querySelector('.total');
        const amountInput = document.getElementById('amount');

        applyCouponBtn.addEventListener('click', async () => {
            const couponCode = couponInput.value.trim();
            if (!couponCode) {
                showError('Please enter a coupon code.');
                return;
            }

            applyCouponBtn.disabled = true;
            applyCouponBtn.textContent = 'Applying...';

            try {
                const response = await fetch('{{ route("user.cart.apply.coupon") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ coupon: couponCode }),
                });

                const data = await response.json();

                if (response.ok) {
                    // Update UI with new values
                    subtotalEl.textContent = `₦ ${data.subtotal.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    vatEl.textContent = `₦ ${data.charges.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    discountEl.textContent = `-₦ ${data.discount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    totalEl.textContent = `₦ ${data.total.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    amountInput.value = data.total;

                    showSuccess('Coupon applied successfully!');
                } else {
                    showError(data.message || 'Invalid coupon code.');
                }
            } catch (error) {
                console.error('Error applying coupon:', error);
                showError('An error occurred while applying the coupon.');
            } finally {
                applyCouponBtn.disabled = false;
                applyCouponBtn.textContent = 'Apply';
            }
        });
    </script>
@endpush
