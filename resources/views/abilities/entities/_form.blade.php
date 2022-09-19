<?php /** @var \App\Models\Ability $model */?>
{{ csrf_field() }}
<div class="form-group required">
    {!! Form::select2(
        'entity_id',
        null,
        App\Models\Entity::class,
        false,
        'crud.fields.entity',
        'search.ability-entities',
        'entities/relations.placeholders.target',
        $model
    ) !!}
</div>

@include('cruds.fields.visibility_id', ['model' => null])

<div class="form-group">
    <button class="btn btn-success">{{ __('crud.save') }}</button>
    @includeWhen(!$ajax, 'partials.or_cancel')
</div>

