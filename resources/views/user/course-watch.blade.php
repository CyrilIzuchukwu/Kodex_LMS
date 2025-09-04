@extends('layouts.user')
@section('content')
<div>
    {{-- header title  --}}

    <div class="w-full bg-white rounded-[20px] p-4 ">

        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-[#5D5D5D] font-medium text-sm">Data Analysis Fundamentals: From Basics to insight
                </h1>
            </div>

            <div class="flex items-center gap-2">
                <div class="border-[8px] border-[#ce6b28]  w-10 h-10 rounded-full"></div>
                <div><span class="text-sm text-black font-medium">Completion 100%</span></div>
            </div>
        </div>

    </div>

    <div class="mx-auto p-4 sm:p-6 mt-6 max-w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column - Video and Overview -->
            <div class="space-y-6">
                <!-- Video Player -->
                <div
                    class="bg-gray-800 relative overflow-hidden w-full h-[200px] sm:h-[300px] md:h-[400px] lg:h-[350px] rounded-lg">
                </div>

                <!-- Course Overview -->
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

                    <div class="bg-white rounded-lg p-4 sm:p-6" id="overview-tab">
                        <!-- Course Description -->
                        <div>
                            <h2 class="text-lg sm:text-xl text-[#1B1B1B] font-medium mb-4">Course Description</h2>
                            <div class="space-y-4 text-[#1B1B1B] text-sm sm:text-base font-normal leading-relaxed">
                                <p>
                                    This course is your gateway into the world of cloud computing and DevOps. Using AWS,
                                    you'll learn how modern applications are built, deployed, and scaled in the cloud.
                                </p>
                                <p>
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
                            <h2 class="text-lg sm:text-xl font-medium text-[#1B1B1B] mb-4">What you will learn</h2>
                            <ul class="space-y-3">
                                <li class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-[#1B1B1B] rounded-full mt-2 flex-shrink-0"></div>
                                    <span class="text-[#1B1B1B] font-normal text-sm sm:text-base">Deploy Apps on
                                        AWS</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-[#1B1B1B] rounded-full mt-2 flex-shrink-0"></div>
                                    <span class="text-[#1B1B1B] font-normal text-sm sm:text-base">Build CI/CD
                                        Pipelines</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-[#1B1B1B] rounded-full mt-2 flex-shrink-0"></div>
                                    <span class="text-[#1B1B1B] font-normal text-sm sm:text-base">Manage Scalable
                                        Infrastructure</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-[#1B1B1B] rounded-full mt-2 flex-shrink-0"></div>
                                    <span class="text-[#1B1B1B] font-normal text-sm sm:text-base">Automate DevOps
                                        Tools</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-[#1B1B1B] rounded-full mt-2 flex-shrink-0"></div>
                                    <span class="text-[#1B1B1B] font-normal text-sm sm:text-base">Monitor and optimize
                                        system performance</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-[#1B1B1B] rounded-full mt-2 flex-shrink-0"></div>
                                    <span class="text-[#1B1B1B] font-normal text-sm sm:text-base">Secure applications
                                        and infrastructure with best practices</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-[#1B1B1B] rounded-full mt-2 flex-shrink-0"></div>
                                    <span class="text-[#1B1B1B] font-normal text-sm sm:text-base">Containerize
                                        applications with Docker and Kubernetes</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <div class="w-2 h-2 bg-[#1B1B1B] rounded-full mt-2 flex-shrink-0"></div>
                                    <span class="text-[#1B1B1B] font-normal text-sm sm:text-base">Integrate version
                                        control with Git and GitHub</span>
                                </li>
                            </ul>
                        </div>

                        <div class="mt-6">
                            <h2 class="text-[#1B1B1B] font-medium text-lg sm:text-xl mb-4">Instructor</h2>
                            <div class="flex items-center space-x-3 sm:space-x-4 mb-3 flex-wrap">
                                <div class="w-16 h-16 sm:w-24 sm:h-24 rounded-full object-cover overflow-hidden">
                                    <img class="w-[100%] h-[100%]"
                                        src="{{ asset('dashboard_assets/images/img/nuel2.png') }}" alt="image1">
                                </div>
                                <div>
                                    <h3 class="text-[#A15F0F] font-medium text-base sm:text-lg">Prince Nuel</h3>
                                    <p class="text-[#696969] font-normal text-xs sm:text-sm">UI/UX Designer</p>
                                </div>
                            </div>
                            <p class="text-[#1B1B1B] font-normal text-sm sm:text-base leading-relaxed">
                                A results-driven UI/UX Designer specializing in creating seamless digital experiences
                                for web and mobile. With expertise in design systems, usability testing, and
                                prototyping, I translate complex ideas into engaging user interfaces. I’m passionate
                                about designing products that are both visually appealing and effortless to use. My goal
                                is to craft solutions that improve user satisfaction while driving business growth.
                            </p>
                        </div>
                    </div>

                    <!-- Q/A Section -->
                    <div class="mt-6 bg-white rounded-lg p-4 sm:p-6 hidden" id="qa-tab">
                        <form action="" class="w-full flex items-center justify-between">
                            <input type="search" name="search" id=""
                                class="w-full sm:w-[90%] border bg-[#F6F6F6] border-[#F6F6F6] rounded-full px-4 py-2 text-sm sm:text-base text-black focus:outline-none focus:ring-2 focus:ring-[#E68815] focus:border-transparent"
                                placeholder="Search course content">
                            <span class="mdi mdi-magnify text-white bg-[#E68815] py-2 px-3 text-xl rounded-full"></span>
                        </form>

                        <div class="mt-4 flex items-center max-width gap-4 sm:gap-6 flex-wrap">
                            <form action="" class="flex sm:flex-col items-center sm:items-start w-full sm:w-auto">
                                <label for="filters"
                                    class="my-2 text-[#1B1B1B] font-medium text-sm sm:text-lg">Filters:</label>
                                <select name="filters" id="filters"
                                    class="border border-[#D9D9D9] rounded-full px-4 py-2 text-sm bg-[#F5CE9F] sm:text-base text-[#1B1B1B] focus:outline-none focus:ring-2 focus:ring-[#F5CE9F] focus:border-transparent">
                                    <option value="all">All Modules</option>
                                    <option value="completed">Completed</option>
                                    <option value="incomplete">Incomplete</option>
                                </select>
                            </form>

                            <form action="" class="flex sm:flex-col items-center sm:items-start w-full sm:w-auto">
                                <label for="filters" class="my-2 text-[#1B1B1B] font-medium text-sm sm:text-lg">Sort
                                    by:</label>
                                <select name="filters" id="filters"
                                    class="border border-[#D9D9D9] rounded-full px-4 py-2 text-sm bg-[#F5CE9F] sm:text-base text-[#1B1B1B] focus:outline-none focus:ring-2 focus:ring-[#F5CE9F] focus:border-transparent">
                                    <option value="all">Sort by most recent</option>
                                    <option value="completed">Completed</option>
                                    <option value="incomplete">Incomplete</option>
                                </select>
                            </form>
                        </div>

                        <h2 class="text-[#1B1B1B] font-medium text-lg my-6 space-x-4">All questions in this course
                            <span class="text-[#E68815]">470</span>
                        </h2>


                        <div class="space-y-6">
                            <div class="flex justify-between items-center gap-2">
                                <div class="flex item start gap-3">
                                    <div
                                        class="flex items-center space-x-3 sm:space-x-4 mb-3 flex-wrap w-[31px] h-[31px] rounded-full overflow-hidden">
                                        <img class="w-[100%] h-[100%] rounded-full"
                                            src="{{ asset('dashboard_assets/images/img/nuel2.png') }}" alt="image">
                                    </div>
                                    <div class="space-y-3">
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


                                <div class="relative inline-block">
                                    <!-- Main Icon -->
                                    <span class="mdi mdi-reply-circle text-[#E68815] text-3xl"></span>

                                    <!-- Badge -->
                                    <span
                                        class="flex items-center justify-center h-5 w-5 bg-[#E30800] rounded-full absolute -top-1 -right-1 text-[10px] text-white font-bold">
                                        1
                                    </span>
                                </div>

                            </div>

                            <div class="flex justify-between items-center gap-2">
                                <div class="flex item start gap-3">
                                    <div
                                        class="flex items-center space-x-3 sm:space-x-4 mb-3 flex-wrap w-[31px] h-[31px] rounded-full overflow-hidden">
                                        <img class="w-[100%] h-[100%] rounded-full"
                                            src="{{ asset('dashboard_assets/images/img/nuel2.png') }}" alt="image">
                                    </div>
                                    <div class="space-y-3">
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


                                <div class="relative inline-block">
                                    <!-- Main Icon -->
                                    <span class="mdi mdi-reply-circle text-[#E68815] text-3xl"></span>

                                    <!-- Badge -->
                                    <span
                                        class="flex items-center justify-center h-5 w-5 bg-[#E30800] rounded-full absolute -top-1 -right-1 text-[10px] text-white font-bold">
                                        1
                                    </span>
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
                        <!-- Module Card Example -->
                        <div
                            class="bg-white rounded-[20px] p-4 sm:p-5 border-2 border-[#D9D9D9] hover:border-[#E68815] transition mb-4 duration-200 cursor-pointer shadow-sm hover:shadow-md">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 ">
                                <div class="block space-y-3 w-full sm:w-auto">
                                    <div class="flex items-center space-x-2">
                                        <div class="flex items-center justify-center w-8 h-8 bg-[#E68815] rounded-full">
                                            <span
                                                class="mdi mdi-book-open-page-variant-outline font-medium text-white text-base"></span>
                                        </div>
                                        <h3 class="text-[#1B1B1B] font-medium text-sm">Module 1</h3>
                                    </div>
                                    <p class="text-xs text-[#1B1B1B] font-normal mt-1">
                                        Deploying and Scaling a Cloud Application
                                    </p>
                                </div>
                                <div class="flex flex-col sm:flex-col items-start sm:items-end gap-3 w-full sm:w-auto">
                                    <form>
                                        <input type="checkbox"
                                            class="rounded-[100px] w-5 h-5 checked:ring-2 checked:ring-[#E68815] checked:bg-[#E68815] checked:border-[#E68815] appearance-none cursor-pointer">
                                    </form>
                                    <div
                                        class="flex items-center space-x-2 bg-[#FDF3E8] border border-[#8C530D] rounded-[20px] px-3 py-1 cursor-pointer w-full sm:w-auto justify-between sm:justify-start">
                                        <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                                        class="text-[#8C530D] bg-[#FDF3E8] hover:bg-[#faf3ed] focus:ring-4 focus:outline-none focus:ring-[#FDF3E8] font-medium rounded text-xs px-3 py-1 w-full sm:w-auto justify-between sm:justify-start inline-flex items-center dark:bg-[#FDF3E8] dark:hover:bg-[#faf3ed] dark:focus:ring-[#faf3ed] "
                                        type="button"><div> <span class="mdi mdi-folder-open-outline w-6 h-6"></span>
                                                <span class="text-xs font-medium">Resources</span>
                                            </div>
                                            <div> <span class="mdi mdi-chevron-down w-6 h-6"></span></div>
                                    </button>

                                    <!-- Dropdown menu -->
                                    <div id="dropdown"
                                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-white">
                                        <ul class="py-2 text-sm text-[#8C530D] dark:text-[#8C530D]"
                                            aria-labelledby="dropdownDefaultButton">
                                            <li>
                                                <a href="#"
                                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Dashboard</a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Settings</a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a>
                                            </li>
                                            <li>
                                                <a href="#"
                                                    class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign
                                                    out</a>
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
</div>




</div>
</div>
@endsection

<script>
function showTab(tab) {
    const overview = document.getElementById('overview-tab');
    const qa = document.getElementById('qa-tab');
    const overviewBtn = document.getElementById('overview-btn');
    const qaBtn = document.getElementById('qa-btn');

    if (tab === 'overview') {
        overview.classList.remove('hidden');
        qa.classList.add('hidden');

        // Active styling
        overviewBtn.classList.add("bg-[#F5CE9F]", "text-[#8C530D]");
        overviewBtn.classList.remove("bg-[#D9D9D9]", "text-[#1B1B1B]");

        qaBtn.classList.add("bg-[#D9D9D9]", "text-[#1B1B1B]");
        qaBtn.classList.remove("bg-[#F5CE9F]", "text-[#8C530D]");
    } else if (tab === 'qa') {
        qa.classList.remove('hidden');
        overview.classList.add('hidden');

        // Active styling
        qaBtn.classList.add("bg-[#F5CE9F]", "text-[#8C530D]");
        qaBtn.classList.remove("bg-[#D9D9D9]", "text-[#1B1B1B]");

        overviewBtn.classList.add("bg-[#D9D9D9]", "text-[#1B1B1B]");
        overviewBtn.classList.remove("bg-[#F5CE9F]", "text-[#8C530D]");
    }
}

// Default state
document.addEventListener("DOMContentLoaded", () => {
    showTab('overview');
});
</script>