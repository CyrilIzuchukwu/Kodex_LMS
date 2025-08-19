 @extends('layouts.admin')

 @section('title', 'Dashboard')

 @section('content')

     {{-- Start Content --}}

     <div x-data="{ open: false }" x-init="$watch('open', value => { document.body.classList.toggle('overflow-hidden', value) })">
         <p class="text-[20px] font-medium text-[#5D5D5D] mb-8">Category > <span class="text-[#848484]">Web Development</span>
         </p>



         <div class="w-auto bg-white rounded-[24px] px-4 md:px-6 py-6 shadow-sm overflow-hidden">
             {{-- search and button  --}}
             <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-8 w-full">
                 <!-- Search Bar -->
                 <div class="relative w-full md:max-w-xs">
                     <form action="">
                         <span class="absolute left-4 top-[14px] text-gray-500">
                             <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                             </svg>
                         </span>

                         <input type="text" placeholder="Search"
                             class="w-full pl-10 pr-4 py-3 border-none rounded-full bg-gray-100 focus:outline-none focus:ring-1 focus:border-none focus:ring-[#cc770f] text-sm text-gray-700 placeholder-gray-500" />
                     </form>
                 </div>

                 <!-- Add Category Button -->
                 <a href=""
                     class="w-full md:w-auto flex items-center justify-center space-x-1 bg-[#E68815] hover:bg-[#cc770f] text-white text-sm font-medium px-5 py-3 rounded-full shadow">
                     <i class="uil uil-plus text-sm font-medium"></i>
                     <span>Add Course</span>
                 </a>
             </div>



             <div class="w-auto overflow-hidden">
                 <div class="overflow-x-auto bg-white mb-10 md:mb-20 rounded-[20px] md:rounded-[30px]">
                     <table class="min-w-full divide-y divide-gray-200 border-collapse">
                         <thead class="bg-[#EDEDED]">
                             <tr>
                                 <th
                                     class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center">
                                     #</th>
                                 <th
                                     class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-left">
                                     Course Title</th>
                                 <th
                                     class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center hidden sm:table-cell">
                                     Student</th>
                                 <th
                                     class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center hidden md:table-cell">
                                     Category</th>
                                 <th
                                     class="table-header px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center hidden md:table-cell">
                                     Price</th>

                                 <th class="px-2 md:px-6 py-3 text-xs md:text-sm font-medium text-gray-500 text-center">
                                     Action</th>
                             </tr>
                         </thead>
                         <tbody class="bg-[#fcfafa] divide-y divide-gray-200" id="users-container">
                             <tr class="hover:bg-gray-50">
                                 <td class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 text-center">1</td>


                                 <td
                                     class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden sm:table-cell text-center">
                                     Data analysis</td>

                                 <td
                                     class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden md:table-cell text-center">
                                     30</td>

                                 <td
                                     class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden md:table-cell text-center">
                                     Development</td>

                                 <td
                                     class="px-2 md:px-6 py-4 text-xs md:text-sm text-gray-700 hidden md:table-cell text-center">
                                     20000</td>



                                 <td class="px-2 md:px-6 py-4">
                                     <div class="flex justify-center relative" x-data="{ open: false }"
                                         @click.away="open = false">
                                         <!-- Gray-colored icon button -->
                                         <button @click="open = !open"
                                             class="inline-flex items-center p-2 text-sm font-medium text-center text-gray-500 hover:text-gray-700 bg-transparent rounded-lg hover:bg-gray-100 focus:outline-none"
                                             type="button" aria-label="Actions menu">
                                             <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                 fill="currentColor" viewBox="0 0 4 15">
                                                 <path
                                                     d="M3.5 1.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 6.041a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Zm0 5.959a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0Z">
                                                 </path>
                                             </svg>
                                         </button>


                                     </div>
                                 </td>
                             </tr>

                         </tbody>
                     </table>
                 </div>

                 <!-- Pagination -->
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

     </div>

     {{-- End Content --}}
 @endsection
