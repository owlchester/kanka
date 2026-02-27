<?php

return [
    'attribute_templates'   => [],
    'create'                => [
        'title' => 'Nuovo Modello di Attributo',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'auto_apply'    => 'Applica automaticamente',
    ],
    'hints'                 => [
        'automatic'                 => 'I seguenti attributi sono stati applicati automaticamente da :link.',
        'automatic_apply'           => '{1} Il seguente :count attributo è stato applicato automaticamente da :link | [2,] I seguenti :count attributi sono stati applicati automaticamente da :link.',
        'entity_type'               => 'Applica automaticamente gli attributi di questo modello alle nuove entità del tipo selezionato.',
        'parent_attribute_template' => 'Questo modello di attributo può essere figlio di un altro modello di attributo. Quando si applica questo modello di attributo, verranno applicati anche tutti i suoi genitori.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'name'  => 'Nome di un Modello di Attributo',
    ],
    'show'                  => [],
];
