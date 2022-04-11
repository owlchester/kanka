<?php

return [
    'actions'       => [
        'follow'    => 'Sledovať',
        'join'      => 'Pridať sa',
        'unfollow'  => 'Zrušiť sledovanie',
    ],
    'campaigns'     => [
        'tabs'  => [
            'modules'   => '{1} :count modul|[2,4] :count moduly|[5,*] :count modulov',
            'roles'     => '{1} :count rola|[2,4] :count role|[5,*] :count rolí',
            'users'     => '{1} :count užívateľ|[2,4] :count užívatelia|[5,*] :count užívateľov',
        ],
    ],
    'dashboards'    => [
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
    'helpers'       => [
        'follow'    => 'Keď sleduješ nejakú kampaň, bude sa ti zobrazovať v prepínači kampaní (vpravo hore) pod tvojimi kampaňami.',
        'join'      => 'Táto kampaň je otvorená pre nových členov. Klikni sem na pridanie sa do nej.',
        'setup'     => 'Nastav svoju nástenku kampane.',
    ],
    'notifications' => [
        'modal' => [
            'confirm'   => 'Rozumiem',
            'title'     => 'Dôležitý oznam',
        ],
    ],
    'recent'        => [
        'title' => 'Nedávno zmenené :name',
    ],
    'settings'      => [
        'title' => 'Nastavenia nástenky',
    ],
    'setup'         => [
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
    'title'         => 'Nástenka',
    'widgets'       => [
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
            'class'             => 'Trieda CSS',
            'dashboard'         => 'Nástenka',
            'name'              => 'Vlastný názov widgetu',
            'optional-entity'   => 'Link k objektu',
            'order'             => 'Zoradenie',
            'text'              => 'Text',
            'width'             => 'Šírka',
        ],
        'helpers'                   => [
            'class' => 'Definuj vlastnú triedu CSS priradenú widgetu.',
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
            'advanced_filter'   => 'Rozšírený filter',
            'advanced_filters'  => [
                'mentionless'   => 'Neobsahuje referencie (Objekty, ktoré nereferencujú iné)',
                'unmentioned'   => 'Nereferencované (Objekty, ktoré nie sú referencované v iných)',
            ],
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
        'tabs'                      => [
            'advanced'  => 'Rozšírené',
            'setup'     => 'Nastavenie',
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
