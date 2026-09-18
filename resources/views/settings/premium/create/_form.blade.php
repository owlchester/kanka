<x-grid type="1/1">

    <p>{!! __('settings/premium.create.subtitle', ['name' => '<strong>' . $campaign->name . '</strong>']) !!}</p>

    @include('settings.premium.create.recap')

@if(auth()->user()->availableBenefits() < 1)
    @can('boost', auth()->user())

        <p class="">
            {!! __('settings/premium.create.no-stock', [
                'upgrade' => '<a href="' . route('settings.subscription') . '" class="text-link">' . __('settings/boosters.boost.upgrade') . '</a>',
            ]) !!}
        </p>
    @endif

@else

    <p class="text-xs text-neutral-content">{{ __('settings/premium.create.more') }}</p>
@endif
</x-grid>
