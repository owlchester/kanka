<?php /** @var \App\Models\Calendar $model */?>
<x-grid type="1/1">

    <x-forms.field field="months" :required="true" :label="__('calendars.fields.months')" :helper="__('calendars.hints.months')">
        <input type="hidden" name="month_name" />
    </x-forms.field>

    <button class="btn2 btn-sm dynamic-row-add" data-template="template_month" data-target="calendar-months" title="{{ __('calendars.actions.add_month') }}">
        <x-icon class="plus"></x-icon> {{ __('calendars.actions.add_month') }}
    </button>

    <?php
    $months = [];
    $names = old('month_name');
    $lengths = old('month_length');
    $aliases = old('month_alias');
    $types = old('month_type');
    if (!empty($names)) {
        $cpt = 0;
        foreach ($names as $name) {
            if (!empty($name) || !empty($lengths[$cpt])) {
                $months[] = [
                    'name' => $name,
                    'length' => $lengths[$cpt],
                    'alias' => $aliases[$cpt],
                    'type' => $types[$cpt],
                ];
            }
            $cpt++;
        }
    } elseif (isset($model)) {
        $months = $model->months();
    } elseif (isset($source)) {
        $months = $source->months();
    }?>
    <div class="flex flex-col gap-2 calendar-months sortable-elements" data-handle=".sortable-handler">
        <div class="grid gap-2 grid-cols-2 md:grid-cols-4 md:gap-4">
            <div class="">{{ __('calendars.parameters.month.name') }}</div>
            <div class="">{{ __('calendars.parameters.month.length') }}</div>
            <div class="">{{ __('calendars.parameters.month.alias') }}</div>
            <div class="">{{ __('calendars.parameters.month.type') }} <i class="fa-solid fa-question-circle" data-toggle="tooltip" data-title="{{ __('calendars.helpers.month_type') }}"></i></div>
        </div>
        @foreach ($months as $month)
            <div class="parent-delete-row">
                <div class="grid gap-2 grid-cols-2 md:grid-cols-4 md:gap-4">
                    <div class="flex items-center gap-2">
                        <div class="sortable-handler p-2 cursor-move">
                            <x-icon class="fa-solid fa-grip-vertical" />
                        </div>
                        <div class="field">
                            <label class="sr-only">{{ __('calendars.parameters.month.name') }}</label>
                            {!! Form::text('month_name[]', $month['name'], ['class' => 'w-full']) !!}
                        </div>
                    </div>

                    <div class="field">
                        <label class="sr-only">{{ __('calendars.parameters.month.length') }}</label>
                        {!! Form::number('month_length[]', $month['length'], [
                            'class' => 'w-full',
                            'maxlength' => 4,
                            'aria-label' => __('calendars.parameters.month.length'),
                        ]) !!}
                    </div>

                    <div class="field">
                        <label class="sr-only">{{ __('calendars.parameters.month.alias') }}</label>
                        {!! Form::text('month_alias[]', \Illuminate\Support\Arr::get($month, 'alias', ''), [
                            'class' => 'w-full',
                            'maxlength' => 191,
                            'placeholder' => __('calendars.parameters.month.alias'),
                            'aria-label' => __('calendars.parameters.month.name'),
                        ]) !!}
                    </div>

                    <div class="flex items-center gap-2">
                        <div class="field">
                            <label class="sr-only">{{ __('calendars.parameters.month.type') }}</label>
                            {!! Form::select('month_type[]', __('calendars.month_types'), (!empty($month['type']) ? $month['type'] : 'standard'), [
                                'class' => 'w-full',
                                'aria-label' => __('calendars.parameters.month.type'),
                            ]) !!}
                        </div>
                        <div>
                            <span class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" data-remove="4" title="{{ __('crud.remove') }}">
                                <x-icon class="trash"></x-icon>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</x-grid>
@section('modals')
    @parent
<template id="template_month">
    <div class="parent-delete-row">
        <div class="grid gap-2 grid-cols-2 md:grid-cols-4 md:gap-4">
            <div class="flex gap-2 items-center">
                <div class="sortable-handler p-2 cursor-move">
                    <x-icon class="fa-solid fa-grip-vertical" />
                </div>
                <div class="field">
                    <label class="sr-only">{{ __('calendars.parameters.month.name') }}</label>
                    {!! Form::text('month_name[]', null, [
                        'class' => 'w-full',
                        'placeholder' => __('calendars.parameters.month.name'),
                        'aria-label' => __('calendars.parameters.month.name'),
                    ]) !!}
                </div>
            </div>
            <div class="field">
                <label class="sr-only">{{ __('calendars.parameters.month.length') }}</label>
                {!! Form::number('month_length[]', null, ['class' => 'w-full', 'placeholder' => __('calendars.parameters.month.length'),
                        'aria-label' => __('calendars.parameters.month.length'),]) !!}
            </div>
            <div class="field">
                <label class="sr-only">{{ __('calendars.parameters.month.alias') }}</label>
                {!! Form::text('month_alias[]', null, ['class' => 'w-full', 'placeholder' => __('calendars.parameters.month.alias'),
                        'aria-label' => __('calendars.parameters.month.alias'),]) !!}
            </div>
            <div class="flex gap-2 items-center">
                <div class="field">
                    <label class="sr-only">{{ __('calendars.parameters.month.type') }}</label>
                    {!! Form::select('month_type[]', __('calendars.month_types'), 'standard', ['class' => 'w-full',
                        'aria-label' => __('calendars.parameters.month.type'),]) !!}
                </div>
                <div class="">
                    <span class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" data-remove="4" title="{{ __('crud.remove') }}">
                        <x-icon class="trash"></x-icon>
                    </span>
                </div>
            </div>
        </div>
    </div>
</template>
@endsection
