<?php /** @var \App\Models\Calendar $model */?>
<x-grid>
    <div class="flex gap-5 flex-col">

        <x-forms.field field="skip-zero" :label="__('calendars.fields.skip_year_zero')">
            <input type="hidden" name="skip_year_zero" value="0" />
            <x-checkbox :text="__('calendars.hints.skip_year_zero')">
                {!! Form::checkbox('skip_year_zero', 1, !empty($model) ? $model->skip_year_zero : 0) !!}
            </x-checkbox>
        </x-forms.field>

        <x-forms.field
            field="start-offset"
            :label="__('calendars.fields.start_offset')"
            :tooltip="true"
            :helper="__('calendars.helpers.start_offset')">
            <input type="number" name="start_offset" value="{{ FormCopy::field('start_offset')->string(0) ?: old('start_offset', $model->start_offset ?? null) }}" />
        </x-forms.field>

        <x-forms.field
            field="reset"
            :label="__('calendars.fields.reset')"
            :tooltip="true"
            :helper="__('calendars.hints.reset')">
            {!! Form::select('reset', __('calendars.options.resets')) !!}
        </x-forms.field>

        <input type="hidden" name="calendar_id" value="" />
        @include('cruds.fields.calendar', ['isParent' => true, 'helper' => __('calendars.hints.parent_calendar'), 'allowNew' => false])

        <x-forms.field
            field="layout"
            :label="__('calendars.fields.default_layout')"
            :tooltip="true"
            :helper="__('calendars.helpers.default_layout')">
            {!! Form::select('parameters[layout]', ['' => __('calendars.layouts.monthly'), 'yearly' => __('calendars.layouts.yearly')])!!}
        </x-forms.field>

        @include('cruds.fields.format')

        <x-forms.field field="incrementing" :label="__('calendars.fields.is_incrementing')">
            <input type="hidden" name="is_incrementing" value="0" />
            <x-checkbox :text="__('calendars.hints.is_incrementing')">
                {!! Form::checkbox('is_incrementing', 1, FormCopy::field('is_incrementing')->string()) !!}
            </x-checkbox>
        </x-forms.field>

        <x-forms.field field="birthdays" :label="__('calendars.fields.show_birthdays')">
            <input type="hidden" name="show_birthdays" value="0" />
            <x-checkbox :text="__('calendars.hints.show_birthdays')">
                {!! Form::checkbox('show_birthdays', 1, FormCopy::field('show_birthdays')->string()) !!}
            </x-checkbox>
        </x-forms.field>
    </div>
    <div class="flex gap-5 flex-col">
        <x-forms.field field="years" :label=" __('calendars.panels.years')" :helper="__('calendars.hints.years')">
        </x-forms.field>


        <button class="btn2 btn-sm dynamic-row-add" data-template="template_year" data-target="calendar-years" title="{{ __('calendars.actions.add_year') }}">
            <x-icon class="plus"></x-icon> {{ __('calendars.actions.add_year') }}
        </button>

        <?php
        $years = [];
        $numbers = old('year_number');
        $names = old('year_name');
        if (!empty($numbers)) {
            $cpt = 0;
            foreach ($numbers as $number) {
                if (!empty($number) || !empty($names[$cpt])) {
                    $years[$number] = $names[$cpt];
                }
                $cpt++;
            }
        } elseif (isset($model)) {
            $years = $model->years();
        } elseif (isset($source)) {
            $years = $source->years();
        } ?>
        <div class="calendar-years sortable-elements" data-handle=".sortable-handler">
            @foreach ($years as $year => $name)
                <div class="parent-delete-row">
                    <x-grid>
                        <div class="flex gap-2 items-center">
                            <div class="sortable-handler p-2 cursor-move">
                                <x-icon class="fa-solid fa-grip-vertical" />
                            </div>
                            <div class="grow field">
                                <label class="sr-only">{{ __('calendars.parameters.year.number') }}</label>
                                {!! Form::text('year_number[]', $year, ['class' => 'w-full', 'placeholder' => __('calendars.parameters.year.number')]) !!}
                            </div>
                        </div>
                        <div class="flex gap-2 items-center">
                            <div class="grow field">
                                <label class="sr-only">{{ __('calendars.parameters.year.name') }}</label>
                                {!! Form::text('year_name[]', $name, ['class' => 'w-full']) !!}
                            </div>

                            <span class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" data-remove="4" title="{{ __('crud.remove') }}">
                                <x-icon class="trash"></x-icon>
                            </span>
                        </div>
                    </x-grid>
                </div>
            @endforeach
        </div>

        <hr class="m-0" />

        <x-forms.field field="leap-year" :label="__('calendars.fields.leap_year')">
            <input type="hidden" name="has_leap_year" value="0" />
            <x-checkbox :text="__('calendars.hints.leap_year')">
                {!! Form::checkbox('has_leap_year', 1, FormCopy::field('has_leap_year')->string()) !!}
            </x-checkbox>
        </x-forms.field>
        <div class="grid grid-cols-2 gap-2 md:gap-5" id="calendar-leap-year" style="@if (isset($model) && $model->has_leap_year || request()->old('has_leap_year') || (isset($source) && $source->has_leap_year))@else display:none; @endif">
            <x-forms.field field="year-amount" :label="__('calendars.fields.leap_year_amount')">
                <input type="number" name="leap_year_amount" value="{{ FormCopy::field('leap_year_amount')->string(0) ?: old('leap_year_amount', $model->leap_year_amount ?? null) }}" class="w-full" maxlength="191" placeholder="{{ __('calendars.placeholders.leap_year_amount') }}"/>
            </x-forms.field>
            <x-forms.field field="leap-month" :label="__('calendars.fields.leap_year_month')">
                <input type="number" name="leap_year_month" value="{{ FormCopy::field('leap_year_month')->string(0) ?: old('leap_year_month', $model->leap_year_month ?? null) }}" class="w-full" maxlength="191" placeholder="{{ __('calendars.placeholders.leap_year_month') }}"/>
            </x-forms.field>
            <x-forms.field field="leap-offset" :label="__('calendars.fields.leap_year_offset')">
                <input type="number" name="leap_year_offset" value="{{ FormCopy::field('leap_year_offset')->string(0) ?: old('leap_year_offset', $model->leap_year_offset ?? null) }}" class="w-full" maxlength="191" placeholder="{{ __('calendars.placeholders.leap_year_offset') }}"/>
            </x-forms.field>
            <x-forms.field field="leap-start" :label="__('calendars.fields.leap_year_start')">
                <input type="number" name="leap_year_start" value="{{ FormCopy::field('leap_year_start')->string(0) ?: old('leap_year_start', $model->leap_year_start ?? null) }}" class="w-full" maxlength="191" placeholder="{{ __('calendars.placeholders.leap_year_start') }}"/>
            </x-forms.field>
        </div>
    </div>
</x-grid>


@section('modals')
    @parent
    <template id="template_year">
        <div class="parent-delete-row">
            <x-grid>
                <div class="flex gap-2 items-center">
                    <div class="sortable-handler p-2 cursor-move">
                        <x-icon class="fa-solid fa-grip-vertical" />
                    </div>
                    <div class="grow field">
                        <label class="sr-only">{{ __('calendars.parameters.year.number') }}</label>
                        <input type="number" name="year_number[]" value="" class="w-full" maxlength="191" placeholder="{{ __('calendars.parameters.year.number') }}"/>
                    </div>
                </div>

                <div class="flex gap-2 items-center">
                    <div class="grow field">
                        <label class="sr-only">{{ __('calendars.parameters.year.name') }}</label>
                        {!! Form::text('year_name[]', null, ['class' => 'w-full', 'placeholder' => __('calendars.parameters.year.name')]) !!}
                    </div>
                    <span class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" data-remove="4" title="{{ __('crud.remove') }}">
                        <x-icon class="trash"></x-icon>
                    </span>
                </div>
            </x-grid>
        </div>
    </template>
@endsection
