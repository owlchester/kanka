<?php /** @var \App\Models\Calendar $model */?>
<x-grid type="1/1">

    <p class="text-neutral-content m-0">{{ __('calendars.hints.moons') }}</p>

    <button class="btn2 btn-sm btn-outline dynamic-row-add" data-template="template_moon" data-target="calendar-moons" title="{{ __('calendars.actions.add_moon') }}">
        <x-icon class="plus" />
        {{ __('calendars.actions.add_moon') }}
    </button>
<?php
$moons = [];
$moonNames = old('moon_name');
$moonFullmoons = old('moon_fullmoon');
$moonOffsets = old('moon_offset');
$moonColours = old('moon_colour');
$moonIds = old('moon_id');
if (!empty($moonNames)) {
    $cpt = 0;
    foreach ($moonNames as $name) {
        if (!empty($name) || !empty($moonFullmoons[$cpt])) {
            $moons[] = [
                'name' => $name,
                'fullmoon' => $moonFullmoons[$cpt],
                'offset' => $moonOffsets[$cpt],
                'colour' => $moonColours[$cpt],
                'id' => $moonIds[$cpt],
            ];
        }
        $cpt++;
    }
} elseif (isset($model)) {
    $moons = $model->moons();
} elseif (isset($source)) {
    $moons = $source->child->moons();
}?>
<div class="flex flex-col gap-2 calendar-moons sortable-elements" data-handle=".sortable-handler">
    <div class="grid gap-2 grid-cols-2 md:grid-cols-4 md:gap-4">
        <div class="">{{ __('calendars.parameters.moon.name') }}</div>
        <div class="">{{ __('calendars.parameters.moon.fullmoon') }}</div>
        <div class="">{{ __('crud.fields.colour') }}</div>
        <div class="">
            {{ __('calendars.parameters.moon.offset') }}
            <x-helpers.tooltip :title="__('calendars.helpers.moon_offset')" />
        </div>
    </div>
    @foreach ($moons as $fullmoon)
        <div class="parent-delete-row">
            <x-grid>
                <div class="grid grid-cols-2 gap-2">
                    <div class="flex gap-2 items-center">
                        <div class="sortable-handler p-2 cursor-move">
                            <x-icon class="fa-regular fa-grip-vertical" />
                        </div>
                        <div class="grow field">
                            <label class="sr-only">{{ __('calendars.parameters.moon.name') }}</label>
                            <input type="text" name="moon_name[]" value="{{ $fullmoon['name'] }}" maxlength="191" class="w-full" aria-label="{{ __('calendars.parameters.moon.name') }}" placeholder="{{ __('calendars.parameters.moon.name') }}" />
                        </div>
                    </div>
                    <div class="field">
                        <label class="sr-only">{{ __('calendars.parameters.moon.fullmoon') }}</label>
                        <input type="number" name="moon_fullmoon[]" class="w-full" value="{{  $fullmoon['fullmoon'] }}" step="any" min="1" placeholder="{{ __('calendars.parameters.moon.fullmoon') }}" aria-label="{{ __('calendars.parameters.moon.fullmoon') }}" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2">
                    <div class="field w-full">
                        <label class="sr-only">{{ __('crud.fields.colour') }}</label>
                        <x-forms.select name="moon_colour[]" :options="FormCopy::colours(false)" :selected="\Illuminate\Support\Arr::get($fullmoon, 'colour', 'grey')" class="w-full select2-colour" :label="__('crud.fields.colour')"/>
                    </div>
                    <div class="flex gap-2 items-center">
                        <div class="grow field">
                            <label class="sr-only">{{ __('calendars.parameters.moon.offset') }}</label>
                            <input type="number" name="moon_offset[]" class="w-full" value="{{  $fullmoon['offset'] }}" placeholder="{{ __('calendars.parameters.moon.offset') }}" aria-label="{{ __('calendars.parameters.moon.offset') }}" />
                        </div>
                        <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                            <x-icon class="trash" />
                        </div>
                    </div>
                </div>
            </x-grid>
        </div>
        <input type="hidden" name="moon_id[]" value="{{ $fullmoon['id'] }}" />
    @endforeach
</div>
</x-grid>
@section('modals')
    @parent
<template id="template_moon">
    <div class="parent-delete-row">
        <x-grid>
            <div class="grid grid-cols-2 gap-2">
                <div class="flex gap-2 items-center">
                    <div class="sortable-handler p-2 cursor-move">
                        <x-icon class="fa-regular fa-grip-vertical" />
                    </div>
                    <div class="grow field">
                        <label class="sr-only">{{ __('calendars.parameters.moon.name') }}</label>
                        <input type="text" name="moon_name[]" value="" placeholder="{{ __('calendars.parameters.moon.name') }}" aria-label="{{ __('calendars.parameters.moon.name') }}" maxlength="191" class="w-full" />
                    </div>
                </div>
                <div class="field">
                    <label class="sr-only">{{ __('calendars.parameters.moon.fullmoon') }}</label>
                    <input type="number" name="moon_fullmoon[]" class="w-full" value="" step="any" min="1" placeholder="{{ __('calendars.parameters.moon.fullmoon') }}" aria-label="{{ __('calendars.parameters.moon.fullmoon') }}" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2">
                <div class="field w-full">
                    <label class="sr-only">{{ __('crud.fields.colour') }}</label>
                    <x-forms.select name="moon_colour[]" :options="FormCopy::colours(false)" selected="grey" class="w-full select2-colour" :label="__('crud.fields.colour')"/>
                </div>
                <div class="flex gap-2 items-center">
                    <div class="grow field">
                        <label class="sr-only">{{ __('calendars.parameters.moon.offset') }}</label>
                        <input type="number" name="moon_offset[]" class="w-full" value="" placeholder="{{ __('calendars.parameters.moon.offset') }}" aria-label="{{ __('calendars.parameters.moon.offset') }}" />
                    </div>
                    <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                        <x-icon class="trash" />
                    </div>
                </div>
            </div>
        </x-grid>
        <input type="hidden" name="moon_id[]" value="" />
    </div>
</template>
@endsection
