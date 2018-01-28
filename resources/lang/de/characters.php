<?php

return [
    'attributes'    => [
        'actions'       => [
            'add'   => 'Füge ein Attribute hinzu',
        ],
        'create'        => [
            'description'   => 'Setze ein Attribute für einen Charakter',
            'success'       => 'Attribut hinzugefügt für :name.',
            'title'         => 'Neues Attribute für :name',
        ],
        'destroy'       => [
            'success'   => 'Charakterattribut für :name entfernt.',
        ],
        'edit'          => [
            'success'   => 'Charakterattribut für :name aktualisert.',
            'title'     => 'Aktualisiere Attribut für :name',
        ],
        'fields'        => [
            'attribute' => 'Attribut',
            'value'     => 'Wert',
        ],
        'placeholders'  => [
            'attribute' => 'Anzahl gewonnener Kämpfe, Hochzeitstag, Initiative',
            'value'     => 'Wert des Attributs',
        ],
    ],
    'create'        => [
        'success'   => 'Charakter \':name\' erstellt.',
        'title'     => 'Erstelle einen neuen Charakter',
    ],
    'destroy'       => [
        'success'   => 'Charakter \':name\' entfernt.',
    ],
    'edit'          => [
        'success'   => 'Charakter \':name\' aktualisiert',
        'title'     => 'Bearbeite Charakter :name',
    ],
    'fields'        => [
        'age'                       => 'Alter',
        'eye'                       => 'Augenfarbe',
        'family'                    => 'Familie',
        'fears'                     => 'Ängste',
        'free'                      => 'Freitext',
        'goals'                     => 'Ziele',
        'hair'                      => 'Haare',
        'height'                    => 'Größe',
        'history'                   => 'Geschichte',
        'image'                     => 'Bild',
        'is_personality_visible'    => 'Ist die Perönlichkeit sichtbar?',
        'languages'                 => 'Sprachen',
        'location'                  => 'Aufenthaltsort',
        'mannerisms'                => 'Angewohnheiten',
        'name'                      => 'Name',
        'physical'                  => 'Körper',
        'race'                      => 'Rasse',
        'relation'                  => 'Beziehung',
        'sex'                       => 'Geschlecht',
        'skin'                      => 'Haut',
        'title'                     => 'Titel',
        'traits'                    => 'Eigenschaften',
        'weight'                    => 'Gewicht',
    ],
    'hints'         => [
        'is_personality_visible'    => 'Du kannst den kompletten Persönlichkeitsbereich vor deinen Zuschauern verstecken.',
    ],
    'index'         => [
        'actions'       => [
            'random'    => 'Neuen zufälligen Charakter',
        ],
        'add'           => 'Neuer Charakter',
        'description'   => 'Bearbeite die Charaktere von :name',
        'header'        => 'Charakter in :name',
        'title'         => 'Charaktere',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Organisation hinzufügen',
        ],
        'create'        => [
            'description'   => 'Füge einem Charakter eine Organisation hinzu',
            'success'       => 'Charakter wurde der Organisation hinzugefügt.',
            'title'         => 'Neue Organisation für :name',
        ],
        'destroy'       => [
            'success'   => 'Character aus Organisation entfernt.',
        ],
        'edit'          => [
            'success'   => 'Organisation des Charakters aktualisiert',
            'title'     => 'Aktualisiere Organisation für :name',
        ],
        'fields'        => [
            'organisation'  => 'Organisation',
            'role'          => 'Rolle',
        ],
        'placeholders'  => [
            'organisation'  => 'Wähle eine Organisation...',
        ],
    ],
    'placeholders'  => [
        'age'       => 'Alter',
        'eye'       => 'Augenfarbe',
        'family'    => 'Bitte wähle einen Charakter',
        'fears'     => 'Ängste',
        'free'      => 'Freitext',
        'goals'     => 'Ziele',
        'hair'      => 'Haare',
        'height'    => 'Größe',
        'history'   => 'Geschichte',
        'image'     => 'Bild',
        'languages' => 'Sprachen',
        'location'  => 'Bitte wähle einen Aufenthaltsort',
        'mannerisms'=> 'Angewohnheiten',
        'name'      => 'Name',
        'physical'  => 'Körper',
        'race'      => 'Rasse',
        'sex'       => 'Geschlecht',
        'skin'      => 'Haut',
        'title'     => 'Titel',
        'traits'    => 'Eigenschaften',
        'weight'    => 'Größe',
    ],
    'sections'      => [
        'appearance'    => 'Aussehen',
        'general'       => 'Allgemeine Informationen',
        'history'       => 'Geschichte',
        'personality'   => 'Persönlichkeit',
    ],
    'show'          => [
        'description'   => 'Eine detaillierte Ansicht eines Charakters',
        'tabs'          => [
            'attributes'    => 'Attribute',
            'free'          => 'Freitext',
            'history'       => 'Geschichte',
            'organisations' => 'Organisationen',
            'personality'   => 'Persönlichkeit',
            'relations'     => 'Beziehungen',
        ],
        'title'         => 'Character :name',
    ],
];
