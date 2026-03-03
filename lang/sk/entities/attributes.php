<?php

return [
    'actions'       => [
        'load'          => 'Nahrať',
        'manage'        => 'Spravovať',
        'more'          => 'Ďalšie možnosti',
        'remove_all'    => 'Odstrániť všetko',
        'save_and_edit' => 'Použiť a Upraviť',
        'save_and_story'=> 'Použiť a Zobraziť',
        'show_hidden'   => 'Zobraziť skryté atribúty',
        'toggle_privacy'=> 'Súkromný/Verejný',
    ],
    'errors'        => [
        'loop'                  => 'Vo výpočte atribútu sa vyskytuje nekonečná slučka!',
        'no_attribute_selected' => 'Vyber najprv jeden alebo viac atribútov.',
        'too_many_v2'           => 'Dosiahnuté max. počet polí (:count/:max). Zmaž najprv niektoré z atribútov pred pridaním nových.',
    ],
    'fields'        => [
        'community_templates'   => 'Komunitné šablóny',
        'is_private'            => 'Súkromné atribúty',
        'is_star'               => 'Pripnutý',
        'preferences'           => 'Preferencie',
        'template'              => 'Šablóna',
        'value'                 => 'Hodnota',
    ],
    'filters'       => [
        'name'  => 'Názov atribútu',
        'value' => 'Hodnota atribútu',
    ],
    'helpers'       => [
        'delete_all'    => 'Naozaj chceš odstrániť všetky atribúty tohto objektu?',
        'is_private'    => 'Povolí iba osobám s :admin-role rolou, aby videli atribúty tohto objektu.',
        'setup'         => 'Prvky ako HP alebo Inteligenciu nejakého objektu s atribútmi je možné referencovať. Atribúty pridáš ručne kliknutím na tlačidlo :manage alebo aplikovaním niektorej zo šablón atribútov.',
    ],
    'hints'         => [],
    'index'         => [
        'success'   => 'Atribúty pre :entity upravené.',
        'title'     => 'Atribúty pre :name',
    ],
    'labels'        => [
        'checkbox'  => 'Názov zaškrtávacieho políčka',
        'name'      => 'Názov atribútu',
        'section'   => 'Názov sekcie',
        'value'     => 'Hodnota atribútu',
    ],
    'live'          => [
        'success'   => 'Atribút :attribute aktualizovaný.',
        'title'     => 'Aktualizácia :attribute',
    ],
    'placeholders'  => [
        'attribute' => 'Počet dobytí, úroveň obtiažnosti výzvy, iniciatíva, obyvateľstvo',
        'block'     => 'Názov bloku',
        'checkbox'  => 'Názov zaškrtávacieho políčka',
        'icon'      => [
            'class' => 'Trieda FontAwesome alebo RPG Awesome: fas fa-users',
            'name'  => 'Názov symbolu',
        ],
        'number'    => 'Názov čísla',
        'random'    => [
            'name'  => 'Názov atribútu',
            'value' => '1-100 alebo zoznam hodnôt oddelených čiarkou',
        ],
        'section'   => 'Názov sekcie',
        'template'  => 'Vybrať šablónu',
        'value'     => 'Hodnota atribútu',
    ],
    'ranges'        => [
        'text'  => 'Dostupné možnosti :options',
    ],
    'sections'      => [
        'unorganised'   => 'Nezorganizované',
    ],
    'show'          => [
        'hidden'    => 'Skryté atribúty',
        'title'     => 'Atribúty :name',
    ],
    'template'      => [
        'load'      => [
            'success'   => 'Šablóna nahraná',
            'title'     => 'Nahrať zo šablóny',
        ],
        'success'   => 'Šablóna atribútov :name použitá na :entity',
        'title'     => 'Použiť šablónu atribútov na :name',
    ],
    'title'         => 'Atribúty',
    'toasts'        => [
        'bulk_deleted'  => 'Atribúty odstránené',
        'bulk_privacy'  => 'Súkromie atribútov prepnuté',
        'lock'          => 'Atribút uzamknutý',
        'pin'           => 'Atribút pripnutý',
        'unlock'        => 'Atribút odomknutý',
        'unpin'         => 'Atribút odopnutý',
    ],
    'tutorials'     => [],
    'types'         => [
        'attribute' => 'Atribút',
        'block'     => 'Blok',
        'checkbox'  => 'Zaškrtávacie políčko',
        'icon'      => 'Symbol',
        'number'    => 'Číslo',
        'random'    => 'Náhodne',
        'section'   => 'Sekcia',
        'text'      => 'Viacriadkový text',
    ],
    'update'        => [
        'success'   => 'Atribúty pre :entity aktualizované.',
    ],
    'visibility'    => [
        'entry'     => 'Atribút je zobrazený v menu objektu.',
        'private'   => 'Atribút viditeľný len pre členov s rolou Admin.',
        'public'    => 'Atribút viditeľný pre všetkých členov.',
        'tab'       => 'Atribút je zobrazený len v karte atribútov.',
    ],
];
