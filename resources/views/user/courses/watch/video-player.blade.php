<div class="video-container rounded-2xl h-80 md:h-96 lg:h-[600px] flex items-center justify-center relative overflow-hidden shadow-2xl cursor-pointer bg-gray-900 mb-10" onclick="toggleYouTubeVideo(this)">
    <iframe id="youtube-player" class="absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-500" src="https://www.youtube.com/embed/{{ $youtube_id }}?enablejsapi=1&origin={{ request()->getSchemeAndHttpHost() }}&theme=light" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="background: transparent;"></iframe>

    <!-- Overlay with play button -->
    <div class="text-center z-10 play-button transition-opacity duration-500">
        <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mb-4 mx-auto backdrop-blur-sm">
            <i class="mdi mdi-play text-white text-3xl"></i>
        </div>
        <p class="text-white text-lg font-medium">{{ $course->title }}</p>
        <p class="text-gray-300 text-sm">Click to start watching</p>
    </div>

    <!-- Loader -->
    <div class="loader absolute inset-0 flex items-center justify-center bg-black/60 z-20 opacity-0 transition-opacity duration-500 pointer-events-none">
        <div class="w-10 h-10 border-4 border-white border-t-transparent rounded-full animate-spin"></div>
    </div>
</div>
