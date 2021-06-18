<?php /** @var \App\Models\AttributeTemplate $model */

?>
<div class="box box-solid box-entity-profile">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->attributeTemplate)
                    <p class="entity-template" data-foreign="{{ $model->attribute_template_id }}">
                        <b>{{ __('attribute_templates.fields.attribute_template') }}</b><br />
                        {!! $model->attributeTemplate->tooltipedLink() !!}
                    </p>
                @endif
                @if ($model->entityType)
                    <p class="entity-type">
                        <b>{{ __('crud.fields.entity_type') }}</b><br />
                        {!! $model->entityType->name() !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
