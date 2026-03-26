<x-grid type="1/1">
    <p class="text-neutral-content m-0">{{ __('calendars.hints.eras') }}</p>

    <button class="btn2 btn-sm btn-outline dynamic-row-add" data-template="template_era" data-target="calendar-eras" title="{{ __('calendars.actions.add_era') }}">
        <x-icon class="plus" /> {{ __('calendars.actions.add_era') }}
    </button>

    <?php
    $eras = [];
    $eraNames = old('era_name');
    $eraStartYears = old('era_start_year');
    $eraEndYears = old('era_end_year');
    $eraFormatDates = old('era_format_dates');
    $formatDateOptions = ['0' => __('general.no'), '1' => __('general.yes')];
    if (!empty($eraNames) && is_array($eraNames)) {
        $cpt = 0;
        foreach ($eraNames as $name) {
            if (!empty($name)) {
                $eras[] = [
                    'name' => $name,
                    'start_year' => $eraStartYears[$cpt] ?? '',
                    'end_year' => $eraEndYears[$cpt] ?? '',
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
        <div class="w-24">{{ __('calendars.parameters.eras.start_year') }}</div>
        <div class="w-24">{{ __('calendars.parameters.eras.end_year') }}</div>
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
                    <div class="w-24 field">
                        <label class="sr-only">{{ __('calendars.parameters.eras.start_year') }}</label>
                        <input type="number" name="era_start_year[]" class="w-full" value="{{ $era['start_year'] }}" />
                    </div>
                    <div class="w-24 field">
                        <label class="sr-only">{{ __('calendars.parameters.eras.end_year') }}</label>
                        <input type="number" name="era_end_year[]" class="w-full" value="{{ $era['end_year'] }}" />
                    </div>
                    <div class="w-24 field">
                        <label class="sr-only">{{ __('calendars.parameters.eras.format_dates') }}</label>
                        <x-forms.select name="era_format_dates[]" :options="$formatDateOptions" :selected="!empty($era['format_dates']) ? '1' : '0'" class="w-full" :label="__('calendars.parameters.eras.format_dates')" />
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
            <div class="w-24 field">
                <label class="sr-only">{{ __('calendars.parameters.eras.start_year') }}</label>
                <input type="number" name="era_start_year[]" class="w-full" value="" placeholder="{{ __('calendars.parameters.eras.start_year') }}" />
            </div>
            <div class="w-24 field">
                <label class="sr-only">{{ __('calendars.parameters.eras.end_year') }}</label>
                <input type="number" name="era_end_year[]" class="w-full" value="" placeholder="{{ __('calendars.parameters.eras.end_year') }}" />
            </div>
            <div class="w-24 field">
                <label class="sr-only">{{ __('calendars.parameters.eras.format_dates') }}</label>
                <x-forms.select name="era_format_dates[]" :options="$formatDateOptions" selected="0" class="w-full" :label="__('calendars.parameters.eras.format_dates')" />
            </div>
            <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                <x-icon class="trash" />
            </div>
        </div>
    </div>
</template>
@endsection
