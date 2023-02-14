@if (isset($boosted) && $boosted && !$campaign->boosted())
    <div class="box mb-0 box-solid box-warning flex flex-wrap flex-col" id="{{ $module }}">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="{{ $icon }}"></i> {{ __('entities.' . $module) }}
            </h3>
        </div>
        <div class="box-body select-none">
            <p>{{ __('campaigns.settings.helpers.' . $module) }}</p>
        </div>
        <div class="box-footer checkbox text-center mt-auto">
            <i>{!! __('campaigns.settings.boosted', ['boosted' => link_to_route('front.pricing', __('crud.boosted_campaigns'), '#boost')]) !!}</i>
        </div>
    </div>
@else
    <div class="box box-module cursor-pointer box-solid flex flex-wrap flex-col select-none {{ $campaign->enabled($module) ? 'box-success' : 'box-default' }} {{ isset($deprecated) ? 'box-deprecated' : null }}" id="{{ $module }}" data-url="{{ route('modules.toggle', [$campaign, 'module' => $module]) }}">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="{{ $icon }}"></i> {{ __('entities.' . $module) }}
            </h3>
        </div>
        <div class="box-body">
            <p>{{ __('campaigns.settings.helpers.' . $module) }}</p>
            <div class="loading text-center py-5" style="display: none">
            <i class="fa-solid fa-spin fa-spinner fa-2x"></i>
            </div>
        </div>
        @if (isset($deprecated))
            <div class="box-footer text-center text-sm">
                <span data-toggle="tooltip" title="{{ __('campaigns.settings.deprecated.help') }}"><i class="fa-solid fa-exclamation-triangle"></i>
                    {{ __('campaigns.settings.deprecated.title') }}
                </span>
                <span class="visible-xs visible-sm">{{ __('campaigns.settings.deprecated.help') }}</span>
            </div>
        @endif
    </div>
@endif
