<?php /** @var \App\Models\AttributeTemplate $model */?>
@if (!empty($model->attributeTemplate))
| {{ __('crud.fields.parent') }} | {!! $model->attributeTemplate->tooltipedLink() !!} |
@endif
@if (!empty($model->entityType))
| {{ __('attribute_templates.fields.auto_apply') }} | {!! $model->entityType->name() !!} |
@endif
