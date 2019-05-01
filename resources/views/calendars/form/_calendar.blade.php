<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('calendars.fields.months') }}</label>
            <p class="help-block">{{ __('calendars.hints.months') }}</p>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">{{ trans('calendars.parameters.month.name') }}</div>
                <div class="col-md-2">{{ trans('calendars.parameters.month.length') }}</div>
                <div class="col-md-4">{{ trans('calendars.parameters.month.type') }} <i class="fa fa-question-circle" data-toggle="tooltip" title="{{ __('calendars.helpers.month_type') }}"></i></div>
            </div>
        </div>
        <?php
        $months = [];
        $names = old('month_name');
        $lengths = old('month_length');
        $types = old('month_type');
        if (!empty($names)) {
            $cpt = 0;
            foreach ($names as $name) {
                if (!empty($name) || !empty($lengths[$cpt])) {
                    $months[] = [
                        'name' => $name,
                        'length' => $lengths[$cpt],
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
        <div class="calendar-months">
            @foreach ($months as $month)
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group">
                                    <span class="input-group-addon">
                                        <span class="fa fa-arrows-alt-v"></span>
                                    </span>
                                {!! Form::text('month_name[]', $month['name'], ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-2">
                            {!! Form::number('month_length[]', $month['length'], ['class' => 'form-control', 'maxlength' => 4]) !!}
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                {!! Form::select('month_type[]', __('calendars.month_types'), (!empty($month['type']) ? $month['type'] : 'standard'), ['class' => 'form-control']) !!}
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
        <a class="btn btn-default" id="add_month" href="#" title="{{ trans('calendars.actions.add_month') }}">
            <i class="fa fa-plus"></i> {{ trans('calendars.actions.add_month') }}
        </a>

        <div class="form-group" id="template_month" style="display: none">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fa fa-arrows-alt-v"></span>
                                </span>
                        {!! Form::text('month_name[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.month.name')]) !!}
                    </div>
                </div>
                <div class="col-md-2">
                    {!! Form::number('month_length[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.month.length')]) !!}
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        {!! Form::select('month_type[]', __('calendars.month_types'), 'standard', ['class' => 'form-control']) !!}
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
        <div class="form-group">
            <label>{{ trans('calendars.fields.weekdays') }}</label>
            <p class="help-block">{{ __('calendars.hints.weekdays') }}</p>
        </div>
        <?php
        $weekdays = [];
        $names = old('weekday');
        if (!empty($names)) {
            foreach ($names as $name) {
                if (!empty($name)) {
                    $weekdays[] = $name;
                }
            }
        } elseif (isset($model)) {
            $weekdays = $model->weekdays();
        } elseif (isset($source)) {
            $weekdays = $source->weekdays();
        } ?>
        <div class="calendar-weekdays">
            @foreach ($weekdays as $weekday)
                <div class="form-group">
                    <div class="input-group">
                            <span class="input-group-addon">
                                <span class="fa fa-arrows-alt-v"></span>
                            </span>
                        {!! Form::text('weekday[]', $weekday, ['class' => 'form-control']) !!}
                        <span class="input-group-btn">
                                <span class="month-delete btn btn-danger" title="{{ trans('crud.remove') }}">
                                    <i class="fa fa-trash"></i>
                                </span>
                            </span>
                    </div>
                </div>
            @endforeach
        </div>
        <a class="btn btn-default" id="add_weekday" href="#" title="{{ trans('calendars.actions.add_weekday') }}">
            <i class="fa fa-plus"></i> {{ trans('calendars.actions.add_weekday') }}
        </a>

        <div class="form-group" id="template_weekday" style="display: none">
            <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-arrows-alt-v"></span>
                        </span>
                {!! Form::text('weekday[]', null, ['class' => 'form-control']) !!}
                <span class="input-group-btn">
                            <span href="#" class="month-delete btn btn-danger" title="{{ trans('crud.remove') }}">
                                <i class="fa fa-trash"></i>
                            </span>
                        </span>
            </div>
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
        <div class="form-group">
            <label>{{ trans('calendars.panels.leap_year') }}</label>
        </div>
        <div class="form-group checkbox">
            {!! Form::hidden('has_leap_year', 0) !!}
            <label>{!! Form::checkbox('has_leap_year', 1, $formService->prefill('has_leap_year', $source)) !!}
                {{ trans('calendars.fields.has_leap_year') }}
            </label>
        </div>
        <div class="" id="calendar-leap-year" style="@if (isset($model) && $model->has_leap_year || request()->old('has_leap_year') || (isset($source) && $source->has_leap_year))@else display:none; @endif">
            <div class="form-group">
                <label>{{ trans('calendars.fields.leap_year_amount') }}</label>
                {!! Form::number('leap_year_amount', $formService->prefill('leap_year_amount', $source), ['placeholder' => trans('calendars.placeholders.leap_year_amount'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
            <div class="form-group">
                <label>{{ trans('calendars.fields.leap_year_month') }}</label>
                {!! Form::number('leap_year_month', $formService->prefill('leap_year_month', $source), ['placeholder' => trans('calendars.placeholders.leap_year_month'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
            <div class="form-group">
                <label>{{ trans('calendars.fields.leap_year_offset') }}</label>
                {!! Form::number('leap_year_offset', $formService->prefill('leap_year_offset', $source), ['placeholder' => trans('calendars.placeholders.leap_year_offset'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
            <div class="form-group">
                <label>{{ trans('calendars.fields.leap_year_start') }}</label>
                {!! Form::number('leap_year_start', $formService->prefill('leap_year_start', $source), ['placeholder' => trans('calendars.placeholders.leap_year_start'), 'class' => 'form-control', 'maxlength' => 191]) !!}
            </div>
        </div>
    </div>
</div>
