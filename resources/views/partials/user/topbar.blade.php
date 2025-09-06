<div class="top-header">
    <div class="header-bar flex justify-between">
        <div class="flex items-center space-x-1">
            <!-- Logo -->

            <!-- show or close sidebar -->
            <a id="close-sidebar"
                class="size-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-white rounded-full"
                href="javascript:void(0)">
                <i data-feather="menu" class="size-4"></i>
            </a>

            <a href="#" class="xl:hidden block ml-2 mt-2 md:mt-0">
                <img src="{{ asset('assets/auth/Kodex-logo.png') }}" class="md:hidden block" alt="">
                <span class="md:block hidden">
                    <img src="{{ asset('assets/auth/Kodex-logo.png') }}" class="inline-block dark:hidden" alt="">
                    <img src="{{ asset('assets/auth/Kodex-logo.png') }}" class="hidden dark:inline-block"
                        alt="">
                </span>
            </a>
            <!-- Logo -->

        </div>

        <ul class="list-none mb-0 space-x-1">
            <!-- Notification Dropdown -->
            <li class="dropdown inline-block relative">
                <button data-dropdown-toggle="dropdown"
                    class="dropdown-toggle size-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-white rounded-full"
                    type="button">
                    <i data-feather="bell" class="size-4"></i>
                    <span
                        class="absolute top-0 end-0 flex items-center justify-center bg-red-600 text-white text-[10px] font-bold rounded-full size-2 after:content-[''] after:absolute after:size-2 after:bg-red-600 after:top-0 after:end-0 after:rounded-full after:animate-ping"></span>
                </button>
                <!-- Dropdown menu -->
                <div class="dropdown-menu absolute end-0 m-0 mt-4 z-10 w-64 rounded-md overflow-hidden bg-white dark:bg-slate-900 shadow-sm dark:shadow-gray-700 hidden"
                    onclick="event.stopPropagation();">
                    <span class="px-4 py-4 flex justify-between">
                        <span class="font-semibold">Notifications</span>
                        <span
                            class="flex items-center justify-center bg-red-600/20 text-red-600 text-[10px] font-bold rounded-full w-5 max-h-5 ms-1">3</span>
                    </span>
                    <ul class="py-2 text-start h-64 border-t border-gray-100 dark:border-gray-800" data-simplebar>
                        <li>
                            <a href="#!" class="block font-medium py-1.5 px-4">
                                <div class="flex items-center">
                                    <div
                                        class="size-10 rounded-md shadow-sm shadow-primary/10 dark:shadow-gray-700 bg-primary/10 dark:bg-slate-800 text-primary dark:text-white flex items-center justify-center">
                                        <i data-feather="shopping-cart" class="size-4"></i>
                                    </div>
                                    <div class="ms-2">
                                        <span class="text-[15px] font-semibold block">Order Complete</span>
                                        <small class="text-slate-400">15 min ago</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="inline-block relative">
                <a href="{{ route('user.carts') }}"
                    class="dropdown-toggle size-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 hover:bg-gray-100 border border-gray-100 rounded-full shadow-md"
                    type="button">
                    <i data-feather="shopping-cart" class="size-4 text-[#1B1B1B] font-medium"></i>

                    <!-- Cart badge with ping animation -->
                    <span
                        class="absolute -top-1 -right-1 flex items-center justify-center w-5 h-5 bg-red-600 text-white text-[8px] font-medium rounded-full">
                        3
                        <!-- Ping effect -->
                        <span
                            class="absolute inline-flex h-full w-full rounded-full bg-red-600 opacity-50 animate-ping">
                        </span>
                    </span>
                </a>
            </li>



            <!-- User/Profile Dropdown -->
            <li class="dropdown inline-block relative">
                <button data-dropdown-toggle="dropdown" class="dropdown-toggle items-center" type="button">
                    <span
                        class="size-8 inline-flex items-center justify-center tracking-wide align-middle duration-500 text-[20px] text-center bg-gray-50 dark:bg-slate-800 hover:bg-gray-100 dark:hover:bg-slate-700 border border-gray-100 dark:border-gray-800 text-slate-900 dark:text-white rounded-full">
                        <img src="{{ asset('dashboard_assets/images/client/05.jpg') }}" class="rounded-full"
                            alt="">
                    </span>
                </button>
                <!-- Dropdown menu -->
                <div class="dropdown-menu absolute end-0 m-0 mt-4 z-10 w-64 rounded-md overflow-hidden bg-white shadow-sm dark:shadow-gray-700 hidden"
                    onclick="event.stopPropagation();">
                    <ul class="py-2 text-start">
                        <li>
                            <a href="{{ route('user.settings') }}"
                                class="block font-medium py-1 px-4 !text-gray-800 hover:text-primary dark:hover:text-white">
                                <i class="uil uil-user me-2"></i>Profile
                            </a>
                        </li>

                        {{-- <li class="border-t border-gray-100 dark:border-gray-800 my-2"></li> --}}

                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
