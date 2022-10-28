<?php

return [
    'attribute_templates'   => [
        'title' => ':name egenskapsmall',
    ],
    'create'                => [
        'title' => 'Ny egenskapsmall',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'attribute_template'    => 'Huvudegenskapsmall',
        'attributes'            => 'Egenskaper',
    ],
    'hints'                 => [
        'automatic'                 => 'Egenskaper appliceras automatiskt från egenskapsmallen :link.',
        'entity_type'               => 'Om satt, när en ny entitet av denna typ skapas så appliceras denna egenskapsmall automatiskt på den.',
        'parent_attribute_template' => 'Denna egenskapsmall kan härledas till en annan egenskapsmall. När egenskapsmallen appliceras kommer den och även alla över den i härledningskedjan att appliceras.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'attribute_template'    => 'Välj en egenskapsmall',
        'name'                  => 'Namn för Egenskapsmallen',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => 'Egenskapsmall',
            'attributes'            => 'Egenskaper',
        ],
    ],
];
