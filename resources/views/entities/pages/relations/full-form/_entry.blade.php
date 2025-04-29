<x-grid>
    @include('cruds.fields.owner', ['owner' => !empty($relation) ? $relation->owner : null])
    @include('cruds.fields.target', ['target' => !empty($relation) ? $relation->target : null])

    @include('cruds.fields.relation')

    @include('cruds.fields.colour_picker')
    @include('cruds.fields.attitude', ['model' => $relation ?? null])

    @include('cruds.fields.visibility_id', ['model' => $relation ?? null])

    @if(empty($relation) && (!isset($mirror) || $mirror == true))
        <x-forms.field field="two-way">
            <x-checkbox :text="__('entities/relations.hints.two_way')" :label="__('entities/relations.fields.two_way')">
                <input type="checkbox" name="two_way" value="1" @if (old('two_way', false)) checked="checked" @endif data-animate="collapse" data-target="#two-way-relation" />
            </x-checkbox>
        </x-forms.field>

    <div>
        <div class="hidden" id="two-way-relation">
            <x-forms.field field="target-relation">
                <label>
                    {!! __('entities/relations.fields.target_relation') !!}
                    <x-helpers.tooltip :title="__('entities/relations.hints.target_relation')" />
                </label>
                <input type="text" name="target_relation" value="{{ old('target_relation', $model->target_relation ?? null) }}" maxlength="191" class="w-full" aria-label="{{ __('entities/relations.placeholders.target_relation') }}" placeholder="{{ __('entities/relations.placeholders.target_relation') }}" />
                <p class="text-neutral-content md:hidden">{{ __('entities/relations.hints.target_relation') }}</p>
            </x-forms.field>
        </div>
    </div>
    @endif

    @include('cruds.fields.pinned')

</x-grid>

@if (!empty($relation) && !empty($relation->isMirrored()))
    <x-alert type="info">
        <h4>
            <x-icon class="fa-solid fa-sync-alt" />
            {{ __('entities/relations.hints.mirrored.title') }}
        </h4>
        <p>{!! __('entities/relations.hints.mirrored.text', [
        'link' => '<a href="' . $relation->target->url() . '" data-toggle="tooltip-ajax" data-id="' . $relation->target_id . '" data-url="' . route('entities.tooltip', [$campaign, $relation->target->id]) . "\">" . $relation->target->name . '</a>'
        ]) !!}</p>
    </x-alert>
@endif

@if (!empty($mode))
    <input type="hidden" name="mode" value="{{ $mode }}" />
@endif
