{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('organisations.relations.fields.second') }}</label>
            {!! Form::select('second_id', (!empty($relation) && $relation->second ? [$relation->second->id => $relation->second->name] : []), null, ['id' => 'second_id', 'class' => 'form-control select2', 'style' => 'width: 100%',
             'data-url' => route('organisations.find'), 'data-placeholder' => trans('organisations.relations.placeholders.second')]) !!}
        </div>
        <div class="form-group required">
            <label>{{ trans('organisations.relations.fields.relation') }}</label>
            {!! Form::text('relation', null, ['placeholder' => trans('organisations.relations.placeholders.relation'), 'class' => 'form-control']) !!}
        </div>
        @if (empty($relation))
            <div class="form-group">
                <label>
                    {!! Form::checkbox('two_way') !!}
                    {{ trans('organisations.relations.fields.two_way') }}
                </label>
                <p class="help-block">{{ trans('organisations.relations.hints.two_way') }}</p>
            </div>
        @endif
    </div>
</div>