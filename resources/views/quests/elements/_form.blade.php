{{ csrf_field() }}

<p class="help-block">
 {{ __('quests.elements.fields.entity_or_name') }}
</p>
<x-grid>
    <x-forms.field field="entity" :required="true">
        <input type="hidden" name="entity_id" value="" />
        @include('cruds.fields.entity')
    </x-forms.field>
    <x-forms.field field="name" :required="true" :label="__('quests.elements.fields.name')">
        {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 100, 'spellcheck' => 'true']) !!}
    </x-forms.field>

    <hr class="col-span-2" />

    <x-forms.field
        field="role"
        css="col-span-2"
        :label="__('quests.fields.role')">
        {!! Form::text('role', null, ['class' => 'form-control', 'maxlength' => 45, 'spellcheck' => 'true']) !!}
    </x-forms.field>

    <x-forms.field
        field="description"
        css="col-span-2"
        :label="__('quests.elements.fields.description')">
        {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'description', 'name' => 'description']) !!}
    </x-forms.field>

    <x-forms.field
        field="colour"
        :label=" __('calendars.fields.colour')">
        {!! Form::select('colour', FormCopy::colours(), null, ['class' => 'form-control select2-colour']) !!}
    </x-forms.field>

    @include('cruds.fields.visibility_id')
</x-grid>

