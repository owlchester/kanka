<?php

return [
    'create'        => [
        'description'   => 'Erstelle ein neues Item',
        'success'       => 'Gegenstand \':name\' erstellt',
        'title'         => 'Neuen Gegenstand erstellen',
    ],
    'destroy'       => [
        'success'   => 'Gegenstand \':name\' entfernt.',
    ],
    'edit'          => [
        'success'   => 'Gegenstand \':name\' aktualisiert.',
        'title'     => 'Bearbeite Gegenstand :name',
    ],
    'fields'        => [
        'character' => 'Charakter',
        'image'     => 'Bild',
        'location'  => 'Ort',
        'name'      => 'Name',
        'price'     => 'Preis',
        'relation'  => 'Beziehung',
        'size'      => 'Größe',
        'type'      => 'Typ',
    ],
    'index'         => [
        'add'           => 'Neuer Gegenstand',
        'description'   => 'Verwalte die Gegenstände von :name.',
        'header'        => 'Gegenstände von :name',
        'title'         => 'Gegenstände',
    ],
    'inventories'   => [
        'description'   => 'Objekte, in denen sich der Artikel befindet.',
        'title'         => 'Gegenstand :name Objekte',
    ],
    'placeholders'  => [
        'character' => 'Wähle einen Charakter',
        'location'  => 'Wähle einen Ort',
        'name'      => 'Name des Gegenstands',
        'price'     => 'Preis des Gegenstandes',
        'size'      => 'Größe, Gewicht, Maße',
        'type'      => 'Waffe, Trank, Artefakt',
    ],
    'quests'        => [
        'description'   => 'Quests des Gegenstands.',
        'title'         => 'Gegenstand :name Quests',
    ],
    'show'          => [
        'description'   => 'Eine detaillierte Ansicht eines Gegenstands',
        'tabs'          => [
            'information'   => 'Informationen',
            'inventories'   => 'Objekte',
            'quests'        => 'Quests',
        ],
        'title'         => 'Gegenstand :name',
    ],
];
