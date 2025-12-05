<?php /**
 * @var \App\Models\EntityType $entityType
 * @var \App\Models\Campaign $campaign
 */
?>
<div class="module module-{{ $entityType->isStandard() ? 'standard' : 'custom'}} w-full @if ($enabled) bg-base-100 @else bg-base-200 @endif p-4 rounded-xl hover:shadow-xs flex flex-col gap-3 ">
    <div class="flex justify-between items-center gap-2">
        <div class="flex gap-2 items-center text-lg">
            @if ($enabled)
                <x-icon class="fa-regular fa-check-circle text-green-500" tooltip title="{{ __('campaigns/modules.states.enabled') }}" ></x-icon>
            @else
                <x-icon class="fa-regular fa-times text-red-500 text-xl" tooltip title="{{ __('campaigns/modules.states.disabled') }}" ></x-icon>
            @endif
            @if ($image)
                <div class="w-6 h-6 rounded-full bg-cover bg-center overflow-hidden">
                    <div class="w-full h-full bg-cover bg-center transition-transform duration-300 hover:scale-125
" style="background-image: url('{{ $image }}')"></div>
                </div>
            @else
                <i class="{!! $entityType->icon() !!} @if (!$enabled) opacity-60 @endif" aria-hidden="true"></i>
            @endif
            <span class="break-all @if (!$enabled) text-neutral-content @endif">
                {!! $entityType->plural() !!}
            </span>
        </div>
        <div class="flex gap-1 items-center">
            @can('update', $campaign)
                <button
                    class="btn2 btn-default btn-xs"
                    data-toggle="dialog"
                    @if ($entityType->isStandard())
                    data-url="{{ route('modules.edit', [$campaign, $entityType]) }}"
                    @else
                    data-url="{{ route('entity_types.edit', [$campaign, $entityType]) }}"
                    @endif
                    data-target="rename-dialog"
                    title="{{ __('campaigns/modules.actions.customise') }}">
                    <x-icon class="cog"></x-icon>
                    {{ __('crud.edit') }}
                </button>
            @endcan
        </div>
    </div>


    @if ($entityType->isDeprecated())
        <div class="rounded-xl border border-base-300 px-2 py-0.5 bg-base-300" data-toggle="tooltip" data-title="{{ __('campaigns.settings.deprecated.help') }}">
            <span >
                ⚠️
                {{ __('campaigns.settings.deprecated.title') }}
            </span>
            <span class="md:hidden">{{ __('campaigns.settings.deprecated.help') }}</span>
        </div>
    @endif

    <p class="text-neutral-content text-xs text-break">
        @if ($entityType->isStandard())
            {{ __('campaigns.settings.helpers.' . $entityType->pluralCode()) }}
        @else
            {{ __('crud.history.created_date_clean', ['date' => $entityType->created_at->diffForHumans()]) }}.
        @endif
    </p>
</div>
