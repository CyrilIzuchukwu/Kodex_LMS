 @extends('layouts.admin')

 @section('title', 'Dashboard')

 @section('content')

 {{-- Start Content --}}

 <div x-data="{ open: false }"
     x-init="$watch('open', value => { document.body.classList.toggle('overflow-hidden', value) })">
     <p class="text-[20px] font-medium text-[#5D5D5D] mb-16">Course Oversight > <span class="text-[#848484]">Manage
             Courses</span></p>
     <div class="flex justify-between items-center mb-6">
         <!-- Search Bar -->
         <div>
             <span class="flex items-center bg-[#EDEDED] rounded-full px-4 w-[30vw]">
                 <i class="uil uil-search text-[#141B34] text-lg mr-2"></i>
                 <input type="search" placeholder="Search" aria-label="Search"
                     class="bg-transparent outline-none border-0 focus:ring-0 w-full py-3 text-[#141B34] font-medium">
             </span>
         </div>


         <!-- Add Student Button + Modal -->
         <div>
             <!-- Trigger -->
             <button
                 class="bg-[#E68815] px-5 py-3 rounded-full text-sm font-medium text-white hover:bg-[#cc6f0f] focus:outline-none focus:ring-2 focus:ring-[#E68815]">
                 + Add Course
             </button>
         </div>
     </div>


     <div class="w-auto bg-white rounded-[30px] p-5 shadow-sm overflow-hidden">
         <!-- Table -->
         <div class="overflow-x-auto border-collapse border border-gray-50 rounded-[30px]">
             <table class="min-w-full divide-y divide-gray-200 text-center">
                 <thead class="bg-[#E1E1E1]">
                     <tr>
                         <th scope="col"
                             class="px-5 py-2 text-[15px] font-medium text-[#767676] border-r-2 tracking-wider">#</th>
                         <th scope="col"
                             class="px-5 py-2 text-[15px] font-medium text-[#767676] border-r-2 tracking-wider">Course
                             Title</th>
                         <th scope="col"
                             class="px-5 py-2 text-[15px] font-medium text-[#767676] border-r-2 tracking-wider">Student
                         </th>
                         <th scope="col"
                             class="px-5 py-2 text-[15px] font-medium text-[#767676] border-r-2 tracking-wider">Category
                         </th>
                         <th scope="col"
                             class="px-5 py-2text-[15px] font-medium text-[#767676] border-r-2 tracking-wider">Modules
                         </th>
                         <th scope="col"
                             class="px-5 py-2px-6 py-3 text-[15px] font-medium text-[#767676] border-r-2 tracking-wider">
                             Price</th>
                         <th scope="col" class="px-5 py-2 text-[15px] font-medium text-[#767676] tracking-wider">Action
                         </th>
                     </tr>
                 </thead>
                 <tbody class="bg-white divide-y divide-gray-200 ">
                     <tr>
                         <td class="px-5 py-2 whitespace-nowrap">
                             <div class="flex items-center justify-center">
                                 <div class="text-sm font-medium text-[#1B1B1B]">1</div>
                             </div>
                         </td>
                         <td class="px-5 py-2 whitespace-nowrap">
                             <div class="flex items-center justify-center">
                                 <div class="text-sm font-medium text-[#1B1B1B]">Data analysis</div>
                             </div>
                         </td>
                         <td class="px-5 py-2 whitespace-nowrap">
                             <div class="text-sm text-[#1B1B1B]">30</div>
                         </td>
                         <td class="px-5 py-2 whitespace-nowrap">
                             <span
                                 class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Development</span>
                         </td>
                         <td class="px-5 py-2 whitespace-nowrap text-sm text-[#1B1B1B]">5</td>
                         <td class="px-5 py-2 whitespace-nowrap text-sm text-[#1B1B1B]">
                             &#8358; 20,000
                         </td>
                         <td class="px-5 py-2 whitespace-nowrap text-sm font-medium">
                             <!-- Dropdown container -->
                             <div class="dropdown-container inline-block">
                                 <!-- Three-dot button -->
                                 <button id="actionButton"
                                     class="action-button text-gray-500 hover:text-gray-700 transition-colors duration-200 p-2 rounded-full hover:bg-gray-100"
                                     aria-label="Course actions">
                                     <i class="mdi mdi-dots-vertical text-xl"></i>
                                 </button>
                             </div>

                             <!-- Dropdown menu (fixed, outside parent) -->
                             <div id="dropdownMenu"
                                 class="dropdown-menu fixed z-50 w-40 origin-top-left rounded-[10px] bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden text-left">

                                 <a href="#"
                                     class="dropdown-item flex items-center gap-2 px-2 py-3 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-100">
                                     <i class="mdi mdi-account-edit-outline text-blue-500"></i>
                                     <span>Edit Course</span>
                                 </a>

                                 <a href="#"
                                     class="dropdown-item flex items-center gap-2 px-2 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                     <i class="mdi mdi-delete text-red-500"></i>
                                     <span>Delete Course</span>
                                 </a>
                             </div>

                         </td>
                     </tr>

                     <tr>
                         <td class="px-5 py-2 whitespace-nowrap">
                             <div class="flex items-center justify-center">
                                 <div class="text-sm font-medium text-[#1B1B1B]">2</div>
                             </div>
                         </td>
                         <td class="px-5 py-2 whitespace-nowrap ">
                             <div class="flex items-center justify-center">
                                 <div class="text-sm font-medium text-[#1B1B1B]">Product Design</div>
                             </div>
                         </td>
                         <td class="px-5 py-2 whitespace-nowrap">
                             <div class="text-sm text-[#1B1B1B]">100</div>
                         </td>
                         <td class="px-5 py-2 whitespace-nowrap">
                             <span
                                 class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Design</span>
                         </td>
                         <td class="px-5 py-2 whitespace-nowrap text-sm text-[#1B1B1B]">8</td>
                         <td class="px-5 py-2 whitespace-nowrap text-sm text-[#1B1B1B]">
                             &#8358; 200,000
                         </td>
                         <td class="px-5 py-2 whitespace-nowrap text-sm font-medium">
                             <!-- Dropdown container -->
                             <div class="dropdown-container1 inline-block">
                                 <!-- Three-dot button -->
                                 <button id="actionButton1"
                                     class="action-button1 text-gray-500 hover:text-gray-700 transition-colors duration-200 p-2 rounded-full hover:bg-gray-100"
                                     aria-label="Course actions">
                                     <i class="mdi mdi-dots-vertical text-xl"></i>
                                 </button>
                             </div>

                             <!-- Dropdown menu (fixed, outside parent) -->
                             <div id="dropdownMenu1"
                                 class="dropdown-menu1 fixed z-50 w-40 origin-top-left rounded-[10px] bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none hidden text-left">

                                 <a href="#"
                                     class="dropdown-item1 flex items-center gap-2 px-2 py-3 text-sm text-gray-700 hover:bg-gray-50 border-b border-gray-100">
                                     <i class="mdi mdi-account-edit-outline text-blue-500"></i>
                                     <span>Edit Course</span>
                                 </a>

                                 <a href="#"
                                     class="dropdown-item1 flex items-center gap-2 px-2 py-3 text-sm text-gray-700 hover:bg-gray-50">
                                     <i class="mdi mdi-delete text-red-500"></i>
                                     <span>Delete Course</span>
                                 </a>
                             </div>

                         </td>
                     </tr>


                     </tr>
                 </tbody>
             </table>
         </div>


         <div class="flex justify-between text-black font-medium items-center mt-10">
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

 @push('scripts')

 <script>
