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
    'helpers'       => [],
    'hints'         => [
        'is_defunct'    => 'Diese Organisation ist aufgelöst.',
    ],
    'index'         => [],
    'members'       => [
        'actions'       => [
            'add'   => 'Füge ein Mitglied hinzu',
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
