@php
$required = !isset($bulk);
@endphp

<div class="form-group @if($required) required @endif">
    {!! Form::select2(
        'target_id',
        !empty($target) ? $target : null,
        App\Models\Entity::class,
        false,
        'entities/relations.fields.target',
        'search.entities-with-relations',
        'crud.placeholders.entity'
    ) !!}
</div>
