<div class="rounded-xl border-primary bg-primary-content flex lg:justify-between lg:items-center gap-4 p-4 flex-col lg:flex-row">
    <div class="flex items-center gap-2 md:gap-4">
        <div class="rounded-full bg-primary text-primary-content w-6 h-6 flex items-center justify-center flex-none">
            <i class="fa-regular fa-gem" aria-hidden="true"></i>
        </div>
        <div>
            <span class="font-bold">{!! $title ?? '' !!}</span>
            <span>{!! $lead ?? '' !!}</span>
        </div>
    </div>
    @auth
        @can('boost', auth()->user())
            <a href="{{ route('settings.premium', ['campaign' => $campaign->id, 'f' => 'cta', 's' => 'theming']) }}" class="text-primary font-semibold">
                @can('admin', $campaign)
                    {!! __('callouts.alert.enable', ['campaign' => $campaign]) !!}
                @else
                    {!! __('callouts.alert.sponsor', ['campaign' => $campaign]) !!}
                @endif
                <i class="fa-regular fa-arrow-right" aria-hidden="true"></i>
            </a>
        @else
            <a href="{{ route('settings.subscription', ['f' => 'cta', 's' => 'theming', 'w' => $campaign->id]) }}" class="text-primary font-semibold">
                {!! __('callouts.actions.subscription') !!}
                <i class="fa-regular fa-arrow-right" aria-hidden="true"></i>
            </a>
        @endcan
    @endauth
</div>
