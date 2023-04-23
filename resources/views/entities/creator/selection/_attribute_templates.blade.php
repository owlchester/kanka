<div class="option flex">

    @include('entities.creator.selection._main', [
        'singular' => 'attribute_template',
        'plural' => 'attribute_templates',
        'icon' => 'fa-solid fa-copy',
        'id' => config('entities.ids.attribute_template'),
    ])
    @include('entities.creator.selection._full', ['key' => 'attribute_templates'])
</div>
