{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            {!! Form::select2(
                'target_id',
                (!empty($relation) && $relation->target ? $relation->target : null),
                App\Models\Entity::class,
                false,
                'relations.fields.target',
                'search.entities-with-relations',
                'relations.placeholders.target'
            ) !!}
        </div>

        <div class="form-group required">
            <label>{{ trans('relations.fields.relation') }}</label>
            {!! Form::text('relation', null, ['placeholder' => trans('relations.placeholders.relation'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>

        @if (Auth::user()->isAdmin())
        <div class="form-group">
            <label>
                {!! Form::hidden('is_private', 0) !!}
                {!! Form::checkbox('is_private') !!}
                {{ trans('crud.fields.is_private') }}
            </label>
            <p class="help-block">{{ trans('crud.hints.is_private') }}</p>
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