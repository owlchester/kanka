<p class="help-block">{{ __('calendars.hints.seasons') }}</p>
<div class="grid gap-2 grid-cols-3 md:gap-4 mb-2">
    <div class="">{{ __('calendars.parameters.seasons.name') }}</div>
    <div class="">{{ __('calendars.parameters.seasons.month') }}</div>
    <div class="">{{ __('calendars.parameters.seasons.day') }}</div>
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
        <div class="parent-delete-row">
            <div class="grid gap-2 grid-cols-3 md:gap-4 mb-2">
                <div class="input-group">
                    <span class="input-group-addon">
                        <span class="fa-solid fa-arrows-alt-v" aria-hidden="true"></span>
                    </span>
                    <label class="sr-only">{{ __('calendars.parameters.seasons.name') }}</label>
                    {!! Form::text('season_name[]', $season['name'], ['class' => 'form-control']) !!}
                </div>

                <div>
                    <label class="sr-only">{{ __('calendars.parameters.seasons.month') }}</label>
                    {!! Form::number('season_month[]', $season['month'], ['class' => 'form-control']) !!}
                </div>

                <div class="input-group">
                    <label class="sr-only">{{ __('calendars.parameters.seasons.day') }}</label>
                    {!! Form::number('season_day[]', $season['day'], ['class' => 'form-control']) !!}
                    <span class="input-group-btn">
                        <span class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" data-remove="4" title="{{ __('crud.remove') }}">
                            <x-icon class="trash"></x-icon>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    @endforeach
</div>
<button class="btn2 btn-sm  dynamic-row-add" data-template="template_season" data-target="calendar-seasons" title="{{ __('calendars.actions.add_season') }}">
    <x-icon class="plus"></x-icon> {{ __('calendars.actions.add_season') }}
</button>

@section('modals')
    @parent
<div id="template_season" style="display: none">
    <div class="parent-delete-row">
        <div class="grid gap-2 grid-cols-3 md:gap-4 mb-2">
            <div class="input-group">
                <span class="input-group-addon cursor-pointer">
                    <span class="fa-solid fa-arrows-alt-v" aria-hidden="true"></span>
                </span>
                <label class="sr-only">{{ __('calendars.parameters.seasons.name') }}</label>
                {!! Form::text('season_name[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.seasons.name')]) !!}
            </div>
            <div>
                <label class="sr-only">{{ __('calendars.parameters.seasons.month') }}</label>
                {!! Form::number('season_month[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.seasons.month')]) !!}
            </div>
            <div>
                <div class="input-group">
                    <label class="sr-only">{{ __('calendars.parameters.seasons.day') }}</label>
                    {!! Form::number('season_day[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.seasons.day')]) !!}
                    <span class="input-group-btn">
                        <span class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" data-remove="4" title="{{ __('crud.remove') }}">
                            <x-icon class="trash"></x-icon>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
