@if (!$campaignService->enabled('races'))
    <?php return ?>
@endif

@php
$preset = null;
if (isset($model) && $model->race) {
    $preset = $model->race;
} elseif (isset($parent) && $parent) {
    $preset = FormCopy::field('race')->select(true, \App\Models\Race::class);
} else {
    $preset = FormCopy::field('race')->select();
}
if (!isset($source)) {
    $source = null;
}
@endphp
<input type="hidden" name="save_races" value="1">
<div class="form-group">
    @include('components.form.races', ['options' => [
        'model' => $model ?? FormCopy::model(),
        'source' => $source ?? null,
        'quickCreator' => $quickCreator ?? false,
        'modelClass' => \App\Models\Race::class
    ]])
</div>
