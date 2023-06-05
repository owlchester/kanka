{{ csrf_field() }}

@include('cruds.fields.entity', [
    'name' => 'target_id',
    'required' => true,
    'preset' => !empty($relation) && $relation->target ? $relation->target : null,
    'label' => __('entities/relations.fields.target'),
    'placeholder' => __('entities/relations.placeholders.target'),
    'dropdownParent' => request()->ajax() ? '#entity-modal' : null,
    'allowClear' => false,
])
<div class="form-group required">
    <label>{{ __('entities/relations.fields.relation') }}</label>
    {!! Form::text('relation', null, ['placeholder' => __('entities/relations.placeholders.relation'), 'class' => 'form-control', 'maxlength' => 191, 'required']) !!}
</div>

<x-grid>
    @include('cruds.fields.colour_picker', request()->ajax() ? ['dropdownParent' => '#entity-modal'] : [])
    @include('cruds.fields.attitude')
</x-grid>

@if(empty($relation) && (!isset($mirror) || $mirror == true))
    <div class="grid gap-5 grid-cols-1 md:grid-cols-2 mb-4">

        <div class="form-group mb-0">
            <label>
                {!! Form::checkbox('two_way') !!}
                {{ __('entities/relations.fields.two_way') }}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" title="{{ __('entities/relations.hints.two_way') }}" data-toggle="tooltip"></i>
            </label>
            <p class="help-block visible-xs visible-sm">{{ __('entities/relations.hints.two_way') }}</p>
        </div>
        <div class="form-group mb-0" style="display:none" id="two-way-relation">
            <label>
                {!! __('entities/relations.fields.target_relation') !!}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" title="{{ __('entities/relations.hints.target_relation') }}" data-toggle="tooltip"></i>
            </label>
            {!! Form::text('target_relation', null, ['class' => 'form-control', 'maxlength' => 191, 'placeholder' => __('entities/relations.placeholders.target_relation')]) !!}
            <p class="help-block visible-xs visible-sm">{{ __('entities/relations.hints.target_relation') }}</p>
        </div>
    </div>
@endif

<div class="grid gap-5 grid-cols-1 md:grid-cols-2 mb-4">
    @include('cruds.fields.pinned', ['model' => $relation ?? null])
</div>

@if (!empty($relation) && !empty($relation->isMirrored()))
    <x-alert type="info">
        <h4>{{ __('entities/relations.hints.mirrored.title') }}</h4>
        <p>{!! __('entities/relations.hints.mirrored.text', [
        'link' => '<a href="' . $relation->target->url() . '" data-toggle="tooltip-ajax" data-id="' . $relation->target_id . '" data-url="' . route('entities.tooltip', $relation->target->id) . "\">" . $relation->target->name . '</a>'
        ]) !!}</p>
        <div class="form-group">
            {!! Form::hidden('unmirror', 0) !!}
            <label>{!! Form::checkbox('unmirror', 1)!!}
                {{ __('entities/relations.fields.unmirror') }}
            </label>
        </div>
    </x-alert>
@endif

@include('cruds.fields.visibility_id', ['model' => isset($relation) ? $relation : null])

@if (!empty($mode))
    <input type="hidden" name="mode" value="{{ $mode }}" />
@endif
