<?php

return [
    'attribute_templates'   => [
        'title' => ':name modelos de atributos',
    ],
    'create'                => [
        'success'   => 'Modelo de Atributo \':name\' criado.',
        'title'     => 'Criar um novo Modelo de Atributo',
    ],
    'destroy'               => [
        'success'   => 'Modelo de Atributo \':name\' removido.',
    ],
    'edit'                  => [
        'success'   => 'Modelo de Atributo \':name\' atualizado.',
        'title'     => 'Editar Modelo de Atributo :name',
    ],
    'fields'                => [
        'attribute_template'    => 'Modelo de atributo pai',
        'attributes'            => 'Atributos',
        'name'                  => 'Nome',
    ],
    'hints'                 => [
        'automatic'                 => 'Atributos aplicados automaticamente a partir do: modelo de atributo de link.',
        'entity_type'               => 'Se definido, a criação de uma nova entidade desse tipo terá automaticamente esse template de atributo aplicado a ela.',
        'parent_attribute_template' => 'Este template de atributo pode ser filho de outro template de atributo. Ao aplicar este template de atributo, ele e todos os seus pais serão aplicados.',
    ],
    'index'                 => [
        'add'       => 'Novo Modelo de Atributo',
        'header'    => 'Modelos de Atributos de :name',
        'title'     => 'Modelos de Atributos',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Escolha um template de atributo',
        'name'                  => 'Nome do Modelo de Atributo',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => 'Modelos de Atributo',
            'attributes'            => 'Atributos',
        ],
        'title' => 'Modelo de Atributo :name',
    ],
];
