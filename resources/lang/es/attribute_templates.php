<?php

return [
    'attribute_templates'   => [
        'title' => 'Plantillas de atributos de :name',
    ],
    'create'                => [
        'description'   => 'Crear nueva plantilla de atributos',
        'success'       => 'Plantilla de atributos \':name\' creada.',
        'title'         => 'Nueva Plantilla de Atributos',
    ],
    'destroy'               => [
        'success'   => 'Plantilla de atributos \':name\' eliminada.',
    ],
    'edit'                  => [
        'description'   => 'Editar plantilla de atributos',
        'success'       => 'Plantilla de atributos \':name\' actualizada.',
        'title'         => 'Editar plantilla de atributos :name',
    ],
    'fields'                => [
        'attribute_template'    => 'Plantilla de atributos superior',
        'attributes'            => 'Atributos',
        'name'                  => 'Nombre',
    ],
    'hints'                 => [
        'parent_attribute_template' => 'Esta plantilla de atributos puede ser descendiente de otra plantilla de atributos. Al aplicar una plantilla, se aplicará con todos sus descendientes.',
    ],
    'index'                 => [
        'add'           => 'Nueva plantilla de atributos',
        'description'   => 'Administrar la plantilla de atributos de :name.',
        'header'        => 'Plantillas de atributos de :name',
        'title'         => 'Plantillas de atributos',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Elige una plantilla de atributos',
        'name'                  => 'Nombre de la plantilla de atributos',
    ],
    'show'                  => [
        'description'   => 'Vista detallada de la plantilla de atributos',
        'tabs'          => [
            'attribute_templates'   => 'Plantillas de atributos',
            'attributes'            => 'Atributos',
        ],
        'title'         => 'Plantilla de atributos :name',
    ],
];
