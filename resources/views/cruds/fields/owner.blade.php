@php
$required = !isset($bulk);
@endphp

<div class="form-group @if($required) required @endif">
    {!! Form::foreignSelect(
        'owner_id',
        [
            'preset' => !empty($owner) ? $owner : null,
            'class' => App\Models\Entity::class,
            'enableNew' => false,
            'labelKey' => 'entities/relations.fields.owner',
            'searchRouteName' => 'search.entities-with-relations',
            'placeholderKey' => 'crud.placeholders.entity',
            'allowClear' => isset($bulk) ? true : false,
        ]
    ) !!}
</div>
