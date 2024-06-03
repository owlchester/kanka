<?php
/** @var \App\Models\EntityEvent $model */
?>
<x-grid>

    <x-forms.foreign
        field="entity_id"
        :required="false"
        label="crud.fields.entity"
        :multiple="false"
        name="entity_id"
        id="entity_id"
        :campaign="$campaign"
        :route="route('search.entities-with-relations', [$campaign])"
        :dropdownParent="$dropdownParent ?? (request()->ajax() ? '#primary-dialog' : null)"
    >
    </x-forms.foreign>
    <x-forms.field field="comment" css="col-span-2" :label="__('calendars.fields.comment')">
        {!! Form::text('comment', null, ['placeholder' => __('calendars.placeholders.comment'), 'maxlength' => 191]) !!}
    </x-forms.field>

    <x-forms.field
            field="length"
            :label="__('calendars.fields.length')"
            :helper="__('calendars.hints.event_length')"
            :tooltip="true">
        <input type="number" name="length" class="w-full" value="{{ old('length', $model->length ?? 1) }}" placeholder="{{ __('calendars.placeholders.length') }}" aria-label="{{ __('calendars.placeholders.length') }}" data-url="{{ route('calendars.event-length', [$campaign, 'calendar' => $calendar ?? 0]) }}" />
            <p class="length-warning hidden text-error">
                {!!  __('calendars.warnings.event_length', ['documentation' => link_to('https://docs.kanka.io/en/latest/entities/calendars.html#long-lasting-reminders', '<i class="fa-solid fa-external-link" aria-hidden="true"></i> ' . __('footer.documentation'), ['target' => '_blank'], null, false)])!!}
            </p>
    </x-forms.field>

    <x-forms.field field="colour" :label="__('crud.fields.colour')">
        {!! Form::text('colour', null, ['class' => ' spectrum', 'maxlength' => 6, 'data-append-to' => '#primary-dialog'] ) !!}
    </x-forms.field>

</x-grid>
