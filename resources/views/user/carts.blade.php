@extends('layouts.user')
@section('content')
    <div class="">
        {{-- header text  --}}
        <div class="mb-4">
            <p class="text-[#5D5D5D] font-medium text-[18px]">My Carts</p>
        </div>

        <div class="min-h-screen bg-white p-3 md:p-6 rounded-[10px] md:rounded-[20px]">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-medium text-black">3 Courses in cart</h2>
            </div>



            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Cart Items -->
                <div class="col-span-2 space-y-4">
                    <!-- Item -->
                    <div
                        class="flex bg-[#F9FAFC] rounded-2xl border border-[#E1E1E1] p-3 shadow-sm hover:bg-gray-100 transition">

                        <div class="flex flex-col md:flex-row items-start md:items-center md:gap-2 justify-between w-full">

                            <div class="flex flex-col md:flex-row md:items-center gap-3">

                                <!-- Image -->
                                <div class="w-full md:w-[170px] h-[170px] md:h-[100px] !rounded-lg !overflow-hidden">
                                    <img src="{{ asset('dashboard_assets/images/img/cp.png') }}" alt="cover photo"
                                        class="w-full h-full object-cover object-center" />
                                </div>

                                <!-- Content -->
                                <div class="flex-1 text-left md:text-left">
                                    <h3 class="font-medium text-[#1B1B1B] text-base">C Programming Fundamentals for
                                        Beginners</h3>
                                    <p class="text-gray-500 text-sm mt-1">by Steve Jobs</p>
                                    <p class="font-medium text-gray-900 text-sm mt-2">₦120,000</p>
                                </div>
                            </div>

                            <!-- Remove Button -->
                            <div class="flex ml-auto">
                                <a href="#" class="text-[#E30800] text-xs flex flex-col items-center justify-center">
                                    <i class="mdi mdi-trash-can-outline"></i>
                                    <span>Remove</span>
                                </a>
                            </div>

                        </div>
                    </div>


                    <!-- Item -->
                    <div
                        class="flex bg-[#F9FAFC] rounded-2xl border border-[#E1E1E1] p-3 shadow-sm hover:bg-gray-100 transition">

                        <div class="flex flex-col md:flex-row items-start md:items-center md:gap-2 justify-between w-full">

                            <div class="flex flex-col md:flex-row md:items-center gap-3">

                                <!-- Image -->
                                <div class="w-full md:w-[170px] h-[170px] md:h-[100px] !rounded-lg !overflow-hidden">
                                    <img src="{{ asset('dashboard_assets/images/img/cp.png') }}" alt="cover photo"
                                        class="w-full h-full object-cover object-center" />
                                </div>

                                <!-- Content -->
                                <div class="flex-1 text-left md:text-left">
                                    <h3 class="font-medium text-[#1B1B1B] text-base">C Programming Fundamentals for
                                        Beginners</h3>
                                    <p class="text-gray-500 text-sm mt-1">by Steve Jobs</p>
                                    <p class="font-medium text-gray-900 text-sm mt-2">₦120,000</p>
                                </div>
                            </div>

                            <!-- Remove Button -->
                            <div class="flex ml-auto">
                                <a href="#" class="text-[#E30800] text-xs flex flex-col items-center justify-center">
                                    <i class="mdi mdi-trash-can-outline"></i>
                                    <span>Remove</span>
                                </a>
                            </div>

                        </div>
                    </div>


                    <!-- Item -->
                    <div
                        class="flex bg-[#F9FAFC] rounded-2xl border border-[#E1E1E1] p-3 shadow-sm hover:bg-gray-100 transition">

                        <div class="flex flex-col md:flex-row items-start md:items-center md:gap-2 justify-between w-full">

                            <div class="flex flex-col md:flex-row md:items-center gap-3">

                                <!-- Image -->
                                <div class="w-full md:w-[170px] h-[170px] md:h-[100px] !rounded-lg !overflow-hidden">
                                    <img src="{{ asset('dashboard_assets/images/img/cp.png') }}" alt="cover photo"
                                        class="w-full h-full object-cover object-center" />
                                </div>

                                <!-- Content -->
                                <div class="flex-1 text-left md:text-left">
                                    <h3 class="font-medium text-[#1B1B1B] text-base">C Programming Fundamentals for
                                        Beginners</h3>
                                    <p class="text-gray-500 text-sm mt-1">by Steve Jobs</p>
                                    <p class="font-medium text-gray-900 text-sm mt-2">₦120,000</p>
                                </div>
                            </div>

                            <!-- Remove Button -->
                            <div class="flex ml-auto">
                                <a href="#" class="text-[#E30800] text-xs flex flex-col items-center justify-center">
                                    <i class="mdi mdi-trash-can-outline"></i>
                                    <span>Remove</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="bg-[#F9FAFC] rounded-2xl border border-[#E1E1E1] h-max sticky p-6 top-6">
                    <h3 class="font-medium text-sm text-black mb-4">Order summary</h3>

                    <div class="flex flex-col gap-y-10">
                        <div class="space-y-4 text-sm text-gray-600">
                            <div class="flex justify-between border-t border-gray-400 pt-2">
                                <span class="text-[#5D5D5D] font-normal text-xs">Subtotal</span>
                                <span class="font-medium text-xs text-[#262626]">₦560,000</span>
                            </div>
                            <div class="flex justify-between pt-2">
                                <span class="text-[#5D5D5D] font-normal text-xs">Charges</span>
                                <span class="text-xs text-[#262626]">₦9,600</span>
                            </div>
                        </div>
                        <div>
                            <div class=" mt-4 pt-4 flex justify-between font-medium text-gray-900">
                                <span class="font-medium text-[#5D5D5D]">Total:</span>
                                <span class="font-medium text-black text-lg">₦569,600</span>
                            </div>
                            <button
                                class="mt-6 w-full bg-[#E68815] hover:bg-orange-600 text-white font-medium py-3 rounded-full flex items-center justify-center">
                                Checkout →
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .custom-bg {
        background: linear-gradient(90deg, #804C0C 0%, #E68815 100%);

    }

    .custom-bg2 {
        background-image: url("{{ asset('dashboard_assets/images/img/awss.jpg') }}");
        background-size: cover;
        background-position: center;
        height: auto;
        background-repeat: no-repeat;
        background-blend-mode: overlay;
        background-color: #00000099;

    }

    @media screen and (max-width: 768px) {
        .custom-bg2 {
            background-image: url("{{ asset('dashboard_assets/images/img/backg1.png') }}");
            background-size: cover;
            background-position: center;
            height: auto;
            background-repeat: no-repeat;
            background-blend-mode: overlay;
            background-color: #00000099;

        }

    }
</style>
