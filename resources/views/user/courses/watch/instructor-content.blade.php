<div class="glass-effect rounded-2xl p-6 shadow-sm">
    <h2 class="text-lg font-bold text-gray-800 mb-6">Meet Your Instructor</h2>
    <div class="flex items-start gap-6">
        <div class="w-16 h-16 rounded-full overflow-hidden flex-shrink-0">
            <img class="w-full h-full object-cover" src="{{ $course->profile && $course->profile->profile_photo_path ? asset($course->profile->profile_photo_path) : 'https://placehold.co/124x124/E5B983/FFF?text=' . substr($course->profile?->user->name ?? 'N', 0, 1) }}" alt="{{ $course->profile?->user->name ?? 'Not Assigned' }}">
        </div>

        <div class="flex-1">
            <h3 class="text-xl font-semibold text-orange-600 mb-1">{{ $course->profile?->user->name ?? 'Not Assigned' }}</h3>
            <p class="text-xs text-gray-500 mb-3">{{ $course->profile->course?->title ?? 'Not Assigned' }}</p>
            <div class="flex gap-4">
                <a href="{{ $course->profile?->user->email ? 'mailto:' . $course->profile->user->email : '#' }}" class="btn-primary bg-orange-500 text-white px-4 py-2 rounded-full font-medium transition-all duration-300 flex items-center gap-2 {{ !$course->profile?->user->email ? 'opacity-50 cursor-not-allowed' : 'hover:bg-orange-600' }}" {{ !$course->profile?->user->email ? 'disabled' : '' }}title="{{ $course->profile?->user->email ? 'Email ' . $course->profile->user->name : 'Email not available' }}">
                    <i class="mdi mdi-email"></i>
                    Email
                </a>

                <a href="{{ $course->profile?->phone ? 'tel:' . $course->profile->phone : '#' }}" class="btn-primary bg-orange-500 text-white px-4 py-2 rounded-full font-medium transition-all duration-300 flex items-center gap-2 {{ !$course->profile?->phone ? 'opacity-50 cursor-not-allowed' : 'hover:bg-orange-600' }}" {{ !$course->profile?->phone ? 'disabled' : '' }}title="{{ $course->profile?->phone ? 'Call ' . $course->profile->user->name : 'Phone not available' }}">
                    <i class="mdi mdi-phone"></i>
                    Phone
                </a>
            </div>
        </div>
    </div>
</div>
