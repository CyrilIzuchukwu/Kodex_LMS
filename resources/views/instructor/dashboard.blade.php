@extends('layouts.instructor')
@section('content')
<div class="">
    <h1 class="text-[#1B1B1B] text-xl font-semibold">Welcome back, <span>Purpose <span
                class="text-2xl text-gray-300">&#x1F44B;</span></span></h1>
    <p class="text-[#848484] font-[16px]">Manage your courses and lessons.</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mt-6 px-0 sm:px-0 lg:px-0">
        <div class="p-4 sm:p-6 bg-white rounded-[20px] shadow-md relative h-[120px] sm:h-[136px] lg:h-[150px]">
            <div class="flex gap-3 sm:gap-4 mt-2 sm:mt-3 items-center">
                <div
                    class="w-6 h-6 sm:w-7 sm:h-7 lg:w-9 lg:h-9 rounded-full bg-[#F5CE9F] flex justify-center items-center">
                    <i class="uil uil-book-alt text-[#8C530D] text-base sm:text-lg lg:text-xl"></i>
                </div>
                <div>
                    <p class="text-[#1B1B1B] font-normal text-sm sm:text-base lg:text-lg">
                        Assigned courses
                    </p>
                    <p class="text-[#1B1B1B] font-medium text-xl sm:text-2xl lg:text-3xl">
                        4
                    </p>
                </div>
            </div>
            <div class="absolute bottom-1 right-1">
                <i class="uil uil-book-alt text-[#8c530d5a] text-4xl sm:text-5xl lg:text-6xl"></i>
            </div>
        </div>

        <div class="p-4 sm:p-6 bg-white rounded-[20px] shadow-md relative h-[120px] sm:h-[136px] lg:h-[150px]">
            <div class="flex gap-3 sm:gap-4 mt-2 sm:mt-3 items-center">
                <div
                    class="w-6 h-6 sm:w-7 sm:h-7 lg:w-9 lg:h-9 rounded-full bg-[#F5CE9F] flex justify-center items-center">
                    <i class="uil uil-users-alt text-[#8C530D] text-base sm:text-lg lg:text-xl"></i>
                </div>
                <div>
                    <p class="text-[#1B1B1B] font-normal text-sm sm:text-base lg:text-lg">
                        Students enrolled
                    </p>
                    <p class="text-[#1B1B1B] font-medium text-xl sm:text-2xl lg:text-3xl">
                        120
                    </p>
                </div>
            </div>
            <div class="absolute bottom-1 right-1">
                <i class="uil uil-users-alt text-[#8c530d5a] text-4xl sm:text-5xl lg:text-6xl"></i>
            </div>
        </div>

    </div>

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3 p-2 mt-6">


        <div class="flex items-center bg-[#D9D9D9] rounded-full px-3 py-1 w-full sm:w-auto ">
            <i class="uil uil-search text-[#1B1B1B] text-lg mr-2"></i>
            <input type="text" placeholder="Search..."
                class="bg-[#D9D9D9] focus:outline-none focus:ring-0 w-full text-black border-0" />
        </div>


        <div class="w-full sm:w-auto">
            <select
                class="bg-[#D9D9D9] rounded-full pl-4 pr-10 sm:pl-6 sm:pr-12 py-2 text-[#1B1B1B] text-sm sm:text-base font-medium focus:outline-none w-full sm:w-auto">
                <option>Product design</option>
                <option>Courses</option>
                <option>Students</option>
                <option>Instructors</option>
            </select>
        </div>

    </div>


    <div class="overflow-x-auto mt-6 bg-white p-6 rounded-[30px]">
        <table class="min-w-full border border-gray-200 rounded-[30px] overflow-hidden shadow-md">

            <thead class="bg-[#D9D9D9] text-[#767676]">
                <tr>
                    <th
                        class="px-2 md:px-4 py-2 md:py-3 text-center text-sm md:text-base font-medium border-r border-gray-200">
                    </th>
                    <th
                        class="px-2 md:px-4 py-2 md:py-3 text-center text-sm md:text-base font-medium border-r border-gray-200">
                        Student Name</th>
                    <th
                        class="px-2 md:px-4 py-2 md:py-3 text-center text-sm md:text-base font-medium border-r border-gray-200 hidden sm:table-cell">
                        Email</th>
                    <th
                        class="px-2 md:px-4 py-2 md:py-3 text-center text-sm md:text-base font-medium border-r border-gray-200 hidden md:table-cell">
                        Phone</th>
                    <th
                        class="px-2 md:px-4 py-2 md:py-3 text-center text-sm md:text-base font-medium border-r border-gray-200">
                        Course</th>
                    <th class="px-2 md:px-4 py-2 md:py-3 text-center text-sm md:text-base font-medium">Action</th>
                </tr>
            </thead>


            <tbody class="text-[#1B1B1B]">
                <tr class="border-t">
                    <td class="px-2 md:px-4 py-2 text-sm text-center font-normal text-[#1B1B1B]">1</td>
                    <td class="px-2 md:px-4 py-2 text-sm text-center font-normal text-[#1B1B1B]">John Doe</td>
                    <td class="px-2 md:px-4 py-2 text-sm text-center font-normal hidden sm:table-cell text-[#1B1B1B]">
                        john@example.com
                    </td>
                    <td class="px-2 md:px-4 py-2 text-sm text-center font-normal hidden md:table-cell text-[#1B1B1B]">
                        +1234567890</td>
                    <td class="px-2 md:px-4 py-2 text-sm text-center font-normal text-[#1B1B1B]">Product Design</td>
                    <td class="px-2 md:px-4 py-2 text-center">
                        <button class="text-[#141B34] hover:text-gray-900">
                            <i class="uil uil-ellipsis-v text-xl"></i>
                        </button>
                    </td>
                </tr>

                <tr class="border-t">
                    <td class="px-2 md:px-4 py-2 text-sm text-center font-normal text-[#1B1B1B]">2</td>
                    <td class="px-2 md:px-4 py-2 text-sm text-center font-normal text-[#1B1B1B]">Jane Smith</td>
                    <td class="px-2 md:px-4 py-2 text-sm text-center font-normal hidden sm:table-cell text-[#1B1B1B]">
                        jane@example.com
                    </td>
                    <td class="px-2 md:px-4 py-2 text-sm text-center font-normal hidden md:table-cell text-[#1B1B1B]">
                        +0987654321</td>
                    <td class="px-2 md:px-4 py-2 text-sm text-center font-normal text-[#1B1B1B]">Web Dev</td>
                    <td class="px-2 md:px-4 py-2 text-center">
                        <button class="text-[#141B34] hover:text-gray-900">
                            <i class="uil uil-ellipsis-v text-xl"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>


    <div class="flex flex-col sm:flex-row items-center justify-between mt-6 px-2 gap-4">
       
        <div class="text-sm sm:text-base text-[#1B1B1B] font-medium text-center sm:text-left">
            <p>
                Showing <span>1</span> to <span>2</span> of <span>5</span> entries
            </p>
        </div>

        
        <div class="flex gap-2 sm:gap-4 items-center">
            <button class="bg-[#D9D9D9] text-[#1B1B1B] font-medium px-4 sm:px-6 py-2 rounded-full text-sm">
                Prev
            </button>
            <div
                class="bg-white text-[#1B1B1B] font-medium px-3 sm:px-4 py-2 rounded-full border-2 border-[#767676] text-sm">
                1
            </div>
            <button
                class="bg-[#E68815] text-white font-medium px-4 sm:px-6 py-2 rounded-full hover:bg-[#e6b87c] text-sm">
                Next
            </button>
        </div>
    </div>

</div>


@endsection