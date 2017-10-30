{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label>Target:</label>
            {!! Form::select('second_id', [], null, ['id' => 'second_id', 'class' => 'form-control select2', 'data-url' => route('families.find'), 'data-placeholder' => 'Choose a family...']) !!}

            <label>Relation:</label>
            {!! Form::text('relation', null, ['placeholder' => 'Title', 'class' => 'form-control']) !!}
        </div>
    </div>
</div>

{!! Form::hidden('first_id', request()->get('family')) !!}

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
</div>
