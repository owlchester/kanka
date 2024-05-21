<?php

return [
    'create'        => [
        'title' => 'Nova missió',
    ],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'    => [
            'success'   => 'S\'ha afegit l\'entitat :entity a la missió.',
            'title'     => 'Nou element per :name',
        ],
        'destroy'   => [
            'success'   => 'S\'ha eliminat l\'element :entity de la missió.',
        ],
        'edit'      => [
            'success'   => 'S\'ha actualitzat l\'element :entity de la missió.',
            'title'     => 'Actualitzar l\'element :name',
        ],
        'fields'    => [
            'description'       => 'Descripció',
            'entity_or_name'    => 'Seleccioneu una entitat de la campanya o doneu un nom a aquest element.',
            'name'              => 'Nom',
        ],
    ],
    'fields'        => [
        'copy_elements' => 'Copia els elements vinculats a la missió',
        'date'          => 'Data',
        'is_completed'  => 'Completada',
        'role'          => 'Rol',
    ],
    'helpers'       => [
        'is_completed'  => 'Marqueu això si la missió es considera completada.',
    ],
    'hints'         => [
        'quests'    => 'Es pot crear una xarxa de missions entrellaçades usant el camp de missió superior.',
    ],
    'index'         => [],
    'items'         => [],
    'locations'     => [],
    'organisations' => [],
    'placeholders'  => [
        'date'  => 'Data real de la missió',
        'role'  => 'El paper que juga l\'entitat a la missió',
        'type'  => 'Història principal, arc de personatge, missió secundària...',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Afegeix un element',
        ],
        'tabs'      => [
            'elements'  => 'Elements',
        ],
    ],
];
