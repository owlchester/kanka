<?php

return [
    'create'        => [
        'title' => 'Erstelle eine neue Familie',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [],
    'helpers'       => [],
    'hints'         => [
        'is_extinct'    => 'Diese Familie ist ausgestorben.',
        'members'       => 'Mitglieder einer Familie werden hier gelistet. Ein Charakter kann einer Familie hinzugefügt werden, in dem bei dem gewünschten Charakter das Familiendropdown genutzt wird.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Verfolge Abstammungslinien, Clans oder Adelshäuser, die deine Charaktere miteinander verbinden.',
    ],
    'members'       => [
        'create'    => [
            'helper'    => 'Füge ein oder mehrere Mitglieder zu :name hinzu.',
            'success'   => '{0} Kein Mitglied wurde hinzugefügt.|{1} 1 Mitglied wurde hinzugefügt.|[2,*] :count Mitglieder wurden hinzugefügt.',
            'title'     => 'Neue Mitglieder',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Name der Familie',
        'type'  => 'königlich, edel, ausgestorben',
    ],
    'show'          => [
        'tabs'  => [
            'tree'  => 'Stammbaum',
        ],
    ],
];
