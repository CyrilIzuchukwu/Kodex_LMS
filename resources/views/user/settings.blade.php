@extends('layouts.user')
@section('content')
    <div>

        {{-- header title  --}}
        <div class="w-full flex items-center space-x-1">
            <span class="text-[#5D5D5D] font-medium text-[18px]">Settings</span>
        </div>


        <div class="mt-6 ">

            <div class="w-full">
                <!-- Title -->
                <p class="text-black font-medium text-base mb-1">Personal Information</p>

                <!-- Card -->
                <form action="">
                    <div class="bg-white rounded-[20px] p-6 flex flex-col gap-7">

                        <!-- Profile Photo -->
                        <div class="flex flex-col items-center">
                            <div class="w-20 h-20 rounded-full overflow-hidden">
                                <img src="https://via.placeholder.com/150" alt="Profile Photo"
                                    class="w-full h-full object-cover">
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Make sure your photo is less than 2MB in size.</p>
                        </div>

                        <!-- Form Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fullname</label>
                                <input type="text" value="Purpose"
                                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:shadow-none focus:ring-2 focus:ring-orange-400">
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="text" value="07048965290"
                                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                <input type="text" value="24 Awolowo Road, Lagos, Lagos State, 100001, Nigeria"
                                    class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">
                            </div>
                        </div>

                        <!-- Biography -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Biography</label>
                            <textarea rows="4"
                                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-400">I’m a passionate learner focused on building tools that solve real problems. Currently working on peer-to-peer learning platforms. LinkedIn | GitHub | Portfolio</textarea>
                        </div>

                        <!-- Button -->
                        <div class="flex justify-end">
                            <button class="bg-[#E68815] hover:bg-orange-600 text-white font-medium px-6 py-2 rounded-full">
                                Save and continue
                            </button>
                        </div>
                    </div>
                </form>

            </div>


        </div>
    </div>
@endsection
