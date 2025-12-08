@php
    /**
     * @var \App\Models\Campaign $campaign
     */
@endphp

<a
    class="btn2 btn-primary btn-sm"
    data-toggle="dialog"
    data-url="{{ route('entity_types.create', [$campaign]) }}"
    title="{{ __('campaigns/modules.actions.new') }}">
    <x-icon class="plus" />
    {{ __('crud.create') }}
</a>
