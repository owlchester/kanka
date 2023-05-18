<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Voeg een nieuwe tag toe',
        ],
        'create'    => [
            'title' => 'Voeg een tag toe aan :name',
        ],
    ],
    'create'        => [
        'title' => 'Nieuwe Tag',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'  => 'Gerelateerden',
    ],
    'helpers'       => [],
    'hints'         => [
        'children'  => 'Deze lijst bevat alle entiteiten rechtstreeks in deze tag en in alle geneste tags.',
        'tag'       => 'Hieronder worden alle tags weergegeven die direct onder deze tag staan.',
    ],
    'index'         => [],
    'placeholders'  => [
        'type'  => 'Lore, Oorlogen, Geschiedenis, Religie, Vexillologie',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Gerelateerden',
        ],
    ],
    'tags'          => [],
];
