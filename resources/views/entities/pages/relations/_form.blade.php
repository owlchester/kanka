{{ csrf_field() }}

<x-grid>
    @include('cruds.fields.entity', [
        'name' => 'target_id',
        'required' => true,
        'preset' => !empty($relation) && $relation->target ? $relation->target : null,
        'label' => __('entities/relations.fields.target'),
        'placeholder' => __('entities/relations.placeholders.target'),
        'dropdownParent' => request()->ajax() ? '#connection-dialog' : null,
        'allowClear' => false,
    ])
    <div class="field-relation required">
        <label>{{ __('entities/relations.fields.relation') }}</label>
        {!! Form::text('relation', null, ['placeholder' => __('entities/relations.placeholders.relation'), 'class' => 'form-control', 'maxlength' => 191, 'required']) !!}
    </div>
    @include('cruds.fields.colour_picker', request()->ajax() ? ['dropdownParent' => '#connection-dialog'] : [])
    @include('cruds.fields.attitude')

@if(empty($relation) && (!isset($mirror) || $mirror == true))
    <div class="field-two-way">
        <label class="" data-toggle="collapse" data-target="#two-way-relation">
            {!! Form::checkbox('two_way') !!}
            {{ __('entities/relations.fields.two_way') }}
            <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-title="{{ __('entities/relations.hints.two_way') }}" data-toggle="tooltip" aria-hidden="true"></i>
        </label>
        <p class="help-block visible-xs visible-sm">{{ __('entities/relations.hints.two_way') }}</p>
    </div>
    <div class="field-target-relation">
        <div class="collapse !visible" id="two-way-relation">
            <label>
                {!! __('entities/relations.fields.target_relation') !!}
                <i class="fa-solid fa-question-circle hidden-xs hidden-sm" data-title="{{ __('entities/relations.hints.target_relation') }}" data-toggle="tooltip" aria-hidden="true"></i>
            </label>
            {!! Form::text('target_relation', null, ['class' => 'form-control', 'maxlength' => 191, 'placeholder' => __('entities/relations.placeholders.target_relation')]) !!}
            <p class="help-block visible-xs visible-sm">{{ __('entities/relations.hints.target_relation') }}</p>
        </div>
    </div>
@endif

@if (!empty($relation) && !empty($relation->isMirrored()))
    <div class="col-span-2">
        <x-alert type="info">
            <h4>{{ __('entities/relations.hints.mirrored.title') }}</h4>
            <p>{!! __('entities/relations.hints.mirrored.text', [
            'link' => '<a href="' . $relation->target->url() . '" data-toggle="tooltip-ajax" data-id="' . $relation->target_id . '" data-url="' . route('entities.tooltip', [$campaign, $relation->target->id]) . "\">" . $relation->target->name . '</a>'
            ]) !!}</p>
            <div class="field-unmirror">
                {!! Form::hidden('unmirror', 0) !!}
                <label>{!! Form::checkbox('unmirror', 1)!!}
                    {{ __('entities/relations.fields.unmirror') }}
                </label>
            </div>
        </x-alert>
    </div>
@endif


    @include('cruds.fields.pinned', ['model' => $relation ?? null])
    @include('cruds.fields.visibility_id', ['model' => isset($relation) ? $relation : null])
</x-grid>
@if (!empty($mode))
    <input type="hidden" name="mode" value="{{ $mode }}" />
@endif
