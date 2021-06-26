<?php /** @var \App\Models\CampaignDashboardWidget $widget */

$background = null;

if ($widget->entity) {
    if (!empty($widget->entity->child->image)) {
        $background = $widget->entity->child->getImageUrl();
    } elseif (!empty($widget->entity->image)) {
        $background = Img::crop(250, 250)->url($widget->entity->image->path);
    }
}
?>


<div class="col-md-{{ $widget->colSize() }} widget-draggable">
    <div class="widget widget-{{ $widget->widget }} cover-background"
         data-toggle="ajax-modal"
    @if($widget->widget == \App\Models\CampaignDashboardWidget::WIDGET_CAMPAIGN)
         data-target="#large-modal"
         data-url="{{ route('campaigns.dashboard-header.edit', ['campaign' => $campaign->campaign(), 'campaignDashboardWidget' => $widget]) }}"
    @else
         data-target="#edit-widget"
         data-url="{{ route('campaign_dashboard_widgets.edit', $widget) }}"
    @endif
    @if (!empty($background))
         style="background-image: url('{{ $background }}')"
    @elseif ($widget->widget == \App\Models\CampaignDashboardWidget::WIDGET_CAMPAIGN && $campaign->campaign()->header_image)
         style="background-image: url('{{ Img::crop(1200, 400)->url($campaign->campaign()->header_image) }}')"
    @endif
    >
        <div class="widget-overlay">
            @if ($widget->widget != \App\Models\CampaignDashboardWidget::WIDGET_HEADER)
                <span class="widget-type">{{ __('dashboard.setup.widgets.' . $widget->widget) }}</span>
            @endif

            @if ($widget->entity)
                <div class="widget-entity">
                    {{ link_to($widget->entity->url(), $widget->entity->name) }}
                </div>
            @endif

            @if ($widget->widget == \App\Models\CampaignDashboardWidget::WIDGET_HEADER)
                @if (!empty($widget->conf('text')))
                    <h3>{{ $widget->conf('text') }}</h3>
                @endif
            @elseif (!empty($widget->conf('text')))
                <span class="custom-name" title="{{ __('dashboard.widgets.fields.name') }}">
                                    <i class="fas fa-paragraph"></i> {{ $widget->conf('text') }}
                                </span>
            @endif


            @if ($widget->widget == \App\Models\CampaignDashboardWidget::WIDGET_UNMENTIONED)
                @if (!empty($widget->conf('entity')))
                    <h5>{{ __('entities.' . $widget->conf('entity')) }}</h5>
                @endif
            @endif

            @if ($widget->widget == \App\Models\CampaignDashboardWidget::WIDGET_RECENT)
                @if (!empty($widget->conf('entity')))
                    <h5>{{ __('entities.' . $widget->conf('entity')) }}</h5>
                @elseif (!empty($widget->conf('singular')))
                    <h5>{{ __('dashboard.widgets.recent.singular') }}</h5>
                @endif
            @endif

            @if (!empty($widget->tags))
                <div class="tags">
                    @foreach ($widget->tags as $tag)
                        {!! $tag->html() !!}
                    @endforeach
                </div>
            @endif
        </div>
        <input type="hidden" name="widgets[]" value="{{ $widget->id }}" />
    </div>
</div>
