<x-dialog.header>
    {{ $title ?? __('concept.premium-feature') }}
</x-dialog.header>
<x-dialog.article class="max-w-xl">
    <x-grid type="1/1">
        <p>
            {!! __('settings/premium.create.pitch', ['name' => '<strong>' . $campaign->name . '</strong>']) !!}
        </p>

        <div class="grid grid-cols-2 gap-4">
            <div class="rounded-2xl p-4 bg-blue-100">
                <p class="text-xl font-semibold text-blue-700">{{ config('limits.filesize.image.standard') }}MiB → {{ config('limits.filesize.image.owlbear') }}MiB</p>
                <p class="text-xs">{{ __('settings/premium.create.recap.size') }}</p>
            </div>
            <div class="rounded-2xl p-4 bg-red-100">
                <p class="text-xl font-semibold text-red-700">{{ __('settings/premium.create.recap.members.title') }}</p>
                <p class="text-xs">{{ __('settings/premium.create.recap.members.description') }}</p>
            </div>
            <div class="rounded-2xl p-4 bg-amber-100">
                <p class="text-xl font-semibold text-amber-700">{{ __('settings/premium.create.recap.recovery.title', ['amount' => config('entities.hard_delete')]) }}</p>
                <p class="text-xs">{{ __('settings/premium.create.recap.recovery.description') }}</p>
            </div>
            <div class="rounded-2xl p-4 bg-green-100">
                <p class="text-xl font-semibold text-green-700">12,000+</p>
                <p class="text-xs">{{ __('settings/premium.create.recap.icons') }}</p>
            </div>
        </div>
        
    </x-grid>
</x-dialog.article>
<x-premium-cta-footer :campaign="$campaign" />
