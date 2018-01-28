<?php

return [
    'attributes'    => [
        'actions'       => [
            'add'   => 'Füge ein Attribut hinzu',
        ],
        'create'        => [
            'description'   => 'Setze ein Attribut für einen Ort',
            'success'       => 'Attribut hinzugefügt zu :name.',
            'title'         => 'Neue Attribute für :name',
        ],
        'destroy'       => [
            'success'   => 'Ortsattribut für :name entfernt.',
        ],
        'edit'          => [
            'success'   => 'Ortsattribut für :name aktualisiert.',
            'title'     => 'Aktualisiere Attribut für :name',
        ],
        'fields'        => [
            'attribute' => 'Attribut',
            'value'     => 'Wert',
        ],
        'placeholders'  => [
            'attribute' => 'Population, Anzahl an Fluten, Armeegröße',
            'value'     => 'Wert des Attributs',
        ],
    ],
    'create'        => [
        'success'   => 'Ort \':name\' erstellt.',
        'title'     => 'Erstelle einen neuen Ort',
    ],
    'destroy'       => [
        'success'   => 'Ort \':name\' entfernt.',
    ],
    'edit'          => [
        'success'   => 'Ort \':name\' aktualisiert.',
        'title'     => 'Bearbeite Ort :name',
    ],
    'fields'        => [
        'characters'    => 'Charaktere',
        'description'   => 'Beschreibung',
        'history'       => 'Geschichte',
        'image'         => 'Bild',
        'location'      => 'Ort',
        'name'          => 'Name',
        'relation'      => 'Beziehung',
        'type'          => 'Typ',
    ],
    'index'         => [
        'add'           => 'Neuer Ort',
        'description'   => 'Verwalte den Ort von :name',
        'header'        => 'Orte in :name',
        'title'         => 'Orte',
    ],
    'placeholders'  => [
        'location'  => 'Wähle einen übergeordneten Ort',
        'name'      => 'Name des Ortes',
        'type'      => 'Stadt, Königreich, Ruine',
    ],
    'show'          => [
        'description'   => 'Eine detaillierte Ansicht eines Ortes',
        'tabs'          => [
            'attributes'    => 'Attribute',
            'characters'    => 'Charaktere',
            'information'   => 'Informationen',
            'locations'     => 'Orte',
            'relations'     => 'Beziehungen',
        ],
        'title'         => 'Ort :name',
    ],
];
