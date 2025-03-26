<div
    class="bg-base-100 rounded-2xl shadow-sm overflow-hidden"
>
    <button class="flex justify-between items-center w-full px-6 py-4 text-left focus:outline-none" data-animate="collapse" data-target="#{{ $id }}">
        <span class="text-xl font-medium">{{ $question }}</span>
        <svg class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <div id="{{ $id }}" class="hidden px-6 pb-4">
        {!! $answer !!}
    </div>

    <!-- Order your soul. Reduce your wants. - Augustine -->
</div>
