@php $fieldID = uniqid('age_'); @endphp

<div class="flex flex-col gap-3" x-data="{ showDates: {{ collect($dateRows)->contains('filled', true) || old('entry_dates') ? 'true' : 'false' }} }">
    <x-forms.field field="age" :label="__('characters.fields.age')" :id="$fieldID">
        @if (!empty($dateRows) && ($dateCalendars->isNotEmpty() || collect($dateRows)->contains('editable', false)))
            <x-slot name="action">
                <button type="button" class="text-link text-xs flex items-center gap-1" @click="showDates = !showDates" :aria-expanded="showDates" aria-controls="entry-calendar-dates">
                    <x-icon class="fa-regular fa-calendar" />
                    {{ __('entries/workspace.dates.action') }}
                </button>
            </x-slot>
        @endif
        <input id="{{ $fieldID }}" type="text" name="age" value="{{ old('age', FormCopy::field('age')->child()->string() ?: $model->age ?? null) }}" maxlength="25" class="w-full" autocomplete="off" placeholder="{{ __('characters.placeholders.age') }}" />
        <x-slot name="helper">{{ __('entries/workspace.dates.manual_hint') }}</x-slot>
    </x-forms.field>

    @if (!empty($dateRows) && ($dateCalendars->isNotEmpty() || collect($dateRows)->contains('editable', false)))
        <div x-show="showDates" x-cloak>
            @include('entities.forms._dates')
        </div>
    @endif
</div>
