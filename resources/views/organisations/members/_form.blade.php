{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('organisations.members.fields.character') }}</label>
            {!! Form::select('character_id', [], null, ['id' => 'character_id', 'class' => 'form-control select2', 'data-url' => route('characters.find'), 'data-placeholder' => trans('organisations.members.placeholders.character')]) !!}
        </div>
        <div class="form-group required">
            <label>{{ trans('organisations.members.fields.role') }}</label>
            {!! Form::text('role', null, ['placeholder' => trans('organisations.members.placeholders.role'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>
    </div>
</div>

{!! Form::hidden('organisation_id', request()->get('organisation')) !!}

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>
