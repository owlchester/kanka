@php
$moduleName = __('entities.' . $module);
if (isset($id) && $campaign->superboosted() && $campaign->hasModuleName($id, true)) {
    $moduleName = $campaign->moduleName($id, true);
}
if (isset($id) && $campaign->superboosted() && $campaign->hasModuleIcon($id)) {
    $icon = $campaign->moduleIcon($id);
}
$enabled = $campaign->enabled($module);
@endphp
<x-box class="box-module overflow-hidden flex flex-wrap flex-col select-none {{ $enabled ? 'module-enabled' : null }} {{ isset($deprecated) ? 'box-deprecated' : null }} " id="{{ $module }}" :padding="false">
    <div class="header p-2 bg-neutral text-neutral-content flex items-center gap-2 transition-all duration-300">
        <x-icon class="flex-0 text-lg {{ $icon }}" />
        <span class="text-lg grow break-all">
            {!! $moduleName !!}
        </span>
    </div>
    <div class="grow flex flex-wrap flex-col">
        <div class="body p-4 grow flex flex-col gap-2">
            <p class="">
                {{ __('campaigns.settings.helpers.' . $module) }}
            </p>
        </div>
        @can('update', $campaign)
        <div class="footer text-center my-4">
            <label class="toggle">
                <input type="checkbox" id="toggle_{{ $module }}" name="enabled" data-url="{{ route('campaign.features.toggle', [$campaign, 'module' => $module]) }}" @if ($enabled) checked="checked" @endif>
                <span class="slider module-enabled"></span>
                <span class="sr-only">Check to enable the {{ $module }} module</span>
            </label>
            <div class="action-loading hidden">
                <x-icon class="load" />
            </div>
        </div>
        @endcan
    </div>
</x-box>
