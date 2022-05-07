<?php

return [
    'attribute_templates'   => [
        'title' => 'Templates attributi :name',
    ],
    'create'                => [
        'success'   => 'Template Attributi \':name\' creato.',
        'title'     => 'Nuovo Template Attributi',
    ],
    'destroy'               => [
        'success'   => 'Template Attributi \':name\' rimosso.',
    ],
    'edit'                  => [
        'success'   => 'Template Attributi \':name\' aggiornato.',
        'title'     => 'Modifica Template Attributi :name',
    ],
    'fields'                => [
        'attribute_template'    => 'Template Attributi Genitore',
        'attributes'            => 'Attributi',
        'name'                  => 'Nome',
    ],
    'hints'                 => [
        'automatic'                 => 'Attributi automaticamente applicati dal Template di Attributi :link',
        'entity_type'               => 'Se impostato, creare una nuova entità di questo tipo avrà automaticamente questo template di attributi applicato su di essa.',
        'parent_attribute_template' => 'Questo template attributi può essere figlio di un altro template attributi. Quando si applica questo template attributi, lui e tutti i suoi figli saranno applicati.',
    ],
    'index'                 => [
        'title' => 'Template Attributi',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Seleziona un template attributi',
        'name'                  => 'Nome del Template Attributi',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => 'Templates attributi',
            'attributes'            => 'Attributi',
        ],
    ],
];
