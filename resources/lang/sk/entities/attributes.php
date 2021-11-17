<?php

return [
    'actions'       => [
        'add'               => 'Pridať atribúť',
        'add_block'         => 'Pridať blok',
        'add_checkbox'      => 'Pridať zaškrtávacie políčko',
        'add_text'          => 'Pridať text',
        'apply_template'    => 'Použiť šablónu atribútov',
        'manage'            => 'Spravovať',
        'more'              => 'Ďalšie možnosti',
        'remove_all'        => 'Odstrániť všetko',
    ],
    'create'        => [
        'description'   => 'Vytvoriť nový atribút',
        'success'       => 'Atribút :name pridaný k :entity.',
        'title'         => 'Nový atribút pre :name',
    ],
    'destroy'       => [
        'success'   => 'Atribút :name odstránený z :entity.',
    ],
    'edit'          => [
        'description'   => 'Upraviť existujúci atribút',
        'success'       => 'Atribút :name upravený pre :entity.',
        'title'         => 'Upraviť atribút pre :name',
    ],
    'errors'        => [
        'loop'  => 'Vo výpočte atribútu sa vyskytuje nekonečná slučka!',
    ],
    'fields'        => [
        'attribute'             => 'Atribút',
        'community_templates'   => 'Komunitné šablóny',
        'is_private'            => 'Súkromné atribúty',
        'is_star'               => 'Pripnutý',
        'template'              => 'Šablóna',
        'value'                 => 'Hodnota',
    ],
    'helpers'       => [
        'delete_all'    => 'Naozaj chceš odstrániť všetky atribúty tohto objektu?',
        'setup'         => 'Prvky ako HP alebo Inteligenciu nejakého objektu s atribútmi je možné referencovať. Atribúty pridáš ručne kliknutím na tlačidlo :manage alebo aplikovaním niektorej zo šablón atribútov.',
    ],
    'hints'         => [
        'is_private'    => 'Všetky atribúty objektu je možné skryť pred všetkými členmi okrem tých s rolou Admin, ak ho nastavíš ako súkromný.',
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
