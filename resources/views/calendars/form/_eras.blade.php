<x-grid type="1/1">
    <p class="text-neutral-content m-0">{{ __('calendars.hints.eras') }}</p>

    <button class="btn2 btn-sm btn-outline dynamic-row-add" data-template="template_era" data-target="calendar-eras" title="{{ __('calendars.actions.add_era') }}">
        <x-icon class="plus" /> {{ __('calendars.actions.add_era') }}
    </button>

    <?php
    $eras = [];
    $eraNames = old('era_name');
    $eraStartYears = old('era_start_year');
    $eraStartMonths = old('era_start_month');
    $eraStartDays = old('era_start_day');
    $eraEndYears = old('era_end_year');
    $eraEndMonths = old('era_end_month');
    $eraEndDays = old('era_end_day');
    $eraFormatDates = old('era_format_dates');
    if (!empty($eraNames) && is_array($eraNames)) {
        $cpt = 0;
        foreach ($eraNames as $name) {
            if (!empty($name)) {
                $eras[] = [
                    'name' => $name,
                    'start_year' => $eraStartYears[$cpt] ?? '',
                    'start_month' => $eraStartMonths[$cpt] ?? '',
                    'start_day' => $eraStartDays[$cpt] ?? '',
                    'end_year' => $eraEndYears[$cpt] ?? '',
                    'end_month' => $eraEndMonths[$cpt] ?? '',
                    'end_day' => $eraEndDays[$cpt] ?? '',
                    'format_dates' => !empty($eraFormatDates[$cpt]),
                ];
            }
            $cpt++;
        }
    } elseif (isset($model)) {
        $eras = $model->eras();
    } elseif (isset($source)) {
        $eras = $source->child->eras();
    }?>
    <div class="flex gap-2 text-sm font-bold">
        <div class="w-8"></div>
        <div class="grow">{{ __('calendars.parameters.eras.name') }}</div>
        <div class="w-20">{{ __('calendars.parameters.eras.start_year') }}</div>
        <div class="w-16">{{ __('calendars.parameters.eras.start_month') }}</div>
        <div class="w-16">{{ __('calendars.parameters.eras.start_day') }}</div>
        <div class="w-20">{{ __('calendars.parameters.eras.end_year') }}</div>
        <div class="w-16">{{ __('calendars.parameters.eras.end_month') }}</div>
        <div class="w-16">{{ __('calendars.parameters.eras.end_day') }}</div>
        <div class="w-24">{{ __('calendars.parameters.eras.format_dates') }}</div>
        <div class="w-10"></div>
    </div>
    <div class="calendar-eras sortable-elements flex flex-col gap-2" data-handle=".sortable-handler">
        @foreach ($eras as $era)
            <div class="parent-delete-row">
                <div class="flex gap-2 items-center">
                    <div class="sortable-handler p-2 cursor-move">
                        <x-icon class="fa-regular fa-grip-vertical" />
                    </div>
                    <div class="grow field">
                        <label class="sr-only">{{ __('calendars.parameters.eras.name') }}</label>
                        <input type="text" name="era_name[]" value="{{ $era['name'] }}" maxlength="191" class="w-full" />
                    </div>
                    <div class="w-20 field">
                        <label class="sr-only">{{ __('calendars.parameters.eras.start_year') }}</label>
                        <input type="number" name="era_start_year[]" class="w-full" value="{{ $era['start_year'] }}" min="0" />
                    </div>
                    <div class="w-16 field">
                        <label class="sr-only">{{ __('calendars.parameters.eras.start_month') }}</label>
                        <input type="number" name="era_start_month[]" class="w-full" value="{{ $era['start_month'] }}" min="1" />
                    </div>
                    <div class="w-16 field">
                        <label class="sr-only">{{ __('calendars.parameters.eras.start_day') }}</label>
                        <input type="number" name="era_start_day[]" class="w-full" value="{{ $era['start_day'] }}" min="1" />
                    </div>
                    <div class="w-20 field">
                        <label class="sr-only">{{ __('calendars.parameters.eras.end_year') }}</label>
                        <input type="number" name="era_end_year[]" class="w-full" value="{{ $era['end_year'] }}" min="0" />
                    </div>
                    <div class="w-16 field">
                        <label class="sr-only">{{ __('calendars.parameters.eras.end_month') }}</label>
                        <input type="number" name="era_end_month[]" class="w-full" value="{{ $era['end_month'] }}" min="1" />
                    </div>
                    <div class="w-16 field">
                        <label class="sr-only">{{ __('calendars.parameters.eras.end_day') }}</label>
                        <input type="number" name="era_end_day[]" class="w-full" value="{{ $era['end_day'] }}" min="1" />
                    </div>
                    <div class="w-24 field flex items-center justify-center">
                        <label class="sr-only">{{ __('calendars.parameters.eras.format_dates') }}</label>
                        <input type="hidden" name="era_format_dates[{{ $loop->index }}]" value="0" />
                        <input type="checkbox" name="era_format_dates[{{ $loop->index }}]" value="1" {{ !empty($era['format_dates']) ? 'checked' : '' }} />
                    </div>
                    <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                        <x-icon class="trash" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</x-grid>

