<?php

return [
    'attribute_templates'   => [
        'title' => ':name egenskapsmall',
    ],
    'create'                => [
        'description'   => 'Skapa en ny egenskapsmall',
        'success'       => 'Egenskapsmall \':name\' skapad.',
        'title'         => 'Ny egenskapsmall',
    ],
    'destroy'               => [
        'success'   => 'Egenskapsmall \':name\' borttagen.',
    ],
    'edit'                  => [
        'description'   => 'Redigera en egenskapsmall',
        'success'       => 'Egenskapsmall \':name\' uppdaterad.',
        'title'         => 'Redigera egenskapsmall :name',
    ],
    'fields'                => [
        'attribute_template'    => 'Huvudegenskapsmall',
        'attributes'            => 'Egenskaper',
        'name'                  => 'Namn',
    ],
    'hints'                 => [
        'automatic'                 => 'Egenskaper appliceras automatiskt från egenskapsmallen :link.',
        'entity_type'               => 'Om satt, när en ny entitet av denna typ skapas så appliceras denna egenskapsmall automatiskt på den.',
        'parent_attribute_template' => 'Denna egenskapsmall kan härledas till en annan egenskapsmall. När egenskapsmallen appliceras kommer den och även alla över den i härledningskedjan att appliceras.',
    ],
    'index'                 => [
        'add'           => 'Ny Egenskapsmall',
        'description'   => 'Hantera Egenskapsmallen för :name',
        'header'        => 'Egenskapsmall för :name',
        'title'         => 'Egenskapsmall',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Välj en egenskapsmall',
        'name'                  => 'Namn för Egenskapsmallen',
    ],
    'show'                  => [
        'description'   => 'En detaljerad vy av en Egenskapsmall',
        'tabs'          => [
            'attribute_templates'   => 'Egenskapsmall',
            'attributes'            => 'Egenskaper',
        ],
        'title'         => 'Egenskapsmall :name',
    ],
];
