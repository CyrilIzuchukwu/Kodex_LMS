@extends('layouts.admin')
@section('content')
    <div class="mb-6 px-4 md:px-6">
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
                    <span class="text-[#E68815] font-semibold">Extensions Settings</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container mx-auto mt-4 mb-5" id="main-content">
        <!-- Extensions Settings -->
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
            <div class="col-span-1 md:col-span-4 lg:col-span-4">
                <div class="sticky top-20">
                    <div class="w-auto bg-white rounded-[20px] md:rounded-[30px] px-6 md:px-8 py-6 md:py-8 shadow-sm overflow-hidden">
                        <ul class="space-y-4">
                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg text-[#1B1B1B] hover:bg-[#F5CE9F] transition" href="{{ route('admin.settings.index') }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-setting text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[18px] leading-[100%] tracking-[-0.02em]">General Settings</p>
                                        <p class="text-sm text-[#6B7280]">Manage site name, logo, and description.</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg text-[#1B1B1B] hover:bg-[#F5CE9F] transition" href="{{ route('admin.settings.seo') }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-search-alt text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[18px] leading-[100%] tracking-[-0.02em]">SEO</p>
                                        <p class="text-sm text-[#6B7280]">Configure SEO settings for better visibility.</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg text-[#1B1B1B] hover:bg-[#F5CE9F] transition" href="{{ route('admin.settings.maintenance') }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-wrench text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[18px] leading-[100%] tracking-[-0.02em]">Maintenance</p>
                                        <p class="text-sm text-[#6B7280]">Control maintenance mode and updates.</p>
                                    </div>
                                </a>
                            </li>
                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg bg-[#F5CE9F] text-[#1B1B1B]" href="{{ route('admin.settings.extensions') }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-plug text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[18px] leading-[100%] tracking-[-0.02em]">Extensions</p>
                                        <p class="text-sm text-[#6B7280]">Manage plugins and extensions.</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-span-1 md:col-span-8 lg:col-span-8">
                <div class="w-auto bg-white rounded-[20px] md:rounded-[30px] px-6 md:px-8 py-6 md:py-8 shadow-sm overflow-hidden">
                    <!-- Extensions Form -->
                    <form id="extensions-form" method="POST" action="{{ route('admin.settings.update.extensions') }}" class="flex flex-col h-full">
                        @csrf
                        @method('PATCH')

                        <div class="flex items-center space-x-3 mb-12">
                            <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                <i class="uil uil-plug text-xl"></i>
                            </div>
                            <h2 class="font-medium text-[18px] leading-[100%] tracking-[-0.02em] text-[#1B1B1B]">
                                Extensions
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div class="mb-5">
                                <label for="google_tag" class="block text-sm font-medium text-[#6B7280] mb-1">Google Tag Manager ID</label>
                                <input id="google_tag" type="text" name="google_tag" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" value="{{ old('google_tag', extensions_settings()->google_tag ?? '') }}" placeholder="e.g., GTM-XXXXXXX">
                                <p class="text-sm text-[#6B7280] mt-2">Enter your Google Tag Manager ID to enable analytics and tracking.</p>
                                @error('google_tag')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="smartsupp_key" class="block text-sm font-medium text-[#6B7280] mb-1">Smartsupp Live Chat Key</label>
                                <input id="smartsupp_key" type="text" name="smartsupp_key" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" value="{{ old('smartsupp_key', extensions_settings()->smartsupp_key ?? '') }}" placeholder="e.g., xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx">
                                <p class="text-sm text-[#6B7280] mt-2">Enter your Smartsupp Live Chat key to enable live chat support.</p>
                                @error('smartsupp_key')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="zoho_salesiq" class="block text-sm font-medium text-[#6B7280] mb-1">Zoho SalesIQ Widget Code</label>
                                <textarea id="zoho_salesiq" name="zoho_salesiq" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" rows="4" placeholder="Enter Zoho SalesIQ widget code">{{ old('zoho_salesiq', extensions_settings()->zoho_salesiq ?? '') }}</textarea>
                                <p class="text-sm text-[#6B7280] mt-2">Paste your Zoho SalesIQ widget code for visitor tracking and live chat.</p>
                                @error('zoho_salesiq')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="whatsapp_number" class="block text-sm font-medium text-[#6B7280] mb-1">WhatsApp Number</label>
                                <input id="whatsapp_number" type="text" name="whatsapp_number" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" value="{{ old('whatsapp_number', extensions_settings()->whatsapp_number ?? '') }}" placeholder="e.g., +1234567890">
                                <p class="text-sm text-[#6B7280] mt-2">Enter your WhatsApp number for customer communication (include country code).</p>
                                @error('whatsapp_number')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="telegram_username" class="block text-sm font-medium text-[#6B7280] mb-1">Telegram Username</label>
                                <input id="telegram_username" type="text" name="telegram_username" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" value="{{ old('telegram_username', extensions_settings()->telegram_username ?? '') }}" placeholder="e.g., @YourTelegramUsername">
                                <p class="text-sm text-[#6B7280] mt-2">Enter your Telegram username for customer support integration.</p>
                                @error('telegram_username')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="intercom_app_id" class="block text-sm font-medium text-[#6B7280] mb-1">Intercom App ID</label>
                                <input id="intercom_app_id" type="text" name="intercom_app_id" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" value="{{ old('intercom_app_id', extensions_settings()->intercom_app_id ?? '') }}" placeholder="e.g., xxxxxxxx">
                                <p class="text-sm text-[#6B7280] mt-2">Enter your Intercom App ID for customer messaging and support.</p>
                                @error('intercom_app_id')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button id="submit-btn" type="submit" class="mt-auto w-full bg-[#EB8C22] text-white font-medium py-3 rounded-full hover:bg-[#d1761a] transition">
                            Save Changes
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('submit-btn').addEventListener('click', function (e) {
            e.preventDefault();
            const form = document.getElementById('extensions-form');
            const button = this;

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
                button.innerHTML = `Save Changes`;
                button.disabled = false;
                return;
            }

            // Delay for animation effect
            setTimeout(() => form.submit(), 500);
        });
    </script>
@endpush
