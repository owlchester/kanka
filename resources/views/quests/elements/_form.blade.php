{{ csrf_field() }}

<x-helper>
 {{ __('quests.elements.fields.entity_or_name') }}
</x-helper>
<x-grid>
    <x-forms.field field="entity" :required="true">
        <input type="hidden" name="entity_id" value="" />
        @include('cruds.fields.entity')
    </x-forms.field>
    <x-forms.field field="name" :required="true" :label="__('quests.elements.fields.name')">
        {!! Form::text('name', null, ['class' => '', 'maxlength' => 100, 'spellcheck' => 'true']) !!}
    </x-forms.field>

    <hr class="col-span-2" />

    <x-forms.field
        field="role"
        css="col-span-2"
        :label="__('quests.fields.role')">
        {!! Form::text('role', null, ['class' => '', 'maxlength' => 45, 'spellcheck' => 'true']) !!}
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

    <x-forms.field
        field="colour"
        :label=" __('calendars.fields.colour')">
        {!! Form::select('colour', FormCopy::colours(), null, ['class' => ' select2-colour']) !!}
    </x-forms.field>

    @include('cruds.fields.visibility_id')
</x-grid>

