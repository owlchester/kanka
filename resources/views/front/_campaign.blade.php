<?php /** @var \App\Models\Campaign $campaign */?>
<div class="campaign-container @if($campaign->boosted()) campaign-boosted @endif">
    <a class="campaign @if(!$featured) small-campaign @endif " href="{{ url(app()->getLocale() . '/' . $campaign->getMiddlewareLink()) }}" title="{!! $campaign->name !!}">
        <div class="campaign-image campaign-placeholder"  @if ($campaign->image) style="background-image: url('{{ $campaign->getImageUrl() }}')" @endif>

        </div>
        <div class="bottom">
            <h4 class="campaign-title">
                @if (!$featured && $campaign->isFeatured())
                    <i class="fas fa-star" title="{{ __('campaigns.fields.featured') }}" data-toggle="tooltip"></i>
                @elseif (!$featured && $campaign->isFeatured(true))
                    <i class="fas fa-star" title="{{ __('campaigns.fields.past_featured') }}" data-toggle="tooltip"></i>
                @endif
                {!! $campaign->name !!}
            </h4>
            <div class="labels">
                <span class="label label-default" title="{{ __('campaigns.fields.entity_count') }}" data-toggle="tooltip"><i class="fa fa-eye"></i> {{ number_format($campaign->visible_entity_count) }}</span>
                @if ($campaign->locale)
                    <span class="label label-default" title="{{ __('languages.codes.' . $campaign->locale) }}" data-toggle="tooltip">{{ $campaign->locale }}</span>
                @endif
                @if (!empty($campaign->system))
                    <span class="label label-default" title="{{ __('campaigns.fields.system') }}" data-toggle="tooltip">{{ $campaign->system }}</span>
                @endif
                @if ($campaign->is_open)
                    <span class="label label-default mr-1" title="{{ __('campaigns.open_campaign.title') }}" data-toggle="tooltip"><i class="fas fa-door-open"></i></span>
                @endif
                @if ($campaign->boosted())
                    <span class="label label-default" title="{{ __('campaigns.panels.boosted') }}" data-toggle="tooltip"><i class="fa fa-rocket"></i></span>
                @endif
            </div>
        </div>
    </a>
</div>
@if ($campaign->is_featured && !empty($campaign->featured_reason))
    <p class="font-weight-light text-muted">
        {!! $campaign->featured_reason !!}
    </p>
@endif
