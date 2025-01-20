@php
    /**
     * @var \App\Models\Campaign $campaign
     */
@endphp

<div
    class="rounded w-full hover:border-primary text-primary justify-center text-center flex items-center transition-all duration-150 border-dashed border-2 py-6 cursor-pointer"
    data-toggle="dialog-ajax"
    data-url="{{ route('entity_types.create', [$campaign]) }}"
    data-target="primary-dialog"
    title="{{ __('campaigns/modules.actions.customise') }}">
    <div class="flex flex-wrap items-center gap-2">
        @can('update', $campaign)
            <x-icon class="plus" />
            {{ __('campaigns/modules.actions.create') }}
        @endcan
    </div>
</div>
