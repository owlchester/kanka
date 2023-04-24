@if ((isset($campaign) && !$campaign->enabled('characters')) || (isset($campaignService) && !$campaignService->enabled('characters')))
    @php return @endphp
@endif

@php
$preset = null;
if (isset($model) && $model->character) {
    $preset = $model->character;
} else {
    $preset = FormCopy::field('character')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Character::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'characters.fields.character';
}
if (isset($labelKey)) {
    $data['labelKey'] = __($labelKey);
}
if (isset($dropdownParent)) {
    $data['dropdownParent'] = $dropdownParent;
} elseif (request()->ajax()) {
    $data['dropdownParent'] = '#entity-modal';
}
if (isset($from)) {
    $data['from'] = $from;
}
if (isset($quickCreator)) {
    $data['quickCreator'] = $quickCreator;
}
@endphp
<div class="form-group">
    {!! Form::foreignSelect(
        'character_id',
        $data
    ) !!}
</div>
