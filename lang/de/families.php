<?php

return [
    'create'        => [
        'title' => 'Erstelle eine neue Familie',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [
        'members'   => 'Mitglieder',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_extinct'    => 'Diese Familie ist ausgestorben.',
        'members'       => 'Mitglieder einer Familie werden hier gelistet. Ein Charakter kann einer Familie hinzugefügt werden, in dem bei dem gewünschten Charakter das Familiendropdown genutzt wird.',
    ],
    'index'         => [],
    'members'       => [
        'create'    => [
            'submit'    => 'Mitglieder hinzufügen',
            'success'   => '{0} Kein Mitglied wurde hinzugefügt.|{1} 1 Mitglied wurde hinzugefügt.|[2,*] :count Mitglieder wurden hinzugefügt.',
            'title'     => 'Neue Mitglieder',
        ],
        'helpers'   => [
            'all_members'       => 'Die folgende Liste zeigt alle Charaktere an, die Teil dieser Familie oder einer Unterfamilie sind.',
            'direct_members'    => 'Die meisten Familien haben Mitglieder, die sie anführen oder sie berühmt machen. Die folgenden Charaktere sind direkte Mitglieder der Familie.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Name der Familie',
        'type'  => 'königlich, edel, ausgestorben',
    ],
    'show'          => [
        'tabs'  => [
            'members'   => 'Mitglieder',
            'tree'      => 'Stammbaum',
        ],
    ],
];
