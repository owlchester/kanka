<?php

return [
    'create'        => [
        'title' => 'Neue Unterhaltung',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_closed'     => 'geschlossen',
        'messages'      => 'Nachrichten',
        'participants'  => 'Teilnehmer',
    ],
    'hints'         => [
        'empty'         => 'An diesem Gespräch sind keine Teilnehmer beteiligt.',
        'participants'  => 'Bitte füge Teilnehmer zu deiner Unterhaltung hinzu, indem du das :icon Symbol oben rechts drückst.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Zeichne Dialoge, Briefe oder den Austausch zwischen Charakteren und Fraktionen auf.',
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
        'create'    => [
            'success'   => 'Teilnehmer :entity zu Unterhaltung hinzugefügt.',
        ],
        'destroy'   => [
            'success'   => 'Teilnehmer :entity von Unterhaltung entfernt.',
        ],
        'helper'    => 'Hinzufügen und Entfernen von Teilnehmern aus :name.',
        'modal'     => 'Teilnehmer',
        'title'     => 'Teilnehmer von :name',
    ],
    'placeholders'  => [
        'name'  => 'Name der Unterhaltung',
        'type'  => 'Im Spiel, Vorbereitung, Handlung',
    ],
    'show'          => [
        'is_closed' => 'Unterhaltung geschlossen',
    ],
    'tabs'          => [
        'participants'  => 'Teilnehmer',
    ],
    'targets'       => [
        'characters'    => 'Charaktere',
        'members'       => 'Mitglieder',
    ],
];
