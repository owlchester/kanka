@php
$name = __('entities.' . $singular);
if (isset($id)) {
    if ($campaign->hasModuleName($id)) {
        $name = $campaign->moduleName($id);
    }
    $icon = \App\Facades\Module::duoIcon($singular);
}
@endphp
<a href="#" class="p-2 quick-creator-selection flex gap-2 overflow-hidden items-center" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', [$campaign, 'type' => $plural]) }}" data-entity-type="{{ $singular }}">
    <x-icon class="{{ $icon }}" />
    <span class="overflow-hidden">{!! $name !!}</span>
</a>
