<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'attribute_template',
        'plural' => 'attribute_templates',
        'icon' => config('entities.icons.attribute_template'),
        'id' => config('entities.ids.attribute_template'),
    ])
    @include('entities.creator.selection._full', ['key' => 'attribute_templates'])
</div>
