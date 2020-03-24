<?php

return [
    'create'        => [
        'description'   => 'Erstelle eine neue Unterhaltung',
        'success'       => 'Unterhaltung :name erstellt.',
        'title'         => 'Neue Unterhaltung',
    ],
    'destroy'       => [
        'success'   => 'Unterhaltung :name gelöscht.',
    ],
    'edit'          => [
        'description'   => 'Aktualisiere die Unterhaltung',
        'success'       => 'Unterhaltung \':name\' aktualisiert.',
        'title'         => 'Unterhaltung :name',
    ],
    'fields'        => [
        'messages'      => 'Nachrichten',
        'name'          => 'Name',
        'participants'  => 'Teilnehmer',
        'target'        => 'Ziel',
        'type'          => 'Typ',
    ],
    'hints'         => [
        'participants'  => 'Bitte füge Teilnehmer zu deiner Unterhaltung hinzu, indem du das :icon Symbol oben rechts drückst.',
    ],
    'index'         => [
        'add'           => 'Neue Unterhaltung',
        'description'   => 'Verwalte die Kategorie von :name.',
        'header'        => 'Unterhaltungen in :name',
        'title'         => 'Unterhaltungen',
    ],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Nachricht gelöscht.',
        ],
        'is_updated'    => 'Aktualisiert',
        'load_previous' => 'Lade vorherige Nachrichten',
        'placeholders'  => [
            'message'   => 'Deine Nachricht',
        ],
    ],
    'participants'  => [
        'create'        => [
            'success'   => 'Teilnehmer :entity zu Unterhaltung hinzugefügt.',
        ],
        'description'   => 'Entferne oder füge Teilnehmer einer Unterhaltung hinzu',
        'destroy'       => [
            'success'   => 'Teilnehmer :entity von Unterhaltung entfernt.',
        ],
        'modal'         => 'Teilnehmer',
        'title'         => 'Teilnehmer von :name',
    ],
    'placeholders'  => [
        'name'  => 'Name der Unterhaltung',
        'type'  => 'Im Spiel, Vorbereitung, Handlung',
    ],
    'show'          => [
        'description'   => 'Eine Detailansicht einer Unterhaltung',
        'title'         => 'Unterhaltung :name',
    ],
    'tabs'          => [
        'conversation'  => 'Unterhaltung',
        'participants'  => 'Teilnehmer',
    ],
    'targets'       => [
        'characters'    => 'Charaktere',
        'members'       => 'Mitglieder',
    ],
];
