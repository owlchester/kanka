{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('characters.relations.fields.second') }}</label>
            {!! Form::select('second_id', [], null, ['id' => 'second_id', 'class' => 'form-control select2', 'data-url' => route('characters.find'), 'data-placeholder' => trans('characters.relations.placeholders.second')]) !!}
        </div>

        <div class="form-group required">
            <label>{{ trans('characters.relations.fields.relation') }}</label>
            {!! Form::text('relation', null, ['placeholder' => trans('characters.relations.placeholders.relation'), 'class' => 'form-control']) !!}
        </div>
    </div>
</div>

{!! Form::hidden('first_id', request()->get('character')) !!}

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
</div>
