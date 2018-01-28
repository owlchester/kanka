<?php

return [
    'create'        => [
        'success'   => 'Organisation \':name\' erstellt.',
        'title'     => 'Erstelle eine neue Organisation',
    ],
    'destroy'       => [
        'success'   => 'Organisation \':name\' entfernt.',
    ],
    'edit'          => [
        'success'   => 'Organisation \':name\' aktualisiert.',
        'title'     => 'Bearbeite Organisation :name',
    ],
    'fields'        => [
        'history'   => 'Geschichte',
        'image'     => 'Bild',
        'location'  => 'Ort',
        'members'   => 'Mitglieder',
        'name'      => 'Name',
        'relation'  => 'Beziehung',
        'type'      => 'Typ',
    ],
    'index'         => [
        'add'           => 'Neue Organisation',
        'description'   => 'Verwalte die Organisationen von :name.',
        'header'        => 'Organisationen von :name',
        'title'         => 'Organisationen',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Füge ein Mitglied hinzu',
        ],
        'create'        => [
            'description'   => 'Füge ein Mitglied zur Organisation hinzu',
            'success'       => 'Mitglied zu Organisation hinzugefügt.',
            'title'         => 'Neues Organisationsmitglied für :name',
        ],
        'destroy'       => [
            'success'   => 'Mitglied aus Organisation entfernt.',
        ],
        'edit'          => [
            'success'   => 'Organisationsmitglied aktualisiert.',
            'title'     => 'Aktualisiere Mitglied für :name',
        ],
        'fields'        => [
            'character' => 'Charakter',
            'role'      => 'Rolle',
        ],
        'placeholders'  => [
            'character' => 'Wähle einen Charakter',
            'role'      => 'Anführer, Mitglied, Hoher Septon, Meisterspion',
        ],
    ],
    'placeholders'  => [
        'location'  => 'Wähle einen Ort',
        'name'      => 'Name der Organisation',
        'type'      => 'Kult, Gang, Rebellion, Anhängerschaft',
    ],
    'show'          => [
        'description'   => 'Eine detaillierte Ansicht einer Organisation',
        'tabs'          => [
            'history'   => 'Geschichte',
            'members'   => 'Mitglieder',
            'relations' => 'Beziehungen',
        ],
        'title'         => 'Organisation :name',
    ],
];
