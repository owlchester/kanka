<x-grid xdata="{opened: false}">
    @include('cruds.fields.owner', ['owner' => !empty($relation) ? $relation->owner : null])
    @include('cruds.fields.target', ['target' => !empty($relation) ? $relation->target : null])

    @include('cruds.fields.relation')

    @include('cruds.fields.attitude', ['model' => $relation ?? null])

    @if(empty($relation) && (!isset($mirror) || $mirror == true))
        @include('entities.pages.relations.fields.mirrored')
    @endif

    @if (!empty($relation) && !empty($relation->isMirrored()))
        @include('entities.pages.relations.fields.unmirror')
    @endif

    <hr class="col-span-2" />

    @include('cruds.fields.visibility_id', ['model' => $relation ?? null])

    @include('cruds.fields.colour_picker', request()->ajax() ? ['dropdownParent' => '#primary-dialog'] : [])

    @include('cruds.fields.pinned')

</x-grid>


@if (!empty($mode))
    <input type="hidden" name="mode" value="{{ $mode }}" />
@endif
