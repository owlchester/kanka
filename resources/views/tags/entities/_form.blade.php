<?php /** @var \App\Models\Tag $model */?>
{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            {!! Form::select2(
                'entity_id',
                null,
                App\Models\Entity::class,
                false,
                'crud.fields.entity',
                'search.tag-children',
                'entities/relations.placeholders.target',
                $model
            ) !!}
        </div>
    </div>
</div>