document.addEventListener("DOMContentLoaded", function() {

    function setupDropdown(buttonId, menuId) {
        const actionButton = document.getElementById(buttonId);
        const dropdownMenu = document.getElementById(menuId);

        actionButton.addEventListener("click", function(e) {
            e.stopPropagation();


            document.querySelectorAll(".dropdown-menu, .dropdown-menu1").forEach(menu => {
                if (menu !== dropdownMenu) menu.classList.add("hidden");
            });

            dropdownMenu.classList.toggle("hidden");

            if (!dropdownMenu.classList.contains("hidden")) {

                const rect = actionButton.getBoundingClientRect();
                const menuWidth = dropdownMenu.offsetWidth;
                const screenWidth = window.innerWidth;

                let left = rect.left + window.scrollX;
                let top = rect.bottom + window.scrollY;


                if (left + menuWidth > screenWidth - 8) {
                    left = rect.right - menuWidth + window.scrollX;
                }


                dropdownMenu.style.position = "fixed";
                dropdownMenu.style.top = `${top}px`;
                dropdownMenu.style.left = `${left}px`;
            }
        });


        document.addEventListener("click", function(e) {
            if (!actionButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add("hidden");
            }
        });


        document.addEventListener("keydown", function(e) {
            if (e.key === "Escape") {
                dropdownMenu.classList.add("hidden");
            }
        });
    }


    setupDropdown("actionButton", "dropdownMenu");
    setupDropdown("actionButton1", "dropdownMenu1");
});
 </script>



 @endpush
 @endsection