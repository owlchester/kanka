<x-grid type="1/1">
    <p class="text-neutral-content m-0">{{ __('calendars.hints.seasons') }}</p>

    <button class="btn2 btn-sm btn-outline dynamic-row-add" data-template="template_season" data-target="calendar-seasons" title="{{ __('calendars.actions.add_season') }}">
        <x-icon class="plus" /> {{ __('calendars.actions.add_season') }}
    </button>

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
        $seasons = $source->child->seasons();
    }?>
    <div class="calendar-seasons sortable-elements flex flex-col gap-2" data-handle=".sortable-handler">
        <x-grid type="3/3">
            <div class="">{{ __('calendars.parameters.seasons.name') }}</div>
            <div class="">{{ __('calendars.parameters.seasons.month') }}</div>
            <div class="">{{ __('calendars.parameters.seasons.day') }}</div>
        </x-grid>
        @foreach ($seasons as $season)
            <div class="parent-delete-row">
                <x-grid type="3/3">
                    <div class="flex gap-2 items-center">
                        <div class="sortable-handler p-2 cursor-move">
                            <x-icon class="fa-solid fa-grip-vertical" />
                        </div>
                        <div class="grow field">
                            <label class="sr-only">{{ __('calendars.parameters.seasons.name') }}</label>
                            <input type="text" name="season_name[]" value="{{ $season['name'] }}" maxlength="191" class="w-full" />
                        </div>
                    </div>

                    <div class="field">
                        <label class="sr-only">{{ __('calendars.parameters.seasons.month') }}</label>
                        <input type="number" name="season_month[]" class="w-full" value="{{ $season['month'] }}" placeholder="{{ __('calendars.parameters.seasons.month') }}" />
                    </div>

                    <div class="flex gap-2 items-center">
                        <div class="grow field">
                            <label class="sr-only">{{ __('calendars.parameters.seasons.day') }}</label>
                            <input type="number" name="season_day[]" class="w-full" value="{{ $season['day'] }}" placeholder="{{ __('calendars.parameters.seasons.day') }}" />

                        </div>
                        <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                            <x-icon class="trash" />
                        </div>
                    </div>
                </x-grid>
            </div>
        @endforeach
    </div>

</x-grid>

@section('modals')
    @parent
<template id="template_season">
    <div class="parent-delete-row">
        <x-grid type="3/3">
            <div class="flex gap-2 items-center">
                <div class="sortable-handler p-2 cursor-move">
                    <x-icon class="fa-solid fa-grip-vertical" />
                </div>
                <div class="grow field">
                    <label class="sr-only">{{ __('calendars.parameters.seasons.name') }}</label>
                    <input type="text" name="season_name[]" value="" placeholder="{{ __('calendars.parameters.seasons.name') }}" aria-label="{{ __('calendars.parameters.seasons.name') }}" maxlength="191" class="w-full" />
                </div>
            </div>

            <div class="field">
                <label class="sr-only">{{ __('calendars.parameters.seasons.month') }}</label>
                <input type="number" name="season_month[]" class="w-full" value="" placeholder="{{ __('calendars.parameters.seasons.month') }}" />
            </div>

            <div class="flex gap-2 items-center">
                <div class="grow field">
                    <label class="sr-only">{{ __('calendars.parameters.seasons.day') }}</label>
                    <input type="number" name="season_day[]" class="w-full" value="" placeholder="{{ __('calendars.parameters.seasons.day') }}" />
                </div>
                <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" />
                </div>
            </div>
        </x-grid>
    </div>
</template>
@endsection
