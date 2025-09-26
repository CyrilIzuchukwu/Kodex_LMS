@foreach($courses as $purchase)
    <div class="bg-white shadow-sm rounded-2xl overflow-hidden w-full transition-transform hover:scale-[1.02] duration-300">
        <div class="relative">
            <div class="rounded-t-2xl w-full h-[200px] overflow-hidden bg-cover bg-center bg-no-repeat relative">
                @if(empty($purchase->course->video_url))
                    <img class="w-full h-full object-cover object-center" src="{{ $purchase->course->media->image_url }}" alt="{{ $purchase->course->title }}" loading="lazy">
                @else
                    <div class="block relative w-full h-full">
                        <a class="block overflow-hidden glightbox w-full h-full" href="{{ $purchase->course->video_url }}" data-glightbox="type: video; width: 900px;" data-gallery="video">
                            <div class="absolute flex items-center justify-center top-0 left-0 w-full h-full z-10 text-white p-4 hover-effect-target">
                                <span class="bg-white text-gray-900 rounded-full flex items-center justify-center w-14 h-14 pulse-animation">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.2A1 1 0 0010 9.8v4.4a1 1 0 001.555.832l3.197-2.2a1 1 0 000-1.664z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </span>
                            </div>
                            <span class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-30 z-[5]"></span>
                            <img src="{{ $purchase->course->media->image_url }}" alt="{{ $purchase->course->title }}" loading="lazy" class="w-full h-full object-cover object-center">
                        </a>
                    </div>
                @endif
            </div>

            <div class="absolute top-3 left-3">
                <span class="bg-white text-[#1B1B1B] px-3 py-1 rounded-full text-xs font-medium shadow-sm" style="backdrop-filter: blur(4px)">
                    {{ $purchase->course->category->name }}
                </span>
            </div>

            <div class="absolute top-3 right-3">
                <span class="bg-[#E68815] text-white px-3 py-1 rounded-full text-xs font-medium shadow-sm">
                    {{ round($purchase->progress) ?? 0 }}% Complete
                </span>
            </div>
        </div>

        <div class="p-3 md:p-3">
            <h3 class="text-[#1B1B1B] font-semibold text-lg mb-2 leading-tight line-clamp-2">
                <a href="{{ route('user.course.watch', ['course' => $purchase->course->id, 'module' => $purchase->module_id]) }}">
                    {{ $purchase->course->title }}
                </a>
            </h3>

            <div class="flex items-center mb-3">
                <img class="w-6 h-6 rounded-full mr-2" src="{{ $purchase->course->profile && $purchase->course->profile?->profile_photo_path ? asset($purchase->course->profile?->profile_photo_path) : asset('dashboard_assets/images/client/default.png') }}" alt="Instructor image">
                <a class="text-[#5D5D5D] font-medium text-sm hover:underline">
                    {{ $purchase->course->profile?->user->name ?? 'Not Assigned' }}
                </a>
            </div>

            <div class="mb-3">
                <div class="w-full bg-gray-200 rounded-full h-1.5">
                    <div class="bg-[#E68815] h-1.5 rounded-full" style="width: {{ round($purchase->progress) ?? 0 }}%"></div>
                </div>
                <div class="flex justify-between mt-1 text-sm text-gray-600">
                    <span>{{ $purchase->lessons_completed ?? 0 }} / {{ $purchase->course->modules_count ?? 0 }} Modules</span>
                    <span>{{ round($purchase->progress) ?? 0 }}%</span>
                </div>
            </div>

            <div class="flex items-center justify-between mb-4">
                <span class="text-[10px] font-[300] text-gray-600">Last Accessed: {{ $purchase->last_accessed ? $purchase->last_accessed->diffForHumans() : 'Not started' }}</span>
                <a href="{{ route('user.course.details', $purchase->course->slug) }}" class="text-[#E68815] font-[400] text-[12px] hover:underline">
                    View Details
                </a>
            </div>

            <a href="{{ route('user.course.watch', ['course' => $purchase->course->id, 'module' => $purchase->module_id]) }}" class="w-full bg-[#E68815] hover:bg-[#ffad48] text-white py-3 px-4 rounded-[100px] font-medium transition-colors flex items-center justify-center gap-1.5">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.2A1 1 0 0010 9.8v4.4a1 1 0 001.555.832l3.197-2.2a1 1 0 000-1.664z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ round(($purchase->progress) > 0 || $purchase->last_accessed !== null) ? 'Resume Course' : 'Start Learning' }}
            </a>
        </div>
    </div>
@endforeach
