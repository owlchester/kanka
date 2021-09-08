@php
$required = !isset($bulk);
@endphp

<div class="form-group @if($required) required @endif">
    {!! Form::select2(
        'owner_id',
        !empty($owner) ? $owner : null,
        App\Models\Entity::class,
        false,
        'entities/relations.fields.owner',
        'search.entities-with-relations',
        'crud.placeholders.entity'
    ) !!}
</div>
