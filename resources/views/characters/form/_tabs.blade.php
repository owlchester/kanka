<?php /** @var \App\Models\EntityType $module */?>
<x-tab.tab target="traits" :title="__('characters.fields.traits')"></x-tab.tab>

@if ($campaign->enabled('organisations'))
    @php $module = \App\Models\EntityType::find(config('entities.ids.organisation')); @endphp
    <x-tab.tab target="organisations" :icon="$module->icon()" :title="$module->plural()"></x-tab.tab>
@endif
