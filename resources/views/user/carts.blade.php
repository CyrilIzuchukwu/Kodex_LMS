@extends('layouts.user')
@section('content')
<div class="space-y-10">
    <div class="min-h-screen bg-white p-6 rounded-[20px]">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-medium text-black">3 Courses in cart</h2>
            <form class="relative w-full max-w-sm">
                <input type="text" placeholder="Search..."
                    class="w-full border border-gray-50 bg-[#F6F6F6] rounded-[10px] py-2 pl-4 pr-10 text-sm focus:outline-none focus:ring-2 focus:ring-orange-400">
                <div class="absolute right-3 top-[10px]">
                    <img src="{{ asset('dashboard_assets/images/img/search.png') }}" alt="Search"
                        class="w-5 h-5 cursor-pointer">
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Cart Items -->
            <div class="col-span-2 space-y-4">
                <!-- Item -->
                <div
                    class="flex items-center gap-4 bg-[#F9FAFC] rounded-2xl border border-[#E1E1E1] p-4 shadow-sm hover:bg-gray-100 transition">
                    <img src="{{ asset('dashboard_assets/images/img/cp.png') }}" alt="cp"
                        class="w-20 h-20 rounded-lg object-cover" />
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900 text-base">C Programming Fundamentals for Beginners</h3>
                        <p class="text-gray-500 text-sm">by Steve Jobs</p>
                        <p class="font-medium text-gray-900 text-base mt-1">₦120,000</p>
                    </div>
                    <a href="#" class="text-[#E30800] text-xs hover:text-red-500 self-end flex items-center">
                        <i class="mdi mdi-trash-can-outline mr-1"></i> Remove
                    </a>
                </div>

                <!-- Repeat for other items -->
                <div
                    class="flex items-center gap-4 bg-[#F9FAFC] rounded-2xl border border-[#E1E1E1] p-4 shadow-sm hover:bg-gray-100 transition">
                    <img src="{{ asset('dashboard_assets/images/img/web.png') }}" alt="web"
                        class="w-20 h-20 rounded-lg object-cover" />
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900 text-base">Full-Stack Web Development Bootcamp</h3>
                        <p class="text-gray-500 text-sm">by Walker Lee</p>
                        <p class="font-medium text-gray-900 text-base mt-1">₦300,000</p>
                    </div>
                    <a href="#" class="text-[#E30800] text-xs hover:text-red-500 self-end flex items-center">
                        <i class="mdi mdi-trash-can-outline mr-1"></i> Remove
                    </a>
                </div>

                <div
                    class="flex items-center gap-4 bg-[#F9FAFC] rounded-2xl border border-[#E1E1E1] p-4 shadow-sm hover:bg-gray-100 transition">
                    <img src="{{ asset('dashboard_assets/images/img/lara.png') }}" alt="lara"
                        class="w-20 h-20 rounded-lg object-cover" />
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900 text-base">Building Scalable Backends with Laravel</h3>
                        <p class="text-gray-500 text-sm">by Prince Nuel</p>
                        <p class="font-medium text-gray-900 text-base mt-1">₦70,000</p>
                    </div>
                    <a href="#" class="text-[#E30800] text-xs hover:text-red-500 self-end flex items-center">
                        <i class="mdi mdi-trash-can-outline mr-1"></i> Remove
                    </a>
                </div>

                <div
                    class="flex items-center gap-4 bg-[#F9FAFC] rounded-2xl border border-[#E1E1E1] p-4 shadow-sm hover:bg-gray-100 transition">
                    <img src="{{ asset('dashboard_assets/images/img/front.png') }}" alt="front"
                        class="w-20 h-20 rounded-lg object-cover" />
                    <div class="flex-1">
                        <h3 class="font-medium text-gray-900 text-base">Frontend Engineering with React & Tailwind</h3>
                        <p class="text-gray-500 text-sm">by Alumzy Jay</p>
                        <p class="font-medium text-gray-900 text-base mt-1">₦70,000</p>
                    </div>
                    <a href="#" class="text-[#E30800] text-xs hover:text-red-500 self-end flex items-center">
                        <i class="mdi mdi-trash-can-outline mr-1"></i> Remove
                    </a>
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
    background-image: url("{{asset('dashboard_assets/images/img/awss.jpg')}}");
    background-size: cover;
    background-position: center;
    height: auto;
    background-repeat: no-repeat;
    background-blend-mode: overlay;
    background-color: #00000099;

}

@media screen and (max-width: 768px) {
    .custom-bg2 {
        background-image: url("{{asset('dashboard_assets/images/img/backg1.png')}}");
        background-size: cover;
        background-position: center;
        height: auto;
        background-repeat: no-repeat;
        background-blend-mode: overlay;
        background-color: #00000099;

    }

}
</style>