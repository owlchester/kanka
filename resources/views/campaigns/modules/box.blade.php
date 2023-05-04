@php
$moduleName = __('entities.' . $module);
if (isset($id) && $campaign->superboosted() && $campaign->hasModuleName($id, true)) {
    $moduleName = $campaign->moduleName($id, true);
}
if (isset($id) && $campaign->superboosted() && $campaign->hasModuleIcon($id)) {
    $icon = $campaign->moduleIcon($id);
}
@endphp

@if (isset($boosted) && $boosted && !$campaign->boosted())
    <div class="rounded p-4 shadow-xs bg-box mb-0 box-warning flex flex-wrap flex-col" id="{{ $module }}">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="{{ $icon }}" aria-hidden="true"></i>
                {!! $moduleName !!}
            </h3>
        </div>
        <div class="box-body select-none">
            <p>{{ __('campaigns.settings.helpers.' . $module) }}</p>
        </div>
        <div class="box-footer checkbox text-center mt-auto">
            <i>{!! __('campaigns.settings.boosted', ['boosted' => link_to_route('front.pricing', __('concept.premium-campaigns'), '#premium')]) !!}</i>
        </div>
    </div>
@else
    <div class="box-module w-full rounded overflow-hidden shadow-xs bg-box flex flex-wrap flex-col select-none {{ $campaign->enabled($module) ? 'module-enabled' : null }} {{ isset($deprecated) ? 'box-deprecated' : null }} hover:shadow-md" id="{{ $module }}">
        <div class="header p-2 bg-gray-200 flex items-center gap-2">
            <h3 class="text-lg m-0 grow">
                <i class="{{ $icon }}" aria-hidden="true"></i>
                {!! $moduleName !!}
            </h3>
            @if (isset($id) && !isset($deprecated))
                <a href="#"
                   class="btn btn-sm btn-default"
                   data-toggle="dialog-ajax"
                   data-url="{{ route('modules.edit', [$id]) }}"
                   data-target="rename-dialog">
                    <i class="fa-solid fa-pencil" aria-hidden="true"></i>
                    Customise
                </a>
            @endif
        </div>
        <div class="grow flex flex-wrap flex-col">

            <div class="body p-4 pb-2 grow"  >
                <p class="mb-0">
                    {{ __('campaigns.settings.helpers.' . $module) }}
                </p>
                @if (isset($deprecated))
                <div class="text-center text-sm mt-2">
                        <span data-toggle="tooltip" title="{{ __('campaigns.settings.deprecated.help') }}">
                            <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ __('campaigns.settings.deprecated.title') }}
                        </span>
                        <span class="visible-xs visible-sm">{{ __('campaigns.settings.deprecated.help') }}</span>
                    </div>
                @endif
            </div>
            <div class="footer p-4 pt-2"  data-url="{{ route('campaign.modules.toggle', ['module' => $module]) }}">
                <div class="module-actions text-center">
                    <div class="btn-toggle btn-module-enable btn btn-default btn-block mb-0" data-url="{{ route('campaign.modules.toggle', ['module' => $module]) }}">
                        {{ __('campaigns/modules.states.enable') }}
                    </div>
                    <div class="btn-toggle btn-module-disable btn btn-default btn-block mb-0"  data-url="{{ route('campaign.modules.toggle', ['module' => $module]) }}">
                        {{ __('campaigns/modules.states.disable') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
