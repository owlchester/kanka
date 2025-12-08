<?php /** @var \App\Models\Campaign $campaign */?>
<a class="flex flex-col gap-5 text-left w-72" href="{{ route('dashboard', $campaign) }}" title="{!! $campaign->name !!}">

    <img src="{{ $campaign->image ? $campaign->thumbnail(320, 240) : 'https://th.kanka.io/zzKcBpijSBvm4rPWdzRpI82pTNQ=/320x240/smart/src/app/backgrounds/mountain-background-medium.jpg' }}" alt="{{ $campaign->name }}" class="w-80 h-60">

    <div class="flex flex-col gap-2">
        <div class="flex gap-2">
            <h3 class="text-xl">{!! $campaign->name !!}</h3>
        </div>

        <div class="flex flex-wrap gap-6 text-sm">

            <span class="" title="{{ __('campaigns.fields.entity_count') }}" data-toggle="tooltip">
                <x-icon class="pencil" />
                {{ number_format($campaign->visible_entity_count) }}
            </span>
            <span class="" title="{{ __('campaigns.fields.followers') }}" data-toggle="tooltip">
                <x-icon class="fa-regular fa-eye" />
                {{ number_format($campaign->follower) }}
            </span>
            @if ($campaign->locale)
                <span class="" title="{{ __('languages.codes.' . $campaign->locale) }}" data-toggle="tooltip">
                    <x-icon class="fa-regular fa-language" />
                    {{ $campaign->locale }}
                </span>
            @endif
            @if (!empty($campaign->system))
                <span class="" title="{{ __('campaigns.fields.system') }}" data-toggle="tooltip">
                    <x-icon class="cog" />
                    {{ $campaign->system }}
                </span>
            @endif
        </div>
    </div>
</a>
