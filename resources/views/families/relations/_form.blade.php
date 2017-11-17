{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('families.relations.fields.second') }}</label>
            {!! Form::select('second_id', (!empty($relation) && $relation->second ? [$relation->second->id => $relation->second->name] : []), null, ['id' => 'second_id', 'class' => 'form-control select2', 'style' => 'width: 100%',
            'data-url' => route('families.find'), 'data-placeholder' => trans('families.relations.placeholders.second')]) !!}
        </div>
        <div class="form-group required">
            <label>{{ trans('families.relations.fields.relation') }}</label>
            {!! Form::text('relation', null, ['placeholder' => trans('families.relations.placeholders.relation'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>

        @if (empty($relation))
        <div class="form-group">
            <label>
                {!! Form::checkbox('two_way') !!}
                {{ trans('families.relations.fields.two_way') }}
            </label>
            <p class="help-block">{{ trans('families.relations.hints.two_way') }}</p>
        </div>
        @endif
    </div>
</div>

{!! Form::hidden('first_id', $model->id) !!}

<div class="form-group">
    <button class="btn btn-success">{{ trans('crud.save') }}</button>
    {!! trans('crud.or_cancel', ['url' => (!empty($cancel) ? $cancel : url()->previous() . '?tab=relation')]) !!}
</div>
