@inject('entityService', 'App\Services\EntityService')
<?php
$entityTypes = ['' => ''];
$entities = $entityService->campaign($campaign)->getEnabledEntitiesSorted(false);
$entityTypes = array_merge($entityTypes, $entities);
?>
<x-grid type="1/1">

    <x-helper>
        {!! __('menu_links.helpers.type', [
            'filter' => '<code>' . __('menu_links.fields.filters') . '</code>',
            '?' => '<code>?</code>',
        ]) !!}
    </x-helper>

    <x-grid>
        <x-forms.field field="type" :label="__('crud.fields.type')">
            {!! Form::select('type', $entityTypes, FormCopy::field('type')->string(), ['class' => '']) !!}
        </x-forms.field>

        <x-forms.field field="filters" :label="__('menu_links.fields.filters')">
            {!! Form::text('filters', FormCopy::field('filters')->string(), ['placeholder' => __('menu_links.placeholders.filters'), 'class' => '', 'maxlength' => 191]) !!}
        </x-forms.field>
        <x-forms.field field="nested" :label="__('menu_links.fields.is_nested')">
            {!! Form::hidden('options[is_nested]', 0) !!}
            <label class="text-neutral-content cursor-pointer flex gap-2">
                {!! Form::checkbox('options[is_nested]', 1, empty($model->options) ? false : $model->options['is_nested']) !!}
                <span>{!! __('menu_links.fields.is_nested') !!}</span>
            </label>
        </x-forms.field>
    </x-grid>
</x-grid>
