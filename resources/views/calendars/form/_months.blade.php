<?php /** @var \App\Models\Calendar $model */?>
<div class="form-group required">
    <label>{{ __('calendars.fields.months') }}</label>
    <p class="help-block">{{ __('calendars.hints.months') }}</p>
    <input type="hidden" name="month_name" />
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-6">{{ trans('calendars.parameters.month.name') }}</div>
        <div class="col-md-2">{{ trans('calendars.parameters.month.length') }}</div>
        <div class="col-md-2">{{ trans('calendars.parameters.month.alias') }}</div>
        <div class="col-md-2">{{ trans('calendars.parameters.month.type') }} <i class="fa fa-question-circle" data-toggle="tooltip" title="{{ __('calendars.helpers.month_type') }}"></i></div>
    </div>
</div>
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
                <div class="col-md-2">
                    {!! Form::text('month_alias[]', \Illuminate\Support\Arr::get($month, 'alias', ''), [
                        'class' => 'form-control',
                        'maxlength' => 191,
                        'placeholder' => __('calendars.parameters.month.alias')
                    ]) !!}
                </div>
                <div class="col-md-2">
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
        <div class="col-md-2">
            {!! Form::text('month_alias[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.month.alias')]) !!}
        </div>
        <div class="col-md-2">
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