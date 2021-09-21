@php
$required = !isset($bulk);
@endphp

<div class="form-group @if($required) required @endif">

    {!! Form::foreignSelect(
        'target_id',
        [
            'preset' => !empty($target) ? $target : null,
            'class' => App\Models\Entity::class,
            'enableNew' => false,
            'labelKey' => 'entities/relations.fields.target',
            'searchRouteName' => 'search.entities-with-relations',
            'placeholderKey' => 'crud.placeholders.entity',
            'allowClear' => false,
        ]
    ) !!}
</div>
