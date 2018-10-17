<?php

return [
    'create'        => [
        'description'   => 'Erstelle einen neuen Menü Link',
        'success'       => 'Menü Link \':name\' created.',
        'title'         => 'Neuer Menü Link',
    ],
    'destroy'       => [
        'success'   => 'Menü Link \':name\' entfernt.',
    ],
    'edit'          => [
        'description'   => 'Verändere einen Menü Punkt.',
        'success'       => 'Menü Link \':name\' aktualisiert.',
        'title'         => 'Menü Link :name',
    ],
    'fields'        => [
        'entity'    => 'Objekt',
        'name'      => 'Name',
        'tab'       => 'Reiter',
    ],
    'index'         => [
        'add'           => 'Neuer Menü Link',
        'description'   => 'Verwalte die Menü Links von :name',
        'header'        => 'Menü Link von :name',
        'title'         => 'Menü Links',
    ],
    'placeholders'  => [
        'entity'    => 'Wähle ein Objekt',
        'name'      => 'Name des Menü Links',
        'tab'       => 'Geschichte, Beziehungen, Notizen',
    ],
    'show'          => [
        'description'   => 'Eine detaillierte Ansicht eines Menü Links',
        'tabs'          => [
            'information'   => 'Informationen',
        ],
        'title'         => 'Menü Link :name',
    ],
];
