@inject('moduleService', 'App\Services\Campaign\ModuleService')
<?php /** @var \App\Models\CampaignDashboardWidget $widget */
use Illuminate\Support\Str;
use App\Enums\Widget;

$background = null;

if ($widget->entity) {
    if (!empty($widget->entity->image_path)) {
        $background = $widget->entity->thumbnail(600, 600, 'image_path');
    } elseif (!empty($widget->entity->image)) {
        $background = Img::crop(600, 600)->url($widget->entity->image->path);
    }
}
if (!empty($widget->conf('entity'))) {
    $entityString = $moduleService->plural($widget->conf('entity'), 'entities.' . Str::plural($widget->conf('entity')));
}
?>


<div class="col-span-{{ $widget->colSize() }}">
    <div class="{{ $widgetClass }} cursor-pointer {{ !empty($background) ? 'p-5' : null }} widget-{{ $widget->widget->value }} cover-background {{ $widget->widget ===  Widget::Header ? 'h-auto' : null }}"
    @if($widget->widget == Widget::Campaign)
         data-toggle="dialog"
         data-target="primary-dialog"
         data-url="{{ route('campaigns.dashboard-header.edit', ['campaign' => $campaign, 'campaignDashboardWidget' => $widget]) }}"
    @else
         data-toggle="dialog"
         data-target="primary-dialog"
         data-url="{{ route('campaign_dashboard_widgets.edit', [$campaign, $widget]) }}"
    @endif
    @if (!empty($background))
         style="background-image: url('{{ $background }}')"
    @elseif ($widget->widget == Widget::Campaign && $campaign->header_image)
         style="background-image: url('{{ Img::crop(1200, 400)->url($campaign->header_image) }}')"
    @endif
    >
        <div class="{{ $overlayClass }}">
            <div class="handle rounded px-2 py-1 top-1 left-1 text-center absolute w-10 border cursor-move background bg-box">
                <i class="fa-solid fa-arrows" aria-hidden="true"></i>
            </div>
            @if ($widget->widget != Widget::Header)
                <span class="block text-2xl">
                    <x-icon :class="$widget->widgetIcon()" />
                    {{ __('dashboard.setup.widgets.' . $widget->widget->value) }}
                </span>
            @endif

            @if ($widget->entity)
                <div class="widget-entity">
                    <a href="{{ $widget->entity->url() }}">{!! $widget->entity->name !!}</a>
                </div>
            @endif

            @if ($widget->widget == Widget::Header)
                @if (!empty($widget->conf('text')))
                    <h3 class="">{{ $widget->conf('text') }}</h3>
                @endif
            @elseif (!empty($widget->conf('text')))
                <span class="text-xs" title="{{ __('dashboard.widgets.fields.name') }}">
                    <i class="fa-solid fa-paragraph" aria-hidden="true"></i> {{ $widget->conf('text') }}
                </span>
            @endif


            @if ($widget->widget == Widget::UNMENTIONED)
                @if (!empty($widget->conf('entity')))
                    <h5>{{ __('entities.' . $widget->conf('entity')) }}</h5>
                @endif
            @endif

            @if ($widget->widget == Widget::Recent)
                @if (!empty($widget->conf('entity')))
                    <h5>{{ __($entityString) }}</h5>
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
