{{ csrf_field() }}

<p class="help-block">
 {{ __('quests.elements.fields.entity_or_name') }}
</p>
<div class="grid gap-5 grid-cols-1 md:grid-cols-2 mb-4">
    <div class="form-group required mb-0">
        <input type="hidden" name="entity_id" value="" />
        @include('cruds.fields.entity')
    </div>
    <div class="form-group required mb-0">
        <label>{{ __('quests.elements.fields.name') }}</label>
        {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 100, 'spellcheck' => 'true']) !!}
    </div>
</div>

<hr />

<div class="form-group">
    <label>{{ __('quests.fields.role') }}</label>
    {!! Form::text('role', null, ['class' => 'form-control', 'maxlength' => 45, 'spellcheck' => 'true']) !!}
</div>

<div class="form-group">
    <label>{{ __('quests.elements.fields.description') }}</label>
{!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'description', 'name' => 'description']) !!}
</div>

<div class="grid gap-5 grid-cols-1 md:grid-cols-2 mb-4">
    <div class="form-group mb-0">
        <label>{{ __('calendars.fields.colour') }}</label>
        {!! Form::select('colour', FormCopy::colours(), null, ['class' => 'form-control select2-colour']) !!}
    </div>
    @include('cruds.fields.visibility_id')
</div>

