{{ csrf_field() }}

<p class="help-block">
 {{ __('quests.elements.fields.entity_or_name') }}
</p>
<div class="row">
    <div class="col-md-6">
        <div class="form-group required">
            <input type="hidden" name="entity_id" value="" />
            {!! Form::select2(
                'entity_id',
                (!empty($model) && $model->entity ? $model->entity : null),
                App\Models\Entity::class,
                false,
                'crud.fields.entity',
                'search.entities-with-relations',
                'crud.placeholders.entity'
            ) !!}
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group required">
            <label>{{ __('quests.elements.fields.name') }}</label>
            {!! Form::text('name', null, ['class' => 'form-control', 'maxlength' => 100, 'spellcheck' => 'true']) !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('quests.fields.role') }}</label>
            {!! Form::text('role', null, ['class' => 'form-control', 'maxlength' => 45, 'spellcheck' => 'true']) !!}
        </div>
    </div>
</div>

<div class="form-group">
    <label>{{ __('quests.elements.fields.description') }}</label>
{!! Form::textarea('entryForEdition', null, ['class' => 'form-control html-editor', 'id' => 'description', 'name' => 'description']) !!}
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label>{{ __('calendars.fields.colour') }}</label>
            {!! Form::select('colour', FormCopy::colours(), null, ['class' => 'form-control']) !!}
        </div>
    </div>
    <div class="col-md-6">
        @include('cruds.fields.visibility_id')
    </div>
</div>

