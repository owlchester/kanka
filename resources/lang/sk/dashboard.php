<?php

return [
    'actions'           => [
        'follow'    => 'Sledovať',
        'join'      => 'Pridať sa',
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
    'dashboards'        => [
        'actions'       => [
            'edit'      => 'Upraviť názov a oprávnenia',
            'new'       => 'Nová nástenka',
            'switch'    => 'Prepnúť na nástenku',
        ],
        'boosted'       => ':boosted_campaigns môžu mať viacero násteniek pre rôzne role v kampani.',
        'create'        => [
            'success'   => 'Nová nástenka :name kampane vytvorená.',
            'title'     => 'Nová nástenka kampane',
        ],
        'custom'        => [
            'text'  => 'Aktuálne upravuješ nástenku :name kampane.',
        ],
        'default'       => [
            'text'  => 'Aktuálne upravuješ štandardnú nástenku kampane.',
            'title' => 'Štandardná nástenka',
        ],
        'delete'        => [
            'success'   => 'Nástenka :name odstránená.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Kopírovať widgety',
            'name'          => 'Názov nástenky',
            'visibility'    => 'Viditeľnosť',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Duplikovať widgety z nástenky :name na túto novú.',
        ],
        'placeholders'  => [
            'name'  => 'Pomenovanie nástenky',
        ],
        'update'        => [
            'success'   => 'Nástenka kampane :name aktualizovaná.',
            'title'     => 'Aktualizovať nástenku kampane :name',
        ],
        'visibility'    => [
            'default'   => 'Štandardná',
            'none'      => 'Žiadna',
            'visible'   => 'Viditeľná',
        ],
    ],
    'description'       => 'Domov tvojej kreativity',
    'helpers'           => [
        'follow'    => 'Keď sleduješ nejakú kampaň, bude sa ti zobrazovať v prepínači kampaní (vpravo hore) pod tvojimi kampaňami.',
        'join'      => 'Táto kampaň je otvorená pre nových členov. Klikni sem na pridanie sa do nej.',
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
        'tutorial'  => [
            'blog'  => 'náš návod',
            'text'  => 'Potrebuješ nastaviť nástenku tvojej kampane? Prečítaj si :blog, ktorý ti poskytne pomoc a inšpiráciu.',
        ],
        'widgets'   => [
            'calendar'      => 'Kalendár',
            'campaign'      => 'Záhlavie kampane',
            'header'        => 'Záhlavie',
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
        'actions'                   => [
            'advanced-options'  => 'Rozšírené možnosti',
            'delete-confirm'    => 'tento widget',
        ],
        'advanced_options_boosted'  => ':boosted_campaigns majú rozšírené možnosti ako zobrazovanie členov rodov alebo atribútov objektu na nástenke.',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Zmeniť dátum na nasledujúci deň',
                'previous'  => 'Zmeniť dátum na predošlý deň',
            ],
            'events_today'      => 'Dnes',
            'previous_events'   => 'Predošlé',
            'upcoming_events'   => 'Nasledujúce',
        ],
        'campaign'                  => [
            'helper'    => 'Tento widget zobrazuje záhlavie kampane. Tento widget je vždy zobrazovaný na štandardnej nástenke.',
        ],
        'create'                    => [
            'success'   => 'Widget bol pridaný na nástenku.',
        ],
        'delete'                    => [
            'success'   => 'Widget bol odstránený z nástenky.',
        ],
        'fields'                    => [
            'dashboard'         => 'Nástenka',
            'name'              => 'Vlastný názov widgetu',
            'optional-entity'   => 'Link k objektu',
            'order'             => 'Zoradenie',
            'text'              => 'Text',
            'width'             => 'Šírka',
        ],
        'orders'                    => [
            'name_asc'  => 'Názov vzostupne',
            'name_desc' => 'Názov zostupne',
            'recent'    => 'Posledne upravené',
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Referencie na náhodný objekt môžeš vložiť pomocou {name}',
            ],
        ],
        'recent'                    => [
            'entity-header'     => 'Použiť záhlavie objektu ako obrázok',
            'filters'           => 'Filtre',
            'full'              => 'Plná',
            'help'              => 'Zobraziť iba posledný upravený objekt, no zobraziť celý náhľad na objekt',
            'helpers'           => [
                'entity-header'     => 'Ak má daný objekt záhlavie (funkcia boostnutých kampaní), nastav tento widget, aby použil tento obrázok namiesto obrázku objektu.',
                'filters'           => 'Môžeš zoradiť zobrazenie objektov. Ak chceš zistiť, ako funguje toto pole, klikni na pomocnú stránu :link.',
                'full'              => 'Zobraziť celý zápis objektu namiesto jeho náhľadu.',
                'show_attributes'   => 'Zobrazí pripnuté atribúty objektu pod záznamom.',
                'show_members'      => 'Ak je objekt rod alebo organizácia, pod záznamom sa zobrazia členovia.',
                'show_relations'    => 'Zobrazí pripnuté vzťahy objektu pod záznamom.',
            ],
            'show_attributes'   => 'Zobraziť pripnuté atribúty',
            'show_members'      => 'Zobraziť členov',
            'show_relations'    => 'Zobraziť pripnuté vzťahy',
            'singular'          => 'Jednotlivý objekt',
            'tags'              => 'Filtrovať zoznam nedávno upravených objektov podľa určitých tagov.',
            'title'             => 'Nedávno upravené',
        ],
        'unmentioned'               => [
            'title' => 'Objekty bez referencií',
        ],
        'update'                    => [
            'success'   => 'Widget bol upravený.',
        ],
        'widths'                    => [
            '0' => 'Automatická',
            '12'=> 'Plná (100%)',
            '3' => 'Mini (25%)',
            '4' => 'Malá (33%)',
            '6' => 'Polovičná (50%)',
            '8' => 'Široká (66%)',
            '9' => 'Veľká (75%)',
        ],
    ],
];
