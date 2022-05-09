<?php /** @var \App\Models\AttributeTemplate $model */?>

@if (!$model->showProfileInfo())
    @php return @endphp
@endif

<div class="sidebar-section-box sidebar-section-profile">
    <div class="sidebar-section-title cursor" data-toggle="collapse" data-target="#sidebar-profile-elements">
        <i class="fa-solid fa-chevron-right" style="display: none"></i>
        <i class="fa-solid fa-chevron-down"></i>
        {{ __('crud.tabs.profile') }}
    </div>

    <div class="sidebar-elements collapse in" id="sidebar-profile-elements">
        @if (!empty($model->attributeTemplate))
            <div class="element profile-attribute-template">
                <div class="title">{{ __('attribute_templates.fields.attribute_template') }}</div>
                {!! $model->attributeTemplate->tooltipedLink() !!}
            </div>
        @endif

        @if (!empty($model->entityType))
            <div class="element profile-entity-type">
                <div class="title">{{ __('crud.fields.entity_type') }}</div>
                {!! $model->entityType->name() !!}
            </div>
        @endif
    </div>
</div>