@section('modals')
    @parent
<template id="template_era">
    <div class="parent-delete-row">
        <div class="flex gap-2 items-center">
            <div class="sortable-handler p-2 cursor-move">
                <x-icon class="fa-regular fa-grip-vertical" />
            </div>
            <div class="grow field">
                <label class="sr-only">{{ __('calendars.parameters.eras.name') }}</label>
                <input type="text" name="era_name[]" value="" placeholder="{{ __('calendars.parameters.eras.name') }}" aria-label="{{ __('calendars.parameters.eras.name') }}" maxlength="191" class="w-full" />
            </div>
            <div class="w-20 field">
                <label class="sr-only">{{ __('calendars.parameters.eras.start_year') }}</label>
                <input type="number" name="era_start_year[]" class="w-full" value="" placeholder="{{ __('calendars.parameters.eras.start_year') }}" min="0" />
            </div>
            <div class="w-16 field">
                <label class="sr-only">{{ __('calendars.parameters.eras.start_month') }}</label>
                <input type="number" name="era_start_month[]" class="w-full" value="" placeholder="{{ __('calendars.parameters.eras.start_month') }}" min="1" />
            </div>
            <div class="w-16 field">
                <label class="sr-only">{{ __('calendars.parameters.eras.start_day') }}</label>
                <input type="number" name="era_start_day[]" class="w-full" value="" placeholder="{{ __('calendars.parameters.eras.start_day') }}" min="1" />
            </div>
            <div class="w-20 field">
                <label class="sr-only">{{ __('calendars.parameters.eras.end_year') }}</label>
                <input type="number" name="era_end_year[]" class="w-full" value="" placeholder="{{ __('calendars.parameters.eras.end_year') }}" min="0" />
            </div>
            <div class="w-16 field">
                <label class="sr-only">{{ __('calendars.parameters.eras.end_month') }}</label>
                <input type="number" name="era_end_month[]" class="w-full" value="" placeholder="{{ __('calendars.parameters.eras.end_month') }}" min="1" />
            </div>
            <div class="w-16 field">
                <label class="sr-only">{{ __('calendars.parameters.eras.end_day') }}</label>
                <input type="number" name="era_end_day[]" class="w-full" value="" placeholder="{{ __('calendars.parameters.eras.end_day') }}" min="1" />
            </div>
            <div class="w-24 field flex items-center justify-center">
                <label class="sr-only">{{ __('calendars.parameters.eras.format_dates') }}</label>
                <input type="hidden" name="era_format_dates[]" value="0" />
                <input type="checkbox" name="era_format_dates[]" value="1" />
            </div>
            <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                <x-icon class="trash" />
            </div>
        </div>
    </div>
</template>
@endsection
