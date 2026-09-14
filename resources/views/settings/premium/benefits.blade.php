<div class="rounded-lg p-6 lg:p-8 flex flex-col gap-6 bg-base-100">
    <div class="flex flex-col gap-2">
        @isset($boosters)
        <h3 class="text-xl">{{ __('settings/boosters.pitch.title') }}</h3>
        <p class="">{{ __('settings/boosters.pitch.description') }}</p>
        @else
        <h3 class="text-2xl font-semibold">{{ __('settings/boosters.pitch.title') }}</h3>
        <p class="text-neutral-content max-w-2xl">{{ __('settings/premium.pitch.description') }}</p>
        @endisset
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 mb-2">
        <div class="bg-blue-100 rounded-2xl p-4 flex flex-col gap-1">
            <p class="text-blue-800 text-3xl font-bold leading-tight">{{ config('limits.filesize.image.owlbear')}} MiB</p>
            <p class="leading-tight">Upload limit per member</p>
        </div>
        <div class="bg-amber-100 rounded-2xl p-4 flex flex-col gap-1">
            <p class="text-amber-600 text-3xl font-bold leading-tight">{{ config('entities.hard_delete')}} days</p>
            <p class="leading-tight">Window to recover deleted entries and articles</p>
        </div>
        <div class="bg-green-100 rounded-2xl p-4 flex flex-col gap-1">
            <p class="text-green-700 text-3xl font-bold leading-tight">12,000 +</p>
            <p class="leading-tight">Icons for maps and timelines</p>
        </div>
        <div class="bg-red-100 rounded-2xl p-4 flex flex-col gap-1">
            <p class="text-red-700 text-3xl font-bold leading-tight">Unlimited</p>
            <p class="leading-tight">Custom themes and community plugins</p>
        </div>
    </div>


    <div class="flex flex-col gap-2">
        <h4 class="text-base font-semibold">{{ __('settings/premium.pitch.title') }}</h4>
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4 mb-3">
            <x-premium-benefit
                icon="fa-palette"
                :title="__('premium/perks.title.css')"
                :subtitle="__('premium/perks.subtitle.css')"
                icon-bg="bg-red-100"
                icon-text="text-red-700"
            />
            <x-premium-benefit
                icon="fa-puzzle-piece"
                :title="__('premium/perks.title.plugins')"
                :subtitle="__('premium/perks.subtitle.plugins')"
            />
            <x-premium-benefit
                icon="fa-history"
                :title="__('premium/perks.title.backup', ['amount' => config('entities.hard_delete')])"
                :subtitle="__('premium/perks.subtitle.backup')"
                icon-bg="bg-amber-100"
                icon-text="text-orange-700"
            />
            <x-premium-benefit
                icon="fa-star"
                :title="__('premium/perks.title.icons')"
                :subtitle="__('premium/perks.subtitle.icons')"
                icon-bg="bg-green-100"
                icon-text="text-green-700"
            />
            <x-premium-benefit
                icon="fa-upload"
                :title="__('premium/perks.title.upload')"
                :subtitle="__('premium/perks.subtitle.upload', ['amount' => config('limits.filesize.image.owlbear')])"
            />
            <x-premium-benefit
                icon="fa-circle-nodes"
                :title="__('premium/perks.title.visual')"
                :subtitle="__('premium/perks.subtitle.visual')"
                icon-bg="bg-red-100"
                icon-text="text-red-700"
            />
        </div>
    </div>


    <p>
        <a href="https://kanka.io/premium?utm_source=premium" class="text-link font-semibold">
            {!! __('callouts.premium.learn-more') !!}
            <x-icon class="fa-regular fa-arrow-right" />
        </a>
    </p>
</div>
