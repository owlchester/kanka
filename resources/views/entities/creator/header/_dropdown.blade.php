@php
$entityTypeKey = 'entities.ids.' . $trans;
$id = config('entities.ids.' . \Illuminate\Support\Str::singular($dropType));
if (!empty($id)) {
    if ($campaign->hasModuleName($id)) {
        $trans = $campaign->moduleName($id);
    }
}

@endphp

<li class="@if ($dropType == $type) disabled @endif">
    @if ($dropType == $type)
        <a href="#">
            <i class="fa-solid fa-check" aria-hidden="true"></i>
            {!! $trans !!}
        </a>
    @else
    <a href="#" class="" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', ['type' => $dropType, 'mode' => $mode ?? null]) }}" data-entity-type="character" data-type="inline">
        <i class="fa-solid" aria-hidden="true"></i>
        {!! $trans !!}
    </a>
    @endif
</li>
