<?php /** @var \App\Models\Campaign $campaign */
$boxClass = 'rounded p-3 text-center bg-box shadow-xs flex items-center justify-center gap-3 flex-col w-32 break-words';
?>
<div class="flex flex-wrap gap-4">

    @can ('update', $campaign)
        <a href="#" role="button" class="{{ $boxClass }}" data-url="{{ route('campaign-visibility', [$campaign, 'from' => 'overview']) }}" data-target="campaign-visibility" data-toggle="dialog-ajax">
    @else
        <div class="{{ $boxClass }}">
    @endcan
        @if ($campaign->isPublic())
            <i class="fa-solid fa-eye fa-2x" aria-hidden="true"></i>
            <div class="">
                {{ __('campaigns.visibilities.public') }}
            </div>
        @else
            <i class="fa-solid fa-lock fa-2x" aria-hidden="true"></i>
            <div class="">
                {{ __('campaigns.visibilities.private') }}
            </div>
        @endif
    @can ('update', $campaign)
        </a>
    @else
        </div>
    @endcan

    <a href="#" class="{{ $boxClass }}" data-toggle="dialog"
         data-target="entity-count">
        <i class="fa-solid fa-globe fa-2x" aria-hidden="true"></i>
        <div class="">
            {{ trans_choice('campaigns.overview.entity-count', \App\Facades\CampaignCache::entityCount(), ['amount' => number_format(\App\Facades\CampaignCache::entityCount())]) }}
        </div>
    </a>

    @if ($campaign->isPublic())
        <div class="{{ $boxClass }}">
            <i class="fa-solid fa-users fa-2x" aria-hidden="true"></i>
            <div class="">
                {{ trans_choice('campaigns.overview.follower-count', $campaign->follower(), ['amount' => number_format($campaign->follower())]) }}
            </div>
        </div>
    @endif

    @if ($campaign->boosted())
        <div class="{{ $boxClass }}">
            <i class="fa-solid fa-rocket fa-2x" aria-hidden="true"></i>
            <div class="">
                @if ($campaign->premium())
                    {{ __('campaigns.fields.premium', ['name' => $campaign->boosts->first()?->user->name]) }}
                @else
                    {{ __('campaigns.fields.' . ($campaign->superboosted() ? 'superboosted' : 'boosted')) }}
                    {{ $campaign->boosts->first()?->user->name }}
                @endif
            </div>
        </div>
    @endif

    @if (!empty($campaign->locale))
        <div class="{{ $boxClass }}">
            <i class="fa-solid fa-language fa-2x" aria-hidden="true"></i>
            <div class="">
                {{ __('languages.codes.' . $campaign->locale) }}
            </div>
        </div>
    @endif
</div>

@section('modals')
    @parent
    <x-dialog id="entity-count" :title="__('campaigns.fields.entity_count')">
        <p>
            {{ __('campaigns.helpers.entity_count_v3', ['amount' => 6]) }}
        </p>
    </x-dialog>
    <x-dialog id="campaign-visibility" :title="__('Loading')" :loading="true"></x-dialog>
@endsection
