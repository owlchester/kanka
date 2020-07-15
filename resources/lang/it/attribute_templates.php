<?php

return [
    'attribute_templates'   => [
        'title' => 'Templates attributi :name',
    ],
    'create'                => [
        'description'   => 'Crea un nuovo template attributi',
        'success'       => 'Template Attributi \':name\' creato.',
        'title'         => 'Nuovo Template Attributi',
    ],
    'destroy'               => [
        'success'   => 'Template Attributi \':name\' rimosso.',
    ],
    'edit'                  => [
        'description'   => 'Modifica un template attributi',
        'success'       => 'Template Attributi \':name\' aggiornato.',
        'title'         => 'Modifica Template Attributi :name',
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
        'add'           => 'Nuovo Template Attributi',
        'description'   => 'Gestisci i Template attributi di :name.',
        'header'        => 'Template Attributi di :name',
        'title'         => 'Template Attributi',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Seleziona un template attributi',
        'name'                  => 'Nome del Template Attributi',
    ],
    'show'                  => [
        'description'   => 'Una vista dettagliata di un Template Attributi',
        'tabs'          => [
            'attribute_templates'   => 'Templates attributi',
            'attributes'            => 'Attributi',
        ],
        'title'         => 'Template Attributi :name',
    ],
];
