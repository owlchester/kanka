<?php

return [
    'actions'           => [
        'follow'    => 'Sledovať',
        'unfollow'  => 'Zrušiť sledovanie',
    ],
    'campaigns'         => [
        'manage'    => 'Spravovať kampaň',
        'tabs'      => [
            'modules'   => '{1} :count modul|[2,4] :count moduly|[5,*] :count modulov',
            'roles'     => '{1} :count rola|[2,4] :count role|[5,*] :count rolí',
            'users'     => '{1} :count užívateľ|[2,4] :count užívatelia|[5,*] :count užívateľov',
        ],
    ],
    'description'       => 'Domov tvojej kreativity',
    'helpers'           => [
        'follow'    => 'Keď sleduješ nejakú kampaň, bude sa ti zobrazovať v prepínači kampaní (vpravo hore) pod tvojimi kampaňami.',
        'setup'     => 'Nastav svoju nástenku kampane.',
    ],
    'latest_release'    => 'Posledná verzia',
    'notifications'     => [
        'modal' => [
            'confirm'   => 'Rozumiem',
            'title'     => 'Dôležitý oznam',
        ],
    ],
    'recent'            => [
        'add'           => 'Vytvoriť :name',
        'no_entries'    => 'Z daného typu neexistujú žiadne objekty.',
        'title'         => 'Nedávno zmenené :name',
        'view'          => 'Zobraziť všetky :name',
    ],
    'settings'          => [
        'description'   => 'Uprav, čo sa zobrazuje na nástenke',
        'edit'          => [
            'success'   => 'Zmeny boli uložené.',
        ],
        'fields'        => [
            'helper'        => 'Jednoducho môžeš zmeniť, čo sa zobrazuje na nástenke. Uvedom si, že toto platí pre všetky tvoje kampane, bez ohľadu na nastavenia v kampani.',
            'recent_count'  => 'Počet nedávno pridaných objektov',
        ],
        'title'         => 'Nastavenia nástenky',
    ],
    'setup'             => [
        'actions'   => [
            'add'               => 'Pridať widget',
            'back_to_dashboard' => 'Naspäť na nástenku',
            'edit'              => 'Upraviť widget',
        ],
        'title'     => 'Nastavenie nástenky kampane',
        'widgets'   => [
            'calendar'  => 'Kalendár',
            'preview'   => 'Náhľad objektu',
            'recent'    => 'Nedávne',
        ],
    ],
    'title'             => 'Nástenka',
    'widgets'           => [
        'calendar'  => [
            'actions'           => [
                'next'      => 'Zmeniť dátum na nasledujúci deň',
                'previous'  => 'Zmeniť dátum na predošlý deň',
            ],
            'events_today'      => 'Dnes',
            'previous_events'   => 'Predošlé',
            'upcoming_events'   => 'Nasledujúce',
        ],
        'create'    => [
            'success'   => 'Widget bol pridaný na nástenku.',
        ],
        'delete'    => [
            'success'   => 'Widget bol odstránený z nástenky.',
        ],
        'fields'    => [
            'width' => 'Šírka',
        ],
        'recent'    => [
            'full'      => 'Plná',
            'help'      => 'Zobraziť iba posledný upravený objekt, no zobraziť celý náhľad na objekt',
            'helpers'   => [
                'full'  => 'Zobraziť celý zápis objektu namiesto jeho náhľadu.',
            ],
            'singular'  => 'Jednotlivý objekt',
            'title'     => 'Nedávno upravené',
        ],
        'update'    => [
            'success'   => 'Widget bol upravený.',
        ],
        'widths'    => [
            '0' => 'Automatická',
            '12'=> 'Plná',
            '4' => 'Malá',
            '6' => 'Polovičná',
        ],
    ],
];
