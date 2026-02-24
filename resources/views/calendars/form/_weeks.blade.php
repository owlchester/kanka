<?php /** @var \App\Models\Calendar $model */?>

<x-grid>
    <x-grid type="1/1">
        <x-forms.field field="weeks" required :label="__('calendars.fields.weekdays')" :helper="__('calendars.hints.weekdays')">
            <input type="hidden" name="weekday" />
        </x-forms.field>

        <button class="btn2 btn-sm btn-outline dynamic-row-add" data-template="template_weekday" data-target="calendar-weekdays" title="{{ __('calendars.actions.add_weekday') }}">
            <x-icon class="plus" /> {{ __('calendars.actions.add_weekday') }}
        </button>

        <?php
        $weekdays = [];
        $names = old('weekday');
        if (!empty($names) && is_array($names)) {
            foreach ($names as $name) {
                if (!empty($name)) {
                    $weekdays[] = $name;
                }
            }
        } elseif (isset($model)) {
            $weekdays = $model->weekdays();
        } elseif (isset($source)) {
            $weekdays = $source->child->weekdays();
        } ?>
        <div class="calendar-weekdays sortable-elements" data-handle=".sortable-handler">
            @foreach ($weekdays as $weekday)
                <div class="parent-delete-row">
                    <div class="flex items-center gap-2">
                        <div class="sortable-handler p-2 cursor-move">
                            <x-icon class="fa-regular fa-grip-vertical" />
                        </div>
                        <div class="grow field">
                            <label class="sr-only">{{ __('calendars.parameters.weeks.name') }}</label>
                            <input type="text" name="weekday[]" value="{{ $weekday }}" placeholder="{{ __('calendars.parameters.weeks.name') }}" aria-label="{{ __('calendars.parameters.weeks.name') }}" maxlength="191" class="w-full" />
                        </div>
                        <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                            <x-icon class="trash" />
                            <span class="sr-only">{{ __('crud.remove') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-grid>

    <x-grid type="1/1">
        <x-forms.field field="week-names" :label="__('calendars.fields.week_names')" :helper="__('calendars.hints.weeks')">
        </x-forms.field>

        <button class="btn2 btn-sm btn-outline dynamic-row-add" data-template="template_week" data-target="calendar-weeks" title="{{ __('calendars.actions.add_week') }}">
            <x-icon class="plus" />
            {{ __('calendars.actions.add_week') }}
        </button>

        <?php
        $weeks = [];
        $numbers = old('week_number');
        $names = old('week_name');
        if (!empty($numbers) && is_array($numbers)) {
            $cpt = 0;
            foreach ($numbers as $number) {
                if (!empty($number) || !empty($names[$cpt])) {
                    $weeks[$number] = $names[$cpt];
                }
                $cpt++;
            }
        } elseif (isset($model)) {
            $weeks = $model->weeks();
        } elseif (isset($source)) {
            $weeks = $source->child->weeks();
        } ?>
        <div class="flex flex-col gap-2 calendar-weeks sortable-elements"  data-handle=".sortable-handler">
            <x-grid>
                <div>{{ __('calendars.parameters.weeks.number') }}</div>
                <div>{{ __('calendars.parameters.weeks.name') }}</div>
            </x-grid>
            @foreach ($weeks as $week => $name)
                <div class="parent-delete-row ">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex items-center gap-2">
                            <div class="sortable-handler p-2 cursor-move">
                                <x-icon class="fa-regular fa-grip-vertical" />
                            </div>
                            <div class="grow field">
                                <label class="sr-only">{{ __('calendars.parameters.weeks.number') }}</label>
                                <input type="text" name="week_number[]" value="{{ $week }}" placeholder="{{ __('calendars.parameters.weeks.number') }}" aria-label="{{ __('calendars.parameters.weeks.number') }}" maxlength="191" class="w-full" />
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="grow field">
                                <label class="sr-only">{{ __('calendars.parameters.weeks.name') }}</label>
                                <input type="text" name="week_name[]" value="{{ $name }}" placeholder="{{ __('calendars.parameters.weeks.name') }}" aria-label="{{ __('calendars.parameters.weeks.name') }}" maxlength="191" class="w-full" />
                            </div>
                            <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                                <x-icon class="trash" />
                                <span class="sr-only">{{ __('crud.remove') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </x-grid>
</x-grid>

@section('modals')
    @parent
    <template id="template_weekday">
        <div class="parent-delete-row">
            <div class="flex items-center gap-2">
                <div class="sortable-handler p-2 cursor-move">
                    <x-icon class="fa-regular fa-grip-vertical" />
                </div>
                <div class="grow field">
                    <label class="sr-only">{{ __('calendars.parameters.weeks.name') }}</label>
                    <input type="text" name="weekday[]" value="" placeholder="{{ __('calendars.parameters.weeks.name') }}" aria-label="{{ __('calendars.parameters.weeks.name') }}" maxlength="191" class="w-full" />
                </div>
                <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" />
                </div>
            </div>
        </div>
    </template>

    <template id="template_week">
        <div class="parent-delete-row ">
            <div class="grid grid-cols-2 gap-2">
                <div class="flex items-center gap-2">
                    <div class="sortable-handler p-2 cursor-move">
                        <x-icon class="fa-regular fa-grip-vertical" />
                    </div>
                    <div class="grow field">
                        <label class="sr-only">{{ __('calendars.parameters.weeks.number') }}</label>
                        <input type="number" name="week_number[]" class="w-full" value="" placeholder="{{ __('calendars.parameters.weeks.number') }}" />
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="grow field">
                        <label class="sr-only">{{ __('calendars.parameters.weeks.name') }}</label>
                        <input type="text" name="week_name[]" value="" placeholder="{{ __('calendars.parameters.weeks.name') }}" aria-label="{{ __('calendars.parameters.weeks.name') }}" maxlength="191" class="w-full" />
                    </div>
                    <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                        <x-icon class="trash" />
                        <span class="sr-only">{{ __('crud.remove') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </template>
@endsection
