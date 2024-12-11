@inject('moduleService', 'App\Services\Campaign\ModuleService')
<?php /** @var \App\Models\CampaignDashboardWidget $widget */
use Illuminate\Support\Str;
use App\Enums\Widget;

$background = null;

if ($widget->entity && $widget->entity->hasImage()) {
    $background = Avatar::entity($widget->entity)->size(40)->thumbnail();
}
if (!empty($widget->conf('entity'))) {
    $entityString = $moduleService->plural($widget->conf('entity'), 'entities.' . Str::plural($widget->conf('entity')));
}
?>


<div class="col-span-{{ $widget->colSize() }}">
    <div class="{{ $widgetClass }} cursor-pointer widget-{{ $widget->widget->value }} cover-background {{ $widget->widget->isHeader() ? 'h-auto' : null }}"
    @if($widget->widget == Widget::Campaign)
         data-toggle="dialog"
         data-target="primary-dialog"
         data-url="{{ route('campaigns.dashboard-header.edit', ['campaign' => $campaign, 'campaignDashboardWidget' => $widget]) }}"
    @else
         data-toggle="dialog"
         data-target="primary-dialog"
         data-url="{{ route('campaign_dashboard_widgets.edit', [$campaign, $widget]) }}"
    @endif
    @if ($widget->widget == Widget::Campaign && $campaign->header_image)
         style="background-image: url('{{ Img::crop(1200, 400)->url($campaign->header_image) }}')"
    @endif
    >
        <div class="{{ $overlayClass }}">
            <div class="handle rounded px-2 py-1 top-1 left-1 text-center absolute w-10 border cursor-move background bg-box" data-toggle="tooltip" data-title="{{ __('dashboard.setup.reorder.helper') }}">
                <x-icon class="fa-solid fa-arrows" />
            </div>
            @if ($widget->widget != Widget::Header)
                <span class="truncate w-full px-12" >
                    <x-icon :class="$widget->widgetIcon()" tooltip title="{{ __('dashboard.setup.widgets.' . $widget->widget->value) }}" />
                    @if (!empty($widget->conf('text')))
                        {{ $widget->conf('text') }} ({{ __('dashboard.setup.widgets.' . $widget->widget->value) }})
                    @else
                        {{ __('dashboard.setup.widgets.' . $widget->widget->value) }}
                    @endif
                </span>
            @endif


            @if ($widget->entity)
                <div class="widget-entity flex items-center gap-2 w-full justify-center">
                    <div class="rounded-full entity-image flex-none" style="background-image: url('{!! $background !!}');"></div>
                    <div class="truncate text-md">
                        <a href="{{ $widget->entity->url() }}">
                            {!! $widget->entity->name !!}
                        </a>
                    </div>
                </div>
            @endif

            @if ($widget->widget == Widget::Header)
                @if (!empty($widget->conf('text')))
                    <span class="text-lg">{{ $widget->conf('text') }}</span>
                @endif
            @endif

            @if ($widget->widget == Widget::Unmentioned)
                @if (!empty($widget->conf('entity')))
                    <span class="text-sm">{{ __('entities.' . $widget->conf('entity')) }}</span>
                @endif
            @endif

            @if ($widget->widget == Widget::Recent)
                <p class="text-neutral-content text-sm">
                    <x-icon class="fa-solid fa-search" />
                @if (!empty($widget->conf('entity')))
                    {{ __($entityString) }}
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

            @if (!empty($widget->tags))
                <div class="flex flex-wrap gap-1 items-center justify-center tags">
                    @foreach ($widget->tags as $tag)
                        @include ('tags._badge')
                    @endforeach
                </div>
            @endif
        </div>
        <input type="hidden" name="widgets[]" value="{{ $widget->id }}" />
    </div>
</div>
