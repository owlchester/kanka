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
            {!! Form::text('relation', null, ['placeholder' => trans('entities/relations.placeholders.relation'), 'class' => 'form-control', 'maxlength' => 191]) !!}
        </div>

        <div class="form-group">
            <label>{{ trans('relations.fields.attitude') }}</label>
            {!! Form::number('attitude', null, ['placeholder' => trans('entities/relations.placeholders.attitude'), 'class' => 'form-control', 'min' => -100, 'max' => 100]) !!}
        </div>

        @include('cruds.fields.visibility', ['model' => isset($relation) ? $relation : null])

        @if(empty($relation) && (!isset($mirror) || $mirror == true))
            <div class="form-group">
                <label>
                    {!! Form::checkbox('two_way') !!}
                    {{ trans('relations.fields.two_way') }}
                </label>
                <p class="help-block">{{ trans('relations.hints.two_way') }}</p>
            </div>
        @endif

        <div class="form-group">
            {!! Form::hidden('is_star', 0) !!}
            <label>{!! Form::checkbox('is_star', 1, !empty($model) ? $model->is_star : 0) !!}
                {{ trans('crud.fields.is_star') }}
            </label>
            <p class="help-block">{{ trans('crud.hints.is_star') }}</p>
        </div>

        @if (!empty($relation) && !empty($relation->mirrored()))
            <div class="callout callout-info">
                <h4>{{ __('relations.hints.mirrored.title') }}</h4>
                <p>{!! __('relations.hints.mirrored.text', ['link' => '<a href="' . $relation->target->url() . '" data-toggle="tooltip-ajax" data-id="' . $relation->target_id . '" data-url="' . route('entities.tooltip', $relation->target->entity->id) . "'>" . $relation->target->name . '</a>']) !!}</p>
            </div>
        @endif
    </div>
</div>
