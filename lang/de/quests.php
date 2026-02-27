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
        ],
    ],
    'fields'        => [
        'copy_elements' => 'Kopiere Elemente, die an die Queste angehängt sind',
        'date'          => 'Datum',
        'element_role'  => 'Rolle',
        'instigator'    => 'Impulsgeber',
        'is_completed'  => 'Abgeschlossen',
        'location'      => 'Startpunkt',
        'role'          => 'Rolle',
    ],
    'helpers'       => [
        'is_completed'  => 'Wählen Sie aus, ob die Quest als abgeschlossen gilt.',
    ],
    'hints'         => [],
    'index'         => [],
    'items'         => [],
    'lists'         => [
        'empty' => 'Erstelle Quests, um Ziele, Handlungsstränge oder Charaktermotivationen festzuhalten.',
    ],
    'locations'     => [],
    'organisations' => [],
    'placeholders'  => [
        'date'      => 'Reales Datum der Quest',
        'entity'    => 'Name eines Elements aus der Quest',
        'location'  => 'Der Startpunkt der Suche',
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
