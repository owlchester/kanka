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
            'calendar'      => 'Kalendár',
            'preview'       => 'Náhľad objektu',
            'random'        => 'Náhodný objekt',
            'recent'        => 'Nedávne',
            'unmentioned'   => 'Objekty bez referencií',
        ],
    ],
    'title'             => 'Nástenka',
    'welcome'           => [
        'body'  => <<<'TEXT'
Vitaj v Kanke! Tvoju prvú kampaň je vytvorená a pre inšpiráciu sme do nej vložili pár objektov ako príklad (tie môžeš hocikedy odstrániť).

Chceš asi začať zakladať vlastné objekty, tak si vyber niektorú z kategórií v menu! Kategórie, ktoré nepotrebuješ, môžeš vypnúť v nastavení tvojej kampane.

Na začiatok pár tipov:
- Zadaním @menoobjektu môžeš vytvoriť linku na daný objekt. Zobrazovaný text linky sa automaticky aktualizuje, ak upravíš meno daného objektu alebo jeho popis.
- V nastavení tvojho profilového konta vpravo hore vieš upraviť dizajn a zobrazenie objektov.
- Na :youtube sa nachádza stále narastajúci počet návodov. Mimo iných aj o atribútoch a ako zdieľať kampaň s ostatnými. Na pomoc tu máme aj :faq.
- Keď budeš mať otázky alebo návrhy - alebo si chceš len pokecať - ukáž sa v našom :discord.
TEXT
,
    ],
    'widgets'           => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Zmeniť dátum na nasledujúci deň',
                'previous'  => 'Zmeniť dátum na predošlý deň',
            ],
            'events_today'      => 'Dnes',
            'previous_events'   => 'Predošlé',
            'upcoming_events'   => 'Nasledujúce',
        ],
        'create'        => [
            'success'   => 'Widget bol pridaný na nástenku.',
        ],
        'delete'        => [
            'success'   => 'Widget bol odstránený z nástenky.',
        ],
        'fields'        => [
            'width' => 'Šírka',
        ],
        'recent'        => [
            'entity-header' => 'Použiť záhlavie objektu ako obrázok',
            'full'          => 'Plná',
            'help'          => 'Zobraziť iba posledný upravený objekt, no zobraziť celý náhľad na objekt',
            'helpers'       => [
                'entity-header' => 'Ak má daný objekt záhlavie (funkcia boostnutých kampaní), nastav tento widget, aby použil tento obrázok namiesto obrázku objektu.',
                'full'          => 'Zobraziť celý zápis objektu namiesto jeho náhľadu.',
            ],
            'singular'      => 'Jednotlivý objekt',
            'tags'          => 'Filtrovať zoznam nedávno upravených objektov podľa určitých tagov.',
            'title'         => 'Nedávno upravené',
        ],
        'unmentioned'   => [
            'title' => 'Objekty bez referencií',
        ],
        'update'        => [
            'success'   => 'Widget bol upravený.',
        ],
        'widths'        => [
            '0' => 'Automatická',
            '12'=> 'Plná (100%)',
            '3' => 'Mini (25%)',
            '4' => 'Malá (33%)',
            '6' => 'Polovičná (50%)',
            '8' => 'Široká (66%)',
        ],
    ],
];
