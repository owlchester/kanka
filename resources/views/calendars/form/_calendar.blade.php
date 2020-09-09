<?php /** @var \App\Models\Calendar $model */?>
<div class="row">
    <div class="col-md-6">

        <div class="form-group">
            <label>{{ trans('calendars.fields.start_offset') }}</label>
            {!! Form::number('start_offset', !empty($model) ? $model->start_offset : FormCopy::field('start_offset')->string(0), ['class' => 'form-control']) !!}
            <p class="help-block">{{ __('calendars.helpers.start_offset') }}</p>
        </div>

        <hr />

        <div class="form-group">
            <label>
                {{ trans('calendars.fields.reset') }}
            </label>
            {!! Form::select('reset', __('calendars.options.resets'), null, ['class' => 'form-control']) !!}
            <p class="help-block">{{ __('calendars.hints.reset') }}</p>
        </div>

        <hr />

        @if ($campaign->enabled('calendars'))
            <?php
            $preset = null;
            if (isset($model) && $model->calendar) {
                $preset = $model->calendar;
            } elseif (isset($isRandom) && $isRandom) {
                $preset = $random->generateForeign(\App\Models\Calendar::class);
            } else {
                $preset = FormCopy::field('calendar')->select();
            }?>
            <div class="form-group">
                {!! Form::select2(
                    'calendar_id',
                    $preset,
                    App\Models\Calendar::class,
                    false,
                    'calendars.fields.calendar'
                ) !!}
                <p class="help-block">{{ __('calendars.hints.parent_calendar') }}</p>
            </div>
            <hr />
        @endif

        <div class="form-group checkbox">
            {!! Form::hidden('is_incrementing', 0) !!}
            <label>{!! Form::checkbox('is_incrementing', 1, FormCopy::field('is_incrementing')->string()) !!}
                {{ trans('calendars.fields.is_incrementing') }}
            </label>
            <p class="help-block">{{ __('calendars.hints.is_incrementing') }}</p>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ trans('calendars.panels.years') }}</label>
            <p class="help-block">{{ __('calendars.hints.years') }}</p>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">{{ trans('calendars.parameters.year.number') }}</div>
                <div class="col-md-8">{{ trans('calendars.parameters.year.name') }}</div>
            </div>
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
        <div class="calendar-years">
            @foreach ($years as $year => $name)
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="fa fa-arrows-alt-v"></span>
                                    </span>
                                {!! Form::text('year_number[]', $year, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                {!! Form::text('year_name[]', $name, ['class' => 'form-control']) !!}
                                <span class="input-group-btn">
                                        <span class="month-delete btn btn-danger" data-remove="4" title="{{ trans('crud.remove') }}">
                                            <i class="fa fa-trash"></i>
                                        </span>
                                    </span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="btn btn-default" id="add_year" href="#" title="{{ trans('calendars.actions.add_year') }}">
            <i class="fa fa-plus"></i> {{ trans('calendars.actions.add_year') }}
        </a>

        <div class="form-group" id="template_year" style="display: none">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fa fa-arrows-alt-v"></span>
                                </span>
                        {!! Form::number('year_number[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.year.number')]) !!}
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="input-group">
                        {!! Form::text('year_name[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.year.name')]) !!}
                        <span class="input-group-btn">
                                    <span class="month-delete btn btn-danger" data-remove="4" title="{{ trans('crud.remove') }}">
                                        <i class="fa fa-trash"></i>
                                    </span>
                                </span>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="form-group checkbox">
            {!! Form::hidden('has_leap_year', 0) !!}
            <label>{!! Form::checkbox('has_leap_year', 1, FormCopy::field('has_leap_year')->string()) !!}
                {{ trans('calendars.fields.has_leap_year') }}
            </label>
        </div>
        <div class="" id="calendar-leap-year" style="@if (isset($model) && $model->has_leap_year || request()->old('has_leap_year') || (isset($source) && $source->has_leap_year))@else display:none; @endif">
            <div class="form-group">
                <label>{{ trans('calendars.fields.leap_year_amount') }}</label>
                {!! Form::number('leap_year_amount', FormCopy::field('leap_year_amount')->string(), ['placeholder' => trans('calendars.placeholders.leap_year_amount'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
            <div class="form-group">
                <label>{{ trans('calendars.fields.leap_year_month') }}</label>
                {!! Form::number('leap_year_month', FormCopy::field('leap_year_month')->string(), ['placeholder' => trans('calendars.placeholders.leap_year_month'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
            <div class="form-group">
                <label>{{ trans('calendars.fields.leap_year_offset') }}</label>
                {!! Form::number('leap_year_offset', FormCopy::field('leap_year_offset')->string(), ['placeholder' => trans('calendars.placeholders.leap_year_offset'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
            <div class="form-group">
                <label>{{ trans('calendars.fields.leap_year_start') }}</label>
                {!! Form::number('leap_year_start', FormCopy::field('leap_year_start')->string(), ['placeholder' => trans('calendars.placeholders.leap_year_start'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
        </div>
    </div>
</div>
