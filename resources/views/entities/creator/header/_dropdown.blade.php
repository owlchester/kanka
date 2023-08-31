@php
$entityTypeKey = 'entities.ids.' . $trans;
$id = config('entities.ids.' . \Illuminate\Support\Str::singular($dropType));
if (!empty($id)) {
    if ($campaign->hasModuleName($id)) {
        $trans = $campaign->moduleName($id);
    }
}

@endphp

@if ($dropType == $type)
    <x-dropdowns.item
        css="disabled"
        link="#"
        icon="check">
        {!! $trans !!}
    </x-dropdowns.item>
@else

@endif
@php $data = [
     'toggle' => 'entity-creator',
     'url' => route('entity-creator.form', [$campaign, 'type' => $dropType, 'mode' => $mode ?? null]),
     'entity-type' => 'entity',
     'type' => 'inline',
]; @endphp
<x-dropdowns.item
    link="#"
    :data="$data"
    icon="fa-solid">
{!! $trans !!}
</x-dropdowns.item>
