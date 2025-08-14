 @extends('layouts.admin')

 @section('title', 'Dashboard')

 @section('content')

 {{-- Start Content --}}
 <div>
     <div>
         <h1 class=" text-[#1B1B1B] text-xl font-semibold ">Welcome back, <span>Admin <span
                     class="text-2xl text-gray-300">&#x1F44B;</span> </span></h1>
         <p class="text-[#848484] font-[16px]">You're logged in to the Kodex Control Center.</p>
     </div>

     <div class="grid grid-cols-3 gap-4 mt-10">
         <div style="background-image: url('{{ asset('dashboard_assets/images/img/backg.png') }}')"
             class="bg-cover bg-center rounded-2xl col-span-2 flex items-center py-10 px-4 gap-[18px]">
             <div><img src="{{ asset('dashboard_assets/images/img/head.png') }}" alt="head"></div>

             <div>
                 <p class="text-[#1B1B1B] font-[16px]">Total Students</p>
                 <h1 class="text-[#1B1B1B] text-2xl font-[24px]">300</h1>
             </div>
         </div>

         <div class="relative flex items-center py-10 px-4 rounded-2xl bg-white shadow-md">
             <div class="flex items-center  gap-[18px] ">
                 <div>
                     <div><img src="{{ asset('dashboard_assets/images/img/two.png') }}" alt="two"></div>
                 </div>
                 <div>
                     <p class="text-[#1B1B1B] font-[16px]">Total Instructors</p>
                     <h1 class="text-[#1B1B1B] text-2xl font-[24px]">120</h1>
                 </div>
             </div>
             <div class="absolute bottom-0 right-0"><img src="{{ asset('dashboard_assets/images/img/mentoring.png') }}" alt="mentoring"></div>
         </div>


         <div class="relative flex items-center py-10 px-4 rounded-2xl bg-white shadow-md">
             <div class="flex items-center  gap-[18px] ">
                 <div>
                     <div><img src="{{ asset('dashboard_assets/images/img/book.png') }}" alt="book"></div>
                 </div>
                 <div>
                     <p class="text-[#1B1B1B] font-[16px]">Total courses</p>
                     <h1 class="text-[#1B1B1B] text-2xl font-[24px]">4</h1>
                 </div>
             </div>
             <div class="absolute bottom-0 right-0"><img src="{{ asset('dashboard_assets/images/img/book2.png') }}" alt="book2"></div>
         </div>


         <div class="relative flex items-center py-10 px-4 rounded-2xl bg-white shadow-md">
             <div class="flex items-center  gap-[18px] ">
                 <div>
                     <div><img src="{{ asset('dashboard_assets/images/img/file.png') }}" alt="file"></div>
                 </div>
                 <div>
                     <p class="text-[#1B1B1B] font-[16px]">Number of Modules</p>
                     <h1 class="text-[#1B1B1B] text-2xl font-[24px]">4</h1>
                 </div>
             </div>
             <div class="absolute bottom-0 right-0"><img src="{{ asset('dashboard_assets/images/img/file2.png') }}" alt="file2"></div>
         </div>

          <div class="relative flex items-center py-10 px-4 rounded-2xl bg-white shadow-md">
             <div class="flex items-center  gap-[18px] ">
                 <div>
                     <div><img src="{{ asset('dashboard_assets/images/img/login.png') }}" alt="login"></div>
                 </div>
                 <div>
                     <p class="text-[#1B1B1B] font-[16px]">Sign-ups This month</p>
                     <h1 class="text-[#1B1B1B] text-2xl font-[24px]">4</h1>
                 </div>
             </div>
             <div class="absolute bottom-0 right-0"><img src="{{ asset('dashboard_assets/images/img/login2.png') }}" alt="login2"></div>
         </div>
         
     </div>

 </div>
 {{-- End Content --}}
 @endsection