@foreach($courses as $course)
    <!-- Single course card -->
    <div class="bg-white shadow-sm rounded-2xl overflow-hidden w-full transition-transform hover:scale-[1.02] duration-300">
        <div class="relative">
            <div class="rounded-t-2xl w-full h-[200px] overflow-hidden bg-cover bg-center bg-no-repeat relative">
                @if(empty($course->video_url))
                    <img class="w-full h-full object-cover object-center" src="{{ $course->media->image_url }}" alt="{{ $course->title }}" loading="lazy">
                @else
                    <div class="block relative w-full h-full">
                        <a class="block overflow-hidden glightbox w-full h-full" href="{{ $course->video_url }}" data-glightbox="type: video; width: 900px;" data-gallery="video">
                            <div class="absolute flex items-center justify-center top-0 left-0 w-full h-full z-10 text-white p-4 hover-effect-target">
                                <span class="bg-white text-gray-900 rounded-full flex items-center justify-center w-14 h-14 pulse-animation">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.2A1 1 0 0010 9.8v4.4a1 1 0 001.555.832l3.197-2.2a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </div>
                            <span class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-30 z-[5]"></span>
                            <img src="{{ $course->media->image_url }}" alt="{{ $course->title }}" loading="lazy" class="w-full h-full object-cover object-center">
                        </a>
                    </div>
                @endif
            </div>

            <div class="absolute top-3 left-3">
                <span class="bg-white text-[#1B1B1B] px-3 py-1 rounded-full text-xs font-medium shadow-sm" style="backdrop-filter: blur(4px)">
                    {{ $course->category->name }}
                </span>
            </div>
        </div>

        <div class="p-4">
            <h3 class="text-[#1B1B1B] font-semibold text-base mb-2 leading-tight line-clamp-2">
                <a href="{{ route('user.course.details', $course->slug) }}">
                    {{ $course->title }}
                </a>
            </h3>

            <div class="flex items-center mb-3">
                <img class="w-6 h-6 rounded-full mr-2" src="{{ $course->profile && $course->profile?->profile_photo_path ? asset($course->profile?->profile_photo_path) : asset('dashboard_assets/images/client/default.png') }}" alt="Instructor image">
                <a class="text-[#5D5D5D] font-medium text-sm hover:underline">
                    {{ $course->profile?->user->name ?? 'Not Assigned' }}
                </a>
            </div>

            <div class="flex items-center justify-between mb-4">
                <span class="text-[#1B1B1B] font-bold text-base">₦ {{ number_format($course->price, 2) }}</span>
                <a href="{{ route('user.course.details', $course->slug) }}" class="text-[#E68815] font-medium text-sm hover:underline">
                    View Details
                </a>
            </div>

            <button id="add-to-cart" class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-3 rounded-[100px] font-medium transition-colors flex items-center justify-center gap-1.5" data-course="{{ $course->id }}">
                <svg class="uil-shopping-cart w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                Add to Cart
            </button>
        </div>
    </div>
@endforeach

<style>
    .pulse-animation {
        animation: pulse 1.5s infinite ease-in-out;
    }
    @keyframes pulse {
        0% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.2);
            opacity: 0.7;
        }
        100% {
            transform: scale(1);
            opacity: 1;
        }
    }
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
