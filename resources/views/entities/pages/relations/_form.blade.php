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
    <div class="col-sm-6">
        @include('cruds.fields.colour_picker', request()->ajax() ? ['dropdownParent' => '#entity-modal'] : null)
    </div>
    <div class="col-sm-6">
        @include('cruds.fields.attitude')
    </div>
</div>

@if(empty($relation) && (!isset($mirror) || $mirror == true))
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>
                    {!! Form::checkbox('two_way') !!}
                    {{ __('entities/relations.fields.two_way') }}
                    <i class="fa fa-question-circle hidden-xs hidden-sm" title="{{ __('entities/relations.hints.two_way') }}" data-toggle="tooltip"></i>
                </label>
                <p class="help-block visible-xs visible-sm">{{ __('entities/relations.hints.two_way') }}</p>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group" style="display:none" id="two-way-relation">
                <label>
                    {!! __('entities/relations.fields.target_relation') !!}
                    <i class="fa fa-question-circle hidden-xs hidden-sm" title="{{ __('entities/relations.hints.target_relation') }}" data-toggle="tooltip"></i>
                </label>
                {!! Form::text('target_relation', null, ['class' => 'form-control', 'maxlength' => 191]) !!}
                <p class="help-block visible-xs visible-sm">{{ __('entities/relations.hints.target_relation') }}</p>
            </div>
        </div>
    </div>
@endif

<div class="form-group">
    {!! Form::hidden('is_star', 0) !!}
    <label>
        {!! Form::checkbox('is_star', 1, !empty($relation) ? $relation->is_star : 0) !!}
        {{ __('crud.fields.is_star') }}
        <i class="fa fa-question-circle hidden-xs hidden-sm" title="{{ __('crud.hints.is_star') }}" data-toggle="tooltip"></i>
    </label>
    <p class="help-block visible-xs visible-sm">{{ __('crud.hints.is_star') }}</p>
</div>

@if (!empty($relation) && !empty($relation->mirrored()))
    <div class="callout callout-info">
        <h4>{{ __('entities/relations.hints.mirrored.title') }}</h4>
        <p>{!! __('entities/relations.hints.mirrored.text', [
        'link' => '<a href="' . $relation->target->url() . '" data-toggle="tooltip-ajax" data-id="' . $relation->target_id . '" data-url="' . route('entities.tooltip', $relation->target->id) . "\">" . $relation->target->name . '</a>'
        ]) !!}</p>
    </div>
@endif

@include('cruds.fields.visibility', ['model' => isset($relation) ? $relation : null])

@if (!empty($mode))
    <input type="hidden" name="mode" value="{{ $mode }}" />
@endif
