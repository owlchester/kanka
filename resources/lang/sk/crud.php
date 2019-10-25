<?php

return [
    'actions'           => [
        'apply'             => 'Použiť',
        'back'              => 'Naspäť',
        'copy'              => 'Kopírovať',
        'copy_to_campaign'  => 'Kopírovať do kampane',
        'explore_view'      => 'Vložené zobrazenie',
        'export'            => 'Exportovať',
        'find_out_more'     => 'Dozvedieť sa viac',
        'go_to'             => 'Prejsť na :name',
        'more'              => 'Ďalšie akcie',
        'move'              => 'Premiestniť',
        'new'               => 'Nový',
        'next'              => 'Ďalej',
        'private'           => 'Súkromný',
        'public'            => 'Verejný',
    ],
    'add'               => 'Pridať',
    'attributes'        => [
        'actions'       => [
            'add'               => 'Pridať atribúť',
            'add_block'         => 'Pridať blok',
            'add_checkbox'      => 'Pridať zaškrtávacie políčko',
            'add_text'          => 'Pridať text',
            'apply_template'    => 'Použiť šablónu atribútov',
            'manage'            => 'Spravovať',
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
        ],
        'hints'         => [
            'is_private'    => 'Všetky atribúty objektu je možné skryť pred všetkými členmi okrem tých s rolou Admin, ak ich ho nastavíš ako súkromný.',
        ],
        'index'         => [
            'success'   => 'Atribúty pre :entity upravené.',
            'title'     => 'Atribúty pre :name',
        ],
        'placeholders'  => [
            'attribute' => 'Počet dobytí, úroveň obtiažnosti výzvy, iniciatíva, obyvateľstvo',
            'block'     => 'Názov bloku',
            'checkbox'  => 'Názov zaškrtávacieho políčka',
            'section'   => 'Názov sekcie',
            'template'  => 'Vybrať šablónu',
            'value'     => 'Hodnota atribútu',
        ],
        'template'      => [
            'success'   => 'Šablóna atribútov :name použitá na :entity',
            'title'     => 'Použiť šablónu atribútov na :name',
        ],
        'types'         => [
            'attribute' => 'Atribút',
            'block'     => 'Blok',
            'checkbox'  => 'Zaškrtávacie políčko',
            'section'   => 'Sekcia',
            'text'      => 'Viacriadkový text',
        ],
        'visibility'    => [
            'entry'     => 'Atribút je zobrazený v menu objektu.',
            'private'   => 'Atribút viditeľný len pre členov s rolou Admin.',
            'public'    => 'Atribút viditeľný pre všetkých členov.',
            'tab'       => 'Atribút je zobrazený len v karte atribútov.',
        ],
    ],
    'bulk'              => [
        'errors'        => [
            'admin' => 'Iba administrátori kampane vedia zmeniť súkromný štatút objektu.',
        ],
        'permissions'   => [
            'fields'    => [
                'override'  => 'Prepísať',
            ],
            'helpers'   => [
                'override'  => 'Ak aktivované, oprávnenia vybratých objektov budú týmito prepísané. Ak deaktivované, vybrané oprávnenia budú pridané k predchádzajúcim.',
            ],
            'title'     => 'Zmeniť oprávnenia pre viaceré objekty',
        ],
        'success'       => [
            'permissions'   => 'Oprávnenia zmenené pre :count objekt.|Oprávnenia zmenené pre :count objektov.',
            'private'       => ':count objekt je teraz súkromný.|:count objektov je teraz súkromných.',
            'public'        => ':count objekt je teraz viditeľný.|:count objektov je teraz viditeľných.',
        ],
    ],
    'cancel'            => 'Zrušiť',
    'click_modal'       => [
        'close'     => 'Zavrieť',
        'confirm'   => 'Potvrdiť',
        'title'     => 'Potvrdiť akciu',
    ],
    'copy_to_campaign'  => [
        'panel' => 'Kopírovať',
        'title' => 'Kopírovať :name do inej kampane',
    ],
    'create'            => 'Vytvoriť',
    'datagrid'          => [
        'empty' => 'Zatiaľ je tu prázdno.',
    ],
    'delete_modal'      => [
        'close'         => 'Zatvoriť',
        'delete'        => 'Odstrániť',
        'description'   => 'Naozaj chceš odstrániť :tag?',
        'mirrored'      => 'Odstrániť zrkadlený vzťah.',
        'title'         => 'Potvrdiť odstránenie',
    ],
];
