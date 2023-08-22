<?php /** @var \App\Models\Tag $model */?>
{{ csrf_field() }}
<div class="field-entity required">
    @include('cruds.fields.entity', [
        'placeholder' => __('entities/relations.placeholders.target'),
        'preset' => false,
        'route' => 'search.tag-children',
        'dropdownParent' => '#entity-modal'
    ])
</div>


