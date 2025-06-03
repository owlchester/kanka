@empty($relation)<x-helper>
    <p>{{ __('entities/relations.create.helper', ['name' => $entity->name]) }}</p>
</x-helper>@endif

<x-grid xdata="{opened: {{ old('two_way', false) ? 'true' : 'false' }}}">
@if(empty($relation))
    <x-forms.foreign
        field="targets"
        required
        label="entities/relations.fields.targets"
        :multiple="true"
        name="targets[]"
        id="targets[]"
        :campaign="$campaign"
        :route="route('search.entities-with-relations', [$campaign])"
    >
    </x-forms.foreign>
@else
    @include('cruds.fields.entity', [
        'name' => 'target_id',
        'required' => true,
        'preset' => !empty($relation) && $relation->target ? $relation->target : null,
        'label' => __('entities/relations.fields.target'),
        'placeholder' => __('entities/relations.placeholders.target'),
        'dropdownParent' => request()->ajax() ? '#primary-dialog' : null,
        'allowClear' => false,
    ])
@endif
    <x-forms.field field="relation" required :label="__('entities/relations.fields.relation')">
        <input type="text" name="relation" value="{!! htmlspecialchars(old('relation', $relation->relation ?? null)) !!}" maxlength="191" class="w-full" aria-label="{{ __('entities/relations.placeholders.relation') }}" placeholder="{{ __('entities/relations.placeholders.relation') }}" />
        <x-slot name="helper">{{ __('entities/relations.helpers.description') }}</x-slot>
    </x-forms.field>

    @include('cruds.fields.colour_picker', request()->ajax() ? ['dropdownParent' => '#primary-dialog', 'model' => $relation ?? null] : ['model' => $relation ?? null])
    @include('cruds.fields.attitude', ['model' => $relation ?? null])

@if(empty($relation) && (!isset($mirror) || $mirror == true))
    <x-forms.field
        field="field-two-way"
        :label="__('entities/relations.fields.two_way')">
        <x-checkbox
            :text="__('entities/relations.hints.two_way')">
            <input type="checkbox" name="two_way" value="1" @if (old('two_way', false)) checked="checked" @endif @click="opened = !opened" />
        </x-checkbox>
    </x-forms.field>

    <div>
        <div x-show="opened">
            <x-forms.field
                field="target-relation"
                :label="__('entities/relations.fields.target_relation')"
                :helper="__('entities/relations.hints.target_relation')"
                >
                <input type="text" name="target_relation" value="{{ old('target_relation', $relation->target_relation ?? null) }}" maxlength="191" class="w-full" aria-label="{{ __('entities/relations.placeholders.target_relation') }}" placeholder="{{ __('entities/relations.placeholders.target_relation') }}" />
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
                <input type="hidden" name="unmirror" value="0" />
                <x-checkbox :text="__('entities/relations.fields.unmirror')">
                    <input type="checkbox" name="unmirror" value="1" @if (old('unmirror', false)) checked="checked" @endif />
                </x-checkbox>
            </x-forms.field>
        </x-alert>
    </div>
@endif

    @include('cruds.fields.pinned', ['model' => $relation ?? null])
    @include('cruds.fields.visibility_id', ['model' => isset($relation) ? $relation : null])
</x-grid>
@if (!empty($mode))
    <input type="hidden" name="mode" value="{{ $mode }}" />
@endif
