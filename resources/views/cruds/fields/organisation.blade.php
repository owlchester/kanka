@if (!$campaign->enabled('organisations'))
    <?php return ?>
@endif

@php

$preset = null;
if (isset($model) && $model->organisation) {
    $preset = $model->organisation;
} else {
    $preset = FormCopy::field('organisation')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Organisation::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'organisations.fields.organisation';
}
if (isset($dropdownParent)) {
    $data['dropdownParent'] = $dropdownParent;
}
if (isset($from)) {
    $data['from'] = $from;
}

@endphp
<div class="form-group">
    {!! Form::foreignSelect(
        'organisation_id',
        $data,
    ) !!}
</div>
