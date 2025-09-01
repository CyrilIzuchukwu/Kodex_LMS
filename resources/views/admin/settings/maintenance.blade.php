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
                    <span class="text-[#E68815] font-semibold">Maintenance Mode</span>
                </li>
            </ol>
        </nav>
    </div>

    <div class="container mx-auto mt-4 mb-5" id="main-content">
        <!-- Maintenance Mode Settings -->
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
                                <a class="flex items-center space-x-3 p-2 rounded-lg bg-[#F5CE9F] text-[#1B1B1B]" href="{{ route('admin.settings.maintenance') }}">
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
                                <a class="flex items-center space-x-3 p-2 rounded-lg text-[#1B1B1B] hover:bg-[#F5CE9F] transition" href="{{ route('admin.settings.extensions') }}">
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
                    <!-- Maintenance Mode Form -->
                    <form id="maintenance-form" method="POST" action="{{ route('admin.settings.update.maintenance') }}" class="flex flex-col h-full">
                        @csrf
                        @method('PATCH')

                        <div class="flex items-center space-x-3 mb-12">
                            <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                                <i class="uil uil-wrench text-xl"></i>
                            </div>
                            <h2 class="font-medium text-[18px] leading-[100%] tracking-[-0.02em] text-[#1B1B1B]">
                                Maintenance Mode
                            </h2>
                        </div>

                        <div class="grid grid-cols-1 gap-4">
                            <div class="mb-5">
                                <label for="maintenance_mode" class="block text-sm font-medium text-[#6B7280] mb-1">Maintenance Mode</label>
                                <div class="flex items-center">
                                    <input id="maintenance_mode" type="checkbox" name="maintenance_mode" class="h-5 w-5 text-[#EB8C22] focus:ring-[#EB8C22] border-[#E1E1E1] rounded" value="1" {{ old('maintenance_mode', maintenance_mode()->maintenance_mode ?? false) ? 'checked' : '' }}>
                                    <label for="maintenance_mode" class="ml-2 text-sm text-[#6B7280]">Enable Maintenance Mode</label>
                                </div>
                                <p class="text-sm text-[#6B7280] mt-2">When enabled, the site will display a maintenance page to all non-admin users.</p>
                                @error('maintenance_mode')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="maintenance_message" class="block text-sm font-medium text-[#6B7280] mb-1">Maintenance Message</label>
                                <textarea id="maintenance_message" name="maintenance_message" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" rows="4" placeholder="Enter a message to display on the maintenance page" maxlength="500">{{ old('maintenance_message', maintenance_mode()->maintenance_message ?? 'The site is currently undergoing maintenance. Please check back later.') }}</textarea>
                                <p class="text-sm text-[#6B7280] mt-2">This message will be displayed to users when maintenance mode is active.</p>
                                @error('maintenance_message')
                                <span class="text-red-500 text-sm mt-1">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-5">
                                <label for="maintenance_end" class="block text-sm font-medium text-[#6B7280] mb-1">Estimated End Time (Optional)</label>
                                <input id="maintenance_end" type="datetime-local" class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] placeholder:text-[#6B7280]" name="maintenance_end" value="{{ old('maintenance_end', maintenance_mode()->maintenance_end ?? '') }}" placeholder="Select estimated end time">
                                <p class="text-sm text-[#6B7280] mt-2">Specify when maintenance is expected to be completed (optional).</p>
                                @error('maintenance_end')
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
            const form = document.getElementById('maintenance-form');
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
