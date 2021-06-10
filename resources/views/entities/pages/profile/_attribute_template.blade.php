<?php /** @var \App\Models\AttributeTemplate $model */

?>
<div class="box box-solid">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4">
                @if ($model->attributeTemplate)
                    <p>
                        <b>{{ __('attribute_templates.fields.attribute_template') }}</b><br />
                        {!! $model->attributeTemplate->tooltipedLink() !!}
                    </p>
                @endif
                @if ($model->entityType)
                    <p>
                        <b>{{ __('crud.fields.entity_type') }}</b><br />
                        {!! $model->entityType->name() !!}
                    </p>
                @endif
            </div>
        </div>
    </div>
</div>
