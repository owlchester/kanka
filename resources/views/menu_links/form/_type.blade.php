@inject('entityService', 'App\Services\EntityService')
<?php
$entityTypes = ['' => ''];
foreach ($entityService->getEnabledEntities($campaign->campaign()) as $entity) {
    $entityTypes[$entity] = __('entities.' . \Illuminate\Support\Str::plural($entity));
}
?>
<p class="help-block">{!! __('menu_links.helpers.type', [
    'filter' => '<code>' . __('menu_links.fields.filters') . '</code>',
    '?' => '<code>?</code>'
]) !!}</p>

<div class="form-group">
    <label>{{ __('menu_links.fields.type') }}</label>
    {!! Form::select('type', $entityTypes, FormCopy::field('type')->string(), ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    <label>{{ __('menu_links.fields.filters') }}</label>
    {!! Form::text('filters', FormCopy::field('filters')->string(), ['placeholder' => __('menu_links.placeholders.filters'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>
