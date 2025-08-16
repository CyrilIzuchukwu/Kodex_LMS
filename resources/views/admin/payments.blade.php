 @extends('layouts.admin')

 @section('title', 'Dashboard')

 @section('content')

 {{-- Start Content --}}

 <div x-data="{ open: false }"
     x-init="$watch('open', value => { document.body.classList.toggle('overflow-hidden', value) })">

     <div class="p-6">
         <p class="text-[20px] font-medium text-[#5D5D5D] mb-10">Payment History</p>
         <div class="max-w-7xl mx-auto">
             <!-- Search and Filters -->
             <div class="flex items-center justify-between mb-6">
                 <div class="relative flex-1 max-w-md">
                     <span
                         class="mdi mdi-magnify absolute left-3 top-9 transform -translate-y-1/2 text-[#141B34] text-[30px] leading-none">
                     </span>
                     <input type="text" placeholder="Search Name or Transaction ID" class="w-full pl-10 pr-4 py-2 bg-[#EDEDED] border border-border rounded-[30px] 
                            focus:outline-none focus:ring-2 focus:ring-ring text-foreground 
                            placeholder:text-muted-foreground text-sm" />
                 </div>


                 <div class="flex items-center gap-3 ml-6 text-sm">
                     <button
                         class="bg-[#F5CE9F] text-[#8C530D] px-8 py-2 rounded-[100px] font-medium hover:bg-opacity-90 transition-colors">
                         All
                     </button>

                     <div class="relative">
                         <button
                             class="flex items-center gap-2 bg-[#EDEDED] border border-border px-4 py-2 rounded-[100px] text-[#1B1B1B] hover:bg-accent transition-colors">
                             Course
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="m19 9-7 7-7-7"></path>
                             </svg>
                         </button>
                     </div>

                     <div x-data="{ open: false }" class="relative">
                         <!-- Trigger Button -->
                         <button @click="open = !open"
                             class="flex items-center gap-2 bg-[#EDEDED] border border-border px-4 py-2 rounded-[100px] text-[#1B1B1B] hover:bg-accent transition-colors">
                             Date
                             <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                     d="m19 9-7 7-7-7"></path>
                             </svg>
                         </button>

                         <!-- Dropdown Modal -->
                         <div x-show="open" @click.outside="open = false" x-transition
                             class="absolute top-full right-0 mt-2 w-80 bg-white rounded-lg border border-border shadow-lg p-6 z-50">
                             <!-- Header -->
                             <div class="flex items-center justify-between mb-6">
                                 <h3 class="text-lg font-semibold text-[#1B1B1B]">Filter by Date Range</h3>
                                 <button @click="open = false"
                                     class="w-6 h-6 rounded-full bg-muted hover:bg-accent transition-colors flex items-center justify-center">
                                     <svg class="w-4 h-4 text-muted-foreground" fill="none" stroke="currentColor"
                                         viewBox="0 0 24 24">
                                         <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                             d="M6 18L18 6M6 6l12 12"></path>
                                     </svg>
                                 </button>
                             </div>

                             <!-- Date Range Buttons -->
                             <div class="flex gap-3 mb-8">
                                 <button
                                     class="px-4 py-2 bg-[#EDEDED] text-[#1B1B1B] rounded-full text-sm font-medium hover:bg-accent transition-colors">
                                     Last 30 Days
                                 </button>
                                 <button
                                     class="px-4 py-2 bg-[#F5CE9F] text-[#8C530D] rounded-full border-[#8C530D] border-2 text-sm font-medium hover:bg-opacity-90 transition-colors">
                                     Last 6 Months
                                 </button>
                             </div>

                             <!-- Custom Date Range -->
                             <div class="mb-8">
                                 <h4 class="text-[#1B1B1B] font-medium mb-4">Custom Date Range</h4>
                                 <div class="flex  gap-3">
                                     <div class="flex-1 relative flex items-center">
                                         <input type="text" value="Last 30 Days"
                                             class="w-full px-2 py-2 pr-7 bg-[#EDEDED] border border-border rounded-full text-sm text-[#1B1B1B] focus:outline-none focus:ring-2 focus:ring-ring"
                                             readonly />
                                         <span
                                             class="mdi mdi-calendar-month-outline absolute right-3 text-[#1B1B1B] text-lg"></span>
                                     </div>
                                     <div class="flex-1 relative flex items-center">
                                         <input type="text" value="Last 6 Months"
                                             class="w-full px-2 py-2 pr-7 bg-[#EDEDED] border border-border rounded-full text-sm text-[#1B1B1B] focus:outline-none focus:ring-2 focus:ring-ring"
                                             readonly />
                                         <span
                                             class="mdi mdi-calendar-month-outline absolute right-3 text-[#1B1B1B] text-lg"></span>
                                     </div>

                                 </div>
                             </div>

                             <!-- Filter by Status -->
                             <div>
                                 <h4 class="text-[#1B1B1B] font-medium mb-4">Filter by Status</h4>
                                 <div class="flex  gap-3">
                                     <button
                                         class="bg-[#EEF4EA] text-success px-4 py-2 rounded-[100px] text-sm text-[#365718] font-medium">
                                         Success
                                     </button>
                                     <button
                                         class="bg-[#FCE6E6] text-destructive px-4 py-2 rounded-[100px] text-[14px] text-[#8A0500] font-medium">
                                         Failed
                                     </button>
                                     <button
                                         class="bg-[#FDF3E8] text-pending px-4 py-2 rounded-[100px] text-sm text-[#8C530D] font-medium">
                                         Pending
                                     </button>
                                 </div>
                             </div>
                         </div>
                     </div>

                 </div>
             </div>

             <!-- Table -->
             <div class="w-auto bg-white rounded-[30px] px-5 py-5 shadow-sm overflow-hidden">
                 <div class="bg-card rounded-[30px] border border-border overflow-hidden">
                     <table class="w-full">
                         <thead class="bg-[#E1E1E1]">
                             <tr class="bg-muted/50 border-b border-border text-[#767676] text-center">
                                 <th class=" px-2 py-3 text-sm font-medium text-gray-500 border-r  border-gray-300">
                                     Transaction ID</th>
                                 <th class=" px-2 py-3 text-sm font-medium text-gray-500 border-r  border-gray-300">
                                     Email</th>
                                 <th class=" px-2 py-3 text-sm font-medium text-gray-500 border-r  border-gray-300">
                                     Assigned Course</th>
                                 <th class=" px-2 py-3 text-sm font-medium text-gray-500 border-r  border-gray-300">Date
                                 </th>
                                 <th class=" px-2 py-3 text-sm font-medium text-gray-500 border-r  border-gray-300">
                                     Amount</th>
                                 <th class=" px-2 py-3 text-sm font-medium text-gray-500 border-r  border-gray-300">
                                     Status</th>
                             </tr>
                         </thead>
                         <tbody class="text-center">
                             <div x-data="{ open: false }">
                                 <!-- Table Row acting as trigger -->
                                 <table class="w-full border-collapse">
                                     <tbody class="text-center">
                                         <tr @click="open = true"
                                             class="border-b border-border hover:bg-muted/20 transition-colors cursor-pointer">
                                             <td class="py-4 px-6 text-[14px]">
                                                 <span class="px-6 py-4 text-[16px] font-medium text-gray-700">1</span>
                                                 <span class="px-6 py-4 text-sm text-gray-700">IT59598</span>
                                             </td>
                                             <td class="px-6 py-4 text-sm text-gray-700">tim@gmail.com</td>
                                             <td class="px-6 py-4 text-sm text-gray-700">Web Development</td>
                                             <td class="px-6 py-4 text-sm text-gray-700">24 May, 2020</td>
                                             <td class="px-6 py-4 text-sm text-gray-700">$210.00</td>
                                             <td class="px-6 py-4 text-sm text-gray-700">
                                                 <span
                                                     class="bg-[#EEF4EA] text-success px-3 py-1 rounded-[100px] text-sm text-[#365718] font-medium">
                                                     Success
                                                 </span>
                                             </td>
                                         </tr>


                                         <tr @click="open = true"
                                             class="border-b border-border hover:bg-muted/20 transition-colors cursor-pointer">
                                             <td class="py-4 px-6 hover:bg-gray-50 transition-colors text-[14px]">
                                                 <span class="px-6 py-4 text-[16px] font-medium text-gray-700">2</span>
                                                 <span class="px-6 py-4 text-sm text-gray-700">IT59598</span>
                                             </td>
                                             <td class="px-6 py-4 text-sm text-gray-700">tim@gmail.com</td>
                                             <td class="px-6 py-4 text-sm text-gray-700">Product Design</td>
                                             <td class="px-6 py-4 text-sm text-gray-700">24 May, 2020</td>
                                             <td class="px-6 py-4 text-sm text-gray-700">$210.00</td>
                                             <td class="px-6 py-4 text-sm text-gray-700">
                                                 <span
                                                     class="bg-[#FCE6E6] text-destructive px-3 py-1 rounded-[100px] text-[14px] text-[#8A0500] font-medium">
                                                     Failed
                                                 </span>
                                             </td>
                                         </tr>

                                         <tr @click="open = true"
                                                class="border-b border-border hover:bg-muted/20 transition-colors cursor-pointer">
                                             <td class="py-4 px-6 hover:bg-gray-50 transition-colors text-[14px]">
                                                 <span class="px-6 py-4 text-[16px] font-medium text-gray-700">3</span>
                                                 <span class="px-6 py-4 text-sm text-gray-700">IT59598</span>
                                             </td>
                                             <td class="px-6 py-4 text-sm text-gray-700">tim@gmail.com</td>
                                             <td class="px-6 py-4 text-sm text-gray-700">Data Analysis</td>
                                             <td class="px-6 py-4 text-sm text-gray-700">24 May, 2020</td>
                                             <td class="px-6 py-4 text-sm text-gray-700">$210.00</td>
                                             <td class="px-6 py-4 text-sm text-gray-700">
                                                 <span
                                                     class="bg-[#FDF3E8] text-pending px-3 py-1 rounded-[100px] text-sm text-[#8C530D] font-medium">
                                                     Pending
                                                 </span>
                                             </td>
                                         </tr>
                                     </tbody>
                                 </table>

                                 <!-- Modal -->
                                 <div x-show="open" x-transition x-cloak x-trap="open" @keydown.escape="open = false"
                                     class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex z-[9999] items-center max-h-[1099px] justify-center overflow-y-auto">
                                     <!-- Backdrop -->
                                     <div x-cloak x-trap="open" @keydown.escape="open = false"
                                         class="absolute inset-0 overflow-y-auto pt-8 pb-8" @click="open = false"></div>

                                     <!-- Modal Content -->
                                     <div
                                         class="relative w-full max-w-[900px] mx-4 bg-white rounded-lg shadow-2xl max-h-[1099px] overflow-auto self-start mt-8 mb-8">
                                         <!-- Close button -->
                                         <button @click="open = false"
                                             class="absolute top-4 right-4 z-10 p-2 rounded-[100px] bg-gray-100 hover:bg-gray-200 transition">
                                             ✕
                                         </button>

                                         <!-- Receipt content -->
                                         <!-- Receipt content -->
                                         <div class="p-8">
                                             <!-- Header with logo -->
                                             <div class="flex items-center mb-8">
                                                 <div class="flex items-center space-x-2">
                                                     <img class="w-[120px]"
                                                         src="{{ asset('dashboard_assets/images/img/Kodex.png') }}"
                                                         alt="logo">
                                                 </div>
                                             </div>

                                             <!-- Title -->
                                             <h1 class="text-[20px] font-[500] text-[#444444] mb-8">Payment Receipt</h1>

                                             <!-- Receipt details grid -->
                                             <div class="space-y-6">
                                                 <!-- Receipt number and date -->
                                                 <div class="grid grid-cols-2 gap-4">
                                                     <div>
                                                         <span class="text-[#1B1B1B] text-[16px] font-medium">Receipt
                                                             #:</span>
                                                         <span
                                                             class="ml-2 text-[#1B1B1B] font-[400] text-[16px]">000123</span>
                                                     </div>
                                                     <div>
                                                         <span
                                                             class="text-[#1B1B1B] text-[16px] font-medium">Date:</span>
                                                         <span class="ml-2 text-[#1B1B1B] font-[400] text-[16px]">11 Aug
                                                             2025</span>
                                                     </div>
                                                 </div>

                                                 <!-- Payment reference -->
                                                 <div>
                                                     <span class="text-[#1B1B1B] text-[16px] font-medium">Payment
                                                         Ref:</span>
                                                     <span
                                                         class="ml-2 text-[#1B1B1B] font-[400] text-[16px]">LMS-2025-0811-7890</span>
                                                 </div>

                                                 <hr class="border-gray-200" />

                                                 <!-- Student information -->
                                                 <div class="space-y-4">
                                                     <div>
                                                         <span class="text-[#1B1B1B] text-[16px] font-medium">Student
                                                             Name:</span>
                                                         <span class="ml-8 text-[#1B1B1B] font-[400] text-[16px]">John
                                                             Doe</span>
                                                     </div>
                                                     <div>
                                                         <span class="text-[#1B1B1B] text-[16px] font-mediumm">Student
                                                             ID:</span>
                                                         <span
                                                             class="ml-12 text-[#1B1B1B] font-[400] text-[16px]">STU-0045</span>
                                                     </div>
                                                     <div>
                                                         <span class="text-[#1B1B1B] text-[16px] font-medium">Course
                                                             purchased:</span>
                                                         <span class="ml-4 text-[#1B1B1B] font-[400] text-[16px]">Web
                                                             Development Masterclass</span>
                                                     </div>
                                                 </div>

                                                 <hr class="border-gray-200" />

                                                 <!-- Table header -->
                                                 <div
                                                     class="grid grid-cols-4 gap-4 py-2 text-[#1B1B1B] text-[16px] font-medium">
                                                     <div>Description</div>
                                                     <div class="text-center">Qty</div>
                                                     <div class="text-center">Unit Price</div>
                                                     <div class="text-right">Total</div>
                                                 </div>

                                                 <!-- Table content -->
                                                 <div class="grid grid-cols-4 gap-4 py-2">
                                                     <div class="text-[#1B1B1B] font-[400] text-[16px]">Web Development
                                                         Masterclass</div>
                                                     <div class="text-[#1B1B1B] font-[400] text-[16px] text-center">1
                                                     </div>
                                                     <div class="text-[#1B1B1B] font-[400] text-[16px] text-center">
                                                         ₦50,000</div>
                                                     <div class="text-[#1B1B1B] font-[400] text-[16px] text-right">
                                                         ₦50,000</div>
                                                 </div>

                                                 <!-- Discount row -->
                                                 <div class="grid grid-cols-4 gap-4 py-2">
                                                     <div class="text-[#1B1B1B] font-[400] text-[16px]">Discount (0%)
                                                     </div>
                                                     <div class="text-[#1B1B1B] font-[400] text-[16px] text-center">-
                                                     </div>
                                                     <div class="text-[#1B1B1B] font-[400] text-[16px] text-center">-
                                                     </div>
                                                     <div class="text-[#1B1B1B] font-[400] text-[16px] text-right">₦0.00
                                                     </div>
                                                 </div>

                                                 <hr class="border-gray-200" />

                                                 <!-- Total -->
                                                 <div class="flex justify-between items-center py-2">
                                                     <span class="text-[#1B1B1B] text-[20px] font-medium">Total
                                                         Paid</span>
                                                     <span class="text-[#1B1B1B] text-[20px] font-medium">₦50,000</span>
                                                 </div>

                                                 <hr class="border-gray-200" />

                                                 <!-- Payment details -->
                                                 <div class="space-y-4">
                                                     <div>
                                                         <span class="text-[#1B1B1B] text-[20px] font-medium">Payment
                                                             Method:</span>
                                                         <span class="ml-4 text-[#1B1B1B] font-[400] text-[16px]">Card
                                                             Payment (Mastercard **** 3421)</span>
                                                     </div>
                                                     <div>
                                                         <span
                                                             class="text-[#1B1B1B] text-[20px] font-medium">Transaction
                                                             ID:</span>
                                                         <span
                                                             class="ml-8 text-[#1B1B1B] font-[400] text-[16px]">TXN-88899-KOD</span>
                                                     </div>
                                                     <div class="flex items-center">
                                                         <span
                                                             class="text-[#1B1B1B] text-[20px] font-medium">Status:</span>
                                                         <div class="ml-12 flex items-center">
                                                             <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                                             <span
                                                                 class="text-green-600 font-[400] text-[16px]">Successful</span>
                                                         </div>
                                                     </div>
                                                 </div>

                                                 <!-- Print button -->
                                                 <div class="flex justify-center pt-6">
                                                     <button @click="window.print()"
                                                         class="flex items-center space-x-4 bg-orange-500 text-white px-6 py-2 rounded-[30px]  hover:bg-orange-600 transition">
                                                         🖨️ <span class="text-[14px]">Print</span>
                                                     </button>
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                 </div>
 
                 </tbody>
                 </table>
             </div>


             <!-- Pagination -->
             <div class="flex items-center justify-between mt-6">
                 <p class="text-[16px] font-medium text-[#1B1B1B]">
                     Showing 1 to 5 of 5 entries
                 </p>

                 <div class="flex items-center gap-2">
                     <button
                         class="px-4 py-2 bg-[#EDEDED] border border-border text-[#1B1B1B] rounded-[100px] text-sm hover:bg-accent transition-colors">
                         Prev
                     </button>
                     <button
                         class="w-10 h-10 bg-white border border-border text-sm rounded-[100px] text-[#1B1B1B] hover:bg-accent transition-colors flex items-center justify-center">
                         1
                     </button>
                     <button
                         class="px-4 py-2 bg-[#E68815] text-white text-sm rounded-[100px] font-medium hover:bg-opacity-90 transition-colors">
                         Next
                     </button>
                 </div>
             </div>
         </div>



     </div>
 </div>





 </div>



 {{-- End Content --}}
 @endsection