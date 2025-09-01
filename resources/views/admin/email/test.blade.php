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
                    <span class="text-[#E68815] font-semibold">Test Email</span>
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
                                <a class="flex items-center space-x-3 p-2 rounded-lg text-[#1B1B1B] hover:bg-[#F5CE9F] transition"
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
                                <a class="flex items-center space-x-3 p-2 rounded-lg bg-[#F5CE9F] text-[#1B1B1B] hover:bg-[#EFCF9F] transition"
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
                    <form id="test-email-form" method="POST" action="{{ route('admin.email.send') }}" class="flex flex-col h-full">
                        @csrf

                        <!-- Header -->
                        <div class="flex items-center space-x-3 mb-12">
                            <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                <i class="uil uil-envelope-add text-xl"></i>
                            </div>
                            <h2 class="font-medium text-[18px] leading-[100%] text-[#1B1B1B]">Test Email</h2>
                        </div>

                        <!-- Recipient Email -->
                        <div class="mb-5">
                            <label for="recipient_email" class="block text-sm font-medium text-[#6B7280] mb-1">Recipient Email</label>
                            <input id="recipient_email" type="email" name="recipient_email" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:ring-1 focus:ring-[#EB8C22] text-gray-900 placeholder:text-gray-600" value="{{ old('recipient_email') }}" placeholder="recipient@domain.com">
                            @error('recipient_email')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Test Message -->
                        <div class="mb-5">
                            <label for="test_message" class="block text-sm font-medium text-[#6B7280] mb-1">Test Message (Optional)</label>
                            <textarea id="test_message" name="test_message" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:ring-1 focus:ring-[#EB8C22] text-gray-900 placeholder:text-gray-600" placeholder="Enter a test message">{{ old('test_message') }}</textarea>
                            @error('test_message')
                            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Send -->
                        <button id="submit-btn" type="submit" class="w-full bg-[#EB8C22] text-white font-medium py-3 rounded-full hover:bg-[#d1761a] transition">
                            Send Test Email
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
            const form = document.getElementById('test-email-form');
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
                button.innerHTML = `Send Test Email`;
                button.disabled = false;
                return;
            }

            setTimeout(() => form.submit(), 500);
        });
    </script>
@endpush
