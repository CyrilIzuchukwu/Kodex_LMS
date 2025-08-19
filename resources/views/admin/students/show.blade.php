 @extends('layouts.admin')

 @section('title', 'Dashboard')

 @section('content')

 {{-- Start Content --}}

 <div x-data="{ open: false }"
     x-init="$watch('open', value => { document.body.classList.toggle('overflow-hidden', value) })">
     <p class="text-[20px] font-medium text-[#5D5D5D] mb-16">User Management > <span class="text-[#848484]">Student's
             profile</span></p>



     <div class="w-full bg-white rounded-[30px] py-6 shadow-sm overflow-hidden">

         <main class="max-w-6xl mx-auto">

             <!-- Top Card -->
             <section class="w-full bg-white text-black rounded-[30px] py-3 shadow-sm">
                 <!-- Header -->
                 <div class="rounded-[30px] border-0 shadow-md bg-[#F9F9F9] p-6">
                     <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                         <div class="flex items-center gap-4">
                             <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center">
                                 <img src="{{ asset('dashboard_assets/images/img/image.png') }}" alt="image">
                             </div>
                             <div>
                                 <h1 class="text-xl font-bold text-gray-800">John Doe</h1>
                                 <p class="text-gray-500">JohnDoe@gmail.com</p>
                             </div>
                         </div>
                         <button
                             class="bg-[#E68815] hover:bg-[#ffaa42] text-white rounded-full px-6 py-2 flex items-center gap-2">
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                 viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" d="M12 20h9"></path>
                             </svg>
                             Edit Profile
                         </button>
                     </div>
                 </div>

                 <!-- Account Information -->
                 <section class="rounded-[30px] border-0 shadow-md bg-[#F9F9F9] mt-6 py-3">
                     <div class="p-6">
                         <h2 class="text-lg font-semibold text-gray-800 mb-6">Account Information</h2>
                         <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 text-sm">
                             <div class="space-y-3">
                                 <p><span class="font-medium">First Name:</span> <span
                                         class="ml-2 text-gray-600">John</span></p>
                                 <p><span class="font-medium">Last Name:</span> <span
                                         class="ml-2 text-gray-600">Doe</span></p>
                             </div>
                             <div class="space-y-3">
                                 <p><span class="font-medium">Phone:</span> <span
                                         class="ml-2 text-gray-600">07038764567</span></p>
                                 <p><span class="font-medium">Email:</span> <span
                                         class="ml-2 text-gray-600">johndoe@gmail.com</span></p>
                             </div>
                             <div class="space-y-3">
                                 <p><span class="font-medium">Registered Date:</span> <span
                                         class="ml-2 text-gray-600">July 10, 2020</span></p>
                             </div>
                         </div>
                     </div>
                 </section>


                 <!-- Statistics Cards -->
                 <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                     <div class="p-6 bg-white shadow rounded-[20px] text-center">
                         <p class="text-gray-500">Total Courses</p>
                         <h3 class="text-2xl font-bold">1</h3>
                     </div>
                     <div class="p-6 bg-white shadow rounded-[20px] text-center">
                         <p class="text-gray-500">Completed Courses</p>
                         <h3 class="text-2xl font-bold">1</h3>
                     </div>
                     <div class="p-6 bg-white shadow rounded-[20px] text-center">
                         <p class="text-gray-500">In Progress</p>
                         <h3 class="text-2xl font-bold">1</h3>
                     </div>
                 </div>

                 <!-- Actions -->
                 <section class="rounded-[30px] border-0 shadow-md bg-[#F9F9F9] mt-6 py-3">
                     <div class="p-6">
                         <h2 class="text-lg font-semibold text-gray-800 mb-6">Actions</h2>
                         <div class="flex flex-wrap gap-4">
                             <button class="px-6 py-2 rounded-full bg-gray-100 hover:bg-gray-200">Reset user
                                 password</button>
                             <button class="px-6 py-2 rounded-full bg-gray-100 hover:bg-gray-200">Send email</button>
                             <button class="px-6 py-2 rounded-full bg-yellow-500 hover:bg-yellow-600 text-white">Block
                                 user</button>
                             <button class="px-6 py-2 rounded-full bg-red-500 hover:bg-red-600 text-white">Delete
                                 user</button>
                         </div>
                     </div>
                 </section>


                 <!-- Tabs Section -->
                 <section x-data="{ tab: 'courses' }" class="rounded-[30px] border-0 shadow-md bg-[#F9F9F9] mt-6 py-3">
                     <div class="p-6">
                         <!-- Tabs Header -->
                         <div class="flex gap-2 bg-gray-100 rounded-full p-1 w-max">
                             <button @click="tab = 'courses'"
                                 :class="tab === 'courses' ? 'bg-white shadow px-4 py-2 rounded-full' : 'px-4 py-2 rounded-full'">
                                 Courses
                             </button>
                             <button @click="tab = 'transactions'"
                                 :class="tab === 'transactions' ? 'bg-white shadow px-4 py-2 rounded-full' : 'px-4 py-2 rounded-full'">
                                 Transaction History
                             </button>
                         </div>

                         <!-- Courses Table -->
                         <div class="mt-6 overflow-x-auto" x-show="tab === 'courses'">
                             <table class="w-full border-collapse text-center">
                                 <thead>
                                     <tr class="border-b">
                                         <th class="py-3 px-2 text-sm font-medium text-gray-500">#</th>
                                         <th class="py-3 px-2 text-sm font-medium text-gray-500">Course Name</th>
                                         <th class="py-3 px-2 text-sm font-medium text-gray-500">Progress</th>
                                         <th class="py-3 px-2 text-sm font-medium text-gray-500">Status</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <tr class="border-b">
                                         <td class="py-4 px-2 text-sm">1</td>
                                         <td class="py-4 px-2 text-sm">Web Development</td>
                                         <td class="py-4 px-2 text-sm">80%</td>
                                         <td class="py-4 px-2"><span
                                                 class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">Completed</span>
                                         </td>
                                     </tr>
                                     <tr>
                                         <td class="py-4 px-2 text-sm">2</td>
                                         <td class="py-4 px-2 text-sm">Node.js</td>
                                         <td class="py-4 px-2 text-sm">50%</td>
                                         <td class="py-4 px-2"><span
                                                 class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-600">In
                                                 Progress</span></td>
                                     </tr>
                                 </tbody>
                             </table>
                         </div>

                         <!-- Transactions Table -->
                         <div class="mt-6 overflow-x-auto" x-show="tab === 'transactions'">
                             <table class="w-full border-collapse text-center">
                                 <thead>
                                     <tr class="border-b">
                                         <th class="py-3 px-2 text-sm font-medium text-gray-500">#</th>
                                         <th class="py-3 px-2 text-sm font-medium text-gray-500">Purchased Courses</th>
                                         <th class="py-3 px-2 text-sm font-medium text-gray-500">Price</th>
                                         <th class="py-3 px-2 text-sm font-medium text-gray-500">Payment Method</th>
                                         <th class="py-3 px-2 text-sm font-medium text-gray-500">Status</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     <tr class="border-b">
                                         <td class="py-4 px-2 text-sm">1</td>
                                         <td class="py-4 px-2 text-sm">Web Development</td>
                                         <td class="py-4 px-2 text-sm">$50</td>
                                         <td class="py-4 px-2 text-sm">Credit Card</td>
                                         <td class="py-4 px-2"><span
                                                 class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">Success</span>
                                         </td>
                                     </tr>
                                     <tr>
                                         <td class="py-4 px-2 text-sm">2</td>
                                         <td class="py-4 px-2 text-sm">Node.js</td>
                                         <td class="py-4 px-2 text-sm">$70</td>
                                         <td class="py-4 px-2 text-sm">PayPal</td>
                                         <td class="py-4 px-2"><span
                                                 class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-600">Pending</span>
                                         </td>
                                     </tr>
                                     <tr>
                                         <td class="py-4 px-2 text-sm">3</td>
                                         <td class="py-4 px-2 text-sm">React JS</td>
                                         <td class="py-4 px-2 text-sm">$70</td>
                                         <td class="py-4 px-2 text-sm">USSD</td>
                                         <td class="py-4 px-2"><span
                                                 class="px-3 py-1 text-xs rounded-full bg-[#E8322B] text-white">Failed</span>
                                         </td>
                                     </tr>
                                 </tbody>
                             </table>
                         </div>
                     </div>
                 </section>



                 <!-- Pagination -->
                 <div class="flex justify-between text-black font-medium items-center mt-6">
                     <p class="text-sm">Showing <span>1</span> to 5 of 5 entries</p>
                     <div class="flex gap-2">
                         <button
                             class="bg-[#EDEDED] text-black px-10 py-3 rounded-full text-sm font-medium hover:bg-gray-200">Prev</button>
                         <span class="border px-6 py-3 rounded-full bg-white text-black">5</span>
                         <button
                             class="bg-[#E68815] text-white px-10 py-3 rounded-full text-sm font-medium hover:bg-amber-600">Next</button>
                     </div>
                 </div>

             </section>
         </main>



     </div>


 </div>



 {{-- End Content --}}
 @endsection