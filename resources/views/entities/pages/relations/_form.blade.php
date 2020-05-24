{{ csrf_field() }}
<div class="form-group required">
    {!! Form::select2(
        'target_id',
        (!empty($relation) && $relation->target ? $relation->target : null),
        App\Models\Entity::class,
        false,
        'entities/relations.fields.target',
        'search.entities-with-relations',
        'entities/relations.placeholders.target'
    ) !!}
</div>
<div class="form-group required">
    <label>{{ __('entities/relations.fields.relation') }}</label>
    {!! Form::text('relation', null, ['placeholder' => __('entities/relations.placeholders.relation'), 'class' => 'form-control', 'maxlength' => 191]) !!}
</div>

<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label>{{ trans('crud.fields.colour') }}</label><br />
            {!! Form::text('colour', null, ['class' => 'form-control spectrum', 'maxlength' => 7] ) !!}
        </div>
    </div>
    <div class="col-sm-8">
        <div class="form-group">
            <label>{{ __('entities/relations.fields.attitude') }}</label>
            {!! Form::number('attitude', null, ['placeholder' => __('entities/relations.placeholders.attitude'), 'class' => 'form-control', 'min' => -100, 'max' => 100]) !!}
            <p class="help-block">{{ __('entities/relations.hints.attitude') }}</p>
        </div>
    </div>
</div>

@include('cruds.fields.visibility', ['model' => isset($relation) ? $relation : null])

@if(empty($relation) && (!isset($mirror) || $mirror == true))
    <div class="form-group">
        <label>
            {!! Form::checkbox('two_way') !!}
            {{ __('entities/relations.fields.two_way') }}
        </label>
        <p class="help-block">{{ __('entities/relations.hints.two_way') }}</p>
    </div>
@endif

<div class="form-group">
    {!! Form::hidden('is_star', 0) !!}
    <label>{!! Form::checkbox('is_star', 1, !empty($relation) ? $relation->is_star : 0) !!}
        {{ trans('crud.fields.is_star') }}
    </label>
    <p class="help-block">{{ trans('crud.hints.is_star') }}</p>
</div>

@if (!empty($relation) && !empty($relation->mirrored()))
    <div class="callout callout-info">
        <h4>{{ __('entities/relations.hints.mirrored.title') }}</h4>
        <p>{!! __('entities/relations.hints.mirrored.text', [
        'link' => '<a href="' . $relation->target->url() . '" data-toggle="tooltip-ajax" data-id="' . $relation->target_id . '" data-url="' . route('entities.tooltip', $relation->target->id) . "\">" . $relation->target->name . '</a>'
        ]) !!}</p>
    </div>
@endif
