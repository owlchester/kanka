<?php

return [
    'attribute_templates'   => [
        'title' => 'Padróns de atributos de ":name"',
    ],
    'create'                => [
        'description'   => 'Crea un novo padrón de atributos',
        'success'       => 'Padrón de atributos ":name" creado.',
        'title'         => 'Novo padrón de atributos',
    ],
    'destroy'               => [
        'success'   => 'Padrón de atributos ":nome" eliminado.',
    ],
    'edit'                  => [
        'description'   => 'Editar un padrón de atributos',
        'success'       => 'Padrón de atributos ":name" actualizado.',
        'title'         => 'Editar padrón de atributos ":name"',
    ],
    'fields'                => [
        'attribute_template'    => 'Padrón de atributos pai',
        'attributes'            => 'Atributos',
        'name'                  => 'Nome',
    ],
    'hints'                 => [
        'automatic'                 => 'Atributos aplicados automaticamente a partir do padrón de atributos :link.',
        'entity_type'               => 'Se está activado, as entidades deste tipo terán este padrón de atributos aplicado automaticamente ao ser creadas.',
        'parent_attribute_template' => 'Este padrón de atributos pode ser descendente doutro padrón. Ao aplicar este padrón de atributos, todos os seus padróns pai serán tamén aplicados.',
    ],
    'index'                 => [
        'add'           => 'Novo padrón de atributos',
        'description'   => 'Xestiona os padróns de atributos de ":name".',
        'header'        => 'Padróns de atributos de ":name"',
        'title'         => 'Padróns de atributos',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Elixe un padrón de atributos',
        'name'                  => 'Nome do padrón de atributos',
    ],
    'show'                  => [
        'description'   => 'Vista detallada dun padrón de atributos.',
        'tabs'          => [
            'attribute_templates'   => 'Padróns de atributos',
            'attributes'            => 'Atributos',
        ],
        'title'         => 'Padrón de atributos ":name"',
    ],
];
