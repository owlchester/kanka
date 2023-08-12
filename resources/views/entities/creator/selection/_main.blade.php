@php
$name = __('entities.' . $singular);
if (isset($id)) {
    if ($campaign->hasModuleName($id)) {
        $name = $campaign->moduleName($id);
    }
    if ($campaign->hasModuleIcon($id)) {
        $icon = $campaign->moduleIcon($id);
    }
}
@endphp
<a href="#" class="p-2 quick-creator-selection flex overflow-hidden items-center" data-toggle="entity-creator" data-url="{{ route('entity-creator.form', [$campaign, 'type' => $plural]) }}" data-entity-type="{{ $singular }}">
    <i class="{{ $icon }} mr-2 text-sm"></i>
    <span class="overflow-hidden">{!! $name !!}</span>
</a>
