<div class="panel panel-default">
    <div class="panel-heading">
        <h4>{{ trans('crud.panels.calendar_date') }}</h4>
    </div>
    <div class="panel-body">
        <div class="form-group">
            <a href="#" id="entity-calendar-form-add" class="btn btn-default" data-url="{{ route('calendars.month-list', ['calendar' => 0]) }}" style="<?=(!empty($model) && $model->hasCalendar() ? "display: none" : null)?>">
                <i class="ra ra-moon-sun"></i> {{ trans('crud.forms.actions.calendar') }}
            </a>

            <div class="entity-calendar-form" style="<?=(!isset($model) || !$model->hasCalendar() ? "display: none" : null)?>">
                <div class="form-group">
                    {!! Form::select2(
                        'calendar_id',
                        (isset($model) && $model->calendar ? $model->calendar : $formService->prefillSelect('calendar', $source)),
                        App\Models\Calendar::class,
                        false
                    ) !!}
                </div>

                <div class="row entity-calendar-subform" style="<?=(!isset($model) || !$model->hasCalendar() ? "display: none" : null)?>">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ trans('calendars.fields.current_year') }}</label>
                            {!! Form::number('calendar_year', $formService->prefill('calendar_year', $source), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group">
                            <label>{{ trans('calendars.fields.current_month') }}</label>
                            {!! Form::select('calendar_month', (!empty($model) && $model->hasCalendar() ? $model->calendar->monthList(): []), $formService->prefill('calendar_month', $source), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>{{ trans('calendars.fields.current_day') }}</label>
                            {!! Form::number('calendar_day', $formService->prefill('calendar_day', $source), ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <div class="entity-calendar-loading" style="display: none">
                    <p class="text-center">
                        <i class="fa fa-spin fa-spinner"></i>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
