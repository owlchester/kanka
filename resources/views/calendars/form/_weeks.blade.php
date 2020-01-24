<?php /** @var \App\Models\Calendar $model */?>
<div class="row">
    <div class="col-md-6">

        <div class="form-group required">
            <label>{{ trans('calendars.fields.weekdays') }}</label>
            <p class="help-block">{{ __('calendars.hints.weekdays') }}</p>
            <input type="hidden" name="weekday" />
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
            <label>{{ trans('calendars.fields.week_names') }}</label>
            <p class="help-block">{{ __('calendars.hints.weeks') }}</p>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-md-4">{{ trans('calendars.parameters.weeks.number') }}</div>
                <div class="col-md-8">{{ trans('calendars.parameters.weeks.name') }}</div>
            </div>
        </div>
        <?php
        $weeks = [];
        $numbers = old('week_number');
        $names = old('week_name');
        if (!empty($numbers)) {
            $cpt = 0;
            foreach ($numbers as $number) {
                if (!empty($number) || !empty($names[$cpt])) {
                    $weeks[$number] = $names[$cpt];
                }
                $cpt++;
            }
        } elseif (isset($model)) {
            $weeks = $model->weeks();
        } elseif (isset($source)) {
            $weeks = $source->weeks();
        } ?>
        <div class="calendar-weeks">
            @foreach ($weeks as $week => $name)
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <span class="fa fa-arrows-alt-v"></span>
                                </span>
                                {!! Form::text('week_number[]', $week, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="input-group">
                                {!! Form::text('week_name[]', $name, ['class' => 'form-control']) !!}
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
        <a class="btn btn-default" id="add_week" href="#" title="{{ trans('calendars.actions.add_week') }}">
            <i class="fa fa-plus"></i> {{ trans('calendars.actions.add_week') }}
        </a>

        <div class="form-group" id="template_week" style="display: none">
            <div class="row">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-arrows-alt-v"></span>
                        </span>
                        {!! Form::number('week_number[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.weeks.number')]) !!}
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="input-group">
                        {!! Form::text('week_name[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.weeks.name')]) !!}
                        <span class="input-group-btn">
                            <span class="month-delete btn btn-danger" data-remove="4" title="{{ trans('crud.remove') }}">
                                <i class="fa fa-trash"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
