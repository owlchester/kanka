<x-forms.field
    field="sex"
    :label="__('characters.fields.sex')">

    <input type="text" name="sex" value="{!! htmlspecialchars(old('sex', $source->sex ?? $model->sex ?? null)) !!}" placeholder="{{ __('characters.placeholders.title') }}" list="entity-gender-list" autocomplete="off" maxlength="45" spellcheck="true" />
    <datalist id="entity-gender-list">
        @foreach (\App\Facades\CharacterCache::genderSuggestion() as $gender)
            <option value="{{ $gender }}">{!! $gender !!}</option>
        @endforeach
    </datalist>
</x-forms.field>
