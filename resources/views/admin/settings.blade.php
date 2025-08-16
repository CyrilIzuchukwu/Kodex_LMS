 @extends('layouts.admin')

 @section('title', 'Dashboard')

 @section('content')

     {{-- Start Content --}}

     <div x-data="{ open: false }" x-init="$watch('open', value => { document.body.classList.toggle('overflow-hidden', value) })">
         <p class="text-[20px] font-medium text-[#5D5D5D] mb-4"> Settings </p>



         <div class="w-auto bg-white rounded-[20px] md:rounded-[30px] px-6 md:px-8 py-6 md:py-8 shadow-sm overflow-hidden">
          
             <div class="grid grid-cols-1 md:grid-cols-2 gap-20">

                 <!-- Edit Profile Card -->
                 <div class="flex flex-col h-full">
                     <div class="flex items-center space-x-3 mb-12">
                         <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                             <i class="uil uil-user"></i>
                         </div>
                         <h2 class="font-medium text-[18px] leading-[100%] tracking-[-0.02em] text-[#1B1B1B]">
                             Edit profile
                         </h2>
                     </div>

                     <!-- Profile Image Upload -->
                     <form class="flex flex-col flex-1">
                         <div class="flex items-center space-x-4 mb-6" x-data="{
                             defaultAvatar: '{{ asset('dashboard_assets/images/client/user-03.png') }}',
                             preview: '{{ asset('dashboard_assets/images/client/user-03.png') }}'
                         }">


                             <div
                                 class="w-20 h-20 rounded-full bg-[#F5CE9F] flex items-center justify-center overflow-hidden">
                                 <img :src="preview" alt="User Icon"
                                     :class="preview === defaultAvatar ? 'w-12 h-12 object-contain' :
                                         'w-full h-full object-cover'">
                             </div>

                             <!-- Upload + Remove Options -->
                             <div class="flex flex-col space-y-2">
                                 <!-- Upload Button -->
                                 <label for="profileImage"
                                     class="cursor-pointer px-4 py-3 font-medium text-[14px] leading-[100%] tracking-[-0.02em] font-sans bg-gray-100 text-[#1B1B1B] rounded-full shadow-sm hover:bg-gray-200 transition inline-block">
                                     Upload new image
                                 </label>
                                 <input type="file" id="profileImage" class="hidden" accept="image/*"
                                     @change="preview = URL.createObjectURL($event.target.files[0])">

                                 <!-- Remove Button -->
                                 <button type="button"
                                     class="px-4 py-3 font-medium text-[14px] leading-[100%] tracking-[-0.02em] font-sans bg-red-100 text-red-600 rounded-full shadow-sm hover:bg-red-200 transition"
                                     @click="preview = defaultAvatar">
                                     Remove Image
                                 </button>
                             </div>
                         </div>



                         <!-- Form Fields -->
                         <div class="mb-5">
                             <label class="block text-sm font-medium text-gray-600 mb-1">Admin name *</label>
                             <input type="text" placeholder="Name"
                                 class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0" />
                         </div>


                         <button type="submit"
                             class="mt-auto w-full bg-[#EB8C22] text-white font-medium py-3 rounded-full hover:bg-[#d1761a] transition">
                             Update
                         </button>
                     </form>
                 </div>

                 <!-- Change Password Card -->
                 <div class="flex flex-col h-full">
                     <div class="flex items-center space-x-3 mb-12">
                         <div class="w-12 h-12 rounded-full bg-[#E68815] flex items-center justify-center text-white">
                             <span class="mdi mdi-shield-key-outline"></span>
                         </div>
                         <h2 class="font-medium text-[18px] leading-[100%] tracking-[-0.02em] text-[#1B1B1B]">
                             Password
                         </h2>
                     </div>

                     <!-- Form Fields -->
                     <form class="flex flex-col flex-1 space-y-4">
                         <div>
                             <label class="block text-sm font-medium text-gray-600 mb-1">Old password *</label>
                             <input type="text" placeholder="Current Password"
                                 class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] text-[14px]" />
                         </div>

                         <div>
                             <label class="block text-sm font-medium text-gray-600 mb-1">New password *</label>
                             <input type="text" placeholder="New Password"
                                 class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] text-[14px]" />
                         </div>

                         <div>
                             <label class="block text-sm font-medium text-gray-600 mb-1">Confirm new password *</label>
                             <input type="text" placeholder="Confirm New Password"
                                 class="w-full px-4 py-3 border border-[#E1E1E1] rounded-lg focus:outline-none focus:ring-1 focus:ring-[#EB8C22] focus:border-0 text-[#1B1B1B] text-[14px]" />
                         </div>


                         <button type="submit"
                             class="mt-auto w-full bg-[#EB8C22] text-white font-medium py-3 rounded-full hover:bg-[#d1761a] transition">
                             Change Password
                         </button>
                     </form>
                 </div>

             </div>
         </div>


     </div>

     {{-- End Content --}}
 @endsection
