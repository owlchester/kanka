@inject('entityService', 'App\Services\EntityService')
<?php
$entityTypes = ['' => ''];
$entities = $entityService->campaign($campaignService->campaign())->getEnabledEntitiesSorted(false);
$entityTypes = array_merge($entityTypes, $entities);
?>
<p class="help-block">{!! __('menu_links.helpers.type', [
    'filter' => '<code>' . __('menu_links.fields.filters') . '</code>',
    '?' => '<code>?</code>',
]) !!}</p>

<x-grid>
    <div class="field-typer">
        <label>{{ __('crud.fields.type') }}</label>
        {!! Form::select('type', $entityTypes, FormCopy::field('type')->string(), ['class' => 'form-control']) !!}
    </div>
    <div class="field-filters">
        <label>{{ __('menu_links.fields.filters') }}</label>
        {!! Form::text('filters', FormCopy::field('filters')->string(), ['placeholder' => __('menu_links.placeholders.filters'), 'class' => 'form-control', 'maxlength' => 191]) !!}
    </div>
    <div class="field-nested checkbox">
        {!! Form::hidden('options[is_nested]', 0) !!}
        <label>
            {!! Form::checkbox('options[is_nested]', 1, empty($model->options) ? false : $model->options['is_nested']) !!}
            {!! __('menu_links.fields.is_nested') !!}
        </label>
    </div>
</x-grid>
