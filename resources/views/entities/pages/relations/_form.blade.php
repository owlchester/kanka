@empty($relation)<x-helper>
    <p>{!! __('entities/relations.create.helper', ['name' => $entity->name]) !!}</p>
</x-helper>@endif

<x-grid xdata="{opened: {{ old('two_way', false) ? 'true' : 'false' }}}">
    <div class="col-span-2">
        @include('cruds.fields.target', ['target' => !empty($relation) ? $relation->target : null])
    </div>

    @include('cruds.fields.relation')

    @include('cruds.fields.attitude', ['model' => $relation ?? null])

@if(empty($relation) && (!isset($mirror) || $mirror == true))

    @include('entities.pages.relations.fields.mirrored')

@endif

@if (!empty($relation) && !empty($relation->isMirrored()))
    @include('entities.pages.relations.fields.unmirror')

@endif

    <hr class="col-span-2" />

    @include('cruds.fields.visibility_id', ['model' => isset($relation) ? $relation : null])

    @include('cruds.fields.colour_picker', request()->ajax() ? ['dropdownParent' => '#primary-dialog', 'model' => $relation ?? null] : ['model' => $relation ?? null])

    @include('cruds.fields.pinned', ['model' => $relation ?? null])
</x-grid>
@if (!empty($mode))
    <input type="hidden" name="mode" value="{{ $mode }}" />
@endif
