<?php /** @var \App\Models\AttributeTemplate $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<x-sidebar.profile>
    @if (!empty($model->attributeTemplate))
        <div class="element profile-attribute-template">
            <div class="title text-uppercase text-xs">{{ __('crud.fields.parent') }}</div>
            <x-entity-link
                :entity="$model->attributeTemplate->entity"
                :campaign="$campaign" />
        </div>
    @endif

    @if (!empty($model->entityType))
        <div class="element profile-entity-type">
            <div class="title text-uppercase text-xs">{{ __('attribute_templates.fields.auto_apply') }}</div>
            {!! $model->entityType->name() !!}
        </div>
    @endif
</x-sidebar.profile>
