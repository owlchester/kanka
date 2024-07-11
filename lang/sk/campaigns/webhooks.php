<?php

return [
    'actions'       => [
        'action'    => 'Zmeniť stav',
        'add'       => 'Vytvoriť webhook',
        'bulks'     => [
            'delete_success'    => '{1} :count webhook zmazaný.|[2,4] :count webhooky zmazané.|[5,*] :count webhookov zmazaných.',
            'disable'           => 'Deaktivovať',
            'disable_success'   => '{1} :count webhook deaktivovaný.|[2,4] :count webhooky deaktivované.|[5,*] :count webhookov deaktivovaných.',
            'enable'            => 'Aktivovať',
            'enable_success'    => '{1} :count webhook aktivovaný.|[2,4] :count webhooky aktivované.|[5,*] :count webhookov aktivovaných.',
        ],
        'test'      => 'Testovať webhook',
        'update'    => 'Aktualizovať webhook',
    ],
    'create'        => [
        'success'   => 'Webhook úspešne vytvorený',
        'title'     => 'Pridať nový webhook',
    ],
    'destroy'       => [
        'success'   => 'Webhook úspešne zmazaný',
    ],
    'edit'          => [
        'success'   => 'Webhook úspešne aktualizovaný',
        'title'     => 'Aktualizovať webhook',
    ],
    'fields'        => [
        'enabled'   => 'Aktivovaný',
        'event'     => 'Udalosť',
        'events'    => [
            'deleted'   => 'Zmazaný objekt',
            'edited'    => 'Upravený objekt',
            'new'       => 'Nový objekt',
        ],
        'message'   => 'Správa',
        'type'      => 'Typ',
        'types'     => [
            'custom'    => 'Správa',
            'payload'   => 'Payload',
        ],
        'url'       => 'Url',
    ],
    'helper'        => [
        'active'    => 'Ak je webhook práve aktívny',
        'message'   => 'Pridaj vlastnú správu s podporou pre mapovanie',
        'status'    => 'Zmeň aktívny stav webhooku',
    ],
    'pitch'         => 'Vytvor vlastné webhooky na príjem cielených aktualizácií, keď je aktualizovaný objekt kampane.',
    'placeholders'  => [
        'message'   => '{who} urobil zmeny v {name}, zisti to na {url}',
        'url'       => 'Url cieľového webhooku',
    ],
    'test'          => [
        'success'   => 'Požiadavka na test zaslaná',
    ],
    'title'         => 'Webhooky',
];
