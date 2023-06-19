<?php /** @var \App\Models\AttributeTemplate $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if (!empty($model->attributeTemplate))
        <div class="element profile-attribute-template">
            <div class="title text-uppercase text-xs">{{ __('crud.fields.parent') }}</div>
            {!! $model->attributeTemplate->tooltipedLink() !!}
        </div>
    @endif

    @if (!empty($model->entityType))
        <div class="element profile-entity-type">
            <div class="title text-uppercase text-xs">{{ __('attribute_templates.fields.auto_apply') }}</div>
            {!! $model->entityType->name() !!}
        </div>
    @endif
</x-sidebar.profile>
