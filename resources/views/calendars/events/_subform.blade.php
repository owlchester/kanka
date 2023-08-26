<?php /** @var \App\Models\EntityEvent $entityEvent */?>
<x-grid type="3/3">
    <x-forms.field
        field="year"
        :label="__('calendars.fields.year')">
        {!! Form::number('year', (!empty($year) ? $year : null), []) !!}
    </x-forms.field>

    <x-forms.field
        field="month"
        :label="__('calendars.fields.month')">
        {!! Form::select('month', isset($calendar) ? $calendar->monthList() : [], (!empty($month) ? $month : null), []) !!}
    </x-forms.field>

    <x-forms.field
        field="day"
        :label="__('calendars.fields.day')">
        {!! Form::number('day', (!empty($day) ? $day : null), []) !!}
    </x-forms.field>
</x-grid>
<x-grid>
    <div class="field field-comment col-span-2 flex flex-col gap-1">
        <label class="m-0">{{ __('calendars.fields.comment') }}</label>
        {!! Form::text('comment', null, ['placeholder' => __('calendars.placeholders.comment'), 'maxlength' => 191]) !!}
    </div>

    <x-forms.field
        field="length"
        :label="__('calendars.fields.length')"
        :helper="__('calendars.hints.event_length')"
        :tooltip="true">
        {!! Form::number('length', (empty($entityEvent) ? 1 : null), ['placeholder' => __('calendars.placeholders.length'), 'maxlength' => 1, 'data-url' => route('calendars.event-length', [$campaign, 'calendar' => 0])]) !!}
        <p class="length-warning hidden text-red">
            {!!  __('calendars.warnings.event_length', ['documentation' => link_to('https://docs.kanka.io/en/latest/entities/calendars.html#long-lasting-reminders', '<i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('footer.documentation'), ['target' => '_blank'], null, false)])!!}
        </p>
    </x-forms.field>

    @include('cruds.fields.colour_picker', ['default' => (!empty($entityEvent) ? null : '#cccccc')])

    <x-forms.field
        field="recurring"
        :label="__('calendars.fields.is_recurring')">
        {!! Form::select('recurring_periodicity', (isset($calendar) ? $calendar->recurringOptions() : []), (isset($entityEvent) && $entityEvent->is_recurring ? $entityEvent->recurring_periodicity : ''), ['class' => 'reminder-periodicity']) !!}
    </x-forms.field>

    <div class="field-recurring-until">
        <div style="@if (!isset($entityEvent) || !$entityEvent->is_recurring) display:none @endif" id="add_event_recurring_until">
            <label>{{ __('calendars.fields.recurring_until') }}</label>
            {!! Form::text('recurring_until', null, ['placeholder' => __('calendars.placeholders.recurring_until'), 'maxlength' => 12]) !!}
        </div>
    </div>
    @include('cruds.fields.visibility_id', ['model' => $entityEvent ?? null])
    @if (!empty($entity) && $entity->isCharacter())
        <x-forms.field
            field="type"
            :label="__('entities/events.fields.type')"
            :helper=" __('entities/events.helpers.characters', ['more' => link_to('https://docs.kanka.io/en/latest/advanced/age.html', __('crud.actions.find_out_more'), null, ['target' => '_blank'])])">
            {!! Form::select('type_id', [null => '', 2 => __('entities/events.types.birth'), 3 =>  __('entities/events.types.death')], (isset($entityEvent) ? $entityEvent->type_id : null), []) !!}
        </x-forms.field>
    @endif
    @if (!empty($entity) && in_array($entity->typeId(), [config('entities.ids.location'), config('entities.ids.family'), config('entities.ids.organisation')]))
        <x-forms.field
            field="type"
            :label="__('entities/events.fields.type')"
            :helper="__('entities/events.helpers.founding', ['type' => '<code>' . __('entities/events.types.founded') . '</code>'])">
            {!! Form::select('type_id', [null => '', 5 => __('entities/events.types.founded')], (isset($entityEvent) ? $entityEvent->type_id : null), []) !!}
        </x-forms.field>
    @endif
</x-grid>


