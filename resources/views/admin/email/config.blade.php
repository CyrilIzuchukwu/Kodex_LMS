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
                    <span class="text-[#E68815] font-semibold">Email Settings</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container mx-auto mt-4 mb-5" id="main-content">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4 mt-4">
            <!-- Sidebar -->
            <div class="col-span-1 md:col-span-4 lg:col-span-4">
                <div class="sticky top-20">
                    <div class="w-auto bg-white rounded-[20px] md:rounded-[30px] px-6 md:px-8 py-6 md:py-8 shadow-sm overflow-hidden">
                        <ul class="space-y-4">
                            <!-- Email Settings -->
                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg bg-[#F5CE9F] text-[#1B1B1B] hover:bg-[#EFCF9F] transition"
                                   href="{{ route('admin.email.config') }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-envelope text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[18px] leading-[100%]">Email Settings</p>
                                        <p class="text-sm text-[#6B7280]">Configure email sending options.</p>
                                    </div>
                                </a>
                            </li>

                            <!-- Test Email -->
                            <li>
                                <a class="flex items-center space-x-3 p-2 rounded-lg text-[#1B1B1B] hover:bg-[#F5CE9F] transition"
                                   href="{{ route('admin.email.send') }}">
                                    <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                        <i class="uil uil-envelope-add text-xl"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-[18px] leading-[100%]">Test Email</p>
                                        <p class="text-sm text-[#6B7280]">Send a test email to verify configuration.</p>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-span-1 md:col-span-8 lg:col-span-8">
                <div class="w-auto bg-white rounded-[20px] md:rounded-[30px] px-6 md:px-8 py-6 md:py-8 shadow-sm overflow-hidden">
                    <form id="email-settings-form" method="POST" action="{{ route('admin.email.update') }}" class="flex flex-col h-full">
                        @csrf
                        @method('PATCH')

                        <!-- Header -->
                        <div class="flex items-center space-x-3 mb-12">
                            <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                <i class="uil uil-envelope text-xl"></i>
                            </div>
                            <h2 class="font-medium text-[18px] leading-[100%] text-[#1B1B1B]">Email Settings</h2>
                        </div>

                        <!-- Provider Selection -->
                        <div class="mb-5">
                            <label for="provider" class="block text-sm font-medium text-[#6B7280] mb-1">Email Provider</label>
                            <select id="provider" name="provider" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] text-gray-900">
                                <option value="phpmailer" {{ old('provider', email_settings()->provider ?? '') == 'phpmailer' ? 'selected' : '' }}>PHPMailer (SMTP)</option>
                                <option value="mailjet" {{ old('provider', email_settings()->provider ?? '') == 'mailjet' ? 'selected' : '' }}>Mailjet</option>
                            </select>
                            @error('provider')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Enable/Disable -->
                        <div class="mb-5 flex items-center">
                            <input id="status" type="checkbox" name="status" value="1" class="w-5 h-5 text-[#EB8C22] border-gray-300 rounded focus:ring-[#EB8C22]"{{ old('status', email_settings()->status ?? false) ? 'checked' : '' }}>
                            <label for="status" class="ml-3 text-sm text-[#6B7280]">Enable email sending</label>
                            @error('status')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- PHPMailer (SMTP) Fields -->
                        <div id="phpmailer-fields" class="provider-fields">
                            <div class="mb-5">
                                <label for="host" class="block text-sm font-medium text-[#6B7280] mb-1">SMTP Host</label>
                                <input id="host" type="text" name="host" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:ring-1 focus:ring-[#EB8C22] text-gray-900 placeholder:text-gray-600" value="{{ old('host', email_settings()->host ?? '') }}" placeholder="smtp.yourmail.com">
                                @error('host')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label for="port" class="block text-sm font-medium text-[#6B7280] mb-1">SMTP Port</label>
                                    <input id="port" type="text" name="port" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:ring-1 focus:ring-[#EB8C22] text-gray-900 placeholder:text-gray-600" value="{{ old('port', email_settings()->port ?? '') }}" placeholder="587">
                                    @error('port')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="encryption" class="block text-sm font-medium text-[#6B7280] mb-1">Encryption</label>
                                    <select id="encryption" name="encryption" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:ring-1 focus:ring-[#EB8C22] text-gray-900">
                                        <option value="tls" {{ old('encryption', email_settings()->encryption ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                        <option value="ssl" {{ old('encryption', email_settings()->encryption ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                        <option value="" {{ old('encryption', email_settings()->encryption ?? '') == '' ? 'selected' : '' }}>None</option>
                                    </select>
                                    @error('encryption')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label for="username" class="block text-sm font-medium text-[#6B7280] mb-1">SMTP Username</label>
                                    <input id="username" type="text" name="username" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:ring-1 focus:ring-[#EB8C22] text-gray-900 placeholder:text-gray-600" value="{{ old('username', email_settings()->username ?? '') }}" placeholder="user@domain.com" autocomplete="off">
                                    @error('username')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="smtp_password" class="block text-sm font-medium text-[#6B7280] mb-1">SMTP Password</label>
                                    <input id="smtp_password" type="password" name="password" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:ring-1 focus:ring-[#EB8C22] text-gray-900 placeholder:text-gray-600" value="{{ old('password', email_settings()->password ?? '') }}" placeholder="••••••••••">
                                    @error('password')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Mailjet Fields -->
                        <div id="mailjet-fields" class="provider-fields hidden">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label for="api_public" class="block text-sm font-medium text-[#6B7280] mb-1">Mailjet Public Key</label>
                                    <input id="api_public" type="text" name="api_public" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:ring-1 focus:ring-[#EB8C22] text-gray-900 placeholder:text-gray-600" value="{{ old('api_public', email_settings()->api_public ?? '') }}" placeholder="Your Mailjet Public Key">
                                    @error('api_public')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="api_secret" class="block text-sm font-medium text-[#6B7280] mb-1">Mailjet Secret Key</label>
                                    <input id="api_secret" type="password" name="api_secret" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:ring-1 focus:ring-[#EB8C22] text-gray-900 placeholder:text-gray-600" value="{{ old('api_secret', email_settings()->api_secret ?? '') }}" placeholder="••••••••••">
                                    @error('api_secret')
                                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Common Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-5">
                            <div>
                                <label for="from_name" class="block text-sm font-medium text-[#6B7280] mb-1">From Name</label>
                                <input id="from_name" type="text" name="from_name" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:ring-1 focus:ring-[#EB8C22] text-gray-900 placeholder:text-gray-600" value="{{ old('from_name', email_settings()->from_name ?? '') }}" placeholder="Your App Name">
                                @error('from_name')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="from_email" class="block text-sm font-medium text-[#6B7280] mb-1">From Email</label>
                                <input id="from_email" type="email" name="from_email" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:ring-1 focus:ring-[#EB8C22] text-gray-900 placeholder:text-gray-600" value="{{ old('from_email', email_settings()->from_email ?? '') }}" placeholder="noreply@domain.com">
                                @error('from_email')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Save -->
                        <button id="submit-btn" type="submit" class="w-full bg-[#EB8C22] text-white font-medium py-3 rounded-full hover:bg-[#d1761a] transition">
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
        // Toggle provider fields
        const providerSelect = document.getElementById('provider');
        const phpmailerFields = document.getElementById('phpmailer-fields');
        const mailjetFields = document.getElementById('mailjet-fields');

        function toggleFields() {
            if (providerSelect.value === 'phpmailer') {
                phpmailerFields.classList.remove('hidden');
                mailjetFields.classList.add('hidden');
            } else if (providerSelect.value === 'mailjet') {
                phpmailerFields.classList.add('hidden');
                mailjetFields.classList.remove('hidden');
            }
        }

        providerSelect.addEventListener('change', toggleFields);
        toggleFields();

        document.getElementById('submit-btn').addEventListener('click', function (e) {
            e.preventDefault();
            const form = document.getElementById('email-settings-form');
            const button = this;

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

            if (!form.checkValidity()) {
                form.reportValidity();
                button.innerHTML = `Save Changes`;
                button.disabled = false;
                return;
            }

            setTimeout(() => form.submit(), 500);
        });
    </script>
@endpush
