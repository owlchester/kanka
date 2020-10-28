<?php /** @var \App\Models\Campaign $campaign */?>
<div class="campaign-container @if($campaign->boosted()) campaign-boosted @endif">
    <a class="campaign @if(!$featured) small-campaign @endif " href="{{ url(app()->getLocale() . '/' . $campaign->getMiddlewareLink()) }}" title="{!! $campaign->name !!}">
        <div class="campaign-image campaign-placeholder"  @if ($campaign->image) style="background-image: url('{{ $campaign->getImageUrl() }}')" @endif>

        </div>
        <div class="bottom">
            <h4 class="campaign-title">
                {!! $campaign->name !!}
            </h4>
            <div class="labels">
                <span class="label label-default" title="{{ __('campaigns.fields.entity_count') }}"><i class="fa fa-eye"></i> {{ number_format($campaign->visible_entity_count) }}</span>
                @if ($campaign->locale)
                    <span class="label label-default" title="{{ __('languages.codes.' . $campaign->locale) }}">{{ $campaign->locale }}</span>
                @endif
                @if (!empty($campaign->system))
                    <span class="label label-default" title="{{ __('campaigns.fields.system') }}">{{ $campaign->system }}</span>
                @endif
                @if ($campaign->boosted())
                    <span class="label label-default" title="{{ __('campaigns.panels.boosted') }}">
                        <i class="fa fa-rocket"></i>
                    </span>
                @endif
            </div>
        </div>
    </a>
</div>
