<?php

return [
    'attribute_templates'   => [
        'title' => 'Plantillas de atributos de :name',
    ],
    'create'                => [
        'success'   => 'Plantilla de atributos \':name\' creada.',
        'title'     => 'Nueva Plantilla de Atributos',
    ],
    'destroy'               => [
        'success'   => 'Plantilla de atributos \':name\' eliminada.',
    ],
    'edit'                  => [
        'success'   => 'Plantilla de atributos \':name\' actualizada.',
        'title'     => 'Editar plantilla de atributos :name',
    ],
    'fields'                => [
        'attribute_template'    => 'Plantilla de atributos superior',
        'attributes'            => 'Atributos',
        'name'                  => 'Nombre',
    ],
    'hints'                 => [
        'automatic'                 => 'Atributos aplicados automáticamente desde la plantilla de atributos :link.',
        'entity_type'               => 'Si se habilita, al crear una nueva entidad de este tipo se le añadirá esta plantilla de atributos automáticamente.',
        'parent_attribute_template' => 'Esta plantilla de atributos puede ser descendiente de otra plantilla de atributos. Al aplicar una plantilla, se aplicará con todos sus descendientes.',
    ],
    'index'                 => [
        'title' => 'Plantillas de atributos',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Elige una plantilla de atributos',
        'name'                  => 'Nombre de la plantilla de atributos',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => 'Plantillas de atributos',
            'attributes'            => 'Atributos',
        ],
    ],
];
