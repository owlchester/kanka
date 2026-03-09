@if ($trans === 'characters')
<x-forms.field field="status" :label="__('characters.fields.status')">
    <select name="status_id" class="w-full">
        <option value=""></option>
        <option value="0">{{ __('characters.status.alive') }}</option>
        <option value="1">{{ __('characters.status.dead') }}</option>
        <option value="2">{{ __('characters.status.missing') }}</option>
    </select>
</x-forms.field>
@elseif ($trans === 'quests')
<x-forms.field field="status" :label="__('quests.fields.status')">
    <select name="status_id" class="w-full">
        <option value=""></option>
        <option value="0">{{ __('quests.status.not_started') }}</option>
        <option value="1">{{ __('quests.status.ongoing') }}</option>
        <option value="2">{{ __('quests.status.completed') }}</option>
        <option value="3">{{ __('quests.status.abandoned') }}</option>
    </select>
</x-forms.field>
@endif
