<section class="sidebar-campaign h-40 overflow-hidden">
    <div class="campaign-block h-32 px-4 pt-24">
        <div class="campaign-head">
            <div class="campaign-name truncate text-xl">
                {!! $campaign->name !!}
            </div>

            <div class="campaign-updated text-xs truncate">
                {{ __('sidebar.campaign_switcher.updated') }} {{ $campaign->updated_at->diffForHumans() }}
            </div>
        </div>
    </div>
</section>
