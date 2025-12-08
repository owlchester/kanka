@php
    /**
     * @var \App\Models\EntityType $entityType
     * @var \App\Models\Campaign $campaign
     */
@endphp

<x-box class="hidden box-module overflow-hidden flex flex-wrap flex-col select-none {{ $entityType->isEnabled() ? 'module-enabled' : null }} " id="{{ $entityType->code }}" :padding="false">
    <div class="header p-2 bg-neutral text-neutral-content flex items-center gap-2 transition-all duration-300">
        <x-icon class="flex-0 text-lg {{ $entityType->icon() }}" />
        <span class="text-lg grow break-all">
            {!! $entityType->plural() !!}
        </span>
        @can('update', $campaign)
            <button
                class="hover:shadow-sm text-xl transition-all hover:rotate-45 flex items-center"
                data-toggle="dialog"
                data-url="{{ route('entity_types.edit', [$campaign, $entityType]) }}"
                data-target="rename-dialog"
                title="{{ __('campaigns/modules.actions.customise') }}">
                    <span class="fill-current h-6 w-6 inline-block">
                        @include('icons.svg.cog')
                    </span>
                    <span class="sr-only">
                    {{ __('campaigns/modules.actions.customise') }}
                </span>
            </button>
        @endcan
    </div>
    <div class="grow flex flex-wrap flex-col">
        <div class="body p-4 grow flex flex-col gap-2">
            <p class="text-break">
                {{ __('campaigns/modules.helpers.custom') }}
            </p>
        </div>
        @can('update', $campaign)
        <div class="footer text-center my-4">
            <label class="toggle">
                <input type="checkbox" id="toggle_{{ $entityType->code }}" name="enabled" data-url="{{ route('entity_types.toggle', [$campaign, $entityType]) }}" @if ($entityType->isEnabled()) checked="checked" @endif>
                <span class="slider module-enabled"></span>
                <span class="sr-only">Check to enable the {{ $entityType->name() }} module</span>
            </label>
            <div class="action-loading hidden">
                <x-icon class="load" />
            </div>
        </div>
        @endcan
    </div>
</x-box>
