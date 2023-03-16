<?php

return [
    'attribute_templates'   => [
        'title' => ':name modelos de atributos',
    ],
    'create'                => [
        'title' => 'Novo Modelo de Atributo',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'attribute_template'    => 'Modelo de Atributo Primário',
        'attributes'            => 'Atributos',
    ],
    'hints'                 => [
        'automatic'                 => 'Atributos aplicados automaticamente a partir do Modelo de Atributo :link',
        'entity_type'               => 'Se definido, a criação de uma nova entidade desse tipo terá automaticamente esse modelo de atributo aplicado a ela.',
        'parent_attribute_template' => 'Este modelo de atributo pode ser secundário de outro modelo de atributo. Ao aplicar este modelo de atributo, ele e todos os seus modelos primários serão aplicados.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'attribute_template'    => 'Escolha um modelo de atributo',
        'name'                  => 'Nome do Modelo de Atributo',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => 'Modelos de Atributo',
            'attributes'            => 'Atributos',
        ],
    ],
];
