{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('families.relations.fields.second') }}</label>
            {!! Form::select('second_id', [], null, ['id' => 'second_id', 'class' => 'form-control select2', 'style' => 'width: 100%',
            'data-url' => route('families.find'), 'data-placeholder' => trans('families.relations.placeholders.second')]) !!}
        </div>
        <div class="form-group required">
            <label>{{ trans('families.relations.fields.relation') }}</label>
            {!! Form::text('relation', null, ['placeholder' => trans('families.relations.placeholders.relation'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>
    </div>
</div>

{!! Form::hidden('first_id', request()->get('family')) !!}

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous())]) !!}
</div>
