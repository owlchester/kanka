@php
/**
 * @var \App\Models\EntityType $entityType
 * @var \App\Models\Campaign $campaign
 */
$enabled = $campaign->enabled($entityType);
@endphp

<div class="w-full bg-base-100 p-4 rounded-xl hover:shadow-xs flex flex-col gap-2 ">
    <div class="flex justify-between items-center gap-2">
        <div class="flex gap-1 items-center text-lg">
            @if ($enabled)
                <x-icon class="fa-regular fa-check-circle text-green-500" tooltip title="{{ __('campaigns/modules.states.enabled') }}" ></x-icon>
            @else
                <x-icon class="fa-regular fa-times text-red-500" tooltip title="{{ __('campaigns/modules.states.disabled') }}" ></x-icon>
            @endif
            <span class="break-all">
                {!! $entityType->plural() !!}
            </span>
        </div>
        <div class="flex gap-1 items-center">
        @can('update', $campaign)
            <button
                class="btn2 btn-default btn-sm"
                data-toggle="dialog"
                data-url="{{ route('modules.edit', [$campaign, $entityType]) }}"
                data-target="rename-dialog"
                title="{{ __('campaigns/modules.actions.customise') }}">
                <span class="fill-current h-6 w-6 inline-block">
                    @include('icons.svg.cog')
                </span>
                {{ __('crud.edit') }}
            </button>
        @endcan
        </div>
    </div>


    @if ($entityType->isDeprecated())
        <div class="text-xs">
            <span data-toggle="tooltip" data-title="{{ __('campaigns.settings.deprecated.help') }}">
                <x-icon class="fa-regular fa-exclamation-triangle" />
                {{ __('campaigns.settings.deprecated.title') }}
            </span>
            <span class="md:hidden">{{ __('campaigns.settings.deprecated.help') }}</span>
        </div>
    @endif

    <p class="text-neutral-content text-sm text-break">
        {{ __('campaigns.settings.helpers.' . $entityType->pluralCode()) }}
    </p>
</div>

<x-box class="hidden box-module overflow-hidden flex flex-wrap flex-col select-none {{ $enabled ? 'module-enabled' : null }} {{ isset($deprecated) ? 'box-deprecated' : null }} " id="{{ $entityType->code }}" :padding="false">
    <div class="header p-2 bg-neutral text-neutral-content flex items-center gap-2 transition-all duration-300">
        <x-icon class="flex-0 text-lg {{ $entityType->icon() }}" />
        <span class="text-lg grow break-all">
            {!! $entityType->plural() !!}
        </span>

    </div>
    <div class="grow flex flex-wrap flex-col">
        <div class="body p-4 grow flex flex-col gap-2">

        </div>
    </div>
</x-box>
