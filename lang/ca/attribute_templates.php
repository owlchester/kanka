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
        'attribute_template'    => 'Plantilla d\'atributs superior',
        'attributes'            => 'Atributs',
        'name'                  => 'Nom',
    ],
    'hints'                 => [
        'automatic'                 => 'Atributs aplicats automàticament des de la plantilla d\'atributs :link.',
        'entity_type'               => 'Si s\'habilita, al crear una nova entitat d\'aquest tipus s\'hi afegirà aquesta plantilla d\'atributs automàticament.',
        'parent_attribute_template' => 'Aqusta plantilla d\'atributs pot ser descendent d\'una altra plantilla d\'atributs. En aplicar una plantilla, s\'aplicarà amb tots els seus descendents.',
    ],
    'index'                 => [
        'title' => 'Plantilles d\'atributs',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Tria una plantilla d\'atributs',
        'name'                  => 'Nom de la plantilla d\'atributs',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => 'Plantilles d\'atributs',
            'attributes'            => 'Atributs',
        ],
    ],
];
