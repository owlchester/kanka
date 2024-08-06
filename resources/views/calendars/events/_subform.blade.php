<?php /** @var \App\Models\EntityEvent $entityEvent */?>
<x-grid type="3/3">
    <x-forms.field
        field="year"
        :label="__('calendars.fields.year')">
        <input type="number" name="year" value="{{ $year ?? old('year', $entityEvent->year ?? null) }}" />
    </x-forms.field>

    <x-forms.field
        field="month"
        :label="__('calendars.fields.month')">
        <x-forms.select
                name="month"
                id="reminder_month"
                :options="isset($calendar) ? $calendar->monthList() : []"
                :selected="$month ?? $entityEvent->month ?? null"
                :optionAttributes="!empty($calendar) ? $calendar->monthDataProperties() : []"
        />
    </x-forms.field>

    <x-forms.field
        field="day"
        :label="__('calendars.fields.day')">
        <x-forms.select
                name="day"
                id="reminder_day"
                :options="isset($calendar) ? $calendar->dayList($month ?? $entityEvent->month ?? $calendar->month) : []"
                :selected="$day ?? $source->day ?? $entityEvent->day ?? null"
        />
    </x-forms.field>
</x-grid>
<x-grid>
    <x-forms.field field="comment" css="col-span-2" :label="__('calendars.fields.comment')">
        <input type="text" name="comment" value="{{ old('comment', $entityEvent->comment ?? null) }}" maxlength="191" class="w-full" placeholder="{{ __('calendars.placeholders.comment') }}" />
    </x-forms.field>
    <div id="entity-calendar-modal-add">
        <x-forms.field
            field="length"
            :label="__('calendars.fields.length')"
            :helper="__('calendars.hints.event_length')"
            tooltip>
            <input type="number" name="length" id="reminder_length" class="w-full" value="{{ old('length', $entityEvent->length ?? 1) }}" placeholder="{{ __('calendars.placeholders.length') }}" aria-label="{{ __('calendars.placeholders.length') }}" data-url="{{ route('calendars.event-length', [$campaign, 'calendar' => $calendar ?? 0]) }}" />
            <p class="length-warning hidden text-error">
                {!!  __('calendars.warnings.event_length', ['documentation' => '<a target="_blank" href="https://docs.kanka.io/en/latest/entities/calendars.html#long-lasting-reminders"><i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('footer.documentation') . '</a>'])!!}
            </p>
        </x-forms.field>
</div>
    @include('cruds.fields.colour_picker', ['default' => '#cccccc', 'model' => $entityEvent ?? null])

    <x-forms.field
        field="recurring"
        :label="__('calendars.fields.is_recurring')">
        <x-forms.select name="recurring_periodicity" :options="isset($calendar) ? $calendar->recurringOptions() : []" :selected="$entityEvent->recurring_periodicity ?? null" class="w-full reminder-periodicity" />
    </x-forms.field>

    <x-forms.field field="recurring-until" :hidden="!isset($entityEvent) || !$entityEvent->is_recurring" :label="__('calendars.fields.recurring_until')"  id="add_event_recurring_until">
        <input type="text" name="recurring_until" value="{{ old('recurring_until', $entityEvent->recurring_until ?? null) }}" maxlength="12" class="w-full" placeholder="{{ __('calendars.placeholders.recurring_until') }}" />
    </x-forms.field>

    @include('cruds.fields.visibility_id', ['model' => $entityEvent ?? null])
    @if (!empty($entity) && $entity->isCharacter())
        <x-forms.field
            field="type"
            :label="__('entities/events.fields.type')"
            :helper=" __('entities/events.helpers.characters', ['more' => '<a target=\'_blank\' href=\'https://docs.kanka.io/en/latest/advanced/age.html\'>' . __('crud.actions.find_out_more') . '</a>'])">
            <x-forms.select name="type_id" :options="[null => '', 2 => __('entities/events.types.birth'), 3 =>  __('entities/events.types.death')]" :selected="$entityEvent->type_id ?? null" />
        </x-forms.field>
    @endif
    @if (!empty($entity) && in_array($entity->typeId(), [config('entities.ids.location'), config('entities.ids.family'), config('entities.ids.organisation')]))
        <x-forms.field
            field="type"
            :label="__('entities/events.fields.type')"
            :helper="__('entities/events.helpers.founding', ['type' => '<code>' . __('entities/events.types.founded') . '</code>'])">
                <x-forms.select name="type_id" :options="[null => '', 5 => __('entities/events.types.founded')]" :selected="$entityEvent->type_id ?? null" />
        </x-forms.field>
    @endif
</x-grid>


