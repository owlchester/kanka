<div class="grid grid-cols-2 gap-4">
    @if ($campaign->members->count() > 1)
    <div class="rounded-2xl p-4 bg-blue-100">
        <p class="text-xl font-semibold text-blue-700">{{ $campaign->members->count() }}</p>
        <p class="text-xs">{{ __('settings/premium.create.recap.instant') }}</p>
    </div>
    <div class="rounded-2xl p-4 bg-red-100">
        <p class="text-xl font-semibold text-red-700">{{ config('limits.filesize.image.standard') }}MiB → {{  config('limits.filesize.image.owlbear') }}MiB</p>
        <p class="text-xs">{{ __('settings/premium.create.recap.size') }}</p>
    </div>
    @else
    <div class="rounded-2xl p-4 bg-blue-100">
        <p class="text-xl font-semibold text-blue-700">{{ __('settings/premium.create.recap.control.title') }}</p>
        <p class="text-xs">{{ __('settings/premium.create.recap.control.description') }}</p>
    </div>
        @php
        $base = config('limits.gallery.premium');
        if (auth()->user()->isWyvern()) {
            $base = config('limits.gallery.wyvern');
        } elseif (auth()->user()->isElemental()) {
            $base = config('limits.gallery.elemental');
        }
        $base = round(($base/1024)/1024, 2);
        @endphp
    <div class="rounded-2xl p-4 bg-red-100">
        <p class="text-xl font-semibold text-red-700">{{ round(config('limits.gallery.standard')/1024, 2) }}MiB → {{ $base }}GiB</p>
        <p class="text-xs">{{ __('settings/premium.create.recap.gallery') }}</p>
    </div>
    @endif
    <div class="rounded-2xl p-4 bg-amber-100">
        <p class="text-xl font-semibold text-amber-700">{{ __('settings/premium.create.recap.recovery.title', ['amount' => config('entities.hard_delete')]) }}</p>
        <p class="text-xs">{{ __('settings/premium.create.recap.recovery.description') }}</p>
    </div>
    <div class="rounded-2xl p-4 bg-green-100">
        <p class="text-xl font-semibold text-green-700">12,000+</p>
        <p class="text-xs">{{ __('settings/premium.create.recap.icons') }}</p>
    </div>
</div>
