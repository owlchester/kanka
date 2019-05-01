<p class="help-block">{{ __('calendars.hints.seasons') }}</p>
<div class="form-group">
    <div class="row">
        <div class="col-md-6">{{ trans('calendars.parameters.seasons.name') }}</div>
        <div class="col-md-3">{{ trans('calendars.parameters.seasons.month') }}</div>
        <div class="col-md-3">{{ trans('calendars.parameters.seasons.day') }}</div>
    </div>
</div>
<?php
$seasons = [];
$seasonNames = old('season_name');
$seasonMonths = old('season_month');
$seasonDays = old('season_day');
if (!empty($seasonNames)) {
    $cpt = 0;
    foreach ($seasonNames as $name) {
        if (!empty($name) || !empty($seasonMonths[$cpt])) {
            $seasons[] = [
                'name' => $name,
                'month' => $seasonMonths[$cpt],
                'day' => $seasonDays[$cpt]
            ];
        }
        $cpt++;
    }
} elseif (isset($model)) {
    $seasons = $model->seasons();
} elseif (isset($source)) {
    $seasons = $source->seasons();
}?>
<div class="calendar-seasons">
    @foreach ($seasons as $season)
        <div class="form-group">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa fa-arrows-alt-v"></span>
                        </span>
                        {!! Form::text('season_name[]', $season['name'], ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    {!! Form::number('season_month[]', $season['month'], ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        {!! Form::number('season_day[]', $season['day'], ['class' => 'form-control']) !!}
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
<a class="btn btn-default" id="add_season" href="#" title="{{ trans('calendars.actions.add_season') }}">
    <i class="fa fa-plus"></i> {{ trans('calendars.actions.add_season') }}
</a>

<div class="form-group" id="template_season" style="display: none">
    <div class="row">
        <div class="col-md-6">
            <div class="input-group">
                <span class="input-group-addon">
                    <span class="fa fa-arrows-alt-v"></span>
                </span>
                {!! Form::text('season_name[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.seasons.name')]) !!}
            </div>
        </div>
        <div class="col-md-3">
            {!! Form::number('season_month[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.seasons.month')]) !!}
        </div>
        <div class="col-md-3">
            <div class="input-group">
                {!! Form::number('season_day[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.seasons.day')]) !!}
                <span class="input-group-btn">
                    <span class="month-delete btn btn-danger" data-remove="4" title="{{ trans('crud.remove') }}">
                        <i class="fa fa-trash"></i>
                    </span>
                </span>
            </div>
        </div>
    </div>
</div>