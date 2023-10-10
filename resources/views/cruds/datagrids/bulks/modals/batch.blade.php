<?php /** @var \App\Datagrids\Bulks\Bulk $bulk */ $fieldCount = 0;?>
{!! Form::open(['url' => route('bulk.process', $campaign), 'method' => 'POST']) !!}
<x-dialog id="bulk-edit" :title="__('crud.bulk.edit.title')" footer="cruds.datagrids.bulks.modals._batch-footer">
    <x-grid>
        @foreach ($bulk->fields() as $field)
            @php 
                $trimmed = \Illuminate\Support\Str::between($field,'parent_', '_id'); 
                $isParent = \Illuminate\Support\Str::contains($field, 'parent');
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

{!! Form::hidden('mode', $mode) !!}
{!! Form::hidden('models', null, ['id' => 'datagrid-bulk-batch-models']) !!}
{!! Form::close() !!}

