<?php

return [
    'actions'       => [
        'follow'    => 'Sledovat',
        'join'      => 'Přidat se',
        'unfollow'  => 'Přestat sledovat',
    ],
    'campaigns'     => [
        'tabs'  => [
            'modules'   => '{1} :count modul|[2,4] :count moduly|[5,*] :count modulů',
            'roles'     => '[1,4] :count role|[5,*] :count rolí',
            'users'     => '{1} :count uživatel|[2,4] :count uživatelé|[5,*] :count uživatelů',
        ],
    ],
    'dashboards'    => [
        'actions'       => [
            'edit'      => 'Upravit název a oprávnění',
            'new'       => 'Nová nástěnka',
            'switch'    => 'Přepnout na nástěnku',
        ],
        'boosted'       => ':boosted_campaigns mohou vytvářet samostatné nástěnky pro každou z rolí tažení',
        'create'        => [
            'success'   => 'Nová nástěnka :name tažení vytvořena.',
            'title'     => 'Nová nástěnka tažení',
        ],
        'custom'        => [
            'text'  => 'Nyní upravuješ nástěnku :name tažení',
        ],
        'default'       => [
            'text'  => 'Nyní upravuješ výchozí nástěnku tažení',
            'title' => 'Výchozí nástěnka',
        ],
        'delete'        => [
            'success'   => 'Nástěnka :name odstraněna.',
        ],
        'fields'        => [
            'copy_widgets'  => 'Zkopírovat součást nástěnky',
            'name'          => 'Název nástěnky',
            'visibility'    => 'Viditelnost',
        ],
        'helpers'       => [
            'copy_widgets'  => 'Zkopírovat součásti nástěnky :name na tuto nástěnku.',
        ],
        'placeholders'  => [
            'name'  => 'Pojmenovat nástěnku',
        ],
        'update'        => [
            'success'   => 'Nástěnka :name tažení aktualizována.',
            'title'     => 'Aktualizovat nástěnku :name tažení',
        ],
        'visibility'    => [
            'default'   => 'Výchozí',
            'none'      => 'Nedostupné',
            'visible'   => 'Viditelné',
        ],
    ],
    'helpers'       => [
        'follow'    => 'Tažení, která sleduješ, se budou zobrazovat v seznamu tažení (vlevo nahoře) pod vlastními taženími.',
        'join'      => 'Tažení přijímá pro nové členy. Klepnutím podáte přihlášku.',
        'setup'     => 'Vytvořit nástěnku tažení',
    ],
    'notifications' => [
        'modal' => [
            'confirm'   => 'Rozumím',
            'title'     => 'Důležité upozornění',
        ],
    ],
    'recent'        => [
        'title' => 'Nedávno upravené :name',
    ],
    'settings'      => [
        'title' => 'Nastavení nástěnky',
    ],
    'setup'         => [
        'actions'   => [
            'add'               => 'Přidat součást nástěnky',
            'back_to_dashboard' => 'Zpět na nástěnku',
            'edit'              => 'Upravit součást nástěnky',
        ],
        'title'     => 'Nastavení nástěnky tažení',
        'tutorial'  => [
            'blog'  => 'Naše výuka',
            'text'  => 'Potřebuješ pomoci s přípravou nástěnky svého tažení? Pomoc a inspiraci najdeš zde: :blog',
        ],
        'widgets'   => [
            'calendar'      => 'Kalendář',
            'campaign'      => 'Záhlaví kalendáře',
            'header'        => 'Záhlaví',
            'preview'       => 'Náhled objektu',
            'random'        => 'Náhodný objekt',
            'recent'        => 'Nedávno upravené',
            'unmentioned'   => 'Objekty bez odkazů',
        ],
    ],
    'title'         => 'Nástěnka',
    'widgets'       => [
        'actions'                   => [
            'advanced-options'  => 'Pokročilá nastavení',
            'delete-confirm'    => 'tato součást nástěnky',
        ],
        'advanced_options_boosted'  => ':boosted_campaigns poskytují pokročilé funkce. Například zobrazení členů rodů nebo atributy objektů na nástěnce',
        'calendar'                  => [
            'actions'           => [
                'next'      => 'Změnit datum na následující den',
                'previous'  => 'Změnit datum na předchozí den',
            ],
            'events_today'      => 'Dnes',
            'previous_events'   => 'Předchozí',
            'upcoming_events'   => 'Následující',
        ],
        'campaign'                  => [
            'helper'    => 'Tato součást ukazuje záhlaví nástěnky a výchozí nástěnka ji vždy obsahuje.',
        ],
        'create'                    => [
            'success'   => 'Součást nástěnky přidána.',
        ],
        'delete'                    => [
            'success'   => 'Součást nástěnky odebrána.',
        ],
        'fields'                    => [
            'dashboard'         => 'Nástěnka',
            'name'              => 'Vlastní název součásti nástěnky.',
            'optional-entity'   => 'Odkaz na objekt',
            'order'             => 'Řazení',
            'text'              => 'Text',
            'width'             => 'Šířka',
        ],
        'orders'                    => [
            'name_asc'  => 'Dle názvu vzestupně',
            'name_desc' => 'Dle názvu sestupně',
            'recent'    => 'Nedávno upravené',
        ],
        'random'                    => [
            'helpers'   => [
                'name'  => 'Pomocí {name} lze odkázat na náhodný objekt',
            ],
        ],
        'recent'                    => [
            'advanced_filter'   => 'Pokročilý filtr',
            'advanced_filters'  => [
                'mentionless'   => 'Objekty bez odkazů (neobsahují odkazy na jiné objekty)',
                'unmentioned'   => 'Neodkazované objekty (objekty, na které není nikde odkaz)',
            ],
            'entity-header'     => 'Použít záhlaví objektu jako obrázek',
            'filters'           => 'Filtry',
            'full'              => 'Zobrazit celý záznam',
            'help'              => 'Zobrazit pouze náhled prvního objektu namísto celého seznamu.',
            'helpers'           => [
                'entity-header'     => 'Pokud daný objekt obsahuje záhlaví, použije tato součást nástěnky obrázek záhlaví, namísto obrázku objektu (dostupné pouze pro zvýhodněná (boosted) tažení).',
                'filters'           => 'Je možné filtrovat druh zobrazovaných objektů. Návod jak používat toto pole najdete na stránce nápovědy zde: :link',
                'full'              => 'Ve výchozím zobrazení se zobrazit celý záznam objektu namísto jen náhledu.',
                'show_attributes'   => 'Zobrazit připnuté atributy pod záznamem.',
                'show_members'      => 'Pokud se jedná o objekt typu rod nebo organizace, zobrazit jeho členy pod záznamem.',
                'show_relations'    => 'Zobrazit připnuté vztahy objektu pod záznamem.',
            ],
            'show_attributes'   => 'Zobrazit připnuté atributy',
            'show_members'      => 'Zobrazit členy',
            'show_relations'    => 'Zobrazit připnuté vztahy',
            'singular'          => 'Náhled',
            'tags'              => 'Filtrovat seznam nedávno upravených objektů dle vybraných štítků.',
            'title'             => 'Nedávno upravené',
        ],
        'unmentioned'               => [
            'title' => 'Objekty bez odkazů',
        ],
        'update'                    => [
            'success'   => 'Součást nástěnky upravena.',
        ],
        'widths'                    => [
            '0' => 'Automatická',
            '12'=> 'Plná (100%)',
            '3' => 'Úzká (25%)',
            '4' => 'Malá (33%)',
            '6' => 'Poloviční (50%)',
            '8' => 'Široká (66%)',
            '9' => 'Velká (75%)',
        ],
    ],
];
