<?php /** @var \App\Models\Campaign $campaign */?>
<div class="grid grid-cols-2 md:grid-cols-5 gap-5 mb-5">

    @can ('update', $campaign)
        <a href="#" role="button" class="block rounded-xl p-5 text-center overflow-hidden bg-box drop-shadow" data-url="{{ route('campaign-visibility', ['from' => 'overview']) }}" data-target="#entity-modal" data-toggle="ajax-modal">
    @else
        <div class="rounded-xl p-5 text-center bg-box drop-shadow">
    @endcan
        @if ($campaign->isPublic())
            <i class="fa-solid fa-eye fa-2x" aria-hidden="true"></i>
            <span class="block mt-2">{{ __('campaigns.visibilities.public') }}</span>
        @else
            <i class="fa-solid fa-lock fa-2x" aria-hidden="true"></i>
            <span class="block mt-2">{{ __('campaigns.visibilities.private') }}</span>
        @endif
    @can ('update', $campaign)
        </a>
    @else
        </div>
    @endcan

    <div class="rounded-xl p-5 text-center bg-box drop-shadow cursor hover:link" data-toggle="dialog"
         data-target="entity-count">
        <i class="fa-solid fa-globe fa-2x" aria-hidden="true"></i>
        <span class="block mt-2">
            {{ trans_choice('campaigns.overview.entity-count', \App\Facades\CampaignCache::entityCount(), ['amount' => number_format(\App\Facades\CampaignCache::entityCount())]) }}
        </span>
    </div>

    @if ($campaign->isPublic())
        <div class="rounded-xl p-5 text-center bg-box drop-shadow">
            <i class="fa-solid fa-users fa-2x" aria-hidden="true"></i>
            <span class="block mt-2">
                {{ trans_choice('campaigns.overview.follower-count', $campaign->follower(), ['amount' => number_format($campaign->follower())]) }}
            </span>
        </div>
    @endif

    @if ($campaign->boosted())
        <div class="rounded-xl p-5 text-center bg-box drop-shadow">
            <i class="fa-solid fa-rocket fa-2x" aria-hidden="true"></i>
            <span class="block mt-2">
                {{ __('campaigns.fields.' . ($campaign->superboosted() ? 'superboosted' : 'boosted')) }}
                {{ $campaign->boosts->first()->user->name }}
            </span>
        </div>
    @endif

    @if (!empty($campaign->locale))
        <div class="rounded-xl p-5 text-center bg-box drop-shadow">
            <i class="fa-solid fa-language fa-2x" aria-hidden="true"></i>
            <span class="block mt-2">{{ __('languages.codes.' . $campaign->locale) }}</span>
        </div>
    @endif
</div>

@section('modals')
    @parent
    @include('partials.helper-modal', [
            'id' => 'entity-count',
            'title' => __('campaigns.fields.entity_count'),
            'textes' => [
                __('campaigns.helpers.entity_count_v3', ['amount' => 6])
            ]
        ])


@endsection
