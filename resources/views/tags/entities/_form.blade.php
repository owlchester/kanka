<?php /** @var \App\Models\Tag $model */?>
{{ csrf_field() }}
<div class="row">
    <div class="col-md-12">
        <div class="form-group required">
            @include('cruds.fields.entity', [
                'placeholder' => __('entities/relations.placeholders.target'),
                'preset' => false,
                'route' => 'search.tag-children'
            ])
        </div>
    </div>
</div>


