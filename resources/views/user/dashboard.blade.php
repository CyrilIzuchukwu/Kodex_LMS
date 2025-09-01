@extends('layouts.user')
@section('content')
<div >
    <div class=" w-full custom-bg items-center rounded-2xl flex justify-between px-6 py-16 relative overflow-hidden">
        <div><h1 class="text-white text-xl font-semibold">Welcome back Cyril 👋🏻</h1>
        <p class="text-white font-[16px]">Every lesson brings you closer to your goal 🚀</p></div>
        <div class="absolute right-2" >
            <img class=" " src="{{ asset('dashboard_assets/images/img/undraw.png') }}" alt="undraw">
        </div>
    </div>

    <div class="mt-6 ">
        <p class="text-[#000000] text-xl font-medium mb-4">Continue Your Journey</p>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div class="bg-[#ffffff] border border-[#D9D9D9] rounded-2xl p-6 shadow-inner">

                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('dashboard_assets/images/img/aws.png') }}" alt="aws">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-lg text-black font-semibold mb-1">Cloud Computing with AWS and DevOps Basics</h2>
                        <p class="text-sm text-[#A6A6A6] font-medium">by Prince nuel</p>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="h-2 bg-[#D9D9D9] rounded-full overflow-hidden" role="progressbar" aria-valuemin="0"
                        aria-valuemax="100" aria-valuenow="45" aria-label="Course progress: 45% complete">
                        <div class="h-full bg-[#D97706] transition-all duration-300" style="width: 45%"></div>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-4 mb-4 text-sm text-[#A6A6A6]">
                    <div class="flex justify-center gap-1">
                        <i class="mdi mdi-book-open-blank-variant-outline w-4 h-4"></i>
                        <span>16/40 Lessons</span>
                    </div>
                    <div class="flex  justify-center gap-1">
                        <i class="mdi mdi-clock-time-eight-outline w-4 h-4"></i>
                        <span>20 hours left</span>
                    </div>
                </div>

                <div class="flex justify-start">
                    <a href="#" class="text-[#8C530D] font-medium hover:underline focus:underline outline-none">
                        Resume Course →
                    </a>
                </div>
            </div>

            <div class="bg-[#ffffff] border border-[#D9D9D9] rounded-2xl p-6 shadow-inner">

                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('dashboard_assets/images/img/ui.png') }}" alt="ui">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-lg text-black font-semibold mb-1">UI/UX Design Fundamentals for Beginners</h2>
                        <p class="text-sm text-[#A6A6A6] font-medium">by Ejike Mike</p>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="h-2 bg-[#D9D9D9] rounded-full overflow-hidden" role="progressbar" aria-valuemin="0"
                        aria-valuemax="100" aria-valuenow="45" aria-label="Course progress: 45% complete">
                        <div class="h-full bg-[#D97706] transition-all duration-300" style="width: 45%"></div>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-4 mb-4 text-sm text-[#A6A6A6]">
                    <div class="flex justify-center gap-1">
                        <i class="mdi mdi-book-open-blank-variant-outline w-4 h-4"></i>
                        <span>16/40 Lessons</span>
                    </div>
                    <div class="flex  justify-center gap-1">
                        <i class="mdi mdi-clock-time-eight-outline w-4 h-4"></i>
                        <span>20 hours left</span>
                    </div>
                </div>

                <div class="flex justify-start">
                    <a href="#" class="text-[#8C530D] font-medium hover:underline focus:underline outline-none">
                        Resume Course →
                    </a>
                </div>
            </div>

            <div class="bg-[#ffffff] border border-[#D9D9D9] rounded-2xl p-6 shadow-inner">

                <div class="flex items-start gap-4 mb-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center flex-shrink-0">
                        <img src="{{ asset('dashboard_assets/images/img/shop.png') }}" alt="shop">
                    </div>
                    <div class="flex-1 min-w-0">
                        <h2 class="text-lg text-black font-semibold mb-1">Adobe Photoshop Essentials for Beginners</h2>
                        <p class="text-sm text-[#A6A6A6] font-medium">by Purpose walks</p>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="h-2 bg-[#D9D9D9] rounded-full overflow-hidden" role="progressbar" aria-valuemin="0"
                        aria-valuemax="100" aria-valuenow="45" aria-label="Course progress: 45% complete">
                        <div class="h-full bg-[#D97706] transition-all duration-300" style="width: 45%"></div>
                    </div>
                </div>

                <div class="flex items-center justify-center gap-4 mb-4 text-sm text-[#A6A6A6]">
                    <div class="flex justify-center gap-1">
                        <i class="mdi mdi-book-open-blank-variant-outline w-4 h-4"></i>
                        <span>16/40 Lessons</span>
                    </div>
                    <div class="flex  justify-center gap-1">
                        <i class="mdi mdi-clock-time-eight-outline w-4 h-4"></i>
                        <span>20 hours left</span>
                    </div>
                </div>

                <div class="flex justify-start">
                    <a href="#" class="text-[#8C530D] font-medium hover:underline focus:underline outline-none">
                        Resume Course →
                    </a>
                </div>
            </div>
        </div>


        <div class="mt-7">

            <p class="text-[#000000] text-xl font-medium mb-4">Available Courses</p>

             <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 place-items-center">
             <!-- Course Card 1 -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden w-full max-w-sm">
                <!-- Header with Figma logo and badges -->
                <div class="bg-figma-purple p-4 relative">
                    <div>
                        <img class="rounded-[20px]" src="{{ asset('dashboard_assets/images/img/figma.png') }}" alt="figma">
                    </div>
                    
                    <!-- Bottom badges -->
                    <div class="absolute top-6 right-7 flex gap-2">
                       <span class="bg-gray-100 text-[#1B1B1B] px-2 py-1 rounded-full text-xs font-medium cursor-pointer">Design</span>
                    </div>
                    
                </div>

                <!-- Content -->
                <div class="p-4">
                    <h3 class="text-[#1B1B1B] font-medium text-base mb-2 leading-tight">
                        Cloud Computing with AWS and DevOps Basics
                    </h3>
                    <p class="text-[#5D5D5D] font-normal text-sm mb-4">
                        by Prince Nuel
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[#1B1B1B] font-medium text-base">₦70,000</span>
                        <a href="{{route('user.course-details')}}" class="text-[#E68815] font-normal text-sm hover:underline">
                            View Details
                        </a>
                    </div>
                    
                    <button class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-4 rounded-[100px] font-medium transition-colors flex items-center justify-center gap-0.5">
                        <span class="mdi mdi-cart-outline w-6"></span>
                        Add to cart
                    </button>
                </div>
            </div>
             <!-- Course Card 2 -->
             <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden w-full max-w-sm">
                <!-- Header with Figma logo and badges -->
                <div class="bg-figma-purple p-4 relative">
                    <div>
                        <img class="rounded-[20px]" src="{{ asset('dashboard_assets/images/img/figma.png') }}" alt="figma">
                    </div>
                    
                    <!-- Bottom badges -->
                    <div class="absolute top-6 right-7 flex gap-2">
                       <span class="bg-gray-100 text-[#1B1B1B] px-2 py-1 rounded-full text-xs font-medium cursor-pointer">Design</span>
                    </div>
                    
                </div>

                <!-- Content -->
                <div class="p-4">
                    <h3 class="text-[#1B1B1B] font-medium text-base mb-2 leading-tight">
                        Cloud Computing with AWS and DevOps Basics
                    </h3>
                    <p class="text-[#5D5D5D] font-normal text-sm mb-4">
                        by Prince Nuel
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[#1B1B1B] font-medium text-base">₦70,000</span>
                        <a href="{{route('user.course-details')}}" class="text-[#E68815] font-normal text-sm hover:underline">
                            View Details
                        </a>
                    </div>
                    
                    <button class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-4 rounded-[100px] font-medium transition-colors flex items-center justify-center gap-0.5">
                        <span class="mdi mdi-cart-outline w-6"></span>
                        Add to cart
                    </button>
                </div>
            </div>

             <!-- Course Card 3 -->
             <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden w-full max-w-sm">
                <!-- Header with Figma logo and badges -->
                <div class="bg-figma-purple p-4 relative">
                    <div>
                        <img class="rounded-[20px]" src="{{ asset('dashboard_assets/images/img/figma.png') }}" alt="figma">
                    </div>
                    
                    <!-- Bottom badges -->
                    <div class="absolute top-6 right-7 flex gap-2">
                       <span class="bg-gray-100 text-[#1B1B1B] px-2 py-1 rounded-full text-xs font-medium cursor-pointer">Design</span>
                    </div>
                    
                </div>

                <!-- Content -->
                <div class="p-4">
                    <h3 class="text-[#1B1B1B] font-medium text-base mb-2 leading-tight">
                        Cloud Computing with AWS and DevOps Basics
                    </h3>
                    <p class="text-[#5D5D5D] font-normal text-sm mb-4">
                        by Prince Nuel
                    </p>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[#1B1B1B] font-medium text-base">₦70,000</span>
                        <a href="{{route('user.course-details')}}" class="text-[#E68815] font-normal text-sm hover:underline">
                            View Details
                        </a>
                    </div>
                    
                    <button class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-4 rounded-[100px] font-medium transition-colors flex items-center justify-center gap-0.5">
                        <span class="mdi mdi-cart-outline w-6"></span>
                        Add to cart
                    </button>
                </div>
            </div>

        </section>
        </div>
        <!-- Revenue chart -->
       
    </div>
</div>
@endsection

<style>
    .custom-bg {
        background: linear-gradient(90deg, #804C0C 0%, #E68815 100%);

    }
</style>