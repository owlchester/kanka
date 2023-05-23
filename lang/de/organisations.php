<?php

return [
    'create'        => [
        'title' => 'Erstelle eine neue Organisation',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_defunct'    => 'stillgelegt',
        'members'       => 'Mitglieder',
    ],
    'helpers'       => [
        'descendants'       => 'Diese Liste enthält alle Organisationen, die direkt unter dieser Organisation und allen untergeordneten Organisationen sind.',
        'nested_without'    => 'Anzeigen aller Organisationen, die keine übergeordnete Organisation haben. Klicken Sie auf eine Zeile, um die untergeordneten Organisationen anzuzeigen.',
    ],
    'hints'         => [
        'is_defunct'    => 'Diese Organisation ist aufgelöst.',
    ],
    'index'         => [],
    'members'       => [
        'actions'       => [
            'add'       => 'Füge ein Mitglied hinzu',
            'submit'    => 'Mitglied hinzufügen',
        ],
        'create'        => [
            'success'   => 'Mitglied zu Organisation hinzugefügt.',
            'title'     => 'Neues Organisationsmitglied für :name',
        ],
        'destroy'       => [
            'success'   => 'Mitglied aus Organisation entfernt.',
        ],
        'edit'          => [
            'success'   => 'Organisationsmitglied aktualisiert.',
            'title'     => 'Aktualisiere Mitglied für :name',
        ],
        'fields'        => [
            'parent'    => 'Vorgesetzter',
            'pinned'    => 'gepinned',
            'role'      => 'Rolle',
            'status'    => 'Mitgliedsstatus',
        ],
        'helpers'       => [
            'all_members'   => 'Alle Charaktere, die Mitglieder dieser Organisation und ihrer Unterorganisationen sind.',
            'members'       => 'Alle Charaktere, die Mitglieder dieser Organisation sind.',
            'pinned'        => 'Wählen Sie aus, ob dieses Mitglied im angehefteten Abschnitt der Übersicht der zugehörigen Objekten angezeigt werden soll.',
        ],
        'pinned'        => [
            'both'  => 'beide',
            'none'  => 'keiner',
        ],
        'placeholders'  => [
            'parent'    => 'Wer ist der Vorgesetzte dieses Mitglieds?',
            'role'      => 'Anführer, Mitglied, Hoher Septon, Meisterspion',
        ],
        'status'        => [
            'active'    => 'aktive Mitglieder',
            'inactive'  => 'inaktive Mitglieder',
            'unknown'   => 'unbekannter Status',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [
        'type'  => 'Kult, Gang, Rebellion, Anhängerschaft',
    ],
    'quests'        => [],
    'show'          => [],
];
