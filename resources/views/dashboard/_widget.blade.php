<?php /** @var \App\Models\CampaignDashboardWidget $widget */

$background = null;

if ($widget->entity) {
    if (!empty($widget->entity->child->image)) {
        $background = $widget->entity->child->thumbnail(600);
    } elseif (!empty($widget->entity->image)) {
        $background = Img::crop(600, 600)->url($widget->entity->image->path);
    }
}
?>


<div class="col-md-{{ $widget->colSize() }}">
    <div class="{{ $widgetClass }} {{ !empty($background) ? 'p-5' : null }} border-dashboard widget-{{ $widget->widget }} cover-background"
         data-toggle="ajax-modal"
    @if($widget->widget == \App\Models\CampaignDashboardWidget::WIDGET_CAMPAIGN)
         data-target="#large-modal"
         data-url="{{ route('dashboard-header.edit', ['campaign' => $campaign, 'campaignDashboardWidget' => $widget]) }}"
    @else
         data-target="#edit-widget"
         data-url="{{ route('campaign_dashboard_widgets.edit', [$campaign, $widget]) }}"
    @endif
    @if (!empty($background))
         style="background-image: url('{{ $background }}')"
    @elseif ($widget->widget == \App\Models\CampaignDashboardWidget::WIDGET_CAMPAIGN && $campaignService->campaign()->header_image)
         style="background-image: url('{{ Img::crop(1200, 400)->url($campaignService->campaign()->header_image) }}')"
    @endif
    >
        <div class="{{ $overlayClass }}">
            <div class="handle rounded-md px-2 py-1 text-center cursor-pointer absolute w-10 border-dashboard background">
                <i class="fa-solid fa-arrows" aria-hidden="true"></i>
            </div>
            @if ($widget->widget != \App\Models\CampaignDashboardWidget::WIDGET_HEADER)
                <span class="block text-2xl">
                     {!! $widget->widgetIcon() !!}
                    {{ __('dashboard.setup.widgets.' . $widget->widget) }}
                </span>
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
                    <i class="fa-solid fa-paragraph"></i> {{ $widget->conf('text') }}
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
                <div class="tags text-xs">
                    @foreach ($widget->tags as $tag)
                        {!! $tag->html() !!}
                    @endforeach
                </div>
            @endif
        </div>
        <input type="hidden" name="widgets[]" value="{{ $widget->id }}" />
    </div>
</div>
