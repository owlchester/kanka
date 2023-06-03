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

<div class="grid gap-5 grid-cols-1 md:grid-cols-2 mb-4">
    <div class="form-group mb-0">
        <label>{{ __('crud.fields.type') }}</label>
        {!! Form::select('type', $entityTypes, FormCopy::field('type')->string(), ['class' => 'form-control']) !!}
    </div>
    <div class="form-group mb-0">
        <label>{{ __('menu_links.fields.filters') }}</label>
        {!! Form::text('filters', FormCopy::field('filters')->string(), ['placeholder' => __('menu_links.placeholders.filters'), 'class' => 'form-control', 'maxlength' => 191]) !!}
    </div>
    <div>
        {!! Form::hidden('options[is_nested]', 0) !!}
        <label>
            {!! Form::checkbox('options[is_nested]', 1, empty($model->options) ? false : $model->options['is_nested']) !!}
            {!! __('menu_links.fields.is_nested') !!}
        </label>
    </div>
</div>
