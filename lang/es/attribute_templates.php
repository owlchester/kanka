<?php

return [
    'attribute_templates'   => [],
    'create'                => [
        'title' => 'Nueva Plantilla de Atributos',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'auto_apply'    => 'Aplicar automáticamente',
        'is_enabled'    => 'Habilitado',
    ],
    'hints'                 => [
        'automatic'                 => 'Atributos aplicados automáticamente desde la plantilla de atributos :link.',
        'automatic_apply'           => '{1} El siguiente atributo se aplicó automáticamente desde :link | [2,] Los :count siguientes atributos se aplicaron automáticamente desde :link.',
        'entity_type'               => 'Si se habilita, al crear una nueva entidad de este tipo se le añadirá esta plantilla de atributos automáticamente.',
        'is_disabled'               => 'Esta plantilla está deshabilitada.',
        'is_enabled'                => 'Habilita esta plantilla para usarla en la campaña.',
        'parent_attribute_template' => 'Esta plantilla de atributos puede ser descendiente de otra plantilla de atributos. Al aplicar una plantilla, se aplicará con todos sus descendientes.',
    ],
    'index'                 => [],
    'lists'                 => [
        'empty' => 'Crea plantillas para reutilizar atributos comunes en múltiples entidades.',
    ],
    'placeholders'          => [
        'name'  => 'Nombre de la plantilla de atributos',
    ],
    'show'                  => [],
];
