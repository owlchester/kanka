<?php

return [
    'attribute_templates'   => [
        'title' => 'Plantilles d\'atributs de :name',
    ],
    'create'                => [
        'title' => 'Nova plantilla d\'atributs',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'attributes'    => 'Atributs',
    ],
    'hints'                 => [
        'automatic'                 => 'Atributs aplicats automàticament des de la plantilla d\'atributs :link.',
        'entity_type'               => 'Si s\'habilita, al crear una nova entitat d\'aquest tipus s\'hi afegirà aquesta plantilla d\'atributs automàticament.',
        'parent_attribute_template' => 'Aqusta plantilla d\'atributs pot ser descendent d\'una altra plantilla d\'atributs. En aplicar una plantilla, s\'aplicarà amb tots els seus descendents.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'name'  => 'Nom de la plantilla d\'atributs',
    ],
    'show'                  => [
        'tabs'  => [
            'attributes'    => 'Atributs',
        ],
    ],
];
