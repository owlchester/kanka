@if (!$campaign->enabled('tags'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->tag) {
    $preset = $model->tag;
} elseif (isset($parent) && $parent) {
    $preset = FormCopy::field('tag')->select(true, \App\Models\Tag::class);
} else {
    $preset = FormCopy::field('tag')->select();
}

$data = [
    'preset' => $preset,
    'class' => App\Models\Tag::class,
];
if (isset($enableNew)) {
    $data['allowNew'] = $enableNew;
}
if (isset($parent) && $parent) {
    $data['labelKey'] = 'tags.fields.tag';
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
        'tag_id',
        $data,
    ) !!}
</div>
