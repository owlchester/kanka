<p class="help-block">{{ __('calendars.hints.seasons') }}</p>
<div class="form-group">
    <div class="row">
        <div class="col-md-6">{{ __('calendars.parameters.seasons.name') }}</div>
        <div class="col-md-3">{{ __('calendars.parameters.seasons.month') }}</div>
        <div class="col-md-3">{{ __('calendars.parameters.seasons.day') }}</div>
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
<div class="calendar-seasons sortable-elements" data-handle=".input-group-addon">
    @foreach ($seasons as $season)
        <div class="form-group parent-delete-row">
            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-addon">
                            <span class="fa-solid fa-arrows-alt-v" aria-hidden="true"></span>
                        </span>
                        <label class="sr-only">{{ __('calendars.parameters.seasons.name') }}</label>
                        {!! Form::text('season_name[]', $season['name'], ['class' => 'form-control']) !!}
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="sr-only">{{ __('calendars.parameters.seasons.month') }}</label>
                    {!! Form::number('season_month[]', $season['month'], ['class' => 'form-control']) !!}
                </div>
                <div class="col-md-3">
                    <div class="input-group">
                        <label class="sr-only">{{ __('calendars.parameters.seasons.day') }}</label>
                        {!! Form::number('season_day[]', $season['day'], ['class' => 'form-control']) !!}
                        <span class="input-group-btn">
                            <span class="dynamic-row-delete btn btn-danger" data-remove="4" title="{{ __('crud.remove') }}">
                                <i class="fa-solid fa-trash"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
<a class="btn btn-default dynamic-row-add" data-template="template_season" data-target="calendar-seasons" href="#" title="{{ __('calendars.actions.add_season') }}">
    <i class="fa-solid fa-plus" aria-hidden="true"></i> {{ __('calendars.actions.add_season') }}
</a>

@section('modals')
    @parent
<div id="template_season" style="display: none">
    <div class="form-group parent-delete-row">
        <div class="row">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-addon cursor-pointer">
                        <span class="fa-solid fa-arrows-alt-v" aria-hidden="true"></span>
                    </span>
                    <label class="sr-only">{{ __('calendars.parameters.seasons.name') }}</label>
                    {!! Form::text('season_name[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.seasons.name')]) !!}
                </div>
            </div>
            <div class="col-md-3">
                <label class="sr-only">{{ __('calendars.parameters.seasons.month') }}</label>
                {!! Form::number('season_month[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.seasons.month')]) !!}
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <label class="sr-only">{{ __('calendars.parameters.seasons.day') }}</label>
                    {!! Form::number('season_day[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.seasons.day')]) !!}
                    <span class="input-group-btn">
                        <span class="dynamic-row-delete btn btn-danger" data-remove="4" title="{{ __('crud.remove') }}">
                            <i class="fa-solid fa-trash"></i>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
