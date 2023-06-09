<p class="help-block">{{ __('calendars.hints.seasons') }}</p>
<x-grid type="3/3">
    <div class="">{{ __('calendars.parameters.seasons.name') }}</div>
    <div class="">{{ __('calendars.parameters.seasons.month') }}</div>
    <div class="">{{ __('calendars.parameters.seasons.day') }}</div>
</x-grid>
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
<div class="calendar-seasons sortable-elements" data-handle=".sortable-handler">
    @foreach ($seasons as $season)
        <div class="parent-delete-row">
            <x-grid type="3/3">
                <div class="flex gap-2 items-center">
                    <div class="sortable-handler p-2 cursor-move">
                        <x-icon class="fa-solid fa-grip-vertical" />
                    </div>
                    <div class="grow">
                        <label class="sr-only">{{ __('calendars.parameters.seasons.name') }}</label>
                        {!! Form::text('season_name[]', $season['name'], ['class' => 'form-control']) !!}
                    </div>
                </div>

                <div>
                    <label class="sr-only">{{ __('calendars.parameters.seasons.month') }}</label>
                    {!! Form::number('season_month[]', $season['month'], ['class' => 'form-control']) !!}
                </div>

                <div class="flex gap-2 items-center">
                    <div class="grow">
                        <label class="sr-only">{{ __('calendars.parameters.seasons.day') }}</label>
                        {!! Form::number('season_day[]', $season['day'], ['class' => 'form-control']) !!}
                    </div>
                    <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                        <x-icon class="trash"></x-icon>
                    </div>
                </div>
            </x-grid>
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
        <x-grid type="3/3">
            <div class="flex gap-2 items-center">
                <div class="sortable-handler p-2 cursor-move">
                    <x-icon class="fa-solid fa-grip-vertical" />
                </div>
                <div class="grow">
                    <label class="sr-only">{{ __('calendars.parameters.seasons.name') }}</label>
                    {!! Form::text('season_name[]', null, ['class' => 'form-control']) !!}
                </div>
            </div>

            <div>
                <label class="sr-only">{{ __('calendars.parameters.seasons.month') }}</label>
                {!! Form::number('season_month[]', null, ['class' => 'form-control']) !!}
            </div>

            <div class="flex gap-2 items-center">
                <div class="grow">
                    <label class="sr-only">{{ __('calendars.parameters.seasons.day') }}</label>
                    {!! Form::number('season_day[]', null, ['class' => 'form-control']) !!}
                </div>
                <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                    <x-icon class="trash"></x-icon>
                </div>
            </div>
        </x-grid>
    </div>
</div>
@endsection
