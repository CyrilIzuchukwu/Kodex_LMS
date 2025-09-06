@extends('layouts.user')
@section('content')
    <div>
        {{-- header title  --}}

        <div class="flex items-center justify-between bg-white p-3 rounded-lg shadow-sm w-full">
            <!-- Title -->
            <div>
                <h1 class="text-[#5D5D5D] font-medium text-sm">
                    Data Analysis Fundamentals: From Basics to Insight
                </h1>
            </div>

            <!-- Progress Circle -->
            <div class="flex items-center gap-2">
                <div class="relative w-8 h-8">
                    <svg class="w-8 h-8 transform -rotate-90">
                        <!-- Background Circle -->
                        <circle cx="16" cy="16" r="14" stroke="#e5e7eb" stroke-width="4" fill="transparent" />
                        <!-- Progress Circle -->
                        <circle cx="16" cy="16" r="14" stroke="#EA9C3D" stroke-width="4" fill="transparent"
                            stroke-dasharray="88" stroke-dashoffset="calc(88 - (88 * var(--progress)) / 100)"
                            style="--progress:65; transition: stroke-dashoffset 0.3s;" />
                    </svg>
                </div>
                <span class=" text-[#1B1B1B] text-sm font-medium">Completion <span id="progress-text">65%</span></span>
            </div>
        </div>

        <div class="mx-auto  mt-6 max-w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Left Column - Video and Overview -->
                <div class="space-y-6">
                    <!-- Video Player -->
                    <div class="bg-gray-800 relative overflow-hidden w-full h-[200px]  md:h-[300px] rounded-lg">
                        {{-- <iframe class="absolute top-0 left-0 w-full h-full" src="https://www.youtube.com/embed/9bZkp7q19f0"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                        </iframe> --}}
                    </div>



                    <div class="space-y-6">
                        <!-- Navigation tabs -->
                        <div class="flex flex-wrap gap-2 sm:space-x-1">
                            <button
                                class="bg-[#F5CE9F] text-[#8C530D] hover:bg-[#f3d7b4] rounded-[100px] px-6 sm:px-10 py-2 font-medium text-sm sm:text-base"
                                onclick="showTab('overview')" id="overview-btn">
                                Overview
                            </button>
                            <button
                                class="text-[#1B1B1B] font-normal bg-[#D9D9D9] hover:bg-[#f3f3f3] text-sm sm:text-base rounded-full px-4 sm:px-6 py-2"
                                onclick="showTab('qa')" id="qa-btn">
                                Q&A
                            </button>
                        </div>

                        {{-- Course Overview Section --}}
                        <div class="bg-white rounded-lg p-4 sm:p-4" id="overview-tab">
                            <!-- Course Description -->
                            <div>
                                <h2 class="text-lg sm:text-xl text-[#1B1B1B] font-medium mb-4">Course Description</h2>
                                <div class="space-y-4 text-[#1B1B1B] text-sm sm:text-sm font-normal leading-relaxed">
                                    <p>
                                        This course is your gateway into the world of cloud computing and DevOps. Using AWS,
                                        you'll learn how modern applications are built, deployed, and scaled in the cloud.

                                        Through guided projects, you'll set up virtual servers, manage storage, and create
                                        automated pipelines that streamline software delivery. By the end, you'll have
                                        practical
                                        experience with AWS services (EC2, S3, Lambda), Docker basics, and CI/CD workflows —
                                        making you ready for real-world DevOps and cloud engineering roles.
                                    </p>

                                </div>
                            </div>

                            <!-- Certificate Section -->
                            <div class="border-y border-course-border my-8 sm:my-10 py-4 sm:py-6">
                                <div
                                    class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3 sm:gap-0">
                                    <span class="font-medium text-[#696969] text-sm sm:text-base">Certificate</span>
                                    <button
                                        class="bg-[#E68815] text-white hover:bg-[#f6b76b] px-8 sm:px-14 py-2 rounded-[100px] text-sm sm:text-base">
                                        Download Certificate
                                    </button>
                                </div>
                            </div>

                            <!-- What you will learn -->
                            <div>
                                <h2 class="text-sm sm:text-base font-medium text-[#1B1B1B] mb-4">What you will learn</h2>
                                <ul class="space-y-3">
                                    <li class="flex items-start space-x-3">
                                        <div class="w-2 h-2 bg-[#1B1B1B] rounded-full mt-2 flex-shrink-0"></div>
                                        <span class="text-[#1B1B1B] font-normal text-sm sm:text-sm">Deploy Apps on
                                            AWS</span>
                                    </li>
                                    <li class="flex items-start space-x-3">
                                        <div class="w-2 h-2 bg-[#1B1B1B] rounded-full mt-2 flex-shrink-0"></div>
                                        <span class="text-[#1B1B1B] font-normal text-sm sm:text-sm">Build CI/CD
                                            Pipelines</span>
                                    </li>
                                    <li class="flex items-start space-x-3">
                                        <div class="w-2 h-2 bg-[#1B1B1B] rounded-full mt-2 flex-shrink-0"></div>
                                        <span class="text-[#1B1B1B] font-normal text-sm sm:text-sm">Manage Scalable
                                            Infrastructure</span>
                                    </li>
                                    <li class="flex items-start space-x-3">
                                        <div class="w-2 h-2 bg-[#1B1B1B] rounded-full mt-2 flex-shrink-0"></div>
                                        <span class="text-[#1B1B1B] font-normal text-sm sm:text-sm">Automate DevOps
                                            Tools</span>
                                    </li>
                                    <li class="flex items-start space-x-3">
                                        <div class="w-2 h-2 bg-[#1B1B1B] rounded-full mt-2 flex-shrink-0"></div>
                                        <span class="text-[#1B1B1B] font-normal text-sm sm:text-sm">Monitor and optimize
                                            system performance</span>
                                    </li>
                                    <li class="flex items-start space-x-3">
                                        <div class="w-2 h-2 bg-[#1B1B1B] rounded-full mt-2 flex-shrink-0"></div>
                                        <span class="text-[#1B1B1B] font-normal text-sm sm:text-sm">Secure applications
                                            and infrastructure with best practices</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="mt-6">
                                <h2 class="text-[#1B1B1B] font-medium text-lg sm:text-xl mb-4">Instructor</h2>
                                <div class="flex items-center space-x-2 sm:space-x-4 mb-3 flex-wrap">
                                    <div class="w-16 h-16 sm:w-24 sm:h-24 rounded-full object-cover overflow-hidden">
                                        <img class="w-full h-full"
                                            src="{{ asset('dashboard_assets/images/img/nuel2.png') }}"
                                            alt="Instructor's Profile">
                                    </div>
                                    <div>
                                        <h3 class="text-[#A15F0F] font-medium text-base sm:text-lg">Prince Nuel</h3>
                                        <p class="text-[#696969] font-normal text-xs sm:text-sm">UI/UX Designer</p>
                                    </div>
                                </div>
                                <p class="text-[#1B1B1B] font-normal text-sm sm:text-sm leading-relaxed">
                                    A results-driven UI/UX Designer specializing in creating seamless digital experiences
                                    for web and mobile. With expertise in design systems, usability testing, and
                                    prototyping, I translate complex ideas into engaging user interfaces. I’m passionate
                                    about designing products that are both visually appealing and effortless to use. My goal
                                    is to craft solutions that improve user satisfaction while driving business growth.
                                </p>
                            </div>
                        </div>




                        <!-- Q&A Parent -->
                        <div class="mt-6 bg-white rounded-lg p-4 sm:p-4 hidden" id="qa-tab">

                            <!-- Questions List -->
                            <div id="qa-questions">
                                <form action="" class="w-full flex items-center justify-between">
                                    <input type="search" name="search" id=""
                                        class="w-full border bg-[#F6F6F6] border-[#F6F6F6] rounded-full px-4 py-2 text-sm  text-[#1B1B1B] focus:outline-none focus:ring-2 focus:ring-[#E68815] focus:border-transparent"
                                        placeholder="Search course content">
                                </form>

                                <div class="mt-4 flex items-center max-width gap-4 sm:gap-6 flex-wrap">
                                    <form action=""
                                        class="flex sm:flex-col items-center sm:items-start w-full sm:w-auto">
                                        <label for="filters"
                                            class="my-2 text-[#1B1B1B] font-medium text-sm sm:text-lg">Filters:</label>
                                        <select name="filters" id="filters"
                                            class="border border-[#D9D9D9] rounded-full px-4 py-2 text-sm bg-[#F5CE9F] sm:text-sm text-[#1B1B1B] focus:outline-none focus:ring-2 focus:ring-[#F5CE9F] focus:border-transparent">
                                            <option value="all">All Modules</option>
                                            <option value="completed">Completed</option>
                                            <option value="incomplete">Incomplete</option>
                                        </select>
                                    </form>

                                    <form action=""
                                        class="flex sm:flex-col items-center sm:items-start w-full sm:w-auto">
                                        <label for="filters"
                                            class="my-2 text-[#1B1B1B] font-medium text-sm sm:text-lg">Sort
                                            by:</label>
                                        <select name="filters" id="filters"
                                            class="border border-[#D9D9D9] rounded-full px-4 py-2 text-sm bg-[#F5CE9F] sm:text-sm text-[#1B1B1B] focus:outline-none focus:ring-2 focus:ring-[#F5CE9F] focus:border-transparent">
                                            <option value="all">Sort by most recent</option>
                                            <option value="completed">Completed</option>
                                            <option value="incomplete">Incomplete</option>
                                        </select>
                                    </form>
                                </div>

                                <h2 class="text-[#1B1B1B] font-medium text-base my-6 space-x-4">All questions in this
                                    course
                                    <span class="text-[#E68815] ml-1">470</span>
                                </h2>


                                <div class="space-y-6">
                                    {{-- single question  --}}
                                    <div class="flex justify-between items-center gap-2">
                                        <div class="flex w-full items-start gap-3">
                                            <div class="w-[31px] h-[31px] rounded-full overflow-hidden">
                                                <img class="w-full h-full rounded-full"
                                                    src="{{ asset('dashboard_assets/images/img/nuel2.png') }}"
                                                    alt="Profile image">
                                            </div>
                                            <div class="space-y-2 w-full">
                                                <h1 class="font-medium text-[#1B1B1B] text-sm sm:text-base">Padding</h1>
                                                <p class="font-medium text-[#444444] text-xs sm:text-sm flex-wrap">In UI
                                                    design, what is
                                                    the purpose of padding inside a container or button?</p>
                                                <p
                                                    class="font-medium text-[#E68815] text-xs sm:text-sm flex gap-3 items-center">
                                                    Chibuike <span class="w-1 h-1 rounded-[100px] bg-black"> </span> <span
                                                        class="text-[#343434]">10 days ago</span></p>
                                            </div>
                                        </div>


                                        {{-- REPLY BTN  --}}
                                        <a href="javascript:void(0)" onclick="showReplies()"
                                            class="relative inline-block cursor-pointer">
                                            <!-- Main Icon -->
                                            <span class="mdi mdi-reply-circle text-[#E68815] text-3xl"></span>

                                            <!-- Badge -->
                                            <span
                                                class="flex items-center justify-center h-5 w-5 bg-[#E30800] rounded-full absolute -top-1 -right-1 text-[10px] text-white font-bold">
                                                1
                                            </span>
                                        </a>

                                    </div>


                                </div>


                                <a class="block w-full" href="">
                                    <button
                                        class="bg-[#E68815]
                                    text-white w-full hover:bg-[#f6b76b] px-8 sm:px-14 py-2 rounded-[100px] text-sm
                                    sm:text-base my-8">
                                        Show more
                                    </button>
                                </a>


                                <div>
                                    <h1 class="font-medium text-lg text-[#1B1B1B]">Ask a question</h1>

                                    <form action="" class="mt-4 flex flex-col gap-y-4">
                                        <div class="space-y-2">
                                            <label for=""
                                                class="text-[#1B1B1B] font-medium text-sm">Title</label><br>
                                            <input type="text"
                                                class="w-full h-12 border bg-white border-[#E1E1E1] rounded-[8px] px-4 py-2 text-sm sm:text-base text-black focus:outline-none focus:ring-2 focus:ring-[#E68815] focus:border-transparent "><br>
                                        </div>

                                        <div class="space-y-2">
                                            <label for=""
                                                class="text-[#1B1B1B] font-medium text-sm">Details</label><br>
                                            <textarea name="" id=""
                                                class="w-full h-40 border bg-white border-[#E1E1E1] rounded-[8px] px-4 py-2 text-sm sm:text-base text-black focus:outline-none focus:ring-2 focus:ring-[#E68815] focus:border-transparent"
                                                id=""></textarea><br>
                                            <div class="flex items-center justify-end">
                                                <!-- Hidden file input -->
                                                <input type="file" id="attachment" class="hidden">

                                                <!-- Styled label as button -->
                                                <label for="attachment"
                                                    class="cursor-pointer bg-[#F5CE9F] text-[#8C530D] hover:bg-[#f3d7b4] rounded-full px-6 py-2 text-sm sm:text-base font-medium">
                                                    Add Attachment
                                                </label>
                                            </div>
                                        </div>
                                        <button
                                            class="bg-[#E68815] text-white w-full hover:bg-[#f6b76b] px-8 sm:px-14 py-2 rounded-[100px] text-sm sm:text-base my-6">
                                            <a href="">Publish</a>
                                        </button>
                                    </form>
                                </div>
                            </div>



                            <!-- Reply Section -->
                            <div id="qa-replies" class="hidden">

                                {{-- Back to questions  --}}

                                <button onclick="backToQuestions()"
                                    class="flex items-center justify-center w-auto px-4 py-3 text-white font-medium text-sm bg-[#E68815] text-center rounded-full ">
                                    <i class="uil uil-arrow-left"></i>
                                    <span>Back to questions</span>
                                </button>

                                {{-- question  --}}
                                <div class="mt-6">
                                    <div class="flex justify-between items-center w-full">
                                        <div class="flex w-full justify-start items-start gap-3">
                                            <div class="w-[40px] h-[40px] rounded-full !overflow-hidden">
                                                <img class="w-full h-full rounded-full"
                                                    src="{{ asset('dashboard_assets/images/img/nuel2.png') }}"
                                                    alt="Profile image">
                                            </div>
                                            <div class="space-y-2 w-full">
                                                <h1 class="font-medium text-[#1B1B1B] text-sm sm:text-base">Padding</h1>
                                                <p class="font-medium text-[#444444] text-xs sm:text-sm flex-wrap">In UI
                                                    design, what is
                                                    the purpose of padding inside a container or button?</p>
                                                <p
                                                    class="font-medium text-[#E68815] text-xs sm:text-sm flex gap-3 items-center">
                                                    Chibuike <span class="w-1 h-1 rounded-[100px] bg-black"> </span> <span
                                                        class="text-[#343434]">10 days ago</span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Replies --}}
                                <div class="mt-6 space-y-6">
                                    <h2 class="font-semibold text-[#1B1B1B] text-base"><span
                                            class="mr-2 text-[#E68815] ">2</span>Replies</h2>

                                    {{-- Single Reply --}}
                                    <div class="flex w-full items-start gap-3">
                                        <div class="w-[36px] h-[36px] rounded-full overflow-hidden">
                                            <img class="w-full h-full rounded-full"
                                                src="{{ asset('dashboard_assets/images/img/nuel2.png') }}"
                                                alt="Profile image">
                                        </div>
                                        <div class="space-y-1 w-full">
                                            <p class="text-[#E68815] font-medium text-xs sm:text-sm">
                                                Arlene <span class="text-[#1B1B1B] font-medium"> - Instructor</span>
                                            </p>
                                            <p class="text-[#696969] text-xs sm:text-sm">11 days ago</p>
                                            <p class="text-[#1B1B1B] font-normal text-sm leading-relaxed">
                                                In UI design, padding creates breathing space inside a container or button,
                                                improving readability and touch comfort.
                                            </p>
                                        </div>
                                    </div>

                                    {{-- Another Reply --}}
                                    <div class="flex w-full items-start gap-3">
                                        <div class="w-[36px] h-[36px] rounded-full overflow-hidden">
                                            <img class="w-full h-full rounded-full"
                                                src="{{ asset('dashboard_assets/images/img/nuel2.png') }}"
                                                alt="Profile image">
                                        </div>
                                        <div class="space-y-1 w-full">
                                            <p class="text-[#E68815] font-medium text-xs sm:text-sm">
                                                John Doe
                                            </p>
                                            <p class="text-[#696969] text-xs sm:text-sm">7 days ago</p>
                                            <p class="text-[#1B1B1B] font-normal text-sm leading-relaxed">
                                                Padding also ensures consistent spacing in UI components, making layouts
                                                more
                                                balanced.
                                            </p>
                                        </div>
                                    </div>


                                    {{-- add reply  --}}
                                    <div>
                                        <form action="" method="">
                                            @csrf
                                            <div>
                                                <input type="text"
                                                    class="w-full border border-[#E1E1E1] rounded-lg px-3 py-4 focus:outline-none focus:shadow-none focus:border-none focus:ring-1 focus:ring-[#E68815] text-[#1B1B1B] text-sm">
                                            </div>


                                            <div class="mt-3">
                                                <button type="submit"
                                                    class="flex items-center justify-center w-full px-4 py-3 text-white font-medium text-sm bg-[#E68815] text-center rounded-full">Reply</button>
                                            </div>

                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- Right Column - Course Content -->
                <div>
                    <div>
                        <div class="mb-4">
                            <h2 class="text-[#1B1B1B] font-medium text-base sm:text-lg">Course Content</h2>
                        </div>
                        <div>
                            <!-- Single module 1 -->
                            <div
                                class="bg-white rounded-[20px] p-3 sm:p-4 border-2 border-[#D9D9D9] hover:border-[#E68815] transition mb-4 duration-200 cursor-pointer shadow-sm hover:shadow-md">
                                <div class="flex flex-col sm:flex-row items-start sm:items-start justify-between gap-4 ">
                                    <div class="block space-y-3 w-full sm:w-auto">
                                        <div class="flex items-center space-x-2">
                                            <div
                                                class="flex items-center justify-center w-8 h-8 bg-[#E68815] rounded-full">
                                                <span
                                                    class="mdi mdi-book-open-page-variant-outline font-medium text-white text-base"></span>
                                            </div>
                                            <h3 class="text-[#1B1B1B] font-medium text-sm">Module 1</h3>
                                        </div>
                                        <p class="text-xs text-[#1B1B1B] font-normal mt-1">
                                            Deploying and Scaling a Cloud Application Deploying and Scaling a Cloud
                                            Application Deploying
                                        </p>
                                    </div>
                                    <div class="flex flex-col sm:flex-col items-start sm:items-end gap-3 w-full sm:w-auto">
                                        <form>
                                            <input type="checkbox"
                                                class="rounded-[100px] w-5 h-5 checked:ring-2 checked:ring-[#E68815] checked:bg-[#E68815] checked:border-[#E68815] appearance-none cursor-pointer">
                                        </form>
                                    </div>
                                </div>

                                <div class="flex items-end justify-end ">
                                    <div
                                        class="flex items-center space-x-2 bg-[#FDF3E8] border border-[#8C530D] rounded-[20px] px-3 py-1 cursor-pointer justify-between sm:justify-start">

                                        {{-- data-dropdown-toggle is going be dynamic  --}}
                                        <button id="dropdownButton1" data-dropdown-toggle="dropdown1"
                                            class="text-[#8C530D] bg-[#FDF3E8] hover:bg-[#faf3ed] focus:ring-4 focus:outline-none focus:ring-[#FDF3E8] font-medium rounded text-xs px-3 py-1 w-full sm:w-auto inline-flex items-center"
                                            type="button">
                                            <div><span class="mdi mdi-folder-open-outline w-6 h-6"></span>
                                                <span class="text-xs font-medium">Resources</span>
                                            </div>
                                            <div><span class="mdi mdi-chevron-down w-6 h-6"></span></div>
                                        </button>

                                        <!-- Dropdown menu 1 -->
                                        {{-- dropdown id matches the data-dropdown-toggle  --}}
                                        <div id="dropdown1"
                                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-auto">
                                            <ul class="py-2 text-sm text-[#8C530D]" aria-labelledby="dropdownButton1">
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center space-x-1 px-4 py-2 text-[#1B1B1B] hover:bg-gray-100">
                                                        <i class="hgi hgi-stroke hgi-file-download text-base"></i>
                                                        <span>Introduction_to_UI_Design.pdf</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center space-x-1 px-4 py-2 text-[#1B1B1B] hover:bg-gray-100">
                                                        <i class="hgi hgi-stroke hgi-file-download text-base"></i>
                                                        <span>Building_Scalable_Backends.pptx</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center space-x-1 px-4 py-2 text-[#1B1B1B] hover:bg-gray-100">
                                                        <i class="hgi hgi-stroke hgi-file-download text-base"></i>
                                                        <span>Frontend_Development_Guide.pdf</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center space-x-1 px-4 py-2 text-[#1B1B1B] hover:bg-gray-100">
                                                        <i class="hgi hgi-stroke hgi-file-download text-base"></i>
                                                        <span>Cybersecurity_Basics_Handbook.pdf</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Single module 2 -->
                            <div
                                class="bg-white rounded-[20px] p-3 sm:p-4 border-2 border-[#D9D9D9] hover:border-[#E68815] transition mb-4 duration-200 cursor-pointer shadow-sm hover:shadow-md">
                                <div class="flex flex-col sm:flex-row items-start sm:items-start justify-between gap-4 ">
                                    <div class="block space-y-3 w-full sm:w-auto">
                                        <div class="flex items-center space-x-2">
                                            <div
                                                class="flex items-center justify-center w-8 h-8 bg-[#E68815] rounded-full">
                                                <span
                                                    class="mdi mdi-book-open-page-variant-outline font-medium text-white text-base"></span>
                                            </div>
                                            <h3 class="text-[#1B1B1B] font-medium text-sm">Module 2</h3>
                                        </div>
                                        <p class="text-xs text-[#1B1B1B] font-normal mt-1">
                                            Deploying and Scaling a Cloud Application Deploying and Scaling a Cloud
                                            Application Deploying
                                        </p>
                                    </div>
                                    <div class="flex flex-col sm:flex-col items-start sm:items-end gap-3 w-full sm:w-auto">
                                        <form>
                                            <input type="checkbox"
                                                class="rounded-[100px] w-5 h-5 checked:ring-2 checked:ring-[#E68815] checked:bg-[#E68815] checked:border-[#E68815] appearance-none cursor-pointer">
                                        </form>
                                    </div>
                                </div>

                                <div class="flex items-end justify-end ">
                                    <div
                                        class="flex items-center space-x-2 bg-[#FDF3E8] border border-[#8C530D] rounded-[20px] px-3 py-1 cursor-pointer justify-between sm:justify-start">
                                        <button id="dropdownButton2" data-dropdown-toggle="dropdown2"
                                            class="text-[#8C530D] bg-[#FDF3E8] hover:bg-[#faf3ed] focus:ring-4 focus:outline-none focus:ring-[#FDF3E8] font-medium rounded text-xs px-3 py-1 w-full sm:w-auto inline-flex items-center"
                                            type="button">
                                            <div><span class="mdi mdi-folder-open-outline w-6 h-6"></span>
                                                <span class="text-xs font-medium">Resources</span>
                                            </div>
                                            <div><span class="mdi mdi-chevron-down w-6 h-6"></span></div>
                                        </button>

                                        <!-- Dropdown menu 2 -->
                                        <div id="dropdown2"
                                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-auto">
                                            <ul class="py-2 text-sm text-[#8C530D]" aria-labelledby="dropdownButton2">
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center space-x-1 px-4 py-2 text-[#1B1B1B] hover:bg-gray-100">
                                                        <i class="hgi hgi-stroke hgi-file-download text-base"></i>
                                                        <span>Introduction_to_UI_Design.pdf</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center space-x-1 px-4 py-2 text-[#1B1B1B] hover:bg-gray-100">
                                                        <i class="hgi hgi-stroke hgi-file-download text-base"></i>
                                                        <span>Building_Scalable_Backends.pptx</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center space-x-1 px-4 py-2 text-[#1B1B1B] hover:bg-gray-100">
                                                        <i class="hgi hgi-stroke hgi-file-download text-base"></i>
                                                        <span>Frontend_Development_Guide.pdf</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center space-x-1 px-4 py-2 text-[#1B1B1B] hover:bg-gray-100">
                                                        <i class="hgi hgi-stroke hgi-file-download text-base"></i>
                                                        <span>Cybersecurity_Basics_Handbook.pdf</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Single module 3 -->
                            <div
                                class="bg-white rounded-[20px] p-3 sm:p-4 border-2 border-[#D9D9D9] hover:border-[#E68815] transition mb-4 duration-200 cursor-pointer shadow-sm hover:shadow-md">
                                <div class="flex flex-col sm:flex-row items-start sm:items-start justify-between gap-4 ">
                                    <div class="block space-y-3 w-full sm:w-auto">
                                        <div class="flex items-center space-x-2">
                                            <div
                                                class="flex items-center justify-center w-8 h-8 bg-[#E68815] rounded-full">
                                                <span
                                                    class="mdi mdi-book-open-page-variant-outline font-medium text-white text-base"></span>
                                            </div>
                                            <h3 class="text-[#1B1B1B] font-medium text-sm">Module 3</h3>
                                        </div>
                                        <p class="text-xs text-[#1B1B1B] font-normal mt-1">
                                            Deploying and Scaling a Cloud Application Deploying and Scaling a Cloud
                                            Application Deploying
                                        </p>
                                    </div>
                                    <div class="flex flex-col sm:flex-col items-start sm:items-end gap-3 w-full sm:w-auto">
                                        <form>
                                            <input type="checkbox"
                                                class="rounded-[100px] w-5 h-5 checked:ring-2 checked:ring-[#E68815] checked:bg-[#E68815] checked:border-[#E68815] appearance-none cursor-pointer">
                                        </form>
                                    </div>
                                </div>

                                <div class="flex items-end justify-end ">
                                    <div
                                        class="flex items-center space-x-2 bg-[#FDF3E8] border border-[#8C530D] rounded-[20px] px-3 py-1 cursor-pointer justify-between sm:justify-start">
                                        <button id="dropdownButton3" data-dropdown-toggle="dropdown3"
                                            class="text-[#8C530D] bg-[#FDF3E8] hover:bg-[#faf3ed] focus:ring-4 focus:outline-none focus:ring-[#FDF3E8] font-medium rounded text-xs px-3 py-1 w-full sm:w-auto inline-flex items-center"
                                            type="button">
                                            <div><span class="mdi mdi-folder-open-outline w-6 h-6"></span>
                                                <span class="text-xs font-medium">Resources</span>
                                            </div>
                                            <div><span class="mdi mdi-chevron-down w-6 h-6"></span></div>
                                        </button>

                                        <!-- Dropdown menu 3 -->
                                        <div id="dropdown3"
                                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-auto">
                                            <ul class="py-2 text-sm text-[#8C530D]" aria-labelledby="dropdownButton3">
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center space-x-1 px-4 py-2 text-[#1B1B1B] hover:bg-gray-100">
                                                        <i class="hgi hgi-stroke hgi-file-download text-base"></i>
                                                        <span>Introduction_to_UI_Design.pdf</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center space-x-1 px-4 py-2 text-[#1B1B1B] hover:bg-gray-100">
                                                        <i class="hgi hgi-stroke hgi-file-download text-base"></i>
                                                        <span>Building_Scalable_Backends.pptx</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center space-x-1 px-4 py-2 text-[#1B1B1B] hover:bg-gray-100">
                                                        <i class="hgi hgi-stroke hgi-file-download text-base"></i>
                                                        <span>Frontend_Development_Guide.pdf</span>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#"
                                                        class="flex items-center space-x-1 px-4 py-2 text-[#1B1B1B] hover:bg-gray-100">
                                                        <i class="hgi hgi-stroke hgi-file-download text-base"></i>
                                                        <span>Cybersecurity_Basics_Handbook.pdf</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function showTab(tabName) {
            // Hide all tabs
            document.getElementById("overview-tab").classList.add("hidden");
            document.getElementById("qa-tab").classList.add("hidden");

            // Reset button styles
            document.getElementById("overview-btn").classList.remove("bg-[#F5CE9F]", "text-[#8C530D]");
            document.getElementById("overview-btn").classList.add("bg-[#D9D9D9]", "text-[#1B1B1B]");

            document.getElementById("qa-btn").classList.remove("bg-[#F5CE9F]", "text-[#8C530D]");
            document.getElementById("qa-btn").classList.add("bg-[#D9D9D9]", "text-[#1B1B1B]");

            // Show active tab
            if (tabName === "overview") {
                document.getElementById("overview-tab").classList.remove("hidden");
                document.getElementById("overview-btn").classList.add("bg-[#F5CE9F]", "text-[#8C530D]");
            } else if (tabName === "qa") {
                document.getElementById("qa-tab").classList.remove("hidden");
                document.getElementById("qa-btn").classList.add("bg-[#F5CE9F]", "text-[#8C530D]");

                // Default to showing questions, not replies
                document.getElementById("qa-questions").classList.remove("hidden");
                document.getElementById("qa-replies").classList.add("hidden");
            }
        }

        function showReplies() {
            // Switch inside Q&A only
            document.getElementById("qa-questions").classList.add("hidden");
            document.getElementById("qa-replies").classList.remove("hidden");

            // Make sure Q&A tab stays active
            document.getElementById("qa-btn").classList.add("bg-[#F5CE9F]", "text-[#8C530D]");
            document.getElementById("qa-btn").classList.remove("bg-[#D9D9D9]", "text-[#1B1B1B]");
        }

        function backToQuestions() {
            document.getElementById("qa-questions").classList.remove("hidden");
            document.getElementById("qa-replies").classList.add("hidden");
        }
    </script>
@endpush
