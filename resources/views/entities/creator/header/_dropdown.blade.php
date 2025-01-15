@php
@endphp

@if ($dropdownEntityType == $entityType)
    <x-dropdowns.item
        css="disabled"
        link="#"
        icon="check">
        {!! $trans !!}
    </x-dropdowns.item>
@else
    @php $data = [
         'toggle' => 'entity-creator',
         'url' => route('entity-creator.form', [$campaign, 'entity_type' => $dropdownEntityType, 'mode' => $mode ?? null]),
         'entity-type' => 'entity',
         'type' => 'inline',
    ]; @endphp
    <x-dropdowns.item
        link="#"
        :data="$data"
        icon="fa-solid">
        @if ($dropdownEntityType instanceof \App\Models\EntityType)
        {!! $dropdownEntityType->name() !!}
        @else
        {{ __('entities.post') }}
        @endif
    </x-dropdowns.item>
@endif
