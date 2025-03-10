<?php

return [
    'actions'       => [
        'customise' => 'Upraviť nástenku',
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
        'pitch'         => 'Vytvor viacero násteniek s vlastnými oprávneniami pre každú rolu v kampani.',
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
            'new'               => 'Nový :type widget',
        ],
        'reorder'   => [
            'helper'    => 'Potiahni ma, ak ma chceš presunúť',
            'success'   => 'Widgety preskupené.',
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
            'welcome'       => 'Vitaj',
        ],
    ],
    'title'         => 'Nástenka',
    'widgets'       => [
        'actions'                   => [
            'advanced-options'  => 'Rozšírené možnosti',
        ],
        'advanced_options_boosted'  => 'Aktivovať viac možností ako napr. zobrazovania značiek s :boosted_campaign.',
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
            'title'     => 'Nový widget',
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
            'size'              => 'Veľkosť',
            'text'              => 'Text',
            'width'             => 'Šírka',
        ],
        'helpers'                   => [
            'class'     => 'Definuj vlastnú triedu CSS priradenú widgetu.',
            'filters'   => 'Klikni sem, ak chceš spoznať možnosti filtrovania.',
        ],
        'orders'                    => [
            'name_asc'  => 'Názov vzostupne',
            'name_desc' => 'Názov zostupne',
            'oldest'    => 'Najstaršie upravené',
            'recent'    => 'Posledne upravené',
        ],
        'preview'                   => [
            'displays'  => [
                'expand'    => 'Rozšíriteľný záznam',
                'full'      => 'Celý záznam',
            ],
            'fields'    => [
                'display'   => 'Zobraziť',
            ],
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Referencie na náhodný objekt môžeš vložiť pomocou {name}',
            ],
            'type'      => [
                'all'   => 'Všetko',
            ],
        ],
        'recent'                    => [
            'advanced_filter'   => 'Rozšírený filter',
            'advanced_filters'  => [
                'mentionless'   => 'Neobsahuje referencie (Objekty, ktoré nereferencujú iné)',
                'unmentioned'   => 'Nereferencované (Objekty, ktoré nie sú referencované v iných)',
            ],
            'all-entities'      => 'Všetky objekty',
            'entity-header'     => 'Použiť záhlavie objektu ako obrázok',
            'filters'           => 'Filtre',
            'help'              => 'Zobraziť iba posledný upravený objekt, no zobraziť celý náhľad na objekt',
            'helpers'           => [
                'entity-header'     => 'Ak má daný objekt záhlavie (funkcia boostnutých kampaní), nastav tento widget, aby použil tento obrázok namiesto obrázku objektu.',
                'show_attributes'   => 'Zobrazí pripnuté atribúty objektu pod záznamom.',
                'show_members'      => 'Ak je objekt rod alebo organizácia, pod záznamom sa zobrazia členovia.',
                'show_relations'    => 'Zobrazí pripnuté vzťahy objektu pod záznamom.',
            ],
            'show_attributes'   => 'Zobraziť pripnuté atribúty',
            'show_members'      => 'Zobraziť členov',
            'show_relations'    => 'Zobraziť pripnuté vzťahy',
            'singular'          => 'Jednotlivý objekt',
            'tags'              => 'Filtrovať zoznam nedávno upravených objektov podľa vybraných kategórií.',
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
        'welcome'                   => [
            'helper'    => 'Tento widget zobrazuje uvítaciu správu na nástenke, ktorá obsahuje nápomocné linky pre nových užívateľov/ky Kanky.',
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
