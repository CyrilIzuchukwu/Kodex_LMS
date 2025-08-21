 @extends('layouts.admin')

 @section('title', 'Dashboard')

 @section('content')

     {{-- Start Content --}}

     <div x-data="{ open: false }" x-init="$watch('open', value => { document.body.classList.toggle('overflow-hidden', value) })">

         <div>
             <p class="text-[20px] font-medium text-[#5D5D5D] mb-10">Course Oversight > <span class="text-[#848484]">Create
                     Course</span></p>
                     
             <div class="max-w-7xl mx-auto ">
                 <div class=" space-x-4  mb-10 mt-20">

                     <!-- Steps -->
                     <div class="flex items-center justify-center space-x-0">
                         <!-- Step 1 (Active) -->
                         <div class="relative flex items-center">
                             <div
                                 class="w-12 h-12 flex items-center relative justify-center rounded-full bg-[#E68815] text-white font-bold shadow-[inset_0_4px_6px_rgba(0,0,0,0.3)]">

                                 1
                                 <!-- Step Label -->
                                 <div
                                     class="px-4 py-2 inline-block bg-[#EDEDED] rounded-[10px] shadow-sm border border-[#929292] absolute -top-14 left-1/2 -translate-x-1/2 whitespace-nowrap">
                                     <span class="text-[#444444] text-sm font-medium">
                                         Course Details
                                     </span>
                                 </div>
                             </div>

                             <!-- Line to Next -->
                             <div class="w-28 h-[8px] line-gradient"></div>
                         </div>

                         <!-- Step 2 -->
                         <div class="relative flex items-center">
                             <div
                                 class="w-12 h-12 flex items-center justify-center rounded-full bg-white border  text-gray-600 font-bold round-gradient">
                                 2
                             </div>
                             <!-- Line to Next -->
                             <div class="w-28 h-[8px] line-gradient"></div>
                         </div>

                         <!-- Step 3 -->
                         <div class="relative flex items-center">
                             <div
                                 class="w-12 h-12 flex items-center justify-center rounded-full bg-white border round-gradient text-gray-600 font-bold">
                                 3
                             </div>
                             <!-- Line to Next -->
                             <div class="w-28 h-[8px] line-gradient"></div>
                         </div>

                         <!-- Step 4 -->
                         <div class="relative flex items-center">
                             <div
                                 class="w-12 h-12 flex items-center justify-center rounded-full bg-white border round-gradient text-gray-600 font-bold">
                                 4
                             </div>
                         </div>
                     </div>
                 </div>


                 <div class="bg-white p-6 rounded-[20px] shadow-md mx-auto">
                     <!-- Header -->
                     <div class="flex items-center mb-6">
                         <div class="w-10 h-10 flex items-center justify-center rounded-full bg-[#E68815] text-white mr-2">
                             <img src="{{ asset('dashboard_assets/images/img/detail.png') }}" alt="detail">
                         </div>
                         <h2 class="text-[16px] font-medium text-[#1B1B1B]">Courses Details</h2>
                     </div>

                     <!-- Form -->
                     <form class="space-y-6">
                         <!-- Title -->
                         <div>
                             <label class="block text-[#1B1B1B] text-sm font-medium mb-1">Course title*</label>
                             <input type="text" placeholder="Title"
                                 class="w-full border border-[#E1E1E1] text-[#1B1B1B] rounded-md px-4 py-2 focus:border-[#E68815] focus:outline-none focus:ring-1 focus:ring-[#E68815]" />
                         </div>

                         <!-- Subtitle -->
                         <div>
                             <label class="block text-[#1B1B1B] text-sm font-medium mb-1">Course subtitle*</label>
                             <input type="text" placeholder="Subtitle"
                                 class="w-full border border-[#E1E1E1] text-[#1B1B1B] rounded-md px-4 py-2 focus:border-[#E68815] focus:outline-none focus:ring-1 focus:ring-[#E68815]" />
                         </div>

                         <!-- Description -->
                         <div>
                             <label class="block text-[#1B1B1B] text-sm font-medium mb-1">Course description*</label>
                             <div class="border border-[#E1E1E1] rounded-lg bg-white">
                                 <textarea placeholder="Write something..." rows="4"
                                     class="w-full px-4 py-3 bg-transparent text-gray-900 placeholder:text-gray-500 resize-none focus:outline-none focus:border-none focus:ring-[#E68815] !focus:ring-1  rounded-t-lg border-[#E1E1E1]"></textarea>
                                 <div
                                     class="flex items-center gap-2 px-4 py-2 border-t border-gray-300 bg-gray-50 rounded-b-lg">
                                     <!-- Bold -->
                                     <button class="p-1 hover:bg-gray-200 rounded">
                                         <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z">
                                             </path>
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z">
                                             </path>
                                         </svg>
                                     </button>
                                     <!-- Italic -->
                                     <button class="p-1 hover:bg-gray-200 rounded">
                                         <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 d="M10 4l4 16m-4-8h8"></path>
                                         </svg>
                                     </button>
                                     <!-- Underline -->
                                     <button class="p-1 hover:bg-gray-200 rounded">
                                         <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 d="M6 20h12M8 4v12a4 4 0 008 0V4"></path>
                                         </svg>
                                     </button>
                                     <div class="w-px h-4 bg-gray-300 mx-1"></div>
                                     <!-- Numbered List -->
                                     <button class="p-1 hover:bg-gray-200 rounded">
                                         <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                             <line x1="8" y1="6" x2="21" y2="6"></line>
                                             <line x1="8" y1="12" x2="21" y2="12"></line>
                                             <line x1="8" y1="18" x2="21" y2="18"></line>
                                             <line x1="3" y1="6" x2="3.01" y2="6"></line>
                                             <line x1="3" y1="12" x2="3.01" y2="12"></line>
                                             <line x1="3" y1="18" x2="3.01" y2="18"></line>
                                         </svg>
                                     </button>
                                     <!-- Bullet List -->
                                     <button class="p-1 hover:bg-gray-200 rounded">
                                         <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                             <line x1="8" y1="6" x2="21" y2="6"></line>
                                             <line x1="8" y1="12" x2="21" y2="12"></line>
                                             <line x1="8" y1="18" x2="21" y2="18"></line>
                                             <circle cx="4" cy="6" r="1"></circle>
                                             <circle cx="4" cy="12" r="1"></circle>
                                             <circle cx="4" cy="18" r="1"></circle>
                                         </svg>
                                     </button>
                                     <div class="w-px h-4 bg-gray-300 mx-1"></div>
                                     <!-- Link -->
                                     <button class="p-1 hover:bg-gray-200 rounded">
                                         <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                 d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                             </path>
                                         </svg>
                                     </button>
                                 </div>
                             </div>
                         </div>

                         <!-- Price & Category -->
                         <div class="grid grid-cols-2 gap-4">
                             <div>
                                 <label class="block text-[#1B1B1B] text-sm font-medium mb-1">Course Price*</label>
                                 <input type="text" placeholder="Price"
                                     class="w-full border border-[#E1E1E1] rounded-md text-[#1B1B1B] px-4 py-2 focus:outline-none focus:border-[#E68815] focus:ring-1 focus:ring-[#E68815]" />
                             </div>

                             <div>
                                 <label class="block text-[#1B1B1B] text-sm font-medium mb-1">Category*</label>
                                 <select
                                     class="w-full border border-[#E1E1E1] rounded-md px-4 py-2 focus:border-[#E68815] focus:outline-none focus:ring-1 focus:ring-[#E68815] text-[#1B1B1B] ">
                                     <option>Select category</option>
                                     <option>Web Development</option>
                                     <option>Design</option>
                                     <option>Marketing</option>
                                 </select>
                             </div>
                         </div>

                         <!-- Button -->
                         <button type="submit"
                             class="w-full bg-[#E68815] text-sm hover:bg-[#cc6f0f] text-white font-medium py-3 !mt-10 rounded-full">
                             Save and continue
                         </button>
                     </form>
                 </div>

             </div>



         </div>
     </div>

     {{-- End Content --}}

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
