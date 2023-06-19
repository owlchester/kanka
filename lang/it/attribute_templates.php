<?php

return [
    'attribute_templates'   => [],
    'create'                => [
        'title' => 'Nuovo Template Attributi',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'attributes'    => 'Attributi',
    ],
    'hints'                 => [
        'automatic'                 => 'Attributi automaticamente applicati dal Template di Attributi :link',
        'entity_type'               => 'Se impostato, creare una nuova entità di questo tipo avrà automaticamente questo template di attributi applicato su di essa.',
        'parent_attribute_template' => 'Questo template attributi può essere figlio di un altro template attributi. Quando si applica questo template attributi, lui e tutti i suoi figli saranno applicati.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'name'  => 'Nome del Template Attributi',
    ],
    'show'                  => [
        'tabs'  => [
            'attributes'    => 'Attributi',
        ],
    ],
];
