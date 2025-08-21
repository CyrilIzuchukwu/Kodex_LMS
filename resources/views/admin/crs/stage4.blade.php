@extends('layouts.admin')
@section('content')
    <div>
        <p class="text-base md:text-[20px] font-medium text-[#5D5D5D] mb-8">
            Course Oversight > <span class="text-[#848484]">Create Course</span>
        </p>
    </div>

    <div class="space-x-4 mb-10 mt-20">

        <!-- Steps -->
        <div class="flex items-center justify-center space-x-0">
            <!-- Step 1 (Active) -->
            <div class="relative flex items-center">
                <div
                    class="w-12 h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">

                    1

                </div>

                <!-- Line to Next -->
                <div class="w-28 h-[8px] line-gradient bg-[#E68815]"></div>
            </div>

            <!-- Step 2 -->
            <div class="relative flex items-center">
                <div
                    class="w-12 h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">
                    2

                </div>
                <!-- Line to Next -->
                <div class="w-28 h-[8px] line-gradient bg-[#E68815]"></div>
            </div>

            <!-- Step 3 -->
            <div class="relative flex items-center">
                <div
                    class="w-12 h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">
                    3

                </div>
                <!-- Line to Next -->
                <div class="w-28 h-[8px] line-gradient bg-[#E68815]"></div>
            </div>


            <!-- Step 4 -->
            <div class="relative flex items-center">
                <div
                    class="w-12 h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">
                    4

                    <!-- Step Label -->
                    <div
                        class="px-4 py-2 inline-block rounded-[10px] shadow-sm border border-[#929292] absolute -top-14 left-1/2 -translate-x-1/2 whitespace-nowrap">
                        <span class="text-[#444444] text-sm font-medium">
                            Course Content
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="w-auto bg-white rounded-[20px] px-4 py-4 md:px-6 md:py-6 shadow-sm overflow-hidden ">

        {{-- header  --}}
        <div class="flex flex-row justify-between mb-8 gap-2 items-center md:flex-row md:justify-between">
            <div class="flex items-center space-x-2">
                <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center">
                    <i class="uil uil-book-open text-white"></i>
                </div>
                <h3 class="text-base font-medium text-[#1B1B1B]">Course Content</h3>
            </div>

            <!-- Add Module Button -->
            <button id=""
                class="flex items-center justify-center space-x-1 w-full md:w-auto bg-[#E68815] hover:bg-[#cc770f] text-white text-sm font-medium px-5 py-3 rounded-full shadow">
                <i class="uil uil-plus text-sm font-medium"></i>
                <span>Add Module</span>
            </button>
        </div>


        {{-- content  --}}
        <div>
            <form action="" method="" enctype="multipart/form-data">
                @csrf



                {{-- buttons  --}}
                <div class="grid grid-cols-2 gap-4 mt-8 w-full">
                    <a href="" type="button" id="prev-button"
                        class="bg-[#EDEDED] block text-center w-full text-gray-800 text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                        Prev
                    </a>

                    <button type="submit" id="next-button"
                        class="bg-[#E68815] w-full text-white text-sm px-6 py-3 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815] flex items-center justify-center transition duration-200">
                        <span class="submit-text">Save</span>
                    </button>
                </div>



            </form>
        </div>


    </div>


    @push('styles')
        <style>
            .line-gradient {
                box-shadow: 0px 4px 4px 0px #00000040 inset;
            }

            .round-gradient {
                box-shadow: 0px 2px 4px 0px #00000040;
            }
        </style>
    @endpush
@endsection
