<?php /** @var \App\Models\Campaign $campaign */
$width = $featured ? 350 : 200;
?>
<div class="campaign-container @if($campaign->boosted()) campaign-boosted @endif">
    <a class="campaign @if(!$featured) small-campaign @endif " href="{{ url(app()->getLocale() . '/' . $campaign->getMiddlewareLink()) }}" title="{!! $campaign->name !!}">
        <div class="campaign-image campaign-placeholder"  @if ($campaign->image) style="background-image: url('{{ $campaign->thumbnail($width, 200) }}')" @endif>

        </div>
        <div class="bottom">
            <h4 class="campaign-title mb-1">
                <div class="float-right">
                    @if ($campaign->is_open)
                        <i class="fa-solid fa-door-open" title="{{ __('campaigns/submissions.helpers.filter-helper') }}" data-toggle="tooltip"></i>
                    @endif
                    @if ($campaign->boosted())
                        <i class="fa-solid fa-rocket" title="{{ __('front.campaigns.public.filters.is-boosted') }}" data-toggle="tooltip"></i>
                    @elseif ($campaign->superboosted())
                        <i class="fa-solid fa-rocket" title="{{ __('front.campaigns.public.filters.is-superboosted') }}" data-toggle="tooltip"></i>
                    @endif
                </div>
                {!! $campaign->name !!}
            </h4>

            @if ($campaign->is_featured && !empty($campaign->featured_reason))
                <p class="font-weight-light text-muted featured-winner mb-1">
                    {!! $campaign->featured_reason !!}
                </p>
            @endif
            <div class="labels text-muted">
                <span class="mr-3" title="{{ __('campaigns.fields.entity_count') }}" data-toggle="tooltip">
                    <i class="fa-solid fa-pencil" aria-hidden="true"></i>
                    {{ number_format($campaign->visible_entity_count) }}
                </span>
                <span class="mr-3" title="{{ __('campaigns.fields.followers') }}" data-toggle="tooltip">
                    <i class="fa-solid fa-eye" aria-hidden="true"></i>
                    {{ number_format($campaign->follower) }}
                </span>
                @if ($campaign->locale)
                    <span class="mr-3" title="{{ __('languages.codes.' . $campaign->locale) }}" data-toggle="tooltip">
                        <i class="fa-solid fa-language" aria-hidden="true"></i>
                        {{ $campaign->locale }}
                    </span>
                @endif
                @if (!empty($campaign->system))
                    <span class="mr-3" title="{{ __('campaigns.fields.system') }}" data-toggle="tooltip">
                        <i class="fa-solid fa-cog" aria-hidden="true"></i>
                        {{ $campaign->system }}
                    </span>
                @endif
            </div>
        </div>
    </a>
</div>
