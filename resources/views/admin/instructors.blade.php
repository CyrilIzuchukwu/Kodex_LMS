 @extends('layouts.admin')

 @section('title', 'Dashboard')

 @section('content')

     {{-- Start Content --}}

     <div x-data="{ open: false }" x-init="$watch('open', value => { document.body.classList.toggle('overflow-hidden', value) })">
         <p class="text-[20px] font-medium text-[#5D5D5D] mb-16">User Management > <span
                 class="text-[#848484]">Instructors</span></p>
         <div class="flex justify-between items-center mb-6">
             <!-- Left Side -->
             <div class="flex items-center gap-4">
                 <!-- Add Student Button + Modal -->
                 <div class="inline-block">
                     <!-- Trigger -->
                     <button @click="open = true"
                         class="bg-[#E68815] px-2 py-3 rounded-full text-[14px] font-medium text-white hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815]">
                         + Add Instructors
                     </button>

                     <!-- Modal Overlay -->
                     <div x-cloak x-show="open" x-transition.opacity x-trap="open" @keydown.escape="open = false"
                         class="fixed inset-0 bg-black bg-opacity-50 flex justify-center z-[9999] overflow-y-auto pt-8 pb-8"
                         role="dialog" aria-modal="true">

                         <!-- Modal Box -->
                         <div @click.stop @click.away="open = false" x-transition.scale
                             class="bg-white rounded-lg shadow-lg max-w-[100%] w-[70vw] p-16 space-y-4 z-[10000] self-start mt-8 mb-8">

                             <!-- Header -->
                             <div class="flex justify-end items-center pb-3 mb-4">

                                 <button @click="open = false"
                                     class="text-gray-500 hover:text-gray-700 focus:outline-none">&times;</button>
                             </div>
                             <form action="">
                                 <!-- Personal Information -->
                                 <div class="mb-6 space-y-8">
                                     <div class="flex items-center gap-2 mb-4">
                                         <img src="{{ asset('dashboard_assets/images/img/person.png') }}" alt="person">
                                         <h3 class="text-lg font-medium text-gray-700">Personal Information</h3>
                                     </div>


                                     <div class="text-center mb-4">
                                         <h3 class="text-sm font-medium text-gray-900 mb-4">Profile Photo</h3>
                                         <div class="relative w-20 h-20 mx-auto">
                                             <input type="file" accept="image/*" id="profile-photo"
                                                 class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                                             <label for="profile-photo"
                                                 class="w-20 h-20 bg-profile-avatar rounded-full flex items-center justify-center cursor-pointer hover:bg-orange-200 transition-colors border-2 border-dashed border-section-icon">
                                                 <!-- Camera/Upload Icon -->
                                                 <!-- <img src="{{ asset('dashboard_assets/images/img/photo.png') }}" alt="photo"> -->
                                             </label>
                                         </div>
                                         <p class="text-xs text-gray-500 mt-2">Click to upload photo</p>
                                     </div>


                                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                         <div>
                                             <label class="block text-sm font-medium text-gray-700 mb-1">First Name
                                                 *</label>
                                             <input name="first_name" type="text"
                                                 class="w-full border border-gray-300 rounded-lg p-2 focus:border-[#E68815] text-black text-sm focus:ring-1 focus:ring-[#E68815]"
                                                 placeholder="Enter first name">
                                         </div>
                                         <div>
                                             <label class="block text-sm font-medium text-gray-700 mb-1">Last Name *</label>
                                             <input name="last_name" type="text"
                                                 class="w-full border border-gray-300 rounded-lg p-2 focus:border-[#E68815] text-black text-sm  ]focus:ring-1 focus:ring-[#E68815]"
                                                 placeholder="Enter last name">
                                         </div>
                                     </div>

                                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                                         <div>
                                             <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                             <input name="phone" type="tel"
                                                 class="w-full border border-gray-300 rounded-lg p-2 focus:border-[#E68815] focus:ring-1 text-black text-sm  focus:ring-[#E68815]"
                                                 placeholder="Enter phone number">
                                         </div>
                                         <div>
                                             <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                                             <input name="address" type="text"
                                                 class="w-full border border-gray-300 rounded-lg p-2 focus:border-[#E68815] focus:ring-1 text-black text-sm  focus:ring-[#E68815]"
                                                 placeholder="Enter house address">
                                         </div>
                                     </div>


                                     <div>
                                         <p class="text-sm font-medium text-gray-900 mb-4">Assigned course*</p>
                                         <div
                                             class="h-full flex flex-col items-start justify-center bg-gray-50 p-4 rounded-[30px]">



                                             <div class="space-y-5">
                                                 <div class="radio-item flex gap-4 items-center space-x-3">
                                                     <input type="radio" name="course" id="web" value="web"
                                                         class="relative w-4 h-4 border-2 rounded-full bg-white cursor-pointer
                                                            transition-all duration-200 ease-in-out hover:border-[#E68815]
                                                            focus:outline-none focus:ring-2 focus:ring-[#E68815]
                                                            checked:border-[#E68815] checked:bg-[#E68815] accent-[#E68815]">
                                                     <label for="web" class="text-sm font-normal text-gray-900">
                                                         Web Development
                                                     </label>
                                                 </div>

                                                 <div class="radio-item flex gap-4 items-center space-x-3">
                                                     <input type="radio" name="course" id="ui-ux" value="ui-ux"
                                                         class="relative w-4 h-4 border-2 rounded-full bg-white cursor-pointer
                                                            transition-all duration-200 ease-in-out hover:border-[#E68815]
                                                            focus:outline-none focus:ring-2 focus:ring-[#E68815]
                                                            checked:border-[#E68815] checked:bg-[#E68815] accent-[#E68815]">
                                                     <label for="ui-ux" class="text-sm font-normal text-gray-900">
                                                         UI/UX Design
                                                     </label>
                                                 </div>

                                                 <div class="radio-item flex gap-4 items-center space-x-3">
                                                     <input type="radio" name="course" id="data" value="data"
                                                         class="relative w-4 h-4 border-2 rounded-full bg-white cursor-pointer
                                                            transition-all duration-200 ease-in-out hover:border-[#E68815]
                                                            focus:outline-none focus:ring-2 focus:ring-[#E68815]
                                                            checked:border-[#E68815] checked:bg-[#E68815] accent-[#E68815]">
                                                     <label for="data" class="text-sm font-normal text-gray-900">
                                                         Data Analysis
                                                     </label>
                                                 </div>

                                                 <div class="radio-item flex gap-4 items-center space-x-3">
                                                     <input type="radio" name="course" id="mobile" value="mobile"
                                                         class="relative w-4 h-4 border-2 rounded-full bg-white cursor-pointer
                                                                transition-all duration-200 ease-in-out hover:border-[#E68815]
                                                                focus:outline-none focus:ring-2 focus:ring-[#E68815]
                                                                checked:border-[#E68815] checked:bg-[#E68815] accent-[#E68815]">
                                                     <label for="mobile" class="text-sm font-normal text-gray-900">
                                                         Mobile App Development
                                                     </label>
                                                 </div>
                                             </div>

                                         </div>
                                     </div>


                                     <div class="mt-4 mb-5">
                                         <label class="block text-sm font-medium text-gray-700 mb-1">Biography*</label>
                                         <div class="border border-gray-300 rounded-lg bg-white">
                                             <textarea placeholder="Write something..." rows="4"
                                                 class="w-full px-4 py-3 bg-transparent text-gray-900 placeholder:text-gray-500 resize-none focus:outline-none focus:border-none focus:ring-[#E68815] rounded-t-lg"></textarea>
                                             <div
                                                 class="flex items-center gap-2 px-4 py-2 border-t border-gray-300 bg-gray-50 rounded-b-lg">
                                                 <!-- Bold -->
                                                 <button class="p-1 hover:bg-gray-200 rounded">
                                                     <svg class="w-4 h-4 text-gray-600" fill="none"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                         <path stroke-linecap="round" stroke-linejoin="round"
                                                             stroke-width="2" d="M6 4h8a4 4 0 014 4 4 4 0 01-4 4H6z">
                                                         </path>
                                                         <path stroke-linecap="round" stroke-linejoin="round"
                                                             stroke-width="2" d="M6 12h9a4 4 0 014 4 4 4 0 01-4 4H6z">
                                                         </path>
                                                     </svg>
                                                 </button>
                                                 <!-- Italic -->
                                                 <button class="p-1 hover:bg-gray-200 rounded">
                                                     <svg class="w-4 h-4 text-gray-600" fill="none"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                         <path stroke-linecap="round" stroke-linejoin="round"
                                                             stroke-width="2" d="M10 4l4 16m-4-8h8"></path>
                                                     </svg>
                                                 </button>
                                                 <!-- Underline -->
                                                 <button class="p-1 hover:bg-gray-200 rounded">
                                                     <svg class="w-4 h-4 text-gray-600" fill="none"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                         <path stroke-linecap="round" stroke-linejoin="round"
                                                             stroke-width="2" d="M6 20h12M8 4v12a4 4 0 008 0V4"></path>
                                                     </svg>
                                                 </button>
                                                 <div class="w-px h-4 bg-gray-300 mx-1"></div>
                                                 <!-- Numbered List -->
                                                 <button class="p-1 hover:bg-gray-200 rounded">
                                                     <svg class="w-4 h-4 text-gray-600" fill="none"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                         <line x1="8" y1="6" x2="21"
                                                             y2="6"></line>
                                                         <line x1="8" y1="12" x2="21"
                                                             y2="12"></line>
                                                         <line x1="8" y1="18" x2="21"
                                                             y2="18"></line>
                                                         <line x1="3" y1="6" x2="3.01"
                                                             y2="6"></line>
                                                         <line x1="3" y1="12" x2="3.01"
                                                             y2="12"></line>
                                                         <line x1="3" y1="18" x2="3.01"
                                                             y2="18"></line>
                                                     </svg>
                                                 </button>
                                                 <!-- Bullet List -->
                                                 <button class="p-1 hover:bg-gray-200 rounded">
                                                     <svg class="w-4 h-4 text-gray-600" fill="none"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                         <line x1="8" y1="6" x2="21"
                                                             y2="6"></line>
                                                         <line x1="8" y1="12" x2="21"
                                                             y2="12"></line>
                                                         <line x1="8" y1="18" x2="21"
                                                             y2="18"></line>
                                                         <circle cx="4" cy="6" r="1"></circle>
                                                         <circle cx="4" cy="12" r="1"></circle>
                                                         <circle cx="4" cy="18" r="1"></circle>
                                                     </svg>
                                                 </button>
                                                 <div class="w-px h-4 bg-gray-300 mx-1"></div>
                                                 <!-- Link -->
                                                 <button class="p-1 hover:bg-gray-200 rounded">
                                                     <svg class="w-4 h-4 text-gray-600" fill="none"
                                                         stroke="currentColor" viewBox="0 0 24 24">
                                                         <path stroke-linecap="round" stroke-linejoin="round"
                                                             stroke-width="2"
                                                             d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1">
                                                         </path>
                                                     </svg>
                                                 </button>
                                             </div>
                                         </div>
                                     </div>
                                 </div>

                                 <!-- Login Credentials -->
                                 <div class="mt-12 mb-11">
                                     <div class="flex items-center gap-2 mb-4">
                                         <img src="{{ asset('dashboard_assets/images/img/login3.png') }}" alt="login">
                                         </svg>
                                         <h3 class="text-lg font-medium text-gray-700">Login Credentials</h3>
                                     </div>

                                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                         <div>
                                             <label class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
                                             <input name="email" type="email"
                                                 class="w-full border border-gray-300 rounded-lg text-black text-sm  p-2 focus:border-[#E68815] focus:ring-1 focus:ring-[#E68815]">
                                         </div>
                                         <div>
                                             <label class="block text-sm font-medium text-gray-700 mb-1">Password*</label>
                                             <input name="password" type="password"
                                                 class="w-full border border-gray-300 rounded-lg text-black text-sm  p-2 focus:border-[#E68815] focus:ring-1 focus:ring-[#E68815]">
                                         </div>
                                     </div>
                                 </div>

                                 <!-- Save Button -->
                                 <div class="flex justify-end mt-10">
                                     <button @click="open = false" type="submit"
                                         class="bg-[#E68815] text-white px-6 py-2 rounded-full hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815]">
                                         Save
                                     </button>
                                 </div>
                             </form>
                         </div>
                     </div>
                 </div>

                 <!-- Search Bar -->
                 <div>
                     <span class="flex items-center bg-[#EDEDED] rounded-full px-4 w-[20vw]">
                         <i class="uil uil-search text-[#141B34] text-lg mr-2"></i>
                         <input type="search" placeholder="Search" aria-label="Search"
                             class="bg-transparent outline-none border-0 focus:ring-0 w-full py-3 text-[#141B34] font-medium">
                     </span>
                 </div>
             </div>

             <!-- Right Side -->
             <div class="flex gap-4">
                 <button class="bg-[#F5CE9F] text-[#8C530D] px-10 py-3 rounded-full font-medium hover:bg-[#e6bb85]">
                     All
                 </button>
                 <div x-cloak x-data="{ open: false, selected: 'Assigned Course' }" class="relative w-64">
                     <!-- Dropdown button -->
                     <button @click="open = !open"
                         class="w-full bg-[#EDEDED] rounded-full px-7 py-3 text-[#141B34] font-medium hover:bg-gray-300 border-0 focus:outline-none focus:ring-0 transition-all flex justify-between items-center">
                         <span x-text="selected"></span>
                         <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                             <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                         </svg>
                     </button>

                     <!-- Dropdown menu -->
                     <div x-show="open" @click.away="open = false"
                         class="absolute mt-2 w-full bg-white text-black text-sm rounded-2xl shadow-lg overflow-hidden z-50">
                         <ul>
                             <template
                                 x-for="option in ['Assigned Course', 'Web Development', 'Product Design', 'Data Analysis', 'Mobile App Development']">
                                 <li @click="selected = option; open = false"
                                     class="px-7 py-3 hover:bg-[#E68815] hover:text-white font-medium cursor-pointer transition-colors">
                                     <span x-text="option"></span>
                                 </li>
                             </template>
                         </ul>
                     </div>
                 </div>
             </div>
         </div>


         <div class="w-auto bg-white rounded-[30px] px-3 py-3 shadow-sm overflow-hidden">

             <!-- Table -->
             <div class="overflow-x-auto bg-white mb-20 rounded-[30px] ">
                 <table class="min-w-full divide-y divide-gray-200 border-collapse">
                     <thead class="bg-[#EDEDED] text-center">
                         <tr>
                             <th class="px-2 py-3 text-xs font-medium text-gray-500 border-r  border-gray-300">
                             </th>
                             <th class="px-2 py-3 text-[14px] font-medium text-gray-500 border-r border-gray-300">
                                 Instructor Name</th>
                             <th class="px-2 py-3 text-[14px] font-medium text-gray-500 border-r border-gray-300">
                                 Email</th>
                             <th class="px-2 py-3 text-[14px] font-medium text-gray-500 border-r border-gray-300">
                                 Phone</th>
                             <th class="px-2 py-3 text-[14px] font-medium text-gray-500 border-r border-gray-300">
                                 Assigned Course</th>
                             <th class="px-6 py-3 text-center text-[14px] font-medium text-gray-500">Action</th>
                         </tr>

                     </thead>
                     <tbody class="bg-[#fcfafa] divide-y divide-gray-200">
                         <tr class="hover:bg-gray-50">
                             <td class="px-6 py-4 text-sm text-gray-700">1</td>
                             <td class="px-6 py-4 text-sm font-medium text-gray-800">John Doe</td>
                             <td class="px-6 py-4 text-sm text-gray-700">john@example.com</td>
                             <td class="px-6 py-4 text-sm text-gray-700">+123456789</td>
                             <td class="px-6 py-4 text-sm text-gray-700">Web Development</td>
                             <td class="px-6 py-4 text-sm text-center">
                                 <div class="flex items-center justify-center gap-2">

                                     <button
                                         class="px-3 py-1 bg-amber-500 text-white rounded-full hover:bg-amber-600 text-sm">
                                         <i class="mdi mdi-account-edit-outline"></i></button>
                                     <div x-cloak x-data="{ open: false }" class="inline-block">
                                         <!-- Delete Button -->
                                         <button @click="open = true"
                                             class="px-3 py-1 bg-red-100 text-red-600 rounded-full hover:bg-red-200 text-sm">
                                             <i class="uil uil-trash"></i>
                                         </button>

                                         <!-- Modal Overlay -->
                                         <div x-show="open" x-transition.opacity
                                             class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999]">
                                             <!-- Modal Box -->
                                             <div @click.away="open = false" x-transition.scale
                                                 class="bg-white rounded-[30px] shadow-lg w-[400px] h-[311px] max-w-sm py-6 px-3 flex flex-col items-center justify-center z-[10000]">
                                                 <img src="{{ asset('dashboard_assets/images/img/gradient.png') }}"
                                                     alt="delete">
                                                 <h2 class="text-lg font-semibold text-gray-800 mb-4">Delete Instructor?
                                                 </h2>
                                                 <p class="text-gray-600 mb-6">
                                                     Are you sure you want to remove <span class="font-semibold">Jane
                                                         Doe</span> from the system? This action cannot be undone.
                                                 </p>

                                                 <div class="flex justify-end gap-3">
                                                     <button @click="open = false"
                                                         class="px-6 py-3 rounded-full bg-[#EDEDED] text-gray-700 hover:bg-gray-300">
                                                         Cancel
                                                     </button>
                                                     <button
                                                         @click="open = false;
                        // Add your delete logic here (AJAX or form submission)
                    "
                                                         class="px-6 py-3 rounded-full bg-[#E30800] text-white hover:bg-red-600">
                                                         Delete
                                                     </button>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </td>
                         </tr>

                     </tbody>
                 </table>
             </div>


             <div class="flex justify-between text-black font-medium items-center">
                 <div>
                     <p class=" text-sm ">Showing <span>1</span> to 5 of 5 entries</p>
                 </div>
                 <div class="flex gap-2">
                     <button
                         class="bg-[#EDEDED] text-black px-10 py-3 rounded-full text-sm font-medium hover:bg-gray-200">Prev</button>
                     <span class="border px-6 py-3 rounded-full bg-white text-black">5</span>
                     <button
                         class="bg-[#E68815] text-white px-10 py-3 rounded-full text-sm font-medium hover:bg-amber-600">Next</button>
                 </div>
             </div>
         </div>

     </div>


     </div>



     {{-- End Content --}}
 @endsection
