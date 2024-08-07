<?php

return [
    'actions'       => [
        'add_appearance'    => 'Füge ein Aussehen hinzu',
        'add_personality'   => 'Füge eine Persönlichkeit hinzu',
    ],
    'conversations' => [],
    'create'        => [
        'title' => 'Erstelle einen neuen Charakter',
    ],
    'destroy'       => [],
    'dice_rolls'    => [],
    'edit'          => [],
    'fields'        => [
        'age'                       => 'Alter',
        'is_appearance_pinned'      => 'Angeheftetes Aussehen',
        'is_dead'                   => 'Tot',
        'is_personality_pinned'     => 'Angeheftete Persönlichkeit',
        'is_personality_visible'    => 'Persönlichkeit sichtbar?',
        'life'                      => 'Leben',
        'physical'                  => 'Körper',
        'pronouns'                  => 'Pronomen',
        'sex'                       => 'Geschlecht',
        'title'                     => 'Titel',
        'traits'                    => 'Eigenschaften',
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
    'index'         => [],
    'items'         => [],
    'journals'      => [],
    'labels'        => [
        'appearance'    => [
            'entry' => 'Erscheinungsbeschreibung',
            'name'  => 'Erscheinungsname',
        ],
        'personality'   => [
            'entry' => 'Beschreibung von Persönlichkeitsmerkmalen',
            'name'  => 'Name des Persönlichkeitsmerkmals',
        ],
    ],
    'maps'          => [],
    'organisations' => [
        'create'    => [
            'success'   => 'Charakter wurde der Organisation hinzugefügt.',
            'title'     => 'Neue Organisation für :name',
        ],
        'destroy'   => [
            'success'   => 'Character aus Organisation entfernt.',
        ],
        'edit'      => [
            'success'   => 'Organisation des Charakters aktualisiert',
            'title'     => 'Aktualisiere Organisation für :name',
        ],
        'fields'    => [
            'role'  => 'Rolle',
        ],
    ],
    'placeholders'  => [
        'age'               => 'Alter',
        'appearance_entry'  => 'Beschreibung',
        'appearance_name'   => 'Haare, Augen, Haut, Größe',
        'name'              => 'Name des Charakters',
        'personality_entry' => 'Details',
        'personality_name'  => 'Persönlichkeitsmerkmal: Ziele, Gewohnheiten, Ängste, Bindungen',
        'physical'          => 'Körper',
        'pronouns'          => 'Er / Ihn, Sie / Sie, Sie / Ihre',
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
    'races'         => [
        'reorder'   => [
            'success'   => 'Die Charakterrassen wurden erfolgreich aktualisiert.',
        ],
        'title'     => 'Verwalten der Rassen von :name',
    ],
    'sections'      => [
        'appearance'    => 'Aussehen',
        'personality'   => 'Persönlichkeit',
    ],
    'show'          => [],
    'warnings'      => [
        'personality_hidden'    => 'Es ist dir nicht erlaubt, die Persönlichkeit dieses Charakters zu bearbeiten.',
    ],
];
