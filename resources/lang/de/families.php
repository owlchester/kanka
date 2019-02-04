<?php

return [
    'create'        => [
        'description'   => 'Erstelle eine neue Familie',
        'success'       => 'Familie \':name\' erstellt.',
        'title'         => 'Erstelle eine neue Familie',
    ],
    'destroy'       => [
        'success'   => 'Familie \':name\' entfernt.',
    ],
    'edit'          => [
        'success'   => 'Familie \':name\' aktualisiert.',
        'title'     => 'Bearbeite Familie :name',
    ],
    'fields'        => [
        'image'     => 'Bild',
        'location'  => 'Ort',
        'members'   => 'Mitglieder',
        'name'      => 'Name',
        'relation'  => 'Beziehung',
    ],
    'hints'         => [
        'members'   => 'Mitglieder einer Familie werden hier gelistet. Ein Charakter kann einer Familie hinzugefügt werden, in dem bei dem gewünschten Charakter das Familiendropdown genutzt wird.',
    ],
    'index'         => [
        'add'           => 'Neue Familie',
        'description'   => 'Verwalte die Familien von :name',
        'header'        => 'Familien von :name',
        'title'         => 'Familien',
    ],
    'placeholders'  => [
        'location'  => 'Wähle einen Ort',
        'name'      => 'Name der Familie',
    ],
    'show'          => [
        'description'   => 'Eine detaillierte Ansicht der Familie',
        'tabs'          => [
            'members'   => 'Mitglieder',
            'relation'  => 'Beziehungen',
        ],
        'title'         => 'Familie :name',
    ],
];
