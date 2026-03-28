@if (count($images) > 0)
    <div
        x-data="{
            current: 0,
            total: {{ count($images) }},
            images: @js($images),
            timer: null,
            next() { this.current = (this.current + 1) % this.total },
            prev() { this.current = (this.current - 1 + this.total) % this.total },
            startTimer() { this.timer = setInterval(() => this.next(), 5000) },
            resetTimer() { clearInterval(this.timer); this.startTimer() },
            init() { if (this.total > 1) this.startTimer() }
        }"
        @mouseenter="clearInterval(timer)"
        @mouseleave="resetTimer()"
        class="relative overflow-hidden rounded-lg aspect-4/3"
    >
        <template x-for="(image, index) in images" :key="index">
            <a :href="image.full" target="_blank"
               class="absolute inset-0 transition-opacity duration-300"
               :class="current === index ? 'opacity-100' : 'opacity-0 pointer-events-none'"
            >
                <img :src="image.url" :alt="image.name || ''" class="w-full h-full object-cover" loading="lazy" />
            </a>
        </template>

        @if (count($images) > 1)
            <button
                @click="prev(); resetTimer()"
                class="absolute left-2 top-1/2 -translate-y-1/2 z-10 bg-base-100/70 hover:bg-base-100 rounded-full w-8 h-8 flex items-center justify-center transition-colors"
                type="button"
            >
                <x-icon class="fa-solid fa-chevron-left" />
            </button>

            <button
                @click="next(); resetTimer()"
                class="absolute right-2 top-1/2 -translate-y-1/2 z-10 bg-base-100/70 hover:bg-base-100 rounded-full w-8 h-8 flex items-center justify-center transition-colors"
                type="button"
            >
                <x-icon class="fa-solid fa-chevron-right" />
            </button>

            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 z-10 flex gap-1">
                <template x-for="(_, index) in images" :key="'dot-'+index">
                    <button
                        @click="current = index"
                        :class="current === index ? 'bg-primary' : 'bg-base-100/70'"
                        class="w-2 h-2 rounded-full transition-colors"
                        type="button"
                    ></button>
                </template>
            </div>
        @endif

        @if ($showName)
            <div class="absolute bottom-0 left-0 right-0 z-10 bg-gradient-to-t from-black/60 to-transparent p-3 pt-8" x-show="images[current]?.name">
                <p class="text-white text-sm" x-text="images[current]?.name"></p>
            </div>
        @endif
    </div>
@else
    <p class="text-neutral-content text-center">{{ __('Nothing to show') }}</p>
@endif
