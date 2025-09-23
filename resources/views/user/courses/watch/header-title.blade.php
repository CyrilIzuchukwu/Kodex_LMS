<div class="glass-effect rounded-2xl p-6 mb-8">
    <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
        <div class="flex-1">
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-2">
                {{ $course->title }}
            </h1>
            <p class="text-gray-600">
                {{ $course->subtitle }}
            </p>
        </div>

        <!-- Enhanced Progress Circle -->
        <div class="flex items-center gap-4 bg-white rounded-full px-6 py-3 shadow-sm">
            <div class="relative w-12 h-12">
                <svg class="w-12 h-12 progress-ring">
                    <circle cx="24" cy="24" r="20" stroke="#e5e7eb" stroke-width="3" fill="transparent" />
                    <circle cx="24" cy="24" r="20" stroke="url(#gradient)" stroke-width="3" fill="transparent" stroke-dasharray="125.6" stroke-dashoffset="{{ 125.6 * (1 - $progress / 100) }}" stroke-linecap="round"/>
                    <defs>
                        <linearGradient id="gradient" x1="0%" y1="0%" x2="100%" y2="0%">
                            <stop offset="0%" style="stop-color:#E68815"/>
                            <stop offset="100%" style="stop-color:#f59e0b"/>
                        </linearGradient>
                    </defs>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-xs font-bold text-gray-700">{{ round($progress) }}%</span>
                </div>
            </div>

            <div>
                <p class="text-sm font-medium text-gray-600">Course Progress</p>
                <p class="text-xs text-gray-500">
                    {{ $lessons_completed }} of {{ $course->modules_count }} modules completed
                </p>
            </div>
        </div>
    </div>
</div>
