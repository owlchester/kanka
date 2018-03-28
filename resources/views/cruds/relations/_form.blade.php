{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            <label>{{ trans('relations.fields.target') }}</label>
            {!! Form::select('target_id', (!empty($relation) && $relation->target ? [
                $relation->target->id => $relation->target->child->name . ' (' . trans('entities.' . $relation->target->type) . ')'
            ] : []), null, ['id' => 'target', 'class' => 'form-control select2', 'style' => 'width: 100%',
            'data-url' => route('search.relations'), 'data-placeholder' => trans('relations.placeholders.target')]) !!}
        </div>

        <div class="form-group required">
            <label>{{ trans('relations.fields.relation') }}</label>
            {!! Form::text('relation', null, ['placeholder' => trans('relations.placeholders.relation'), 'class' => 'form-control', 'maxlength' => 45]) !!}
        </div>

        @if (Auth::user()->isAdmin())
        <div class="form-group">
            <label>
                {!! Form::hidden('is_private', 0) !!}
                {!! Form::checkbox('is_private') !!}
                {{ trans('crud.fields.is_private') }}
                <p class="help-block">{{ trans('crud.hints.is_private') }}</p>
            </label>
        </div>
        @endif

        @if(empty($relation) && (!isset($mirror) || $mirror == true))
            <div class="form-group">
                <label>
                    {!! Form::checkbox('two_way') !!}
                    {{ trans('relations.fields.two_way') }}
                </label>
                <p class="help-block">{{ trans('relations.hints.two_way') }}</p>
            </div>
        @endif
    </div>
</div>