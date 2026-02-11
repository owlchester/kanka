<?php
/** @var \App\Models\EntityEvent $model */
?>
<x-grid>

    <x-forms.foreign
        field="entity_id"
        :required="false"
        label="fields.entry.label"
        :multiple="false"
        name="entity_id"
        id="entity_id"
        :campaign="$campaign"
        :route="route('search.entities-with-relations', [$campaign])"
        :dropdownParent="$dropdownParent ?? (request()->ajax() ? '#primary-dialog' : null)"
    >
    </x-forms.foreign>
    <x-forms.field field="comment" css="col-span-2" :label="__('calendars.fields.comment')">

        <input type="text" name="comment" value="{{ old('comment', $source->comment ?? $model->comment ?? null) }}" class="w-full" maxlength="191" placeholder="{{  __('calendars.placeholders.comment') }}" />
    </x-forms.field>

    <x-forms.field
            field="length"
            :label="__('calendars.fields.length')"
            :helper="__('calendars.hints.event_length')"
            tooltip>
        <input type="number" name="length" class="w-full" value="{{ old('length', $model->length ?? 1) }}" placeholder="{{ __('calendars.placeholders.length') }}" aria-label="{{ __('calendars.placeholders.length') }}" data-url="{{ route('calendars.event-length', [$campaign, 'calendar' => $calendar ?? 0]) }}" />
            <p class="length-warning hidden text-error">
                {!!  __('calendars.warnings.event_length', ['documentation' => '<a target="_blank" href="https://docs.kanka.io/en/latest/entities/calendars.html#long-lasting-reminders"><i class="fa-regular fa-external-link" aria-hidden="true"></i> ' . __('footer.documentation') . '</a>'])!!}
            </p>
    </x-forms.field>

    @include('cruds.fields.colour_picker', ['dropdownParent' => request()->ajax() ? '#primary-dialog' : null])

</x-grid>
