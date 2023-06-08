<?php /** @var \App\Models\Calendar $model */?>

<x-grid>
    <div>
        <div class="flex flex-col xl:flex-row gap-2 mb-2 items-center">
            <div class="required grow mb-0">
                <label>{{ __('calendars.fields.weekdays') }}</label>
                <p class="help-block">{{ __('calendars.hints.weekdays') }}</p>
                <input type="hidden" name="weekday" />
            </div>
            <div>
                <button class="btn2 btn-sm dynamic-row-add" data-template="template_weekday" data-target="calendar-weekdays" title="{{ __('calendars.actions.add_weekday') }}">
                    <x-icon class="plus"></x-icon> {{ __('calendars.actions.add_weekday') }}
                </button>
            </div>
        </div>

        <?php
        $weekdays = [];
        $names = old('weekday');
        if (!empty($names)) {
            foreach ($names as $name) {
                if (!empty($name)) {
                    $weekdays[] = $name;
                }
            }
        } elseif (isset($model)) {
            $weekdays = $model->weekdays();
        } elseif (isset($source)) {
            $weekdays = $source->weekdays();
        } ?>
        <div class="calendar-weekdays sortable-elements" data-handle=".sortable-handler">
            @foreach ($weekdays as $weekday)
                <div class="parent-delete-row mb-1">
                    <div class="flex items-center gap-2">
                        <div class="sortable-handler p-2 cursor-move">
                            <x-icon class="fa-solid fa-grip-vertical" />
                        </div>
                        <div class="grow">
                            <label class="sr-only">{{ __('calendars.parameters.weeks.name') }}</label>
                            {!! Form::text('weekday[]', $weekday, ['class' => 'form-control']) !!}
                        </div>
                        <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                            <x-icon class="trash"></x-icon>
                            <span class="sr-only">{{ __('crud.remove') }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div>
        <div class="flex flex-col xl:flex-row gap-2 mb-2 items-center">
            <div class="grow mb-0">
                <label>{{ __('calendars.fields.week_names') }}</label>
                <p class="help-block">{{ __('calendars.hints.weeks') }}</p>
            </div>
            <div>
                <button class="btn2 btn-sm btn-sm dynamic-row-add" data-template="template_week" data-target="calendar-weeks" title="{{ __('calendars.actions.add_week') }}">
                    <x-icon class="plus"></x-icon> {{ __('calendars.actions.add_week') }}
                </button>
            </div>
        </div>
        <x-grid>
            <div>{{ __('calendars.parameters.weeks.number') }}</div>
            <div>{{ __('calendars.parameters.weeks.name') }}</div>
        </x-grid>
        <?php
        $weeks = [];
        $numbers = old('week_number');
        $names = old('week_name');
        if (!empty($numbers)) {
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
            $weeks = $source->weeks();
        } ?>
        <div class="calendar-weeks sortable-elements"  data-handle=".sortable-handler">
            @foreach ($weeks as $week => $name)
                <div class="parent-delete-row mb-1">
                    <div class="grid grid-cols-2 gap-2">
                        <div class="flex items-center gap-2">
                            <div class="sortable-handler p-2 cursor-move">
                                <x-icon class="fa-solid fa-grip-vertical" />
                            </div>
                            <div class="grow">
                                <label class="sr-only">{{ __('calendars.parameters.weeks.number') }}</label>
                                {!! Form::text('week_number[]', $week, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="grow">
                                <label class="sr-only">{{ __('calendars.parameters.weeks.name') }}</label>
                                {!! Form::text('week_name[]', $name, ['class' => 'form-control']) !!}
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
    </div>
</x-grid>

@section('modals')
    @parent
    <div id="template_weekday" style="display: none">
        <div class="parent-delete-row mb-1">
            <div class="flex items-center gap-2">
                <div class="sortable-handler p-2 cursor-move">
                    <x-icon class="fa-solid fa-grip-vertical" />
                </div>
                <div class="grow">
                    <label class="sr-only">{{ __('calendars.parameters.weeks.name') }}</label>
                    {!! Form::text('weekday[]', null, ['class' => 'form-control', 'aria-label' => __('calendars.parameters.weeks.name')]) !!}
                </div>
                <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                    <x-icon class="trash" />
                </div>
            </div>
        </div>
    </div>

    <div id="template_week" style="display: none">
        <div class="parent-delete-row mb-1">
            <div class="grid grid-cols-2 gap-2">
                <div class="flex items-center gap-2">
                    <div class="sortable-handler p-2 cursor-move">
                        <x-icon class="fa-solid fa-grip-vertical" />
                    </div>
                    <div class="grow">
                        <label class="sr-only">{{ __('calendars.parameters.weeks.number') }}</label>
                        {!! Form::number('week_number[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.weeks.number')]) !!}
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <div class="grow">
                        <label class="sr-only">{{ __('calendars.parameters.weeks.name') }}</label>
                        {!! Form::text('week_name[]', null, ['class' => 'form-control', 'placeholder' => __('calendars.parameters.weeks.name')]) !!}
                    </div>
                    <div class="dynamic-row-delete btn2 btn-error btn-outline btn-sm" title="{{ __('crud.remove') }}">
                        <x-icon class="trash" />
                        <span class="sr-only">{{ __('crud.remove') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
