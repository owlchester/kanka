<?php

return [
    'actions'       => [
        'apply_template'    => 'Použiť šablónu atribútov',
        'manage'            => 'Spravovať',
        'more'              => 'Ďalšie možnosti',
        'remove_all'        => 'Odstrániť všetko',
    ],
    'errors'        => [
        'loop'      => 'Vo výpočte atribútu sa vyskytuje nekonečná slučka!',
        'too_many'  => 'Tento objekt má príliš veľa polí a nie je možné mu pridať ďalšie atribúty. Zmaž niektoré z atribútov, ak chceš pridať nové.',
    ],
    'fields'        => [
        'attribute'             => 'Atribút',
        'community_templates'   => 'Komunitné šablóny',
        'is_private'            => 'Súkromné atribúty',
        'is_star'               => 'Pripnutý',
        'template'              => 'Šablóna',
        'value'                 => 'Hodnota',
    ],
    'filters'       => [
        'name'  => 'Názov atribútu',
        'value' => 'Hodnota atribútu',
    ],
    'helpers'       => [
        'delete_all'    => 'Naozaj chceš odstrániť všetky atribúty tohto objektu?',
        'setup'         => 'Prvky ako HP alebo Inteligenciu nejakého objektu s atribútmi je možné referencovať. Atribúty pridáš ručne kliknutím na tlačidlo :manage alebo aplikovaním niektorej zo šablón atribútov.',
    ],
    'hints'         => [
        'is_private2'   => 'Ak aktivované, iba členovia role :admin-role budú vidieť atribúty tohto objektu.',
    ],
    'index'         => [
        'success'   => 'Atribúty pre :entity upravené.',
        'title'     => 'Atribúty pre :name',
    ],
    'placeholders'  => [
        'attribute' => 'Počet dobytí, úroveň obtiažnosti výzvy, iniciatíva, obyvateľstvo',
        'block'     => 'Názov bloku',
        'checkbox'  => 'Názov zaškrtávacieho políčka',
        'icon'      => [
            'class' => 'Trieda FontAwesome alebo RPG Awesome: fas fa-users',
            'name'  => 'Názov symbolu',
        ],
        'random'    => [
            'name'  => 'Názov atribútu',
            'value' => '1-100 alebo zoznam hodnôt oddelených čiarkou',
        ],
        'section'   => 'Názov sekcie',
        'template'  => 'Vybrať šablónu',
        'value'     => 'Hodnota atribútu',
    ],
    'show'          => [
        'title' => 'Atribúty :name',
    ],
    'template'      => [
        'success'   => 'Šablóna atribútov :name použitá na :entity',
        'title'     => 'Použiť šablónu atribútov na :name',
    ],
    'types'         => [
        'attribute' => 'Atribút',
        'block'     => 'Blok',
        'checkbox'  => 'Zaškrtávacie políčko',
        'icon'      => 'Symbol',
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
