@inject('typeService', 'App\Services\Entity\TypeService')
@php
$entityTypes = $typeService->campaign($campaign)->plural()->permissionless()->exclude(['bookmark'])->singularKey()->add(['' => ''])->get();
@endphp
<x-grid type="1/1">

    <x-helper>
        {!! __('bookmarks.helpers.type', [
            'filter' => '<code>' . __('bookmarks.fields.filters') . '</code>',
            '?' => '<code>?</code>',
        ]) !!}
    </x-helper>

    <x-grid>
        <x-forms.field field="type" :label="__('crud.fields.type')">
            {!! Form::select('type', $entityTypes, FormCopy::field('type')->string(), ['class' => '']) !!}
        </x-forms.field>

        <x-forms.field field="filters" :label="__('bookmarks.fields.filters')">
            {!! Form::text('filters', FormCopy::field('filters')->string(), ['placeholder' => __('bookmarks.placeholders.filters'), 'class' => '', 'maxlength' => 191]) !!}
        </x-forms.field>

{{--        <x-forms.field field="nested" :label="__('bookmarks.fields.is_nested')">--}}
{{--            {!! Form::hidden('options[is_nested]', 0) !!}--}}
{{--            <x-checkbox :text="__('bookmarks.fields.is_nested')">--}}
{{--                {!! Form::checkbox('options[is_nested]', 1, empty($model->options) ? false : $model->options['is_nested']) !!}--}}
{{--            </x-checkbox>--}}
{{--        </x-forms.field>--}}
    </x-grid>
</x-grid>
