{{ csrf_field() }}
<x-grid>
    @include('cruds.fields.owner', ['owner' => !empty($relation) ? $relation->owner : null])
    @include('cruds.fields.target', ['target' => !empty($relation) ? $relation->target : null])

    @include('cruds.fields.relation')

    @include('cruds.fields.colour_picker')
    @include('cruds.fields.attitude')

    @include('cruds.fields.visibility_id', ['model' => $relation ?? null])

    @if(empty($relation) && (!isset($mirror) || $mirror == true))
        <x-forms.field field="two-way">
            <label class="" data-toggle="collapse" data-target="#two-way-relation">
                {!! Form::checkbox('two_way') !!}
                {{ __('entities/relations.fields.two_way') }}
                <x-helpers.tooltip :title="__('entities/relations.hints.two_way')" />
            </label>
            <p class="text-neutral-content md:hidden">{{ __('entities/relations.hints.two_way') }}</p>
        </x-forms.field>

        <div class="collapse !visible" id="two-way-relation">
            <x-forms.field field="target-relation">
                <label>
                    {!! __('entities/relations.fields.target_relation') !!}
                    <x-helpers.tooltip :title="__('entities/relations.hints.target_relation')" />
                </label>
                {!! Form::text('target_relation', null, ['class' => '', 'maxlength' => 191, 'placeholder' => __('entities/relations.placeholders.target_relation')]) !!}
                <p class="text-neutral-content md:hidden">{{ __('entities/relations.hints.target_relation') }}</p>
            </x-forms.field>
        </div>
    @endif

    @include('cruds.fields.pinned')

</x-grid>

@if (!empty($relation) && !empty($relation->isMirrored()))
    <x-alert type="info">
        <h4><i class="fa-solid fa-sync-alt"></i> {{ __('entities/relations.hints.mirrored.title') }}</h4>
        <p>{!! __('entities/relations.hints.mirrored.text', [
        'link' => '<a href="' . $relation->target->url() . '" data-toggle="tooltip-ajax" data-id="' . $relation->target_id . '" data-url="' . route('entities.tooltip', [$campaign, $relation->target->id]) . "\">" . $relation->target->name . '</a>'
        ]) !!}</p>
    </x-alert>
@endif

@if (!empty($mode))
    <input type="hidden" name="mode" value="{{ $mode }}" />
@endif
