<?php

return [
    'create'        => [
        'success'   => 'Quest \':name\' erstellt.',
        'title'     => 'Erstelle einen neuen Quest',
    ],
    'destroy'       => [
        'success'   => 'Quest \':name\' entfernt',
    ],
    'edit'          => [
        'success'   => 'Quest \':name\' aktualisiert',
        'title'     => 'Bearbeite Quest :name',
    ],
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
    ],
    'fields'        => [
        'character'     => 'Auslöser',
        'copy_elements' => 'Kopiere Elemente, die an die Queste angehängt sind',
        'date'          => 'Datum',
        'description'   => 'Beschreibung',
        'image'         => 'Bild',
        'is_completed'  => 'Abgeschlossen',
        'name'          => 'Name',
        'quest'         => 'Übergeordnete Queste',
        'quests'        => 'Untergeornete Queste',
        'role'          => 'Rolle',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'is_completed'      => 'Wählen Sie aus, ob die Quest als abgeschlossen gilt.',
        'nested_parent'     => 'Anzeigen der Quests von :parent.',
        'nested_without'    => 'Anzeigen aller Quests, die keine übergeordnete Quest haben. Klicken Sie auf eine Zeile, um die Quests für Kinder anzuzeigen.',
    ],
    'hints'         => [
        'quests'    => 'Ein Netz aus verknüpften Quests kann mit dem Elternquest-Feld erstellt werden.',
    ],
    'index'         => [
        'add'       => 'Neuer Quest',
        'header'    => 'Quests von :name',
        'title'     => 'Quests',
    ],
    'items'         => [],
    'locations'     => [],
    'organisations' => [],
    'placeholders'  => [
        'date'  => 'Reales Datum der Quest',
        'name'  => 'Name des Quests',
        'quest' => 'Elternquest',
        'role'  => 'Die Rolle des Objekts in der Quest',
        'type'  => 'Charakterentwicklung, Sidequest, Hauptquest',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Element hinzufügen',
        ],
        'tabs'      => [
            'elements'  => 'Elemente',
        ],
        'title'     => 'Quest :name',
    ],
];
