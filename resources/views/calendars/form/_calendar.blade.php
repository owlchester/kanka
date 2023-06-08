<?php /** @var \App\Models\Calendar $model */?>
<x-grid>
    <div class="flex gap-5 flex-col">
        <div class="field-skip-zero checkbox">
            {!! Form::hidden('skip_year_zero', 0) !!}
            <label>
                {!! Form::checkbox('skip_year_zero', 1, !empty($model) ? $model->skip_year_zero : 0) !!}
                {{ __('calendars.fields.skip_year_zero') }}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" aria-hidden="true" title="{{ __('calendars.hints.skip_year_zero') }}" data-toggle="tooltip"></i>
            </label>
            <p class="help-block visible-xs visible-sm">{{ __('calendars.hints.skip_year_zero') }}</p>
        </div>

        <div class="field-start-offset">
            <label>
                {{ __('calendars.fields.start_offset') }}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" aria-hidden="true" data-toggle="tooltip" title="{{ __('calendars.helpers.start_offset') }}"></i>
            </label>
            {!! Form::number('start_offset', !empty($model) ? $model->start_offset : FormCopy::field('start_offset')->string(0), ['class' => 'form-control']) !!}
            <p class="help-block visible-xs visible-sm">{{ __('calendars.helpers.start_offset') }}</p>
        </div>

        <hr class="m-0" />

        <div class="field-reset">
            <label>
                {{ __('calendars.fields.reset') }}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" aria-hidden="true" data-toggle="tooltip" title="{{ __('calendars.hints.reset') }}"></i>
            </label>
            {!! Form::select('reset', __('calendars.options.resets'), null, ['class' => 'form-control']) !!}
            <p class="help-block visible-xs visible-sm">{{ __('calendars.hints.reset') }}</p>
        </div>

        <hr class="m-0" />

        <div class="field-calendar">
            <input type="hidden" name="calendar_id" value="" />
            @include('cruds.fields.calendar', ['isParent' => true, 'helper' => __('calendars.hints.parent_calendar'), 'allowNew' => false])
        </div>

        <hr class="m-0" />

        <div class="field-incrementing checkbox">
            {!! Form::hidden('is_incrementing', 0) !!}
            <label>{!! Form::checkbox('is_incrementing', 1, FormCopy::field('is_incrementing')->string()) !!}
                {{ __('calendars.fields.is_incrementing') }}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" aria-hidden="true" data-toggle="tooltip" title="{{ __('calendars.hints.is_incrementing') }}"></i>
            </label>
            <p class="help-block visible-xs visible-sm">{{ __('calendars.hints.is_incrementing') }}</p>
        </div>

        <hr class="m-0" />

        <div class="field-layout">
            <label>
                {{ __('calendars.fields.default_layout') }}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" aria-hidden="true" data-toggle="tooltip" title="{{ __('calendars.helpers.default_layout') }}"></i>
            </label>
            {!! Form::select('parameters[layout]', ['' => __('calendars.layouts.monthly'), 'yearly' => __('calendars.layouts.yearly')], null, ['class' => 'form-control'])!!}
            <p class="help-block visible-xs visible-sm">
                {{ __('calendars.helpers.default_layout') }}
            </p>
        </div>
    </div>
    <div class="flex gap-5 flex-col">
        <div class="field-years">
            <label>{{ __('calendars.panels.years') }}</label>
            <p class="help-block">{{ __('calendars.hints.years') }}</p>
        </div>
        <?php
        $years = [];
        $numbers = old('year_number');
        $names = old('year_name');
        if (!empty($numbers)) {
            $cpt = 0;
            foreach ($numbers as $number) {
                if (!empty($number) || !empty($names[$cpt])) {
                    $years[$number] = $names[$cpt];
                }
                $cpt++;
            }
        } elseif (isset($model)) {
            $years = $model->years();
        } elseif (isset($source)) {
            $years = $source->years();
        } ?>
        <div class="calendar-years sortable-elements" data-handle=".input-group-addon">
            @foreach ($years as $year => $name)
                <div class="parent-delete-row mb-2">
                    <x-grid>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <span class="fa-solid fa-arrows-alt-v" aria-hidden="true"></span>
                            </span>
                            <label class="sr-only">{{ __('calendars.parameters.year.number') }}</label>
                            {!! Form::text('year_number[]', $year, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.year.number')]) !!}
                        </div>

                        <div class="input-group">
                            <label class="sr-only">{{ __('calendars.parameters.year.name') }}</label>
                            {!! Form::text('year_name[]', $name, ['class' => 'form-control']) !!}
                            <span class="input-group-btn">
                                <span class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" data-remove="4" title="{{ __('crud.remove') }}">
                                    <x-icon class="trash"></x-icon>
                                </span>
                            </span>
                        </div>
                    </x-grid>
                </div>
            @endforeach
        </div>

        <button class="btn2 btn-sm dynamic-row-add" data-template="template_year" data-target="calendar-years" title="{{ __('calendars.actions.add_year') }}">
            <x-icon class="plus"></x-icon> {{ __('calendars.actions.add_year') }}
        </button>

        <hr class="m-0" />

        <div class="field-leap-year checkbox">
            {!! Form::hidden('has_leap_year', 0) !!}
            <label>{!! Form::checkbox('has_leap_year', 1, FormCopy::field('has_leap_year')->string()) !!}
                {{ __('calendars.fields.has_leap_year') }}
            </label>
        </div>
        <div class="grid grid-cols-2 gap-2 md:gap-5" id="calendar-leap-year" style="@if (isset($model) && $model->has_leap_year || request()->old('has_leap_year') || (isset($source) && $source->has_leap_year))@else display:none; @endif">
            <div class="field-year-amount">
                <label>{{ __('calendars.fields.leap_year_amount') }}</label>
                {!! Form::number('leap_year_amount', FormCopy::field('leap_year_amount')->string(), ['placeholder' => __('calendars.placeholders.leap_year_amount'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
            <div class="field-leap-month">
                <label>{{ __('calendars.fields.leap_year_month') }}</label>
                {!! Form::number('leap_year_month', FormCopy::field('leap_year_month')->string(), ['placeholder' => __('calendars.placeholders.leap_year_month'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
            <div class="field-leap-offset">
                <label>{{ __('calendars.fields.leap_year_offset') }}</label>
                {!! Form::number('leap_year_offset', FormCopy::field('leap_year_offset')->string(), ['placeholder' => __('calendars.placeholders.leap_year_offset'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
            <div class="field-leap-start">
                <label>{{ __('calendars.fields.leap_year_start') }}</label>
                {!! Form::number('leap_year_start', FormCopy::field('leap_year_start')->string(), ['placeholder' => __('calendars.placeholders.leap_year_start'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
        </div>
    </div>
</x-grid>


@section('modals')
    @parent
    <div id="template_year" style="display: none">
        <div class="parent-delete-row">
            <x-grid>
                <div class="input-group">
                    <span class="input-group-addon">
                        <span class="fa-solid fa-arrows-alt-v" aria-hidden="true"></span>
                    </span>
                    <label class="sr-only">{{ __('calendars.parameters.year.number') }}</label>
                    {!! Form::number('year_number[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.year.number')]) !!}
                </div>

                <div class="input-group">
                    <label class="sr-only">{{ __('calendars.parameters.year.name') }}</label>
                    {!! Form::text('year_name[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.year.name')]) !!}
                    <span class="input-group-btn">
                        <span class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" data-remove="4" title="{{ __('crud.remove') }}">
                            <x-icon class="trash"></x-icon>
                        </span>
                    </span>
                </div>
            </x-grid>
        </div>
    </div>
@endsection
