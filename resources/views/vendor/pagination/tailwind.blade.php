<!-- Pagination -->
<div class="flex flex-col sm:flex-row justify-between text-black font-medium items-center gap-4">
    <div>
        <p class="text-xs md:text-sm">Showing <span>{{ $paginator->firstItem() }}</span> to {{ $paginator->lastItem() }} of {{ $paginator->total() }} entries</p>
    </div>

    <div class="flex gap-2">
        @if ($paginator->onFirstPage())
            <button class="bg-[#EDEDED] text-black px-4 md:px-10 py-2 md:py-3 text-xs md:text-sm rounded-full font-medium hover:bg-gray-200 transition-colors" disabled>
                Prev
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="bg-[#EDEDED] text-black px-4 md:px-10 py-2 md:py-3 text-xs md:text-sm rounded-full font-medium hover:bg-gray-200 transition-colors">
                Prev
            </a>
        @endif

        <span class="border px-3 md:px-6 py-2 md:py-3 rounded-full text-xs md:text-sm bg-white text-black">{{ $paginator->currentPage() }}</span>

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="bg-[#E68815] text-white px-4 md:px-10 py-2 md:py-3 text-xs md:text-sm rounded-full font-medium hover:bg-amber-600 transition-colors">
                Next
            </a>
        @else
            <button class="bg-[#E68815] text-white px-4 md:px-10 py-2 md:py-3 text-xs md:text-sm rounded-full font-medium hover:bg-amber-600 transition-colors" disabled>
                Next
            </button>
        @endif
    </div>
</div>
