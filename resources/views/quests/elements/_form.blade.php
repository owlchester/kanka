<x-helper>
 {{ __('quests.elements.fields.entity_or_name') }}
</x-helper>
<x-grid>
    <x-forms.field field="entity" required>
        <input type="hidden" name="entity_id" value="" />
        @include('cruds.fields.entity')
    </x-forms.field>
    <x-forms.field field="name" required :label="__('quests.elements.fields.name')">
        <input type="text" name="name" maxlength="100" spellcheck="true" placeholder="{{ __('quests.elements.fields.name') }}" value="{!! htmlspecialchars(old('name', $model->name ?? null)) !!}" />
    </x-forms.field>

    <hr class="col-span-2" />

    <x-forms.field
        field="role"
        css="col-span-2"
        :label="__('quests.fields.role')">
        <input type="text" name="role" value="{{ old('role', $model->role ?? null) }}" spellcheck="true" maxlength="45" autocomplete="off" list="quest-element-roles" />
        <div class="hidden">
            <datalist id="quest-element-roles">
                @foreach (\App\Facades\QuestCache::roleSuggestion() as $name)
                    <option value="{{ $name }}">{{ $name }}</option>
                @endforeach
            </datalist>
        </div>
    </x-forms.field>

    <x-forms.field
        field="description"
        css="col-span-2"
        :label="__('quests.elements.fields.description')">

        <textarea name="description"
                  id="element-entry"
                  class="html-editor"
                  rows="3"
        >{!! old('description', $model->entryForEdition ?? null) !!}</textarea>
    </x-forms.field>

    @include('cruds.fields.colour')
    @include('cruds.fields.visibility_id')
</x-grid>

