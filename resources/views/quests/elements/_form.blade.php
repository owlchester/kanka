{{ csrf_field() }}

<p class="help-block">
 {{ __('quests.elements.fields.entity_or_name') }}
</p>
<x-grid>
    <div class="field-entity required">
        <input type="hidden" name="entity_id" value="" />
        @include('cruds.fields.entity')
    </div>
    <div class="field-name required">
        <label>{{ __('quests.elements.fields.name') }}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 100, 'spellcheck' => 'true']) !!}
    </div>

    <hr class="col-span-2" />

    <div class="field-role col-span-2">
        <label>{{ __('quests.fields.role') }}</label>
        {!! Form::text('role', null, ['class' => 'form-control', 'maxlength' => 45, 'spellcheck' => 'true']) !!}
    </div>

    <div class="field-description col-span-2">
        <label>{{ __('quests.elements.fields.description') }}</label>
    {!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'description', 'name' => 'description']) !!}
    </div>

    <div class="field-colour">
        <label>{{ __('calendars.fields.colour') }}</label>
        {!! Form::select('colour', FormCopy::colours(), null, ['class' => 'form-control select2-colour']) !!}
    </div>

    @include('cruds.fields.visibility_id')
</x-grid>

