@extends('layouts.user')
@section('content')
    <div>

        {{-- header text  --}}
        <div class="mb-4">
            <p class="text-[#5D5D5D] font-medium text-[18px]">My Learning</p>
        </div>

        {{-- filter and sort --}}

        {{-- added both form and anchor tag  --}}
        <div class=" flex flex-col md:flex-row items-start md:items-center gap-3 w-full ">
            {{-- filter  --}}

            <div class="w-full md:max-w-[250px]">
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

            {{-- sort --}}
            <div x-data="{ open: false, selected: 'Completed' }" class="relative w-full md:max-w-[250px]">
                <p class="font-medium text-[18px] text-[#1B1B1B] mb-2">Sort by:</p>

                <!-- Button -->
                <button @click="open = !open"
                    class="w-full px-4 py-2 h-12 rounded-full bg-[#F5CE9F] text-[#1B1B1B] font-medium text-sm flex justify-between items-center">
                    <span x-text="selected"></span>
                    <i :class="open ? 'uil uil-angle-up text-2xl' : 'uil uil-angle-down text-2xl'"></i>
                </button>

                <!-- Dropdown -->
                <ul x-show="open" @click.outside="open = false" x-transition
                    class="absolute mt-2 w-full bg-white text-[#1B1B1B] rounded-2xl shadow-md overflow-hidden z-20">
                    <li>
                        <a @click="selected = 'Completed'; open = false"
                            class="block px-4 py-2 text-sm hover:bg-[#F5CE9F] cursor-pointer">Completed</a>
                    </li>
                    <li>
                        <a @click="selected = 'Ongoing'; open = false"
                            class="block px-4 py-2 text-sm hover:bg-[#F5CE9F] cursor-pointer">Ongoing</a>
                    </li>
                    <li>
                        <a @click="selected = 'Paused'; open = false"
                            class="block px-4 py-2 text-sm hover:bg-[#F5CE9F] cursor-pointer">Paused</a>
                    </li>
                </ul>
            </div>

        </div>



        <div class="mt-6 ">

            {{-- items  --}}
            <div class=" bg-white rounded-[20px] p-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                {{-- item  --}}
                <div class="bg-[#F9F8F7] rounded-2xl p-3 shadow-inner">

                    <div class="flex items-start gap-4 mb-4">

                        <a href="{{ route('user.course-watch') }}"
                            class="w-12 h-12 rounded-lg flex-shrink-0 relative block cursor-pointer overflow-hidden">

                            <!-- Cover Image -->
                            <img src="{{ asset('dashboard_assets/images/img/aws.png') }}" alt="Cover Image"
                                class="w-full h-full object-cover rounded-lg">

                            <!-- Dark Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-30 rounded-lg"></div>

                            <!-- Video Icon -->
                            <div class="absolute inset-0 flex items-center justify-center z-50">
                                <div class="relative flex items-center justify-center h-8 w-8 rounded-full bg-white">
                                    <i class="uil uil-play text-[#E68815] text-[14px]"></i>

                                    <!-- Ripple Effect -->
                                    <span
                                        class="absolute inline-flex h-full w-full rounded-full bg-white opacity-50 animate-ripple"></span>
                                </div>
                            </div>
                        </a>



                        <div class="flex-1 min-w-0">
                            <h2 class="text-sm text-[#1B1B1B] font-medium mb-1">Cloud Computing with AWS and DevOps Basics
                            </h2>
                            <p class="text-sm text-[#A6A6A6] font-medium">by Prince nuel</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="h-2 bg-[#D9D9D9] rounded-full overflow-hidden" role="progressbar" aria-valuemin="0"
                            aria-valuemax="100" aria-valuenow="45" aria-label="Course progress: 45% complete">
                            <div class="h-full bg-[#D97706] transition-all duration-300 w-1/2"></div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-4 text-sm text-[#A6A6A6]">
                        <div class="flex justify-center gap-2">
                            <i class="mdi mdi-book-open-blank-variant-outline"></i>
                            <span class="text-sm">16/40 Lessons</span>
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <a href="{{ route('user.course-watch') }}" class="text-[#8C530D] font-medium text-sm outline-none">
                            Resume Learning →
                        </a>
                    </div>
                </div>

                {{-- item  --}}
                <div class="bg-[#F9F8F7] rounded-2xl p-3 shadow-inner">

                    <div class="flex items-start gap-4 mb-4">

                        <a href=""
                            class="w-12 h-12 rounded-lg flex-shrink-0 relative block cursor-pointer overflow-hidden">

                            <!-- Cover Image -->
                            <img src="{{ asset('dashboard_assets/images/img/aws.png') }}" alt="Cover Image"
                                class="w-full h-full object-cover rounded-lg">

                            <!-- Dark Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-30 rounded-lg"></div>

                            <!-- Video Icon -->
                            <div class="absolute inset-0 flex items-center justify-center z-50">
                                <div class="relative flex items-center justify-center h-8 w-8 rounded-full bg-white">
                                    <i class="uil uil-play text-[#E68815] text-[14px]"></i>

                                    <!-- Ripple Effect -->
                                    <span
                                        class="absolute inline-flex h-full w-full rounded-full bg-white opacity-50 animate-ripple"></span>
                                </div>
                            </div>
                        </a>



                        <div class="flex-1 min-w-0">
                            <h2 class="text-sm text-[#1B1B1B] font-medium mb-1">Cloud Computing with AWS and DevOps Basics
                            </h2>
                            <p class="text-sm text-[#A6A6A6] font-medium">by Prince nuel</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="h-2 bg-[#D9D9D9] rounded-full overflow-hidden" role="progressbar" aria-valuemin="0"
                            aria-valuemax="100" aria-valuenow="45" aria-label="Course progress: 45% complete">
                            <div class="h-full bg-[#D97706] transition-all duration-300" style="width: 65%"></div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-4 text-sm text-[#A6A6A6]">
                        <div class="flex justify-center gap-2">
                            <i class="mdi mdi-book-open-blank-variant-outline"></i>
                            <span class="text-sm">16/40 Lessons</span>
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <a href="#" class="text-[#8C530D] font-medium text-sm outline-none">
                            Resume Learning →
                        </a>
                    </div>
                </div>


                {{-- item  --}}
                <div class="bg-[#F9F8F7] rounded-2xl p-3 shadow-inner">

                    <div class="flex items-start gap-4 mb-4">

                        <a href=""
                            class="w-12 h-12 rounded-lg flex-shrink-0 relative block cursor-pointer overflow-hidden">

                            <!-- Cover Image -->
                            <img src="{{ asset('dashboard_assets/images/img/aws.png') }}" alt="Cover Image"
                                class="w-full h-full object-cover rounded-lg">

                            <!-- Dark Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-30 rounded-lg"></div>

                            <!-- Video Icon -->
                            <div class="absolute inset-0 flex items-center justify-center z-50">
                                <div class="relative flex items-center justify-center h-8 w-8 rounded-full bg-white">
                                    <i class="uil uil-play text-[#E68815] text-[14px]"></i>

                                    <!-- Ripple Effect -->
                                    <span
                                        class="absolute inline-flex h-full w-full rounded-full bg-white opacity-50 animate-ripple"></span>
                                </div>
                            </div>
                        </a>



                        <div class="flex-1 min-w-0">
                            <h2 class="text-sm text-[#1B1B1B] font-medium mb-1">Cloud Computing with AWS and DevOps Basics
                            </h2>
                            <p class="text-sm text-[#A6A6A6] font-medium">by Prince nuel</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="h-2 bg-[#D9D9D9] rounded-full overflow-hidden" role="progressbar" aria-valuemin="0"
                            aria-valuemax="100" aria-valuenow="45" aria-label="Course progress: 45% complete">
                            <div class="h-full bg-[#D97706] transition-all duration-300" style="width: 65%"></div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-4 text-sm text-[#A6A6A6]">
                        <div class="flex justify-center gap-2">
                            <i class="mdi mdi-book-open-blank-variant-outline"></i>
                            <span class="text-sm">16/40 Lessons</span>
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <a href="#" class="text-[#8C530D] font-medium text-sm outline-none">
                            Resume Learning →
                        </a>
                    </div>
                </div>


                {{-- item  --}}
                <div class="bg-[#F9F8F7] rounded-2xl p-3 shadow-inner">

                    <div class="flex items-start gap-4 mb-4">

                        <a href=""
                            class="w-12 h-12 rounded-lg flex-shrink-0 relative block cursor-pointer overflow-hidden">

                            <!-- Cover Image -->
                            <img src="{{ asset('dashboard_assets/images/img/aws.png') }}" alt="Cover Image"
                                class="w-full h-full object-cover rounded-lg">

                            <!-- Dark Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-30 rounded-lg"></div>

                            <!-- Video Icon -->
                            <div class="absolute inset-0 flex items-center justify-center z-50">
                                <div class="relative flex items-center justify-center h-8 w-8 rounded-full bg-white">
                                    <i class="uil uil-play text-[#E68815] text-[14px]"></i>

                                    <!-- Ripple Effect -->
                                    <span
                                        class="absolute inline-flex h-full w-full rounded-full bg-white opacity-50 animate-ripple"></span>
                                </div>
                            </div>
                        </a>



                        <div class="flex-1 min-w-0">
                            <h2 class="text-sm text-[#1B1B1B] font-medium mb-1">Cloud Computing with AWS and DevOps Basics
                            </h2>
                            <p class="text-sm text-[#A6A6A6] font-medium">by Prince nuel</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="h-2 bg-[#D9D9D9] rounded-full overflow-hidden" role="progressbar" aria-valuemin="0"
                            aria-valuemax="100" aria-valuenow="45" aria-label="Course progress: 45% complete">
                            <div class="h-full bg-[#D97706] transition-all duration-300" style="width: 65%"></div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-4 text-sm text-[#A6A6A6]">
                        <div class="flex justify-center gap-2">
                            <i class="mdi mdi-book-open-blank-variant-outline"></i>
                            <span class="text-sm">16/40 Lessons</span>
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <a href="#" class="text-[#8C530D] font-medium text-sm outline-none">
                            Resume Learning →
                        </a>
                    </div>
                </div>

                {{-- item  --}}
                <div class="bg-[#F9F8F7] rounded-2xl p-3 shadow-inner">

                    <div class="flex items-start gap-4 mb-4">

                        <a href=""
                            class="w-12 h-12 rounded-lg flex-shrink-0 relative block cursor-pointer overflow-hidden">

                            <!-- Cover Image -->
                            <img src="{{ asset('dashboard_assets/images/img/aws.png') }}" alt="Cover Image"
                                class="w-full h-full object-cover rounded-lg">

                            <!-- Dark Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-30 rounded-lg"></div>

                            <!-- Video Icon -->
                            <div class="absolute inset-0 flex items-center justify-center z-50">
                                <div class="relative flex items-center justify-center h-8 w-8 rounded-full bg-white">
                                    <i class="uil uil-play text-[#E68815] text-[14px]"></i>

                                    <!-- Ripple Effect -->
                                    <span
                                        class="absolute inline-flex h-full w-full rounded-full bg-white opacity-50 animate-ripple"></span>
                                </div>
                            </div>
                        </a>



                        <div class="flex-1 min-w-0">
                            <h2 class="text-sm text-[#1B1B1B] font-medium mb-1">Cloud Computing with AWS and DevOps Basics
                            </h2>
                            <p class="text-sm text-[#A6A6A6] font-medium">by Prince nuel</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="h-2 bg-[#D9D9D9] rounded-full overflow-hidden" role="progressbar" aria-valuemin="0"
                            aria-valuemax="100" aria-valuenow="45" aria-label="Course progress: 45% complete">
                            <div class="h-full bg-[#D97706] transition-all duration-300" style="width: 65%"></div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-4 text-sm text-[#A6A6A6]">
                        <div class="flex justify-center gap-2">
                            <i class="mdi mdi-book-open-blank-variant-outline"></i>
                            <span class="text-sm">16/40 Lessons</span>
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <a href="#" class="text-[#8C530D] font-medium text-sm outline-none">
                            Resume Learning →
                        </a>
                    </div>
                </div>


                {{-- item  --}}
                <div class="bg-[#F9F8F7] rounded-2xl p-3 shadow-inner">

                    <div class="flex items-start gap-4 mb-4">

                        <a href=""
                            class="w-12 h-12 rounded-lg flex-shrink-0 relative block cursor-pointer overflow-hidden">

                            <!-- Cover Image -->
                            <img src="{{ asset('dashboard_assets/images/img/aws.png') }}" alt="Cover Image"
                                class="w-full h-full object-cover rounded-lg">

                            <!-- Dark Overlay -->
                            <div class="absolute inset-0 bg-black bg-opacity-30 rounded-lg"></div>

                            <!-- Video Icon -->
                            <div class="absolute inset-0 flex items-center justify-center z-50">
                                <div class="relative flex items-center justify-center h-8 w-8 rounded-full bg-white">
                                    <i class="uil uil-play text-[#E68815] text-[14px]"></i>

                                    <!-- Ripple Effect -->
                                    <span
                                        class="absolute inline-flex h-full w-full rounded-full bg-white opacity-50 animate-ripple"></span>
                                </div>
                            </div>
                        </a>



                        <div class="flex-1 min-w-0">
                            <h2 class="text-sm text-[#1B1B1B] font-medium mb-1">Cloud Computing with AWS and DevOps Basics
                            </h2>
                            <p class="text-sm text-[#A6A6A6] font-medium">by Prince nuel</p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="h-2 bg-[#D9D9D9] rounded-full overflow-hidden" role="progressbar" aria-valuemin="0"
                            aria-valuemax="100" aria-valuenow="45" aria-label="Course progress: 45% complete">
                            <div class="h-full bg-[#D97706] transition-all duration-300" style="width: 65%"></div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 mb-4 text-sm text-[#A6A6A6]">
                        <div class="flex justify-center gap-2">
                            <i class="mdi mdi-book-open-blank-variant-outline"></i>
                            <span class="text-sm">16/40 Lessons</span>
                        </div>
                    </div>

                    <div class="flex justify-start">
                        <a href="#" class="text-[#8C530D] font-medium text-sm outline-none">
                            Resume Learning →
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <style>
        @keyframes ripple {
            0% {
                transform: scale(1);
                opacity: 0.6;
            }

            100% {
                transform: scale(2.5);
                opacity: 0;
            }
        }

        .animate-ripple {
            animation: ripple 1.5s infinite;
        }
    </style>
@endsection
