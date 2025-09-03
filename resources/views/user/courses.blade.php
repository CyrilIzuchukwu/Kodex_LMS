@extends('layouts.user')
@section('content')
    <div>

        {{-- header text  --}}
        <div class="mb-4">
            <p class="text-[#5D5D5D] font-medium text-[18px]">Courses</p>
        </div>


        {{-- filter  --}}
        <div class="w-full max-w-xs ">
            <p class="font-medium text-[18px] text-[#1B1B1B] mb-2">Filters:</p>
            <form action="">
                <select
                    class="w-full px-4 py-2 h-12 rounded-full bg-[#F5CE9F] text-[#1B1B1B] font-medium text-sm
         appearance-none border-none outline-none focus:ring-0 focus:outline-none focus:border-none cursor-pointer">
                    <option class="bg-white" value="all">All courses</option>
                    <option class="bg-white" value="cybersecurity">Cybersecurity</option>
                    <option class="bg-white" value="uiux">UI/UX Design</option>
                    <option class="bg-white" value="frontend">Frontend Development</option>
                    <option class="bg-white" value="backend">Backend Development</option>
                </select>
            </form>

        </div>


        <div class="mt-6 ">

            <div class=" bg-white rounded-[20px] p-4 flex flex-col gap-7">
                {{-- each category courses  --}}
                <div class="">
                    <a href="{{ route('user.more-courses') }}"
                        class="text-[#1B1B1B] flex items-center gap-2 text-[18px] font-medium mt-2">
                        Cyber Security
                        <i class="hgi hgi-stroke hgi-arrow-right-01"></i>
                    </a>

                    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 place-items-center mt-4 ">
                        <!-- item 1 -->
                        <div class="bg-[#F9F8F7] rounded-2xl overflow-hidden w-full max-w-full p-3">
                            <!-- Header with Figma logo and badges -->
                            <div class="bg-figma-purple relative">
                                <div class="rounded-[10px] w-100 h-[140px] overflow-hidden bg-cover bg-center bg-no-repeat">
                                    <img class="w-100 h-100" src="{{ asset('dashboard_assets/images/img/figma.png') }}"
                                        alt="figma">
                                </div>

                                <!-- Bottom badges -->
                                <div class="absolute top-3 right-3 flex gap-2">
                                    <span class="bg-gray-100 text-[#1B1B1B] px-3 py-1 rounded-full text-xs font-medium"
                                        style="backdrop-filter: blur(4px)">
                                        Cyber Security
                                    </span>
                                </div>


                            </div>

                            <!-- Content -->
                            <div class="mt-4">
                                <h3 class="text-[#1B1B1B] font-medium text-base mb-2 leading-tight">
                                    Cloud Computing with AWS and DevOps Basics
                                </h3>
                                <p class="text-[#5D5D5D] font-normal text-sm mb-4">
                                    by Prince Nuel
                                </p>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-[#1B1B1B] font-medium text-base">₦70,000</span>
                                    <a href="{{ route('user.course-details') }}"
                                        class="text-[#E68815] font-medium text-sm transition-transform duration-400 hover:scale-105 inline-block">
                                        View Details
                                    </a>
                                </div>

                                <button
                                    class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-4 rounded-[100px] text-sm font-medium transition-colors flex items-center justify-center gap-0.5">
                                    <span class="mdi mdi-cart-outline w-6"></span>
                                    Add to cart
                                </button>
                            </div>
                        </div>

                        {{-- item 2  --}}
                        <div class="bg-[#F9F8F7] rounded-2xl overflow-hidden w-full max-w-full p-3">
                            <!-- Header with Figma logo and badges -->
                            <div class="bg-figma-purple relative">
                                <div class="rounded-[10px] w-100 h-[140px] overflow-hidden bg-cover bg-center bg-no-repeat">
                                    <img class="w-100 h-100" src="{{ asset('dashboard_assets/images/img/figma.png') }}"
                                        alt="figma">
                                </div>

                                <!-- Bottom badges -->
                                <div class="absolute top-3 right-3 flex gap-2">
                                    <span class="bg-gray-100 text-[#1B1B1B] px-3 py-1 rounded-full text-xs font-medium"
                                        style="backdrop-filter: blur(4px)">
                                        Cyber Security
                                    </span>
                                </div>


                            </div>

                            <!-- Content -->
                            <div class="mt-4">
                                <h3 class="text-[#1B1B1B] font-medium text-base mb-2 leading-tight">
                                    Cloud Computing with AWS and DevOps Basics
                                </h3>
                                <p class="text-[#5D5D5D] font-normal text-sm mb-4">
                                    by Prince Nuel
                                </p>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-[#1B1B1B] font-medium text-base">₦70,000</span>
                                    <a href="{{ route('user.course-details') }}"
                                        class="text-[#E68815] font-medium text-sm transition-transform duration-400 hover:scale-105 inline-block">
                                        View Details
                                    </a>
                                </div>

                                <button
                                    class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-4 rounded-[100px] text-sm font-medium transition-colors flex items-center justify-center gap-0.5">
                                    <span class="mdi mdi-cart-outline w-6"></span>
                                    Add to cart
                                </button>
                            </div>
                        </div>

                        {{-- item 3  --}}
                        <div class="bg-[#F9F8F7] rounded-2xl overflow-hidden w-full max-w-full p-3">
                            <!-- Header with Figma logo and badges -->
                            <div class="bg-figma-purple relative">
                                <div class="rounded-[10px] w-100 h-[140px] overflow-hidden bg-cover bg-center bg-no-repeat">
                                    <img class="w-100 h-100" src="{{ asset('dashboard_assets/images/img/figma.png') }}"
                                        alt="figma">
                                </div>

                                <!-- Bottom badges -->
                                <div class="absolute top-3 right-3 flex gap-2">
                                    <span class="bg-gray-100 text-[#1B1B1B] px-3 py-1 rounded-full text-xs font-medium"
                                        style="backdrop-filter: blur(4px)">
                                        Cyber Security
                                    </span>
                                </div>


                            </div>

                            <!-- Content -->
                            <div class="mt-4">
                                <h3 class="text-[#1B1B1B] font-medium text-base mb-2 leading-tight">
                                    Cloud Computing with AWS and DevOps Basics
                                </h3>
                                <p class="text-[#5D5D5D] font-normal text-sm mb-4">
                                    by Prince Nuel
                                </p>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-[#1B1B1B] font-medium text-base">₦70,000</span>
                                    <a href="{{ route('user.course-details') }}"
                                        class="text-[#E68815] font-medium text-sm transition-transform duration-400 hover:scale-105 inline-block">
                                        View Details
                                    </a>
                                </div>

                                <button
                                    class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-4 rounded-[100px] text-sm font-medium transition-colors flex items-center justify-center gap-0.5">
                                    <span class="mdi mdi-cart-outline w-6"></span>
                                    Add to cart
                                </button>
                            </div>
                        </div>
                    </section>
                </div>

                {{-- each category courses  --}}
                <div class="">
                    <a href="{{ route('user.more-courses') }}"
                        class="text-[#1B1B1B] flex items-center gap-2 text-[18px] font-medium mt-2">
                        Backend Development
                        <i class="hgi hgi-stroke hgi-sharp hgi-arrow-right-01 text-[#1B1B1B]"></i>
                    </a>

                    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 place-items-center mt-4 ">
                        <!-- item 1 -->
                        <div class="bg-[#F9F8F7] rounded-2xl overflow-hidden w-full max-w-full p-3">
                            <!-- Header with Figma logo and badges -->
                            <div class="bg-figma-purple relative">
                                <div class="rounded-[10px] w-100 h-[140px] overflow-hidden bg-cover bg-center bg-no-repeat">
                                    <img class="w-100 h-100" src="{{ asset('dashboard_assets/images/img/figma.png') }}"
                                        alt="figma">
                                </div>

                                <!-- Bottom badges -->
                                <div class="absolute top-3 right-3 flex gap-2">
                                    <span class="bg-gray-100 text-[#1B1B1B] px-3 py-1 rounded-full text-xs font-medium"
                                        style="backdrop-filter: blur(4px)">
                                        Backend Development
                                    </span>
                                </div>


                            </div>

                            <!-- Content -->
                            <div class="mt-4">
                                <h3 class="text-[#1B1B1B] font-medium text-base mb-2 leading-tight">
                                    Cloud Computing with AWS and DevOps Basics
                                </h3>
                                <p class="text-[#5D5D5D] font-normal text-sm mb-4">
                                    by Prince Nuel
                                </p>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-[#1B1B1B] font-medium text-base">₦70,000</span>
                                    <a href="{{ route('user.course-details') }}"
                                        class="text-[#E68815] font-medium text-sm transition-transform duration-400 hover:scale-105 inline-block">
                                        View Details
                                    </a>
                                </div>

                                <button
                                    class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-4 rounded-[100px] text-sm font-medium transition-colors flex items-center justify-center gap-0.5">
                                    <span class="mdi mdi-cart-outline w-6"></span>
                                    Add to cart
                                </button>
                            </div>
                        </div>

                        {{-- item 2  --}}
                        <div class="bg-[#F9F8F7] rounded-2xl overflow-hidden w-full max-w-full p-3">
                            <!-- Header with Figma logo and badges -->
                            <div class="bg-figma-purple relative">
                                <div
                                    class="rounded-[10px] w-100 h-[140px] overflow-hidden bg-cover bg-center bg-no-repeat">
                                    <img class="w-100 h-100" src="{{ asset('dashboard_assets/images/img/figma.png') }}"
                                        alt="figma">
                                </div>

                                <!-- Bottom badges -->
                                <div class="absolute top-3 right-3 flex gap-2">
                                    <span class="bg-gray-100 text-[#1B1B1B] px-3 py-1 rounded-full text-xs font-medium"
                                        style="backdrop-filter: blur(4px)">
                                        Backend Development
                                    </span>
                                </div>


                            </div>

                            <!-- Content -->
                            <div class="mt-4">
                                <h3 class="text-[#1B1B1B] font-medium text-base mb-2 leading-tight">
                                    Cloud Computing with AWS and DevOps Basics
                                </h3>
                                <p class="text-[#5D5D5D] font-normal text-sm mb-4">
                                    by Prince Nuel
                                </p>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-[#1B1B1B] font-medium text-base">₦70,000</span>
                                    <a href="{{ route('user.course-details') }}"
                                        class="text-[#E68815] font-medium text-sm transition-transform duration-400 hover:scale-105 inline-block">
                                        View Details
                                    </a>
                                </div>

                                <button
                                    class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-4 rounded-[100px] text-sm font-medium transition-colors flex items-center justify-center gap-0.5">
                                    <span class="mdi mdi-cart-outline w-6"></span>
                                    Add to cart
                                </button>
                            </div>
                        </div>

                        {{-- item 3  --}}
                        <div class="bg-[#F9F8F7] rounded-2xl overflow-hidden w-full max-w-full p-3">
                            <!-- Header with Figma logo and badges -->
                            <div class="bg-figma-purple relative">
                                <div
                                    class="rounded-[10px] w-100 h-[140px] overflow-hidden bg-cover bg-center bg-no-repeat">
                                    <img class="w-100 h-100" src="{{ asset('dashboard_assets/images/img/figma.png') }}"
                                        alt="figma">
                                </div>

                                <!-- Bottom badges -->
                                <div class="absolute top-3 right-3 flex gap-2">
                                    <span class="bg-gray-100 text-[#1B1B1B] px-3 py-1 rounded-full text-xs font-medium"
                                        style="backdrop-filter: blur(4px)">
                                        Backend Development
                                    </span>
                                </div>


                            </div>

                            <!-- Content -->
                            <div class="mt-4">
                                <h3 class="text-[#1B1B1B] font-medium text-base mb-2 leading-tight">
                                    Cloud Computing with AWS and DevOps Basics
                                </h3>
                                <p class="text-[#5D5D5D] font-normal text-sm mb-4">
                                    by Prince Nuel
                                </p>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-[#1B1B1B] font-medium text-base">₦70,000</span>
                                    <a href="{{ route('user.course-details') }}"
                                        class="text-[#E68815] font-medium text-sm transition-transform duration-400 hover:scale-105 inline-block">
                                        View Details
                                    </a>
                                </div>

                                <button
                                    class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-4 rounded-[100px] text-sm font-medium transition-colors flex items-center justify-center gap-0.5">
                                    <span class="mdi mdi-cart-outline w-6"></span>
                                    Add to cart
                                </button>
                            </div>
                        </div>
                    </section>
                </div>


                {{-- each category courses  --}}
                <div class="">
                    <a href="{{ route('user.more-courses') }}"
                        class="text-[#1B1B1B] flex items-center gap-2 text-[18px] font-medium mt-2">
                        UI/UX Design
                        <i class="hgi hgi-stroke hgi-sharp hgi-arrow-right-01 text-[#1B1B1B]"></i>
                    </a>

                    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 place-items-center mt-4 ">
                        <!-- item 1 -->
                        <div class="bg-[#F9F8F7] rounded-2xl overflow-hidden w-full max-w-full p-3">
                            <!-- Header with Figma logo and badges -->
                            <div class="bg-figma-purple relative">
                                <div
                                    class="rounded-[10px] w-100 h-[140px] overflow-hidden bg-cover bg-center bg-no-repeat">
                                    <img class="w-100 h-100" src="{{ asset('dashboard_assets/images/img/figma.png') }}"
                                        alt="figma">
                                </div>

                                <!-- Bottom badges -->
                                <div class="absolute top-3 right-3 flex gap-2">
                                    <span class="bg-gray-100 text-[#1B1B1B] px-3 py-1 rounded-full text-xs font-medium"
                                        style="backdrop-filter: blur(4px)">
                                        UI/UX Design
                                    </span>
                                </div>


                            </div>

                            <!-- Content -->
                            <div class="mt-4">
                                <h3 class="text-[#1B1B1B] font-medium text-base mb-2 leading-tight">
                                    Cloud Computing with AWS and DevOps Basics
                                </h3>
                                <p class="text-[#5D5D5D] font-normal text-sm mb-4">
                                    by Prince Nuel
                                </p>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-[#1B1B1B] font-medium text-base">₦70,000</span>
                                    <a href="{{ route('user.course-details') }}"
                                        class="text-[#E68815] font-medium text-sm transition-transform duration-400 hover:scale-105 inline-block">
                                        View Details
                                    </a>
                                </div>

                                <button
                                    class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-4 rounded-[100px] text-sm font-medium transition-colors flex items-center justify-center gap-0.5">
                                    <span class="mdi mdi-cart-outline w-6"></span>
                                    Add to cart
                                </button>
                            </div>
                        </div>

                        {{-- item 2  --}}
                        <div class="bg-[#F9F8F7] rounded-2xl overflow-hidden w-full max-w-full p-3">
                            <!-- Header with Figma logo and badges -->
                            <div class="bg-figma-purple relative">
                                <div
                                    class="rounded-[10px] w-100 h-[140px] overflow-hidden bg-cover bg-center bg-no-repeat">
                                    <img class="w-100 h-100" src="{{ asset('dashboard_assets/images/img/figma.png') }}"
                                        alt="figma">
                                </div>

                                <!-- Bottom badges -->
                                <div class="absolute top-3 right-3 flex gap-2">
                                    <span class="bg-gray-100 text-[#1B1B1B] px-3 py-1 rounded-full text-xs font-medium"
                                        style="backdrop-filter: blur(4px)">
                                        UI/UX Design
                                    </span>
                                </div>


                            </div>

                            <!-- Content -->
                            <div class="mt-4">
                                <h3 class="text-[#1B1B1B] font-medium text-base mb-2 leading-tight">
                                    Cloud Computing with AWS and DevOps Basics
                                </h3>
                                <p class="text-[#5D5D5D] font-normal text-sm mb-4">
                                    by Prince Nuel
                                </p>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-[#1B1B1B] font-medium text-base">₦70,000</span>
                                    <a href="{{ route('user.course-details') }}"
                                        class="text-[#E68815] font-medium text-sm transition-transform duration-400 hover:scale-105 inline-block">
                                        View Details
                                    </a>
                                </div>

                                <button
                                    class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-4 rounded-[100px] text-sm font-medium transition-colors flex items-center justify-center gap-0.5">
                                    <span class="mdi mdi-cart-outline w-6"></span>
                                    Add to cart
                                </button>
                            </div>
                        </div>

                        {{-- item 3  --}}
                        <div class="bg-[#F9F8F7] rounded-2xl overflow-hidden w-full max-w-full p-3">
                            <!-- Header with Figma logo and badges -->
                            <div class="bg-figma-purple relative">
                                <div
                                    class="rounded-[10px] w-100 h-[140px] overflow-hidden bg-cover bg-center bg-no-repeat">
                                    <img class="w-100 h-100" src="{{ asset('dashboard_assets/images/img/figma.png') }}"
                                        alt="figma">
                                </div>

                                <!-- Bottom badges -->
                                <div class="absolute top-3 right-3 flex gap-2">
                                    <span class="bg-gray-100 text-[#1B1B1B] px-3 py-1 rounded-full text-xs font-medium"
                                        style="backdrop-filter: blur(4px)">
                                        UI/UX Design
                                    </span>
                                </div>


                            </div>

                            <!-- Content -->
                            <div class="mt-4">
                                <h3 class="text-[#1B1B1B] font-medium text-base mb-2 leading-tight">
                                    Cloud Computing with AWS and DevOps Basics
                                </h3>
                                <p class="text-[#5D5D5D] font-normal text-sm mb-4">
                                    by Prince Nuel
                                </p>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-[#1B1B1B] font-medium text-base">₦70,000</span>
                                    <a href="{{ route('user.course-details') }}"
                                        class="text-[#E68815] font-medium text-sm transition-transform duration-400 hover:scale-105 inline-block">
                                        View Details
                                    </a>
                                </div>

                                <button
                                    class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-4 rounded-[100px] text-sm font-medium transition-colors flex items-center justify-center gap-0.5">
                                    <span class="mdi mdi-cart-outline w-6"></span>
                                    Add to cart
                                </button>
                            </div>
                        </div>
                    </section>
                </div>
            </div>

        </div>
    </div>
@endsection
