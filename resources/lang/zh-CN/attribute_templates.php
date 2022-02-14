<?php

return [
    'attribute_templates'   => [
        'title' => ':name特质模板',
    ],
    'create'                => [
        'success'   => '成功创建特质模板：:name',
        'title'     => '新建特质模板',
    ],
    'destroy'               => [
        'success'   => '成功移除特质模板：:name',
    ],
    'edit'                  => [
        'success'   => '成功更新特质模板：:name',
        'title'     => '编辑特质模板:name',
    ],
    'fields'                => [
        'attribute_template'    => '父特质模板',
        'attributes'            => '特质',
        'name'                  => '名称',
    ],
    'hints'                 => [
        'automatic'                 => '自动应用:link特质模板的特质。',
        'entity_type'               => '如果设定，每次创建该类型的实体就会自动应用本特质模板。',
        'parent_attribute_template' => '这个特质模板可以是其他模板的子模板。当应用该特质模板的时候，所有的父模板会同时被应用。',
    ],
    'index'                 => [
        'add'       => '新特质模板',
        'header'    => ':name的特质模板',
        'title'     => '特质模板',
    ],
    'placeholders'          => [
        'attribute_template'    => '选择特质模板',
        'name'                  => '特质模板的名称',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => '特质模板',
            'attributes'            => '特质',
        ],
        'title' => '特质模板：:name',
    ],
];
