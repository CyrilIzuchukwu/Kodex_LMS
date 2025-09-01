@extends('layouts.user')
@section('content')
<div class="space-y-10">
    <!-- Hero Section -->
    <div class="custom-bg2 p-6 sm:p-10 rounded-[20px] sm:rounded-[30px]">
        <h1 class="text-white text-2xl sm:text-3xl lg:text-4xl font-medium max-w-2xl leading-snug sm:leading-normal">
            Cloud Computing with AWS and DevOps Basics
        </h1>
        <p class="text-white text-base sm:text-lg font-normal max-w-2xl mt-3 sm:mt-4 mb-6 sm:mb-10">
            Master the foundations of cloud computing and DevOps with hands-on AWS projects. Build scalable apps, 
            automate deployments, and get career-ready skills.
        </p>

        <div class="space-y-4">
            <h2 class="text-base sm:text-lg font-medium text-white">
                Skills You'll gain
            </h2>

            <div class="flex flex-wrap gap-2 sm:gap-4">
                <div class="px-3 sm:px-4 py-2 sm:py-3 bg-white text-slate-900 rounded-full font-medium text-xs sm:text-sm hover:scale-105 transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-200">
                    Deploy Apps on AWS
                </div>
                <div class="px-3 sm:px-4 py-2 sm:py-3 bg-white text-slate-900 rounded-full font-medium text-xs sm:text-sm hover:scale-105 transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-200">
                    Build CI/CD Pipelines
                </div>
                <div class="px-3 sm:px-4 py-2 sm:py-3 bg-white text-slate-900 rounded-full font-medium text-xs sm:text-sm hover:scale-105 transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-200">
                    Manage Scalable Infrastructure
                </div>
                <div class="px-3 sm:px-4 py-2 sm:py-3 bg-white text-slate-900 rounded-full font-medium text-xs sm:text-sm hover:scale-105 transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-200">
                    Automate with DevOps Tools
                </div>
                <div class="px-3 sm:px-4 py-2 sm:py-3 bg-white text-slate-900 rounded-full font-medium text-xs sm:text-sm hover:scale-105 transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-200">
                    12+ More skills
                </div>
            </div>

            <div class="pt-4">
                <button class="inline-flex items-center justify-center bg-[#E68815] text-white hover:bg-orange-600 text-sm sm:text-base font-medium px-6 sm:px-8 py-3 sm:py-4 rounded-full shadow-lg hover:shadow-xl transition-all duration-300 hover:scale-95 w-full sm:max-w-4xl">
                    <span class="mdi mdi-cart-outline w-4 mr-2"></span>
                    Add to cart
                </button>
            </div>
        </div>
    </div>

    <!-- Course Includes -->
    <div>
        <p class="text-black text-lg sm:text-xl font-medium mb-4">This course includes:</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Card -->
            <div class="bg-white border border-[#D9D9D9] rounded-2xl p-4 flex items-start hover:scale-95 transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-200">
                <img src="{{ asset('dashboard_assets/images/img/pdf.png') }}" alt="pdf" class="w-8 h-8 sm:w-10 sm:h-10">
                <div class="ml-3 sm:ml-4">
                    <h1 class="text-sm sm:text-base font-medium text-[#1B1B1B] mb-2 sm:mb-3">Downloadable Resources</h1>
                    <p class="text-xs sm:text-sm text-[#767676]">Access templates, guides, and materials anytime.</p>
                </div>
            </div>

            <div class="bg-white border border-[#D9D9D9] rounded-2xl p-4 flex items-start hover:scale-95 transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-200">
                <img src="{{ asset('dashboard_assets/images/img/mod.png') }}" alt="mod" class="w-8 h-8 sm:w-10 sm:h-10">
                <div class="ml-3 sm:ml-4">
                    <h1 class="text-sm sm:text-base font-medium text-[#1B1B1B] mb-2 sm:mb-3">4 Modules </h1>
                    <p class="text-xs sm:text-sm text-[#767676]">Step-by-step modules for guided learning.</p>
                </div>
            </div>

            <div class="bg-white border border-[#D9D9D9] rounded-2xl p-4 flex items-start hover:scale-95 transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-200">
                <img src="{{ asset('dashboard_assets/images/img/cert.png') }}" alt="cert" class="w-8 h-8 sm:w-10 sm:h-10">
                <div class="ml-3 sm:ml-4">
                    <h1 class="text-sm sm:text-base font-medium text-[#1B1B1B] mb-2 sm:mb-3">Certificate </h1>
                    <p class="text-xs sm:text-sm text-[#767676]">Shareable certificate on completion.</p>
                </div>
            </div>
            <!-- Repeat for others -->
        </div>
    </div>

    <!-- Course Description -->
    <div>
        <p class="text-[#1B1B1B] text-lg sm:text-xl font-medium mb-4">Course Description</p>
        <p class="text-[#1B1B1B] text-sm sm:text-base max-w-4xl leading-relaxed mb-8">
            This course is your gateway into the world of cloud computing and DevOps. Using AWS, you’ll learn how modern applications are built, deployed, and scaled in the cloud. <br/>Through guided projects, you’ll set up virtual servers, manage storage, and create automated pipelines that streamline software delivery. By the end, you’ll have practical experience with AWS services (EC2, S3, Lambda), Docker basics, and CI/CD workflows — making you ready for real-world DevOps and cloud engineering roles. 
        </p>

        <p class="text-[#1B1B1B] text-lg sm:text-xl font-medium mb-4">What you will learn</p>
        <ul class="list-disc pl-5 space-y-2 text-sm sm:text-base text-[#1B1B1B]">
            <li>Deploy Apps on AWS</li>
            <li>Build CI/CD Pipelines</li>
            <li>Manage Scalable Infrastructure</li>
            <li>Automate DevOps Tools</li>
            <li>Monitor and optimize system performance</li>
            <li>Secure applications and infrastructure with best practices</li>
            <li>Containerize applications with Docker and Kubernetes</li>
            <li>Integrate version control with Git and GitHub</li>
            <!-- etc -->
        </ul>
    </div>

    <!-- Course Modules -->
    <div>
        <p class="text-[#1B1B1B] text-lg sm:text-xl font-medium mb-4">Course Modules</p>
        <div class="space-y-3 sm:space-y-4">
            <div class="bg-white border border-[#D9D9D9] rounded-2xl p-3 sm:p-4 flex items-start hover:scale-95 transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-200">
                <div class="bg-[#E68815] w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-white text-lg sm:text-2xl">
                    <span class="mdi mdi-book-open-blank-variant-outline"></span>
                </div>
                <div class="ml-2 sm:ml-3">
                    <h1 class="text-sm sm:text-base font-medium text-[#1B1B1B] mb-2">Module 1</h1>
                    <p class="text-xs sm:text-sm text-[#1B1B1B]">Deploying and Scaling a Cloud Application.</p>
                </div>
            </div>

            <div class="bg-white border border-[#D9D9D9] rounded-2xl p-3 sm:p-4 flex items-start hover:scale-95 transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-200">
                <div class="bg-[#E68815] w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-white text-lg sm:text-2xl">
                    <span class="mdi mdi-book-open-blank-variant-outline"></span>
                </div>
                <div class="ml-2 sm:ml-3">
                    <h1 class="text-sm sm:text-base font-medium text-[#1B1B1B] mb-2">Module 2</h1>
                    <p class="text-xs sm:text-sm text-[#1B1B1B]">Deploying and Scaling a Cloud Application.</p>
                </div>
            </div>

            <div class="bg-white border border-[#D9D9D9] rounded-2xl p-3 sm:p-4 flex items-start hover:scale-95 transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-200">
                <div class="bg-[#E68815] w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-white text-lg sm:text-2xl">
                    <span class="mdi mdi-book-open-blank-variant-outline"></span>
                </div>
                <div class="ml-2 sm:ml-3">
                    <h1 class="text-sm sm:text-base font-medium text-[#1B1B1B] mb-2">Module 3</h1>
                    <p class="text-xs sm:text-sm text-[#1B1B1B]">Deploying and Scaling a Cloud Application.</p>
                </div>
            </div>

            <div class="bg-white border border-[#D9D9D9] rounded-2xl p-3 sm:p-4 flex items-start hover:scale-95 transition-transform duration-200 cursor-pointer shadow-sm hover:bg-gray-200">
                <div class="bg-[#E68815] w-8 h-8 sm:w-10 sm:h-10 rounded-full flex items-center justify-center text-white text-lg sm:text-2xl">
                    <span class="mdi mdi-book-open-blank-variant-outline"></span>
                </div>
                <div class="ml-2 sm:ml-3">
                    <h1 class="text-sm sm:text-base font-medium text-[#1B1B1B] mb-2">Module 4</h1>
                    <p class="text-xs sm:text-sm text-[#1B1B1B]">Deploying and Scaling a Cloud Application.</p>
                </div>
            </div>
            <!-- Repeat for modules -->
        </div>
    </div>

    <!-- Instructor -->
    <div>
        <p class="text-[#1B1B1B] text-lg sm:text-xl font-medium mb-4">Instructor</p>
        <div class="flex items-center space-x-3">
            <img src="{{ asset('dashboard_assets/images/img/nuel.png') }}" alt="nuel" class="w-12 h-12 sm:w-16 sm:h-16 rounded-full">
            <div>
                <h1 class="text-base sm:text-lg font-medium text-[#A15F0F]">Prince Nuel</h1>
                <p class="text-xs sm:text-sm text-[#1B1B1B]">Software Engineer</p>
            </div>
        </div>
        <p class="text-sm sm:text-base text-[#1B1B1B] max-w-4xl mt-3 sm:mt-4">
            A results-driven UI/UX Designer specializing in creating seamless digital experiences for web and mobile. With expertise in design systems, usability testing, and prototyping, I translate complex ideas into engaging user interfaces. I’m passionate about designing products that are both visually appealing and effortless to use. My goal is to craft solutions that improve user satisfaction while driving business growth.
        </p>
    </div>

    <!-- Available Courses -->
    <div>
        <p class="text-black text-lg sm:text-xl font-medium mb-4">Available Courses</p>
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Course Card -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden w-full max-w-sm">
                <div class="bg-figma-purple p-4 relative">
                    <img class="rounded-xl" src="{{ asset('dashboard_assets/images/img/figma.png') }}" alt="figma">
                    <div class="absolute top-6 right-6 flex gap-2">
                        <span class="bg-gray-100 text-black px-2 py-1 rounded-full text-xs sm:text-sm font-medium">Design</span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-black font-medium text-sm sm:text-base mb-2 leading-tight">
                        Cloud Computing with AWS and DevOps Basics
                    </h3>
                    <p class="text-[#5D5D5D] text-xs sm:text-sm mb-3">by Prince Nuel</p>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-black font-medium text-sm sm:text-base">₦70,000</span>
                        <a href="{{route('user.course-details')}}" class="text-[#E68815] text-xs sm:text-sm hover:underline">View Details</a>
                    </div>
                    <button class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-2 sm:py-3 rounded-full font-medium transition-colors flex items-center justify-center gap-1 text-sm sm:text-base">
                        <span class="mdi mdi-cart-outline w-5"></span>
                        Add to cart
                    </button>
                </div>
            </div>

             <!-- Course Card -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden w-full max-w-sm">
                <div class="bg-figma-purple p-4 relative">
                    <img class="rounded-xl" src="{{ asset('dashboard_assets/images/img/figma.png') }}" alt="figma">
                    <div class="absolute top-6 right-6 flex gap-2">
                        <span class="bg-gray-100 text-black px-2 py-1 rounded-full text-xs sm:text-sm font-medium">Design</span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-black font-medium text-sm sm:text-base mb-2 leading-tight">
                        Cloud Computing with AWS and DevOps Basics
                    </h3>
                    <p class="text-[#5D5D5D] text-xs sm:text-sm mb-3">by Prince Nuel</p>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-black font-medium text-sm sm:text-base">₦70,000</span>
                        <a href="{{route('user.course-details')}}" class="text-[#E68815] text-xs sm:text-sm hover:underline">View Details</a>
                    </div>
                    <button class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-2 sm:py-3 rounded-full font-medium transition-colors flex items-center justify-center gap-1 text-sm sm:text-base">
                        <span class="mdi mdi-cart-outline w-5"></span>
                        Add to cart
                    </button>
                </div>
            </div>

             <!-- Course Card -->
            <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden w-full max-w-sm">
                <div class="bg-figma-purple p-4 relative">
                    <img class="rounded-xl" src="{{ asset('dashboard_assets/images/img/figma.png') }}" alt="figma">
                    <div class="absolute top-6 right-6 flex gap-2">
                        <span class="bg-gray-100 text-black px-2 py-1 rounded-full text-xs sm:text-sm font-medium">Design</span>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="text-black font-medium text-sm sm:text-base mb-2 leading-tight">
                        Cloud Computing with AWS and DevOps Basics
                    </h3>
                    <p class="text-[#5D5D5D] text-xs sm:text-sm mb-3">by Prince Nuel</p>
                    <div class="flex items-center justify-between mb-3">
                        <span class="text-black font-medium text-sm sm:text-base">₦70,000</span>
                        <a href="{{route('user.course-details')}}" class="text-[#E68815] text-xs sm:text-sm hover:underline">View Details</a>
                    </div>
                    <button class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-2 sm:py-3 rounded-full font-medium transition-colors flex items-center justify-center gap-1 text-sm sm:text-base">
                        <span class="mdi mdi-cart-outline w-5"></span>
                        Add to cart
                    </button>
                </div>
            </div>
            <!-- Repeat for other courses -->
        </section>
    </div>
</div>

@endsection

<style>
.custom-bg {
    background: linear-gradient(90deg, #804C0C 0%, #E68815 100%);

}

.custom-bg2 {
    background-image: url("{{asset('dashboard_assets/images/img/awss.jpg')}}");
    background-size: cover;
    background-position: center;
    height: auto;
    background-repeat: no-repeat;
    background-blend-mode: overlay;
    background-color: #00000099;
    
}

@media screen and (max-width: 768px) {
    .custom-bg2 {
        background-image: url("{{asset('dashboard_assets/images/img/backg1.png')}}");
        background-size: cover;
        background-position: center;
        height: auto;
        background-repeat: no-repeat;
        background-blend-mode: overlay;
        background-color: #00000099;
        
    }
    
}
</style>