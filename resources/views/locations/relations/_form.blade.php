{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('locations.relations.fields.second') }}</label>
            {!! Form::select('second_id', (!empty($relation) && $relation->second ? [$relation->second->id => $relation->second->name] : []), null, ['id' => 'second_id', 'class' => 'form-control select2', 'style' => 'width: 100%',
             'data-url' => route('locations.find'), 'data-placeholder' => trans('locations.relations.placeholders.second')]) !!}
        </div>

        <div class="form-group required">
            <label>{{ trans('locations.relations.fields.relation') }}</label>
            {!! Form::text('relation', null, ['placeholder' => trans('locations.relations.placeholders.relation'), 'class' => 'form-control']) !!}
        </div>

        @if (empty($relation))
            <div class="form-group">
                <label>
                    {!! Form::checkbox('two_way') !!}
                    {{ trans('locations.relations.fields.two_way') }}
                </label>
                <p class="help-block">{{ trans('locations.relations.hints.two_way') }}</p>
            </div>
        @endif
    </div>
</div>
