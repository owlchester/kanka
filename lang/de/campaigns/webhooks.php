<?php

return [
    'actions'       => [
        'action'    => 'Status ändern',
        'add'       => 'Webhook erstellen',
        'bulks'     => [
            'delete_success'    => '{1} Gelöscht :count webhook.|[2,*] Gelöscht :count webhooks.',
            'disable'           => 'Deaktivieren',
            'disable_success'   => '{1} Deaktiviert :count webhook.|[2,*] Deaktiviert :count webhooks.',
            'enable'            => 'Aktivieren',
            'enable_success'    => '{1} Freigegeben :count webhook.|[2,*] Freigegeben :count webhooks.',
        ],
        'test'      => 'Test Webhook',
        'update'    => 'Webhook aktualisieren',
    ],
    'create'        => [
        'success'   => 'Webhook erfolgreich erstellt',
        'title'     => 'Neuen Webhook hinzufügen',
    ],
    'destroy'       => [
        'success'   => 'Webhook erfolgreich gelöscht',
    ],
    'edit'          => [
        'success'   => 'Webhook erfolgreich aktualisiert',
        'title'     => 'Webhook aktualisieren',
    ],
    'fields'        => [
        'enabled'           => 'Aktiviert',
        'event'             => 'Event',
        'events'            => [
            'deleted'   => 'Gelöschtes Objekt',
            'edited'    => 'Bearbeitetes Objekt',
            'new'       => 'Neues Objekt',
        ],
        'message'           => 'Nachricht',
        'private_entities'  => [
            'helper'    => 'Löse den Webhook nicht aus, wenn du private Objekte aktualisierst.',
            'skip'      => <<<'TEXT'
Private Objekte 
überspringen
TEXT
,
        ],
        'type'              => 'Typ',
        'types'             => [
            'custom'    => 'Nachricht',
            'payload'   => 'Nutzlast',
        ],
        'url'               => 'Url',
    ],
    'helper'        => [
        'active'    => 'Falls der Webhook gerade aktiv ist',
        'message'   => 'Hinzufügen einer benutzerdefinierten Nachricht mit Unterstützung für Mappings',
        'status'    => 'Umschalten des aktiven Status des Webhooks',
    ],
    'pitch'         => 'Erstelle benutzerdefinierte Webhooks, um benutzerdefinierte Aktualisierungen zu erhalten, wenn ein Objekt der Kampagne aktualisiert wird.',
    'placeholders'  => [
        'message'   => '{who} hat Änderungen an  {name}, vorgenommen, sieh sie dir hier {url} an.',
        'url'       => 'Url des Ziel-Webhooks',
    ],
    'test'          => [
        'success'   => 'Testanfrage gesendet',
    ],
    'title'         => 'Webhooks',
];
