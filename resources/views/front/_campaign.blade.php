<?php /** @var \App\Models\Campaign $campaign */?>
<div class="flex flex-col gap-5 text-left w-72" title="{!! $campaign->name !!}">
    <a href="{{ route('dashboard', $campaign) }}" class="relative">
        <img src="{{ $campaign->image ? $campaign->thumbnail(320, 240) : 'https://th.kanka.io/zzKcBpijSBvm4rPWdzRpI82pTNQ=/320x240/smart/src/app/backgrounds/mountain-background-medium.jpg' }}" alt="{{ $campaign->name }}" class="w-80 h-60">
        @if ($campaign->is_prioritised)
            <span class="absolute top-2 left-2 bg-purple text-white text-xs font-semibold px-2 py-1 rounded">
                <x-icon class="fa-regular fa-star" />
                {{ __('campaigns/applications.setup.prioritised') }}
            </span>
        @endif
    </a>

    <div class="flex flex-col gap-2">
        <a class="flex gap-2" href="{{ route('dashboard', $campaign) }}">
            <h3 class="block" >{!! $campaign->name !!}</h3>
        </a>

        @if ($campaign->spotlight)
            <a class="text-sm text-light hover:font-semibold" href="{{ $campaign->spotlight->url }}">View spotlight</a>

        @endif
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
</div>
