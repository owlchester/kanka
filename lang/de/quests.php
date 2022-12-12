<?php

return [
    'create'        => [
        'title' => 'Erstelle einen neuen Quest',
    ],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'    => [
            'success'   => 'Objekt :entity zur Quest hinzugefügt',
            'title'     => 'Neues Element für :name',
        ],
        'destroy'   => [
            'success'   => 'Quest Element :entity entfernt',
        ],
        'edit'      => [
            'success'   => 'Quest Element :entity aktualisiert',
            'title'     => 'Questelement für aktualisieren :name',
        ],
        'fields'    => [
            'description'       => 'Beschreibung',
            'entity_or_name'    => 'Wählen Sie entweder ein Objekt der Kampagne aus oder geben Sie diesem Element einen Namen.',
            'name'              => 'Name',
            'quest'             => 'Quest',
        ],
        'title'     => 'Quest :name Elemente',
        'warning'   => [
            'editing'   => [
                'description'   => 'Es sieht so aus, als ob gerade jemand anderes diese Quest bearbeitet! Möchtest du zurückgehen oder diese Warnung ignorieren, auf die Gefahr hin, dass Daten verloren gehen? Mitglieder, die diese Quest derzeit bearbeiten:',
            ],
        ],
    ],
    'fields'        => [
        'character'     => 'Auslöser',
        'copy_elements' => 'Kopiere Elemente, die an die Queste angehängt sind',
        'date'          => 'Datum',
        'element_role'  => 'Rolle',
        'is_completed'  => 'Abgeschlossen',
        'quest'         => 'Übergeordnete Queste',
        'quests'        => 'Untergeornete Queste',
        'role'          => 'Rolle',
    ],
    'helpers'       => [
        'is_completed'      => 'Wählen Sie aus, ob die Quest als abgeschlossen gilt.',
        'nested_without'    => 'Anzeigen aller Quests, die keine übergeordnete Quest haben. Klicken Sie auf eine Zeile, um die Quests für Kinder anzuzeigen.',
    ],
    'hints'         => [
        'quests'    => 'Ein Netz aus verknüpften Quests kann mit dem Elternquest-Feld erstellt werden.',
    ],
    'index'         => [],
    'items'         => [],
    'locations'     => [],
    'organisations' => [],
    'placeholders'  => [
        'date'      => 'Reales Datum der Quest',
        'entity'    => 'Name eines Elements aus der Quest',
        'name'      => 'Name des Quests',
        'quest'     => 'Elternquest',
        'role'      => 'Die Rolle des Objekts in der Quest',
        'type'      => 'Charakterentwicklung, Sidequest, Hauptquest',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Element hinzufügen',
        ],
        'tabs'      => [
            'elements'  => 'Elemente',
        ],
    ],
];
