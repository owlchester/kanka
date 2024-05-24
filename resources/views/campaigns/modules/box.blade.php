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

@if (isset($boosted) && $boosted && !$campaign->boosted())
    <x-box css="box-warning flex flex-wrap flex-col" id="{{ $module }}">
        <div class="header p-2 bg-neutral text-neutral-content flex items-center gap-2">
            <i class="flex-0 text-lg {{ $icon }}" aria-hidden="true"></i>
            <span class="text-lg grow">
                {!! $moduleName !!}
            </span>
        </div>
        <div class="grow flex flex-wrap flex-col">
            <div class="body p-4 pb-2 grow">
                <p>{{ __('campaigns.settings.helpers.' . $module) }}</p>
            </div>
            <div class="box-footer checkbox text-center mt-auto">
                <i>{!! __('campaigns.settings.boosted', ['boosted' => link_to(\App\Facades\Domain::toFront('pricing'), __('concept.premium-campaigns'), '#premium')]) !!}</i>
            </div>
        </div>
    </x-box>
@else
    <x-box css="box-module overflow-hidden flex flex-wrap flex-col select-none {{ $enabled ? 'module-enabled' : null }} {{ isset($deprecated) ? 'box-deprecated' : null }} " id="{{ $module }}" :padding="false">
        <div class="header p-2 bg-neutral text-neutral-content flex items-center gap-2 ">
            <i class="flex-0 text-lg {{ $icon }}" aria-hidden="true"></i>
            <span class="text-lg grow break-all">
                {!! $moduleName !!}
            </span>
            @can('update', $campaign)
            @if (isset($id) && !isset($deprecated))
                <button
                    class="hover:shadow-sm text-xl transition-all hover:rotate-45 flex items-center"
                    data-toggle="dialog-ajax"
                    data-url="{{ route('modules.edit', [$campaign, $id]) }}"
                    data-target="rename-dialog"
                    title="{{ __('campaigns/modules.actions.customise') }}">
                        <span class="fill-current h-6 w-6 inline-block">
                            @include('icons.svg.cog')
                        </span>
                        <span class="sr-only">
                        {{ __('campaigns/modules.actions.customise') }}
                    </span>
                </button>
            @endif
            @endcan
        </div>
        <div class="grow flex flex-wrap flex-col">
            <div class="body p-4 grow flex flex-col gap-2">
                <p class="">
                    {{ __('campaigns.settings.helpers.' . $module) }}
                </p>
                @if (isset($deprecated))
                <div class="text-center text-sm">
                        <span data-toggle="tooltip" data-title="{{ __('campaigns.settings.deprecated.help') }}">
                            <i class="fa-solid fa-exclamation-triangle" aria-hidden="true"></i>
                            {{ __('campaigns.settings.deprecated.title') }}
                        </span>
                        <span class="md:hidden">{{ __('campaigns.settings.deprecated.help') }}</span>
                    </div>
                @endif
            </div>
            @can('update', $campaign)
            <div class="footer text-center my-4">
                <label class="toggle">
                    <input type="checkbox" name="enabled" data-url="{{ route('campaign.modules.toggle', [$campaign, 'module' => $module]) }}" @if ($enabled) checked="checked" @endif>
                    <span class="slider module-enabled"></span>
                    <span class="sr-only">Check to enable the {{ $module }} module</span>
                </label>
            </div>
            @endcan
        </div>
    </x-box>
@endif
