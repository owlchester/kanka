<?php

return [
    'attribute_templates'   => [
        'title' => 'Padróns de atributos de ":name"',
    ],
    'create'                => [
        'title' => 'Novo padrón de atributos',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'attributes'    => 'Atributos',
    ],
    'hints'                 => [
        'automatic'                 => 'Atributos aplicados automaticamente a partir do padrón de atributos :link.',
        'entity_type'               => 'Se está activado, as entidades deste tipo terán este padrón de atributos aplicado automaticamente ao ser creadas.',
        'parent_attribute_template' => 'Este padrón de atributos pode ser descendente doutro padrón. Ao aplicar este padrón de atributos, todos os seus padróns pai serán tamén aplicados.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'name'  => 'Nome do padrón de atributos',
    ],
    'show'                  => [
        'tabs'  => [
            'attributes'    => 'Atributos',
        ],
    ],
];
