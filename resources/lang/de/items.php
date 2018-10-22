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
        'character'     => 'Charakter',
        'image'         => 'Bild',
        'location'      => 'Ort',
        'name'          => 'Name',
        'relation'      => 'Beziehung',
        'type'          => 'Typ',
    ],
    'index'         => [
        'add'           => 'Neuer Gegenstand',
        'description'   => 'Verwalte die Gegenstände von :name.',
        'header'        => 'Gegenstände von :name',
        'title'         => 'Gegenstände',
    ],
    'placeholders'  => [
        'character' => 'Wähle einen Charakter',
        'location'  => 'Wähle einen Ort',
        'name'      => 'Name des Gegenstands',
        'type'      => 'Waffe, Trank, Artefakt',
    ],
    'show'          => [
        'description'   => 'Eine detaillierte Ansicht eines Gegenstands',
        'tabs'          => [
            'information'   => 'Informationen',
        ],
        'title'         => 'Gegenstand :name',
    ],
];
