<?php

return [
    'create'        => [
        'description'   => 'Erstelle eine neue Organisation',
        'success'       => 'Organisation \':name\' erstellt.',
        'title'         => 'Erstelle eine neue Organisation',
    ],
    'destroy'       => [
        'success'   => 'Organisation \':name\' entfernt.',
    ],
    'edit'          => [
        'success'   => 'Organisation \':name\' aktualisiert.',
        'title'     => 'Bearbeite Organisation :name',
    ],
    'fields'        => [
        'image'         => 'Bild',
        'location'      => 'Ort',
        'members'       => 'Mitglieder',
        'name'          => 'Name',
        'organisation'  => 'Oberorganisation',
        'organisations' => 'Unterorganisation',
        'relation'      => 'Beziehung',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'descendants'   => 'Diese Liste enthält alle Organisationen, die direkt unter dieser Organisation und allen untergeordneten Organisationen sind.',
        'nested'        => 'In der verschachtelten Ansicht, siehst du alle Organisationen verschachtelt. Organisationen ohne Oberorganisation werden im Standard angezeigt. Organisationen mit Unterorganisationen, können per Klick geöffnet werden, um die Unterorganisationen zu sehen. Das geht so tief, bis es keine Unterorganisation mehr gibt.',
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
            'character'     => 'Charakter',
            'organisation'  => 'Organisation',
            'role'          => 'Rolle',
        ],
        'helpers'       => [
            'all_members'       => 'Diese Liste enthält alle Charaktere, die direkt unter dieser Organisation und allen untergeordneten Organisationen sind.',
            'direct_members'    => 'Diese Liste enthält alle Charaktere, die direkt in dieser Organisation sind und keiner Unterorganisation.',
            'members'           => 'Die folgende Liste enthält alle Charaktere in dieser Organisation und alle untergeordneten Organisationen der Organisation. Du kannst die Seite filtern, um nur direkte Mitglieder anzuzeigen.',
        ],
        'hint'          => 'Die meisten Organisationen brauchen Mitglieder um erfolgreich zu sein.',
        'placeholders'  => [
            'character' => 'Wähle einen Charakter',
            'role'      => 'Anführer, Mitglied, Hoher Septon, Meisterspion',
        ],
        'title'         => 'Organisationen :name Mitglieder',
    ],
    'organisations' => [
        'title' => 'Organisation :name Organisationen',
    ],
    'placeholders'  => [
        'location'  => 'Wähle einen Ort',
        'name'      => 'Name der Organisation',
        'type'      => 'Kult, Gang, Rebellion, Anhängerschaft',
    ],
    'quests'        => [
        'description'   => 'Quests der Organisation',
        'title'         => 'Organisation :name Quests',
    ],
    'show'          => [
        'description'   => 'Eine detaillierte Ansicht einer Organisation',
        'tabs'          => [
            'all_members'   => 'Alle Mitglieder',
            'members'       => 'Direkte Mitglieder',
            'organisations' => 'Organisationen',
            'quests'        => 'Quests',
            'relations'     => 'Beziehungen',
        ],
        'title'         => 'Organisation :name',
    ],
];
