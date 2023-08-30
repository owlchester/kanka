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
    <x-forms.field field="relation" :required="true" :label="__('entities/relations.fields.relation')">
        {!! Form::text('relation', null, ['placeholder' => __('entities/relations.placeholders.relation'), 'class' => '', 'maxlength' => 191, 'required']) !!}
    </x-forms.field>

    @include('cruds.fields.colour_picker', request()->ajax() ? ['dropdownParent' => '#connection-dialog'] : [])
    @include('cruds.fields.attitude')

@if(empty($relation) && (!isset($mirror) || $mirror == true))
    <x-forms.field field="field-two-way" :label="__('entities/relations.fields.two_way')">
        <label class="text-neutral-content cursor-pointer flex gap-2" data-toggle="collapse" data-target="#two-way-relation">
            {!! Form::checkbox('two_way') !!}
            {{ __('entities/relations.hints.two_way') }}
        </label>
    </x-forms.field>

    <div>
    <div class="collapse !visible" id="two-way-relation">
        <x-forms.field
            field="target-relation"
            :label="__('entities/relations.fields.target_relation')"
            :helper="__('entities/relations.hints.target_relation')"
            :tooltip="true">
        {!! Form::text('target_relation', null, ['class' => '', 'maxlength' => 191, 'placeholder' => __('entities/relations.placeholders.target_relation')]) !!}
        </x-forms.field>
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
            <x-forms.field field="unmirror">
                {!! Form::hidden('unmirror', 0) !!}
                <label class="cursor-pointer flex gap-1">
                    {!! Form::checkbox('unmirror', 1)!!}
                    {{ __('entities/relations.fields.unmirror') }}
                </label></x-forms.field>
        </x-alert>
    </div>
@endif

    @include('cruds.fields.pinned', ['model' => $relation ?? null])
    @include('cruds.fields.visibility_id', ['model' => isset($relation) ? $relation : null])
</x-grid>
@if (!empty($mode))
    <input type="hidden" name="mode" value="{{ $mode }}" />
@endif
