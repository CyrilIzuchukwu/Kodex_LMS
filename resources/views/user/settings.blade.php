@extends('layouts.user')
@section('content')
    <div>

        {{-- header title  --}}
        <div class="w-full flex items-center space-x-1">
            <span class="text-[#5D5D5D] font-medium text-[18px]">Settings</span>
        </div>


        <div class="mt-6 ">


            {{-- content wrapper  --}}
            <div class=" flex flex-col gap-8 ">
                {{-- personal information section   --}}
                <div class="w-full">
                    <!-- Title -->
                    <p class="text-black font-medium text-base mb-1">Personal Information</p>

                    <!-- Card -->
                    <form action="">
                        <div class="bg-white rounded-[20px] p-6 flex flex-col gap-7">

                            <!-- Profile Photo -->
                            <div class="flex flex-col items-center">
                                <p class="text-base text-[#1B1B1B] font-medium mb-3">Profile Photo</p>

                                <!-- Profile Photo Container -->
                                <div
                                    class="relative w-24 h-24 rounded-full border-2 border-dashed border-[#E68815] flex items-center justify-center overflow-hidden">

                                    <!-- Default User Icon (hidden if photo exists) -->
                                    <i id="userIcon" class="uil uil-user text-[#1B1B1B] text-3xl"></i>

                                    <!-- Image Preview (hidden by default, or load from DB if exists) -->
                                    <img id="previewImage" src="{{ $user->profile_photo ?? '' }}" alt="Profile Photo"
                                        class="hidden w-full h-full object-cover object-center">

                                    <!-- Hidden File Input -->
                                    <input type="file" id="photoInput" name="" accept="image/*"
                                        class="absolute inset-0 opacity-0 cursor-pointer">
                                </div>

                                <p class="text-xs text-gray-500 mt-2">Make sure your photo is less than 2MB in size.</p>
                            </div>


                            <!-- Form Fields -->
                            <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fullname</label>
                                    <input type="text" value="Purpose" class="input">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                    <input type="text" value="07048965290" class="input">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <input type="text" value="24 Awolowo Road, Lagos, Lagos State, 100001, Nigeria"
                                        class="input">
                                </div>
                            </div>

                            <!-- Biography -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Biography</label>
                                <textarea rows="4" class="input">I’m a passionate learner focused on building tools that solve real problems. Currently working on peer-to-peer learning platforms. LinkedIn | GitHub | Portfolio</textarea>
                            </div>

                            <!-- Button -->
                            <div class="flex justify-end">
                                <button
                                    class="bg-[#E68815] hover:bg-orange-600 text-white font-medium px-6 py-2 rounded-full">
                                    Save and continue
                                </button>
                            </div>
                        </div>
                    </form>

                </div>


                {{-- payment history section   --}}
                <div class="w-full">
                    <!-- Title -->
                    <p class="text-black font-medium text-base mb-1">Payment History</p>

                    <div class="bg-white rounded-[20px] p-6 flex flex-col gap-7">


                    </div>

                </div>




                {{-- Account and Security section   --}}
                <div class="w-full">
                    <!-- Title -->
                    <p class="text-black font-medium text-base mb-1">Account & Security</p>

                    <div class="bg-white rounded-[20px] p-6 flex flex-col gap-7">


                    </div>

                </div>

            </div>



        </div>
    </div>

    @push('scripts')
        <script>
            const photoInput = document.getElementById('photoInput');
            const previewImage = document.getElementById('previewImage');
            const userIcon = document.getElementById('userIcon');

            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(event) {
                        previewImage.src = event.target.result;
                        previewImage.classList.remove('hidden');
                        userIcon.classList.add('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            });
        </script>
    @endpush
@endsection
