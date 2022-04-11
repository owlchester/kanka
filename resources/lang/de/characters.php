<?php

return [
    'actions'       => [
        'add_appearance'    => 'Füge ein Aussehen hinzu',
        'add_organisation'  => 'Füge eine Organisation hinzu',
        'add_personality'   => 'Füge eine Persönlichkeit hinzu',
    ],
    'conversations' => [
        'title' => 'Charakter :name Unterhaltungen',
    ],
    'create'        => [
        'success'   => 'Charakter \':name\' erstellt.',
        'title'     => 'Erstelle einen neuen Charakter',
    ],
    'destroy'       => [
        'success'   => 'Charakter \':name\' entfernt.',
    ],
    'dice_rolls'    => [
        'hint'  => 'Würfelwürfe können einem Charakter zugewiesen werden, um in einem Spiel verwendet zu werden.',
        'title' => 'Charakter :name Würfelwürfe',
    ],
    'edit'          => [
        'success'   => 'Charakter \':name\' aktualisiert',
        'title'     => 'Bearbeite Charakter :name',
    ],
    'fields'        => [
        'age'                       => 'Alter',
        'families'                  => 'Familien',
        'family'                    => 'Familie',
        'image'                     => 'Bild',
        'is_appearance_pinned'      => 'Angeheftetes Aussehen',
        'is_dead'                   => 'Tot',
        'is_personality_pinned'     => 'Angeheftete Persönlichkeit',
        'is_personality_visible'    => 'Persönlichkeit sichtbar?',
        'life'                      => 'Leben',
        'location'                  => 'Aufenthaltsort',
        'name'                      => 'Name',
        'physical'                  => 'Körper',
        'pronouns'                  => 'Pronomen',
        'race'                      => 'Spezies',
        'races'                     => 'Spezies',
        'relation'                  => 'Beziehung',
        'sex'                       => 'Geschlecht',
        'title'                     => 'Titel',
        'traits'                    => 'Eigenschaften',
        'type'                      => 'Typ',
    ],
    'helpers'       => [
        'age'   => 'Sie können dieses Objektes mit einem Kalender Ihrer Kampagne verknüpfen, um stattdessen automatisch dessen Alter zu berechnen. :more.',
    ],
    'hints'         => [
        'is_appearance_pinned'      => 'Wenn diese Option aktiviert ist, werden die Aussehensmerkmale des Charakters unter dem Eintrag auf der Übersichtsseite angezeigt.',
        'is_dead'                   => 'Dieser Charakter ist tot',
        'is_personality_pinned'     => 'Wenn diese Option aktiviert ist, werden die PErsönlichkeitsmerkmale des Charakters unter dem Eintrag auf der Übersichtsseite angezeigt.',
        'is_personality_visible'    => 'Du kannst den kompletten Persönlichkeitsbereich vor deinen Zuschauern verstecken.',
        'personality_not_visible'   => 'Persönlichkeitsmerkmale dieses Charakters sind derzeit nur für Administratoren sichtbar.',
        'personality_visible'       => 'Persönlichkeitsmerkmale dieses Charakters sind für alle sichtbar.',
    ],
    'index'         => [
        'actions'   => [
            'random'    => 'Neuen zufälligen Charakter',
        ],
        'add'       => 'Neuer Charakter',
        'header'    => 'Charakter in :name',
        'title'     => 'Charaktere',
    ],
    'items'         => [
        'hint'  => 'Items können einem Charakter hinzugefügt werden und werden dann hier dargestellt.',
        'title' => 'Charakter :name Gegenstände',
    ],
    'journals'      => [
        'title' => 'Charakter :name Logbücher',
    ],
    'maps'          => [
        'title' => 'Charakter :name Beziehungskarte',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Organisation hinzufügen',
        ],
        'create'        => [
            'success'   => 'Charakter wurde der Organisation hinzugefügt.',
            'title'     => 'Neue Organisation für :name',
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
        'pronouns'          => 'Er / Ihn, Sie / Sie, Sie / Ihre',
        'race'              => 'Spezies',
        'races'             => 'Spezies wählen',
        'sex'               => 'Geschlecht',
        'title'             => 'Titel',
        'traits'            => 'Eigenschaften',
        'type'              => 'NSC, Spieler Charakter, Gottheit',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Quests bei denen der Charakter Auftraggeber war.',
            'quest_member'  => 'Quests an denen der Charakter teilgenommen hat.',
        ],
    ],
    'sections'      => [
        'appearance'    => 'Aussehen',
        'general'       => 'Allgemeine Informationen',
        'personality'   => 'Persönlichkeit',
    ],
    'show'          => [
        'tabs'  => [
            'map'           => 'Beziehungskarte',
            'organisations' => 'Organisationen',
        ],
        'title' => 'Charakter :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Es ist dir nicht erlaubt, die Persönlichkeit dieses Charakters zu bearbeiten.',
    ],
];
