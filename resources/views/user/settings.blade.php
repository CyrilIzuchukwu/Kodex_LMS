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
                    <form action="" method="" enctype="multipart/form-data">
                        @csrf

                        <div class="bg-white rounded-[20px] px-4 p-4 md:px-6 md:p-6 flex flex-col gap-7">

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
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                    <input type="text" value="cypher34@gmail.com" readonly name="" class="input">
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fullname</label>
                                    <input type="text" value="Purpose" name="" class="input">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                    <input type="text" value="07048965290" name="" class="input">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                    <input type="text" name=""
                                        value="24 Awolowo Road, Lagos, Lagos State, 100001, Nigeria" class="input">
                                </div>
                            </div>

                            <!-- Biography -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Biography</label>
                                <textarea rows="4" class="input">I’m a passionate learner focused on building tools that solve real problems. Currently working on peer-to-peer learning platforms. LinkedIn | GitHub | Portfolio</textarea>
                            </div>

                            <!-- Button -->
                            <div class="flex justify-end">
                                <button class="bg-[#E68815] text-white font-medium px-6 py-2 rounded-full">
                                    Update Information
                                </button>
                            </div>


                        </div>
                    </form>


                </div>


                {{-- payment history section   --}}
                <div class="w-full">
                    <!-- Title -->
                    <p class="text-black font-medium text-base mb-1">Payment History</p>

                    <div class="bg-white rounded-[20px] p-3 md:p-4 flex flex-col gap-7">
                        <div class="overflow-x-auto bg-white mb-4  rounded-[10px]">
                            <table class="min-w-full divide-y divide-gray-200 border-collapse">
                                <thead class="bg-[#EDEDED]">
                                    <tr>
                                        <th class="settings-table-header">
                                            #</th>
                                        <th class="settings-table-header">
                                            Course Title</th>
                                        <th class="settings-table-header">
                                            Status</th>
                                        <th class="settings-table-header">
                                            Price</th>
                                        <th class="settings-table-header">
                                            Date & Time</th>
                                        <th class="settings-table-header">
                                            Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-[#fcfafa] divide-y divide-gray-200" id="users-container">
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-2 py-2 text-xs text-gray-700 text-center">1</td>

                                        <td class="px-2 py-2 text-xs text-gray-800 text-center">
                                            Python for Beginners
                                        </td>

                                        <td class="px-2 py-2 text-xs text-gray-800 text-center">
                                            <div
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#8A0500] bg-[#F49A96] rounded-full">

                                                Failed
                                            </div>
                                        </td>

                                        <td class="px-2 py-2 text-xs text-gray-800 text-center">
                                            ₦260,000</td>

                                        <td class="px-2 py-2 text-xs text-gray-800 text-center">
                                            Dec 4, 2019 21:42</td>
                                        </td>

                                        <td class="px-2 py-2 text-xs text-gray-800 ">
                                            <div class="text-center">
                                                <i id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                                                    class="mdi mdi-dots-vertical text-gray-500 text-2xl font-medium cursor-pointer"></i>
                                            </div>

                                            <!-- Dropdown menu -->
                                            <div id="dropdown"
                                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                                                <ul class="py-2 text-sm text-gray-700 "
                                                    aria-labelledby="dropdownDefaultButton">
                                                    <li>
                                                        <a href="javascript:void(0)" id="open-receipt-modal"
                                                            class="block px-4 py-2 hover:bg-gray-100">View
                                                            Receipt</a>
                                                    </li>

                                                    <li>
                                                        <a href="#"
                                                            class="block px-4 py-2 hover:bg-gray-100">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>

                                    <tr class="hover:bg-gray-50">
                                        <td class="px-2 py-2 text-xs text-gray-700 text-center">2</td>

                                        <td class="px-2 py-2 text-xs text-gray-800 text-center">
                                            Introduction to UI/UX Design
                                        </td>

                                        <td class="px-2 py-2 text-xs text-gray-800 text-center">
                                            <div
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#8C530D] bg-[#F5CE9F] rounded-full">

                                                Pending
                                            </div>
                                        </td>

                                        <td class="px-2 py-2 text-xs text-gray-800 text-center">
                                            ₦660,000</td>

                                        <td class="px-2 py-2 text-xs text-gray-800 text-center">
                                            Mar 20, 2019 23:14</td>
                                        </td>

                                        <td class="px-2 py-2 text-xs text-gray-800 ">
                                            <div class="text-center">
                                                <i id="dropdownDefaultButton" data-dropdown-toggle="dropdown2"
                                                    class="mdi mdi-dots-vertical text-gray-500 text-2xl font-medium cursor-pointer"></i>
                                            </div>

                                            <!-- Dropdown menu -->
                                            <div id="dropdown2"
                                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                                                <ul class="py-2 text-sm text-gray-700 "
                                                    aria-labelledby="dropdownDefaultButton">
                                                    <li>
                                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">View
                                                            Receipt</a>
                                                    </li>

                                                    <li>
                                                        <a href="#"
                                                            class="block px-4 py-2 hover:bg-gray-100">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>


                                    <tr class="hover:bg-gray-50">
                                        <td class="px-2 py-2 text-xs text-gray-700 text-center">3</td>

                                        <td class="px-2 py-2 text-xs text-gray-800 text-center">
                                            Python for Beginners
                                        </td>

                                        <td class="px-2 py-2 text-xs text-gray-800 text-center">
                                            <div
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-[#365718] bg-[#BBD1A7] rounded-full">

                                                Success
                                            </div>
                                        </td>

                                        <td class="px-2 py-2 text-xs text-gray-800 text-center">
                                            ₦260,000</td>

                                        <td class="px-2 py-2 text-xs text-gray-800 text-center">
                                            Dec 4, 2019 21:42</td>
                                        </td>

                                        <td class="px-2 py-2 text-xs text-gray-800 ">
                                            <div class="text-center">
                                                <i id="dropdownDefaultButton" data-dropdown-toggle="dropdown3"
                                                    class="mdi mdi-dots-vertical text-gray-500 text-2xl font-medium cursor-pointer"></i>
                                            </div>

                                            <!-- Dropdown menu -->
                                            <div id="dropdown3"
                                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44">
                                                <ul class="py-2 text-sm text-gray-700 "
                                                    aria-labelledby="dropdownDefaultButton">

                                                    <li>
                                                        <a href="#" class="block px-4 py-2 hover:bg-gray-100">View
                                                            Receipt</a>
                                                    </li>

                                                    <li>
                                                        <a href="#"
                                                            class="block px-4 py-2 hover:bg-gray-100">Delete</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="flex flex-col sm:flex-row justify-between text-black font-medium items-center gap-4">
                            <div>
                                <p class="text-xs md:text-sm">Showing <span>1</span> to 2 of 2 entries</p>
                            </div>

                            <div class="flex gap-2">
                                <button
                                    class="bg-[#EDEDED] text-black px-4 md:px-10 py-2 md:py-3 text-xs md:text-sm rounded-full font-medium hover:bg-gray-200 transition-colors"
                                    disabled="">
                                    Prev
                                </button>

                                <span
                                    class="border px-3 md:px-6 py-2 md:py-3 rounded-full text-xs md:text-sm bg-white text-black">1</span>

                                <button
                                    class="bg-[#E68815] text-white px-4 md:px-10 py-2 md:py-3 text-xs md:text-sm rounded-full font-medium hover:bg-amber-600 transition-colors"
                                    disabled="">
                                    Next
                                </button>
                            </div>
                        </div>

                    </div>

                </div>




                {{-- Account and Security section   --}}
                <div class="w-full">
                    <!-- Title -->
                    <p class="text-black font-medium text-base mb-1">Account & Security</p>

                    <div class="bg-white rounded-[20px] p-6 gap-8 flex flex-col">


                        <div
                            class=" flex flex-col md:flex-row items-start md:items-end justify-start md:justify-between  gap-4 ">
                            <div>
                                <p class="text-[#8C530D] font-medium text-lg flex items-center gap-2 ">
                                    <i class="hgi hgi-stroke hgi-lock-password  text-lg font-medium"></i> Security &
                                    Password
                                </p>
                                <span class="text-[#1B1B1B] text-sm font-normal ">Manage your password and security
                                    settings
                                    to safeguard your
                                    account.</span>

                            </div>


                            <button id="open-password-modal"
                                class="flex items-center justify-center space-x-1 w-full md:w-auto bg-[#E68815] hover:bg-[#cc770f] text-white text-sm font-medium px-5 py-3 rounded-full shadow">

                                <span>Change Password</span>
                            </button>

                        </div>

                        <div
                            class="  flex flex-col md:flex-row items-start md:items-end justify-start md:justify-between  gap-4  ">
                            <div>
                                <p class="text-[#8C530D] font-medium text-lg flex items-center gap-2 ">
                                    <i class="hgi hgi-stroke hgi-link-04 text-lg font-medium"></i>
                                    Linked accounts
                                </p>
                                <span class="text-[#1B1B1B] text-sm font-normal ">Enable seamless and secure access by
                                    linking your Kodex account with Google</span>
                                <div class="mt-3 flex items-center gap-2">
                                    <img src="{{ asset('dashboard_assets/images/img/google.png') }}" alt="Google icon">
                                    <span class="text-[#1E1E2F] text-base font-bold ">Google</span>
                                </div>

                            </div>


                            <a href=""
                                class="flex items-center justify-center space-x-1 w-full md:w-auto bg-[#E68815] hover:bg-[#cc770f] text-white text-sm font-medium px-5 py-3 rounded-full shadow">

                                <span>Connect</span>
                            </a>

                        </div>


                        <div
                            class="  flex flex-col md:flex-row items-start md:items-end justify-start md:justify-between  gap-4  ">
                            <div>
                                <p class="text-[#E30800] font-medium text-lg flex items-center gap-2 ">
                                    <i class="hgi hgi-stroke hgi-link-04 text-lg font-medium"></i>
                                    Delete my Account
                                </p>
                                <span class="text-[#1B1B1B] text-sm font-normal ">Warning: Deleting your account is
                                    permanent and cannot be undone</span>

                            </div>



                            {{-- use the modal for logout or any delete modal  --}}
                            <button
                                class="flex items-center justify-center space-x-1 w-full md:w-auto bg-[#E30800] text-white text-sm font-medium px-5 py-3 rounded-full shadow">

                                <span>Delete</span>
                            </button>
                        </div>

                    </div>

                </div>

            </div>



        </div>
    </div>



    <!-- Modal Overlay for changing password -->
    <div id="password-modal-content"
        class="fixed inset-0 bg-black min-h-[100%] bg-opacity-75 backdrop-blur-sm flex justify-center items-center z-[9999] overflow-y-auto pt-4 pb-4 px-4 md:px-0 hidden opacity-0 transition-all duration-300 ease-in-out"
        role="dialog" aria-modal="true">
        <div
            class="bg-[#F9FAFC] modal-content rounded-[20px] relative shadow-lg max-w-[100%] w-[600px] p-6 md:p-10 z-[10000] self-start mt-8 mb-8 transform scale-95 transition-transform duration-300 ease-in-out">
            <!-- Close Button -->
            <div class="absolute -top-4 -right-4">
                <button id="close-password-modal"
                    class="w-[50px] h-[50px] flex items-center justify-center rounded-full bg-white shadow-md text-black text-2xl leading-none hover:bg-gray-100 focus:outline-none"
                    style="box-shadow: 0 2px 4px 0 #00000040;">
                    &times;
                </button>
            </div>

            <!-- Modal Form -->
            <form id="add-form" action="{{ route('admin.categories.store') }}" method="POST">
                @csrf
                <div class="mb-6">
                    <div class="flex items-center space-x-2 mb-8">
                        <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center">
                            <i class="hgi hgi-stroke hgi-lock-password text-white"></i>
                        </div>
                        <h3 class="text-base font-medium text-[#1B1B1B]">Password</h3>
                    </div>
                    <div class="grid grid-cols-1 mb-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#1B1B1B] mb-2">Old password *</label>
                            <input name="name" type="text"
                                class="w-full border h-12 border-gray-300 rounded-lg p-2 pl-3 focus:border-[#E68815] text-black text-sm focus:ring-1 focus:ring-[#E68815]"
                                placeholder="Enter your current password">
                            <span class="text-red-500 text-xs mt-1 hidden error-message"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 mb-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#1B1B1B] mb-2">New password *</label>
                            <input name="name" type="text"
                                class="w-full border h-12 border-gray-300 rounded-lg p-2 pl-3 focus:border-[#E68815] text-black text-sm focus:ring-1 focus:ring-[#E68815]"
                                placeholder="Create a new password">
                            <span class="text-red-500 text-xs mt-1 hidden error-message"></span>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 mb-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-[#1B1B1B] mb-2">Confirm new password *</label>
                            <input name="name" type="text"
                                class="w-full border h-12 border-gray-300 rounded-lg p-2 pl-3 focus:border-[#E68815] text-black text-sm focus:ring-1 focus:ring-[#E68815]"
                                placeholder="Re-enter new password">
                            <span class="text-red-500 text-xs mt-1 hidden error-message"></span>
                        </div>
                    </div>

                </div>
                <div class="flex mt-8 w-full">
                    <button type="submit"
                        class="bg-[#E68815] w-full text-white text-sm px-6 py-3 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815] flex items-center justify-center">
                        <span class="submit-text">Change Password</span>
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- modal for receipt  --}}
    <div id="receipt-modal-content"
        class="fixed inset-0 bg-black min-h-[100%] bg-opacity-75 backdrop-blur-sm flex justify-center items-center z-[9999] overflow-y-auto pt-4 pb-4 px-4 md:px-0 hidden opacity-0 transition-all duration-300 ease-in-out"
        role="dialog" aria-modal="true">

        <!-- Modal Content -->
        <div
           class="bg-[#F9FAFC] modal-content rounded-[20px] relative shadow-lg max-w-[100%] w-[800px] p-3 md:p-10 z-[10000] self-start mt-8 mb-8 transform scale-95 transition-transform duration-300 ease-in-out">

            <!-- Close Button -->
            <div class="absolute -top-4 -right-4">
                <button id="close-receipt-modal"
                    class="w-[50px] h-[50px] flex items-center justify-center rounded-full bg-white shadow-md text-black text-2xl leading-none hover:bg-gray-100 focus:outline-none"
                    style="box-shadow: 0 2px 4px 0 #00000040;">
                    &times;
                </button>
            </div>


            <!-- Receipt content -->
            <div class="p-3 md:p-4">
                <!-- Header with logo -->
                <div class="flex items-center mb-8">
                    <div class="flex items-center space-x-2">
                        <img class="w-[120px]" src="{{ asset('dashboard_assets/images/img/Kodex.png') }}" alt="logo">
                    </div>
                </div>

                <!-- Title -->
                <h1 class="text-[20px] font-[500] text-[#444444] mb-8">Payment Receipt</h1>

                <!-- Receipt details grid -->
                <div class="space-y-6">
                    <!-- Receipt number and date -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-[#1B1B1B] text-[14px] font-medium">Receipt
                                #:</span>
                            <span class="ml-2 text-[#1B1B1B] font-[400] text-[14px]">000123</span>
                        </div>
                        <div>
                            <span class="text-[#1B1B1B] text-[16px] font-medium">Date:</span>
                            <span class="ml-2 text-[#1B1B1B] font-[400] text-[14px]">11 Aug
                                2025</span>
                        </div>
                    </div>

                    <!-- Payment reference -->
                    <div>
                        <span class="text-[#1B1B1B] text-[14px] font-medium">Payment
                            Ref:</span>
                        <span class="ml-2 text-[#1B1B1B] font-[400] text-[14px]">LMS-2025-0811-7890</span>
                    </div>

                    <hr class="border-gray-200" />

                    <!-- Student information -->
                    <div class="space-y-4">
                        <div>
                            <span class="text-[#1B1B1B] text-[16px] font-medium">Student
                                Name:</span>
                            <span class="ml-8 text-[#1B1B1B] font-[400] text-[14px]">John
                                Doe</span>
                        </div>
                        <div>
                            <span class="text-[#1B1B1B] text-[14px] font-mediumm">Student
                                ID:</span>
                            <span class="ml-12 text-[#1B1B1B] font-[400] text-[14px]">STU-0045</span>
                        </div>
                        <div>
                            <span class="text-[#1B1B1B] text-[14px] font-medium">Course
                                purchased:</span>
                            <span class="ml-4 text-[#1B1B1B] font-[400] text-[14px]">Web
                                Development Masterclass</span>
                        </div>
                    </div>

                    <hr class="border-gray-200" />

                    <!-- Table header -->
                    <div class="grid grid-cols-4 gap-4 py-2 text-[#1B1B1B] text-[14px] font-medium">
                        <div>Description</div>
                        <div class="text-center">Qty</div>
                        <div class="text-center">Unit Price</div>
                        <div class="text-right">Total</div>
                    </div>

                    <!-- Table content -->
                    <div class="grid grid-cols-4 gap-4 py-2">
                        <div class="text-[#1B1B1B] font-[400] text-[14px]">Web Development
                            Masterclass</div>
                        <div class="text-[#1B1B1B] font-[400] text-[14px] text-center">1
                        </div>
                        <div class="text-[#1B1B1B] font-[400] text-[14px] text-center">
                            ₦50,000</div>
                        <div class="text-[#1B1B1B] font-[400] text-[14px] text-right">
                            ₦50,000</div>
                    </div>

                    <!-- Discount row -->
                    <div class="grid grid-cols-4 gap-4 py-2">
                        <div class="text-[#1B1B1B] font-[400] text-[14px]">Discount (0%)
                        </div>
                        <div class="text-[#1B1B1B] font-[400] text-[14px] text-center">-
                        </div>
                        <div class="text-[#1B1B1B] font-[400] text-[14px] text-center">-
                        </div>
                        <div class="text-[#1B1B1B] font-[400] text-[14px] text-right">₦0.00
                        </div>
                    </div>

                    <hr class="border-gray-200" />

                    <!-- Total -->
                    <div class="flex justify-between items-center py-2">
                        <span class="text-[#1B1B1B] text-[18px] font-medium">Total
                            Paid</span>
                        <span class="text-[#1B1B1B] text-[18px] font-medium">₦50,000</span>
                    </div>

                    <hr class="border-gray-200" />

                    <!-- Payment details -->
                    <div class="space-y-4">
                        <div>
                            <span class="text-[#1B1B1B] text-[18px] font-medium">Payment
                                Method:</span>
                            <span class="ml-4 text-[#1B1B1B] font-[400] text-[14px]">Card
                                Payment (Mastercard **** 3421)</span>
                        </div>
                        <div>
                            <span class="text-[#1B1B1B] text-[18px] font-medium">Transaction
                                ID:</span>
                            <span class="ml-8 text-[#1B1B1B] font-[400] text-[14px]">TXN-88899-KOD</span>
                        </div>
                        <div class="flex items-center">
                            <span class="text-[#1B1B1B] text-[18px] font-medium">Status:</span>
                            <div class="ml-12 flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-green-600 font-[400] text-[14px]">Successful</span>
                            </div>
                        </div>
                    </div>

                    <!-- Print button -->
                    <div class="flex justify-center pt-6">
                        <button
                            class="flex items-center space-x-4 bg-[#E68815] text-white px-6 py-2 rounded-[30px] ">
                            🖨️ <span class="text-[12px]">Print</span>
                        </button>
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




        <script>
            // Password Modal
            const openPasswordBtn = document.getElementById("open-password-modal");
            const passwordModal = document.getElementById("password-modal-content");
            const closePasswordBtn = document.getElementById("close-password-modal");


            function openPasswordModal() {
                passwordModal.classList.remove("hidden", "opacity-0");
                passwordModal.classList.add("opacity-100");
                passwordModal.querySelector(".modal-content").classList.add("scale-100");
                passwordModal.querySelector(".modal-content").classList.remove("scale-95");
            }

            function closePasswordModal() {
                passwordModal.classList.remove("opacity-100");
                passwordModal.classList.add("opacity-0");
                passwordModal.querySelector(".modal-content").classList.add("scale-95");
                passwordModal.querySelector(".modal-content").classList.remove("scale-100");

                setTimeout(() => {
                    passwordModal.classList.add("hidden");
                }, 300);
            }

            openPasswordBtn.addEventListener("click", openPasswordModal);
            closePasswordBtn.addEventListener("click", closePasswordModal);


            // Receipt Modal
            const openReceiptBtn = document.getElementById("open-receipt-modal");
            const receiptModal = document.getElementById("receipt-modal-content");
            const closeReceiptBtn = document.getElementById("close-receipt-modal");

            function openReceiptModal() {
                receiptModal.classList.remove("hidden", "opacity-0");
                receiptModal.classList.add("opacity-100");
                receiptModal.querySelector(".modal-content").classList.add("scale-100");
                receiptModal.querySelector(".modal-content").classList.remove("scale-95");
            }

            function closeReceiptModal() {
                receiptModal.classList.remove("opacity-100");
                receiptModal.classList.add("opacity-0");
                receiptModal.querySelector(".modal-content").classList.add("scale-95");
                receiptModal.querySelector(".modal-content").classList.remove("scale-100");

                setTimeout(() => {
                    receiptModal.classList.add("hidden");
                }, 300);
            }

            openReceiptBtn.addEventListener("click", openReceiptModal);
            closeReceiptBtn.addEventListener("click", closeReceiptModal);

            // Optional: close on outside click
            [passwordModal, receiptModal].forEach((modal) => {
                modal.addEventListener("click", (e) => {
                    if (e.target === modal) {
                        if (modal.id === "password-modal-content") closePasswordModal();
                        if (modal.id === "receipt-modal-content") closeReceiptModal();
                    }
                });
            });

            // Optional: close with Escape key
            document.addEventListener("keydown", (e) => {
                if (e.key === "Escape") {
                    if (!passwordModal.classList.contains("hidden")) closePasswordModal();
                    if (!receiptModal.classList.contains("hidden")) closeReceiptModal();
                }
            });
        </script>
    @endpush
@endsection
