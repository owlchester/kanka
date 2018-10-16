<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Gib einem Charakter eine Quest',
            'success'       => 'Charakter zu :name hinzugefügt.',
            'title'         => 'Neuer Charakter für :name',
        ],
        'destroy'   => [
            'success'   => 'Charakter :name von Quest entfernt.',
        ],
        'edit'      => [
            'description'   => 'Aktualisiere die Charaktere eines Quests.',
            'success'       => 'Charakter für Quest :name aktualisiert.',
            'title'         => 'Aktualisiere Charakter für :name',
        ],
        'fields'    => [
            'character'     => 'Charakter',
            'description'   => 'Beschreibung',
        ],
    ],
    'create'        => [
        'description'   => 'Erstelle einen neuen Quest',
        'success'       => 'Quest \':name\' erstellt.',
        'title'         => 'Erstelle einen neuen Quest',
    ],
    'destroy'       => [
        'success'   => 'Quest \':name\' entfernt',
    ],
    'edit'          => [
        'description'   => 'Bearbeite einen Quest',
        'success'       => 'Quest \':name\' aktualisiert',
        'title'         => 'Bearbeite Quest :name',
    ],
    'fields'        => [
        'character'     => 'Auslöser',
        'characters'    => 'Charaktere',
        'description'   => 'Beschreibung',
        'image'         => 'Bild',
        'is_completed'  => 'Abgeschlossen',
        'locations'     => 'Orte',
        'name'          => 'Name',
        'quest'         => 'Elternquest',
        'type'          => 'Typ',
    ],
    'hints'         => [
        'quests'    => 'Ein Netz aus verknüpften Quests kann mit dem Elternquest-Feld erstellt werden.',
    ],
    'index'         => [
        'add'           => 'Neuer Quest',
        'description'   => 'Verwalte die Quests von :name.',
        'header'        => 'Quests von :name',
        'title'         => 'Quests',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Setze einen Ort für eine Quest',
            'success'       => 'Ort für :name hinzugefügt.',
            'title'         => 'Neuer Ort für :name',
        ],
        'destroy'   => [
            'success'   => 'Questort für :name entfernt.',
        ],
        'edit'      => [
            'description'   => 'Aktualisiere den Ort eines Quests',
            'success'       => 'Questort für :name aktualisiert.',
            'title'         => 'Aktualisiere den Ort für :name',
        ],
        'fields'    => [
            'description'   => 'Beschreibung',
            'location'      => 'Ort',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Name des Quests',
        'quest' => 'Elternquest',
        'type'  => 'Charakterentwicklung, Sidequest, Hauptquest',
    ],
    'show'          => [
        'actions'       => [
            'add_character' => 'Füge einen Charakter hinzu',
            'add_location'  => 'Füge einen Ort hinzu',
        ],
        'description'   => 'Eine detaillierte Ansicht eines Quests',
        'tabs'          => [
            'characters'    => 'Charaktere',
            'information'   => 'Informationen',
            'locations'     => 'Orte',
            'quests'        => 'Quests',
        ],
        'title'         => 'Quest :name',
    ],
];
