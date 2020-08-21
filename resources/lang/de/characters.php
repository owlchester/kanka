<?php

return [
    'actions'       => [
        'add_appearance'    => 'Füge ein Aussehen hinzu',
        'add_organisation'  => 'Füge eine Organisation hinzu',
        'add_personality'   => 'Füge eine Persönlichkeit hinzu',
    ],
    'conversations' => [
        'description'   => 'Unterhaltungen, in denen der Charakter teilnimmt.',
        'title'         => 'Charakter :name Unterhaltungen',
    ],
    'create'        => [
        'description'   => 'Erstelle einen neuen Charakter',
        'success'       => 'Charakter \':name\' erstellt.',
        'title'         => 'Erstelle einen neuen Charakter',
    ],
    'destroy'       => [
        'success'   => 'Charakter \':name\' entfernt.',
    ],
    'dice_rolls'    => [
        'description'   => 'Würfelwürfe, die dem Charakter zugewiesen sind.',
        'hint'          => 'Würfelwürfe können einem Charakter zugewiesen werden, um in einem Spiel verwendet zu werden.',
        'title'         => 'Charakter :name Würfelwürfe',
    ],
    'edit'          => [
        'description'   => 'Bearbeite einen Charakter',
        'success'       => 'Charakter \':name\' aktualisiert',
        'title'         => 'Bearbeite Charakter :name',
    ],
    'fields'        => [
        'age'                       => 'Alter',
        'family'                    => 'Familie',
        'image'                     => 'Bild',
        'is_dead'                   => 'Tot',
        'is_personality_visible'    => 'Persönlichkeit sichtbar?',
        'life'                      => 'Leben',
        'location'                  => 'Aufenthaltsort',
        'name'                      => 'Name',
        'physical'                  => 'Körper',
        'race'                      => 'Rasse',
        'relation'                  => 'Beziehung',
        'sex'                       => 'Geschlecht',
        'title'                     => 'Titel',
        'traits'                    => 'Eigenschaften',
        'type'                      => 'Typ',
    ],
    'helpers'       => [
        'age'   => 'Sie können dieses Objektes mit einem Kalender Ihrer Kampagne verknüpfen, um stattdessen automatisch dessen Alter zu berechnen. :more.',
        'free'  => 'Wo ist das "Freitext" Feld? Wenn dieser Charakter ein solches Feld hatte, wurde es in den neuen Notizen Tab verschoben.',
    ],
    'hints'         => [
        'hide_personality'          => 'Dieser Tab kann vor nicht "Admin" Nutzern versteckt werden, in dem die "Persönlichkeit sichtbar" Option deaktiviert wird, wenn man den Charakter bearbeitet.',
        'is_dead'                   => 'Dieser Charakter ist tot',
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
    'items'         => [
        'description'   => 'Gegenstände, die vom Charakter getragen oder in dessem Besitz sind.',
        'hint'          => 'Items können einem Charakter hinzugefügt werden und werden dann hier dargestellt.',
        'title'         => 'Charakter :name Gegenstände',
    ],
    'journals'      => [
        'description'   => 'Logbücher, die der Charakter geschrieben hat.',
        'title'         => 'Charakter :name Logbücher',
    ],
    'maps'          => [
        'description'   => 'Beziehungskarte des Charakters.',
        'title'         => 'Charakter :name Beziehungskarte',
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
        'description'   => 'Organisationen, denen der Charakter angehört.',
        'destroy'       => [
            'success'   => 'Character aus Organisation entfernt.',
        ],
        'edit'          => [
            'description'   => 'Aktualisiere die Organisation eines Charakters',
            'success'       => 'Organisation des Charakters aktualisiert',
            'title'         => 'Aktualisiere Organisation für :name',
        ],
        'fields'        => [
            'organisation'  => 'Organisation',
            'role'          => 'Rolle',
        ],
        'hint'          => 'Charaktere können Mitglied mehrerer Organisationen sein, um darzustellen, für wen sie arbeiten oder welcher Geheimgesellschaft sie angehören.',
        'placeholders'  => [
            'organisation'  => 'Wähle eine Organisation...',
        ],
        'title'         => 'Charakter :name Organisationen',
    ],
    'placeholders'  => [
        'age'               => 'Alter',
        'appearance_entry'  => 'Beschreibung',
        'appearance_name'   => 'Haare, Augen, Haut, Größe',
        'family'            => 'Bitte wähle einen Charakter',
        'image'             => 'Bild',
        'location'          => 'Bitte wähle einen Aufenthaltsort',
        'name'              => 'Name',
        'personality_entry' => 'Details',
        'personality_name'  => 'Persönlichkeitsmerkmal: Ziele, Gewohnheiten, Ängste, Bindungen',
        'physical'          => 'Körper',
        'race'              => 'Rasse',
        'sex'               => 'Geschlecht',
        'title'             => 'Titel',
        'traits'            => 'Eigenschaften',
        'type'              => 'NSC, Spieler Charakter, Gottheit',
    ],
    'quests'        => [
        'description'   => 'Quests des Charakters.',
        'helpers'       => [
            'quest_giver'   => 'Quests bei denen der Charakter Auftraggeber war.',
            'quest_member'  => 'Quests an denen der Charakter teilgenommen hat.',
        ],
        'title'         => 'Charakter :name Quests',
    ],
    'sections'      => [
        'appearance'    => 'Aussehen',
        'general'       => 'Allgemeine Informationen',
        'personality'   => 'Persönlichkeit',
    ],
    'show'          => [
        'description'   => 'Eine detaillierte Ansicht eines Charakters',
        'tabs'          => [
            'conversations' => 'Unterhaltungen',
            'dice_rolls'    => 'Würfelwürfe',
            'items'         => 'Items',
            'journals'      => 'Logbücher',
            'map'           => 'Beziehungskarte',
            'organisations' => 'Organisationen',
            'personality'   => 'Persönlichkeit',
            'quests'        => 'Quests',
        ],
        'title'         => 'Charakter :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Es ist dir nicht erlaubt, die Persönlichkeit dieses Charakters zu bearbeiten.',
    ],
];
