<?php

return [
    'actions'       => [
        'action'    => 'Cambia stato',
        'add'       => 'Crea webhook',
        'bulks'     => [
            'delete_success'    => '{1} :count webhook eliminato.|[2,*] :count webhooks eliminati .',
            'disable'           => 'Disattiva',
            'disable_success'   => '{1} :count webhook disattivato.|[2,*] :count webhooks disattivati.',
            'enable'            => 'Attiva',
            'enable_success'    => '{1} :count webhook attivato.|[2,*] :count webhooks attivati.',
        ],
        'test'      => 'Testo del webhook',
        'update'    => 'Aggiorna webhook',
    ],
    'create'        => [
        'success'   => 'Webhook creato con successo',
        'title'     => 'Aggiungi nuovo webhook',
    ],
    'destroy'       => [
        'success'   => 'Webhook eliminato con successo',
    ],
    'edit'          => [
        'success'   => 'Webhook aggiornato con successo',
        'title'     => 'Aggiorna webhook',
    ],
    'fields'        => [
        'enabled'           => 'Attivato',
        'event'             => 'Evento',
        'events'            => [
            'deleted'   => 'Entità eliminata',
            'edited'    => 'Entità Modificata',
            'new'       => 'Nuova entità',
        ],
        'message'           => 'Messaggio',
        'private_entities'  => [
            'helper'    => 'Non attivare il webhook quando si aggiornano entità private.',
            'skip'      => 'Ignora entità private',
        ],
        'type'              => 'Tipo',
        'types'             => [
            'custom'    => 'Messaggio',
            'payload'   => 'Carico Utile',
        ],
        'url'               => 'Url',
    ],
    'helper'        => [
        'active'    => 'Se il webhook è attualmente attivo',
        'message'   => 'Aggiungi un messaggio personalizzato con supporto',
        'status'    => 'Cambia lo stato attivo del webhook',
    ],
    'pitch'         => 'Crea webhook personalizzati per ricevere aggiornamenti personalizzati ogni volta che un\'entità della campagna viene aggiornata.',
    'placeholders'  => [
        'message'   => '{chi} ha apportato delle modifiche a {nome}, controlla su {url}.',
        'url'       => 'Url del webhook di destinazione',
    ],
    'test'          => [
        'success'   => 'Richiesta di test inviata',
    ],
    'title'         => 'Webhooks',
];
