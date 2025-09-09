<!-- JAVASCRIPT -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/iziToast.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/js/glightbox.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/js/cleave.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('dashboard_assets/js/plugins.init.js') }}"></script>
<script src="{{ asset('dashboard_assets/js/app.js') }}"></script>

<script src="{{ asset('dashboard_assets/js/manage_cart.js') }}"></script>

@if(Route::is('user.cart'))
    <script src="{{ asset('dashboard_assets/js/process-checkout.js') }}"></script>
@endif
