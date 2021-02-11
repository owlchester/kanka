<?php

return [
    'children'      => [
        'actions'       => [
            'add'   => 'Voeg een nieuwe tag toe',
        ],
        'create'        => [
            'title' => 'Voeg een tag toe aan :name',
        ],
        'description'   => 'Entiteiten die bij de tag horen',
        'title'         => 'Tag :name Gerelateerden',
    ],
    'create'        => [
        'description'   => 'Maak een nieuwe tag',
        'success'       => 'Tag \':name\' gemaakt.',
        'title'         => 'Nieuwe Tag',
    ],
    'destroy'       => [
        'success'   => 'Tag \':name\' verwijderd.',
    ],
    'edit'          => [
        'success'   => 'Tag \':name\' bijgewerkt.',
        'title'     => 'Wijzig Tag :name',
    ],
    'fields'        => [
        'characters'    => 'Personages',
        'children'      => 'Gerelateerden',
        'name'          => 'Naam',
        'tag'           => 'Bovenliggende Tag',
        'tags'          => 'Subtags',
        'type'          => 'Type',
    ],
    'helpers'       => [
        'nested'    => 'In geneste weergave kan je jouw tags op een geneste manier bekijken. Tags zonder bovenliggende tag worden standaard weergegeven. Op tags met gerelateerde tags kan worden geklikt om die gerelateerden te bekijken. Je kunt blijven klikken totdat er geen gerelateerden meer te zien zijn.',
    ],
    'hints'         => [
        'children'  => 'Deze lijst bevat alle entiteiten rechtstreeks in deze tag en in alle geneste tags.',
        'tag'       => 'Hieronder worden alle tags weergegeven die direct onder deze tag staan.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'Geneste Weergave',
        ],
        'add'           => 'Nieuwe Tag',
        'description'   => 'Beheer de tag van :name',
        'header'        => 'Tags in :name',
        'title'         => 'Tags',
    ],
    'new_tag'       => 'Nieuwe Tag',
    'placeholders'  => [
        'name'  => 'Naam van de tag',
        'tag'   => 'Kies een bovenliggende tag',
        'type'  => 'Lore, Oorlogen, Geschiedenis, Religie, Vexillologie',
    ],
    'show'          => [
        'description'   => 'Een gedetailleerd overzicht van een tag',
        'tabs'          => [
            'children'      => 'Gerelateerden',
            'information'   => 'Informatie',
            'tags'          => 'Tags',
        ],
        'title'         => 'Tag :name',
    ],
    'tags'          => [
        'description'   => 'Gerelateerde Tags',
        'title'         => 'Tag :name Gerelateerden',
    ],
];
