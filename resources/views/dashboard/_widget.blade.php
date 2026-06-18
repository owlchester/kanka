<?php /** @var \App\Models\CampaignDashboardWidget $widget */
use App\Enums\Widget;
?>


<div class="col-span-{{ $widget->colSize() }}">
    <div class="{{ $widgetClass }} cursor-pointer widget-{{ $widget->widget->value }} cover-background has-[.handle:hover]:ring-2 has-[.handle:hover]:ring-primary rounded-xl"
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
        <div class="rounded-xl bg-box flex items-center gap-3 justify-between p-4">
            <div class="flex-none text-neutral-content handle cursor-move" data-toggle="tooltip" data-title="{{ __('dashboard.setup.reorder.helper') }}">
                <x-icon class="fa-solid fa-grip-vertical" />
            </div>
            <div class="flex-none">
                <div class="rounded-lg flex items-center justify-center w-10 h-10 text-lg {{ $widget->setupClass() }}" tooltip title="{{ __('dashboards/widgets/' . $widget->widget->value . '.name') }}">
                <x-icon :class="$widget->widgetIcon()"  />
                </div>
            </div>

            <div class="flex flex-col gap-1 grow">
                <div class="flex gap-2 items-center w-full ">
                    <div class="truncate font-medium">

                        @if (!empty($widget->conf('text')))
                            {{ $widget->conf('text') }}
                        @else
                            {{ __('dashboards/widgets/' . $widget->widget->value . '.name') }}
                        @endif
                    </div>
                    <div class="rounded  px-2 py-0.5 {{ $widget->setupClass() }} text-xs font-medium uppercase">
                        {{ __('dashboards/widgets/' . $widget->widget->value . '.tag') }}
                    </div>
                </div>

                <div class="flex items-center overflow-hidden gap-2">
                    @if ($widget->entity)
                        <a href="{{  route('entities.show', [$campaign, $widget->entity]) }}" class="truncate text-xs bg-base-200 px-2 py-1 rounded text-neutral-content">
                            {!! $widget->entity->name !!}
                        </a>
                    @endif

                    @if (in_array($widget->widget, [Widget::Recent, Widget::Random]))
                        <div class="rounded bg-base-200 text-neutral-content px-2 py-1 text-xs">
                            <x-icon class="fa-regular fa-search" />
                        @if ($widget->entityType)
                            {!! $widget->entityType->plural() !!}
                        @elseif (!empty($widget->conf('singular')))
                            {{ __('dashboard.widgets.recent.singular') }}
                        @else
                            {{ __('dashboard.widgets.recent.all-entities') }}
                        @endif
                        </div>

                        @if (!empty($widget->conf('filters')))
                            <div class="rounded bg-base-200 text-neutral-content px-2 py-1 text-xs truncate">
                                <x-icon class="fa-regular fa-filter" tooltip title="{{ $widget->conf('filters') }}" />
                                {{ $widget->conf('filters') }}
                            </div>
                        @endif
                    @endif
                @if ($widget->widget === Widget::Gallery && !empty($widget->conf('folder_id')))
                    @php $galleryFolder = \App\Models\Image::find($widget->conf('folder_id')); @endphp
                    @if ($galleryFolder)
                        <p class="text-neutral-content text-sm">
                            <x-icon class="fa-regular fa-folder" />
                            {{ $galleryFolder->name }}
                        </p>
                    @endif
                @endif

                @if ($widget->tags->isNotEmpty())
                    <div class="flex flex-wrap gap-1 items-center tags">
                        @foreach ($widget->tags as $tag)
                            @include ('tags._badge')
                        @endforeach
                    </div>
                @endif

                </div>

                @if ($widget->widget === Widget::Campaign)
                    <p class="text-neutral-content text-xs italic">
                        {{ __('dashboards/widgets/campaign.tagline')}}
                    </p>
                @elseif ($widget->widget === Widget::Header)
                    <p class="text-neutral-content text-xs italic">
                        {{ __('dashboards/widgets/header.tagline')}}
                    </p>
                @elseif ($widget->widget === Widget::Onboarding)
                    <p class="text-neutral-content text-xs italic">
                        {{ __('dashboards/widgets/onboarding.tagline')}}
                    </p>
                @endif
            </div>
            <div class="rounded bg-base-200 px-2 py-0.5 text-neutral-content text-xs">
                {{ __('dashboard.widgets.widths.' . $widget->colSize())}}
            </div>
        </div>
        <input type="hidden" name="widgets[]" value="{{ $widget->id }}" />
    </div>
</div>
