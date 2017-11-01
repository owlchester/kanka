{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Character:</label>
            {!! Form::select('character_id', [], null, ['id' => 'character_id', 'class' => 'form-control select2', 'data-url' => route('characters.find'), 'data-placeholder' => 'Choose a character...']) !!}

            <label>Role:</label>
            {!! Form::text('role', null, ['placeholder' => 'Role', 'class' => 'form-control']) !!}
        </div>
    </div>
</div>

{!! Form::hidden('organisation_id', request()->get('organisation')) !!}

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>
