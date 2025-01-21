<?php /** @var \App\Datagrids\Bulks\Bulk $bulk */ $fieldCount = 0;?>
<x-form :action="['bulk.process', $campaign]" direct>
<x-dialog id="bulk-edit" :title="__('crud.bulk.edit.title')" footer="cruds.datagrids.bulks.modals._batch-footer">
    <x-grid>
        @foreach ($bulk->fields() as $field)
            @php
                $trimmed = \Illuminate\Support\Str::before($field, '_id');
                $isParent = isset($entityType) ? \Illuminate\Support\Str::contains($trimmed, $entityType->code) : false;
            @endphp

            {!! $fieldCount % 2 === 0 ? '' : null !!}
            @include('cruds.fields.' . $trimmed, [
                'trans' => $name,
                'base' => $model,
                'bulk' => true,
                'parent' => \Illuminate\Support\Str::plural($trimmed) == $name,
                'allowNew' => false,
                'dropdownParent' => '#bulk-edit',
                'route' => null,
                'isParent' => $isParent,
            ])
            @php $fieldCount++; @endphp
        @endforeach
    </x-grid>
</x-dialog>
<input type="hidden" name="datagrid-action" value="batch" />
<input type="hidden" name="entity" value="{{ $name }}" />
<input type="hidden" name="mode" value="{{ $mode }}" />
<input type="hidden" name="models" value="" id="datagrid-bulk-batch-models" />
@isset($entityType) <input type="hidden" name="entity_type" value="{{ $entityType->id }}" />@endisset
</x-form>

