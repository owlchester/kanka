<?php /** @var \App\Datagrids\Bulks\ $bulk */ $fieldCount = 0;?>
<x-grid>
    @foreach ($bulk->fields() as $field)
        @php
            $trimmed = \Illuminate\Support\Str::before($field, '_id');
            $isParent = $field === 'parent_id';
        @endphp

        {!! $fieldCount % 2 === 0 ? '' : null !!}
        @include('cruds.fields.' . $trimmed, [
            'trans' => $isParent ? 'crud' : 'entities',
            'base' => $model ?? null,
            'bulk' => true,
            'parent' => false,
            'allowNew' => false,
            'dropdownParent' => '#primary-dialog',
            'route' => null,
            'isParent' => $isParent,
        ])
        @php $fieldCount++; @endphp
    @endforeach
</x-grid>
