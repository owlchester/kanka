<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Voeg een nieuwe tag toe',
        ],
        'create'    => [
            'title' => 'Voeg een tag toe aan :name',
        ],
        'title'     => 'Tag :name Gerelateerden',
    ],
    'create'        => [
        'title' => 'Nieuwe Tag',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'  => 'Gerelateerden',
        'name'      => 'Naam',
        'tag'       => 'Bovenliggende Tag',
        'tags'      => 'Subtags',
        'type'      => 'Type',
    ],
    'helpers'       => [],
    'hints'         => [
        'children'  => 'Deze lijst bevat alle entiteiten rechtstreeks in deze tag en in alle geneste tags.',
        'tag'       => 'Hieronder worden alle tags weergegeven die direct onder deze tag staan.',
    ],
    'index'         => [
        'title' => 'Tags',
    ],
    'new_tag'       => 'Nieuwe Tag',
    'placeholders'  => [
        'name'  => 'Naam van de tag',
        'tag'   => 'Kies een bovenliggende tag',
        'type'  => 'Lore, Oorlogen, Geschiedenis, Religie, Vexillologie',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Gerelateerden',
            'tags'      => 'Tags',
        ],
    ],
    'tags'          => [
        'title' => 'Tag :name Gerelateerden',
    ],
];
