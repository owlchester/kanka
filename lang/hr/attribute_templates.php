<?php

return [
    'attribute_templates'   => [
        'title' => ':name predlošci svojstva',
    ],
    'create'                => [
        'title' => 'Novi predložak svojstva',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'attribute_template'    => 'Predložak svojstva roditelj',
        'attributes'            => 'Svojstva',
    ],
    'hints'                 => [
        'automatic'                 => 'Svojstva automatski pridjeljena iz :link predloška svojstva.',
        'entity_type'               => 'Ako je uključeno, kreiranje novog entiteta ovog tipa će automatski primjeniti ovaj predložak svojstva na njega.',
        'parent_attribute_template' => 'Ovaj predložak svojstva može biti dijete drugog predloška svojstva. Kad se primjenjuje ovaj predložak svojstva, primjenjuju se i svi njegovi predlošci svojstva roditelji.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'attribute_template'    => 'Izaberi predložak svojstva',
        'name'                  => 'Naziv predloška svojstva',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => 'Predlošci svojstva',
            'attributes'            => 'Svojstva',
        ],
    ],
];
