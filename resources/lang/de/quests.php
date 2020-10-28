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
        'title'     => 'Charaktere in :name',
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
        'copy_elements' => 'Kopiere Elemente, die an die Queste angehängt sind',
        'date'          => 'Datum',
        'description'   => 'Beschreibung',
        'image'         => 'Bild',
        'is_completed'  => 'Abgeschlossen',
        'items'         => 'Gegenstände',
        'locations'     => 'Orte',
        'name'          => 'Name',
        'organisations' => 'Organisationen',
        'quest'         => 'Übergeordnete Queste',
        'quests'        => 'Untergeornete Queste',
        'role'          => 'Rolle',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'nested'    => 'In der verschachtelten Ansicht, siehst du alle Quests verschachtelt. Quests ohne Oberquest werden im Standard angezeigt. Quests mit Subquests, können per Klick geöffnet werden, um die Subquests zu sehen. Das geht so tief, bis es keine Subquest mehr gibt.',
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
    'items'         => [
        'create'    => [
            'description'   => 'Erstelle einen Quest Gegenstand',
            'success'       => 'Gegenstand zu :name hinzugefügt.',
            'title'         => 'Neuer Gegenstand für :name',
        ],
        'destroy'   => [
            'success'   => 'Quest Gegenstand für :name entfernt.',
        ],
        'edit'      => [
            'description'   => 'Aktualisier einen Quest Gegenstand',
            'success'       => 'Quest Gegenstand für :name aktualisiert.',
            'title'         => 'Aktualisiere Gegenstand für :name',
        ],
        'fields'    => [
            'description'   => 'Beschreibung',
            'item'          => 'Gegenstand',
        ],
        'title'     => 'Gegenstände in :name',
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
        'title'     => 'Orte in :name',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Erstelle eine Quest Organisation',
            'success'       => 'Organisation zu :name hinzugefügt.',
            'title'         => 'Neue Organisation für :name',
        ],
        'destroy'   => [
            'success'   => 'Quest Organisation für :name entfernt.',
        ],
        'edit'      => [
            'description'   => 'Aktualisiere eine Quest Organisation',
            'success'       => 'Quest Organisation für :name aktualisiert.',
            'title'         => 'Aktualisiere Organisation für :name',
        ],
        'fields'    => [
            'description'   => 'Beschreibung',
            'organisation'  => 'Organisation',
        ],
        'title'     => 'Organisationen in :name',
    ],
    'placeholders'  => [
        'date'  => 'Reales Datum der Quest',
        'name'  => 'Name des Quests',
        'quest' => 'Elternquest',
        'role'  => 'Die Rolle des Objekts in der Quest',
        'type'  => 'Charakterentwicklung, Sidequest, Hauptquest',
    ],
    'show'          => [
        'actions'       => [
            'add_character'     => 'Füge einen Charakter hinzu',
            'add_item'          => 'Füge einen Gegenstand hinzu',
            'add_location'      => 'Füge einen Ort hinzu',
            'add_organisation'  => 'Füge eine Organisation hinzu',
        ],
        'description'   => 'Eine detaillierte Ansicht eines Quests',
        'tabs'          => [
            'characters'    => 'Charaktere',
            'information'   => 'Informationen',
            'items'         => 'Gegenstände',
            'locations'     => 'Orte',
            'organisations' => 'Organisationen',
            'quests'        => 'Quests',
        ],
        'title'         => 'Quest :name',
    ],
];
