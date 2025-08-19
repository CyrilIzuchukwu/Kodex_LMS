 @extends('layouts.admin')

 @section('title', 'Dashboard')

 @section('content')

     {{-- Start Content --}}

     <div x-data="{ open: false }" x-init="$watch('open', value => { document.body.classList.toggle('overflow-hidden', value) })">
         <p class="text-[20px] font-medium text-[#5D5D5D] mb-8">Course Oversight > <span class="text-[#848484]">Add
                 category</span></p>



         <div class="w-auto bg-white rounded-[24px] px-4 py-4 md:px-6 md:py-6 shadow-sm overflow-hidden">


             {{-- search and button  --}}
             <div class="flex flex-col justify-center items-center md:flex-row md:justify-between mb-8 gap-2">

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
                 <button @click="open = true"
                     class="flex items-center justify-center space-x-1 w-full md:w-auto bg-[#E68815] hover:bg-[#cc770f] text-white text-sm font-medium px-5 py-3 rounded-full shadow">
                     <i class="uil uil-plus text-sm font-medium"></i>
                     <span>Add Category</span>
                 </button>

                 <!-- Modal Overlay -->
                 <div x-cloak x-show="open" x-transition.opacity x-trap="open" @keydown.escape="open = false"
                     class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center z-[9999] overflow-y-auto pt-8 pb-8 px-4 md:px-0"
                     role="dialog" aria-modal="true">


                     <!-- Modal Box for Adding of Category-->
                     <div @click.stop @click.away="open = false" x-transition.scale
                         class="bg-[#F9FAFC] rounded-[20px] relative shadow-lg max-w-[100%] w-[600px] p-6 md:p-10 z-[10000] self-start mt-8 mb-8">

                         <!-- Header -->
                         <div class="absolute -top-4 -right-4">
                             <button @click="open = false"
                                 class="w-[50px] h-[50px] flex items-center justify-center rounded-full bg-white shadow-md text-black text-2xl leading-none hover:bg-gray-100 focus:outline-none"
                                 style="box-shadow: 0px 2px 4px 0px #00000040;">
                                 &times;
                             </button>
                         </div>

                         <form action="">

                             <div class="mb-6">
                                 <div class="flex items-center space-x-2 mb-8">
                                     <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center">
                                         <i class="uil uil-folder text-white "></i>
                                     </div>
                                     <h3 class="text-base font-medium text-[#1B1B1B]">Add Category</h3>
                                 </div>




                                 <div class="grid grid-cols-1">
                                     <div>
                                         <label class="block text-sm font-medium text-[#1B1B1B] mb-2">Category Name
                                             *</label>
                                         <input name="first_name" type="text"
                                             class="w-full border h-12 border-gray-300 rounded-lg p-2 pl-3 focus:border-[#E68815] text-black text-sm focus:ring-1 focus:ring-[#E68815]"
                                             placeholder="Development, Design, Security">
                                     </div>

                                 </div>

                             </div>




                             <div class="flex flex-col md:flex-row justify-end gap-4 mt-8 w-full">
                                 <button type="button" @click="open = false"
                                     class="bg-[#EDEDED] w-full md:w-[200px] text-gray-800 text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                     Cancel
                                 </button>

                                 <button @click="open = false" type="submit"
                                     class="bg-[#E68815] w-full md:w-auto text-white text-sm px-6 py-3 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815]">
                                     Save and Continue
                                 </button>
                             </div>
                         </form>
                     </div>
                 </div>


             </div>


             <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-x-[24px] gap-y-[20px]">



                 <!-- Card -->
                 <div class="w-auto px-4 py-4 relative border border-[#EDEDED] !rounded-[5px]" x-data="{ open: false, editOpen: false, currentCategoryName: 'Data & Analytics' }">

                     <div class="flex justify-between items-start">
                         <div class="flex items-center space-x-2">
                             <!-- Icon -->
                             <div class="w-8 h-8 rounded-full bg-[#F5CE9F] flex items-center justify-center">
                                 <i class="uil uil-graduation-cap text-[#8C530D] "></i>
                             </div>
                         </div>

                         <!-- Dropdown -->
                         <div class="relative" @click.outside="open=false">
                             <button @click="open = !open" class="p-1 rounded-full hover:bg-gray-100">
                                 <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-600" fill="currentColor"
                                     viewBox="0 0 20 20">
                                     <path
                                         d="M10 6a2 2 0 11.001-4.001A2 2 0 0110 6zM10 12a2 2 0 11.001-4.001A2 2 0 0110 12zM10 18a2 2 0 11.001-4.001A2 2 0 0110 18z" />
                                 </svg>
                             </button>

                             <!-- Dropdown menu -->
                             <div x-show="open" x-transition
                                 class="absolute right-0 mt-2 w-60 bg-white rounded-lg shadow-md border border-gray-100 z-10">
                                 <ul class="py-1 text-sm text-gray-700">
                                     <li>
                                         <button @click="open = false; editOpen = true"
                                             class="w-full text-left block text-[13px] text-[#1B1B1B] px-4 py-2 hover:bg-gray-50">
                                             Edit Category
                                         </button>
                                     </li>

                                     {{-- use the same delete modal you used for the user  --}}
                                     <li>
                                         <a href="#"
                                             class=" delete-category block cursor-pointer text-[13px] text-[#1B1B1B] px-4 py-2 hover:bg-gray-50">Delete
                                             Category</a>
                                     </li>
                                 </ul>
                             </div>
                         </div>
                     </div>

                     <div class="mt-6">
                         <h2 class="font-[400] text-[#444444] text-[12px]" x-text="currentCategoryName">Data & Analytics
                         </h2>
                     </div>

                     <div class="flex items-center justify-between mt-3">
                         <span class="text-[18px] font-medium text-[#1B1B1B]">1</span>
                         <a href="/admin/course-category/2" class="text-[10px] text-[#1B1B1B] hover:text-[#E68815]">View
                             Courses</a>
                     </div>

                     <!-- Edit Category Modal -->
                     <div x-cloak x-show="editOpen" x-transition.opacity x-trap="editOpen"
                         @keydown.escape="editOpen = false"
                         class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center z-[9999] overflow-y-auto pt-8 pb-8 px-4 md:px-0"
                         role="dialog" aria-modal="true">

                         <!-- Modal Box for Editing Category -->
                         <div @click.stop @click.away="editOpen = false" x-transition.scale
                             class="bg-[#F9FAFC] rounded-[20px] relative shadow-lg max-w-[100%] w-[600px] p-6 md:p-10 z-[10000] self-start mt-8 mb-8">

                             <!-- Header -->
                             <div class="absolute -top-4 -right-4">
                                 <button @click="editOpen = false"
                                     class="w-[50px] h-[50px] flex items-center justify-center rounded-full bg-white shadow-md text-black text-2xl leading-none hover:bg-gray-100 focus:outline-none"
                                     style="box-shadow: 0px 2px 4px 0px #00000040;">
                                     &times;
                                 </button>
                             </div>

                             <form action="">
                                 <div class="mb-6">
                                     <div class="flex items-center space-x-2 mb-8">
                                         <div class="w-10 h-10 rounded-full bg-[#E68815] flex items-center justify-center">
                                             <i class="uil uil-folder text-white"></i>
                                         </div>
                                         <h3 class="text-base font-medium text-[#1B1B1B]">Edit Category</h3>
                                     </div>

                                     <div class="grid grid-cols-1">
                                         <div>
                                             <label class="block text-sm font-medium text-[#1B1B1B] mb-2">Category Name
                                                 *</label>
                                             <input name="category_name" type="text" x-model="currentCategoryName"
                                                 class="w-full border h-12 border-gray-300 rounded-lg p-2 pl-3 focus:border-[#E68815] text-black text-sm focus:ring-1 focus:ring-[#E68815]"
                                                 placeholder="Development, Design, Security">
                                         </div>
                                     </div>
                                 </div>

                                 <div class="flex flex-col md:flex-row justify-end gap-4 mt-8 w-full">
                                     <button type="button" @click="editOpen = false"
                                         class="bg-[#EDEDED] w-full md:w-[200px] text-gray-800 text-sm font-medium px-6 py-3 rounded-full hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                         Cancel
                                     </button>
                                     <button @click="editOpen = false" type="submit"
                                         class="bg-[#E68815] w-full md:w-auto text-white text-sm px-6 py-3 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815]">
                                         Save Changes
                                     </button>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>

             </div>


         </div>

     </div>

     {{-- End Content --}}
 @endsection
