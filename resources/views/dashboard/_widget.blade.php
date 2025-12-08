<?php /** @var \App\Models\CampaignDashboardWidget $widget */
use App\Enums\Widget;
?>


<div class="col-span-{{ $widget->colSize() }}">
    <div class="{{ $widgetClass }} cursor-pointer widget-{{ $widget->widget->value }} cover-background {{ $widget->widget->isHeader() ? 'h-28' : null }}"
    @if($widget->widget == Widget::Campaign)
         data-toggle="dialog"
         data-url="{{ route('campaigns.dashboard-header.edit', ['campaign' => $campaign, 'campaignDashboardWidget' => $widget]) }}"
    @else
         data-toggle="dialog"
         data-url="{{ route('campaign_dashboard_widgets.edit', [$campaign, $widget]) }}"
    @endif
    @if ($widget->widget == Widget::Campaign && $campaign->header_image)
         style="background-image: url('{{ Img::crop(1200, 400)->url($campaign->header_image) }}')"
    @endif
    >
        <div class="rounded-xl bg-box flex gap-2 flex-col p-4 h-full">
            <div class="flex gap-4 items-center w-full ">
                <div class="grow truncate">
                    <x-icon :class="$widget->widgetIcon()" tooltip title="{{ __('dashboards/widgets/' . $widget->widget->value . '.name') }}" />
                    @if (!empty($widget->conf('text')))
                        {{ $widget->conf('text') }} ({{ __('dashboards/widgets/' . $widget->widget->value . '.name') }})
                    @else
                        {{ __('dashboards/widgets/' . $widget->widget->value . '.name') }}
                    @endif
                </div>
                <div class="flex-none handle cursor-move text-neutral-content" data-toggle="tooltip" data-title="{{ __('dashboard.setup.reorder.helper') }}">
                    <x-icon class="fa-solid fa-arrows" />
                </div>
            </div>

            @if ($widget->entity)
                <div class="widget-entity flex items-center gap-2 w-full">
                    <div class="rounded entity-picture w-9 h-9 flex-none" style="background-image: url('{!! Avatar::entity($widget->entity)->size(40)->fallback()->thumbnail() !!}');"></div>
                    <div class="truncate text-md">
                        <a href="{{ $widget->entity->url() }}">
                            {!! $widget->entity->name !!}
                        </a>
                    </div>
                </div>
            @endif
            @if (in_array($widget->widget, [Widget::Recent, Widget::Random]))
                <p class="text-neutral-content text-sm">
                    <x-icon class="fa-solid fa-search" />
                @if ($widget->entityType)
                    {!! $widget->entityType->plural() !!}
                @elseif (!empty($widget->conf('singular')))
                    {{ __('dashboard.widgets.recent.singular') }}
                @else
                    {{ __('dashboard.widgets.recent.all-entities') }}
                @endif
                    @if (!empty($widget->conf('filters')))
                        <x-icon class="fa-solid fa-filter" tooltip title="{{ $widget->conf('filters') }}" />
                    @endif
                </p>
            @endif

            @if ($widget->tags->isNotEmpty())
                <div class="flex flex-wrap gap-1 items-center tags">
                    @foreach ($widget->tags as $tag)
                        @include ('tags._badge')
                    @endforeach
                </div>
            @endif
        </div>
        <input type="hidden" name="widgets[]" value="{{ $widget->id }}" />
    </div>
</div>
