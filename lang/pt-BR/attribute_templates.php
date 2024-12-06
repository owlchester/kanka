<?php

return [
    'attribute_templates'   => [],
    'create'                => [
        'title' => 'Novo Modelo de Atributo',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'attributes'    => 'Atributos',
        'auto_apply'    => 'Auto-aplicar',
    ],
    'hints'                 => [
        'automatic'                 => 'Atributos aplicados automaticamente a partir do Modelo de Atributo :link',
        'automatic_apply'           => '{1} O seguinte :count atributo foi aplicado automaticamente de :link | [2,] Os seguintes :count atributos foram aplicados automaticamente de :link.',
        'entity_type'               => 'Aplique automaticamente os atributos deste modelo a novas entidades do tipo selecionado.',
        'parent_attribute_template' => 'Este modelo de atributo pode ser secundário de outro modelo de atributo. Ao aplicar este modelo de atributo, ele e todos os seus modelos primários serão aplicados.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'name'  => 'Nome do Modelo de Atributo',
    ],
    'show'                  => [
        'tabs'  => [
            'attributes'    => 'Atributos',
        ],
    ],
];
