<section class="sidebar-campaign h-40 overflow-hidden">
    <div class="campaign-block h-32 px-4 pt-24">
        <div class="campaign-head">
            @if (!$campaign->image && auth()->check() && auth()->user()->can('update', $campaign))
                <div class="flex gap-2 items-center">
                    <div class="campaign-name grow truncate  text-xl">
                        {!! $campaign->name !!}
                    </div>
                    <a href="#" class="text-sidebar-content" data-toggle="dialog"
                       data-target="primary-dialog" data-url="{{ route('campaign.sidebar.image', [$campaign]) }}" data-tooltip data-title="{{ __('campaigns/sidebar.tooltips.image') }}">
                        <x-icon class="fa-solid fa-image" />
                    </a>
                </div>
            @else
            <div class="campaign-name truncate text-xl">
                {!! $campaign->name !!}
            </div>
            @endif

            <div class="campaign-updated text-xs truncate">
                {{ __('sidebar.campaign_switcher.updated') }} {{ $campaign->updated_at->diffForHumans() }}
            </div>
        </div>
    </div>
</section>
