<?php

return [
    'attribute_templates'   => [],
    'bulk'                  => [
        'entity_type'   => [
            'unset' => 'Nenastavené',
        ],
    ],
    'create'                => [
        'title' => 'Nová šablóna atribútov',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'auto_apply'    => 'Autom. prevziať',
        'is_enabled'    => 'Aktívne',
    ],
    'hints'                 => [
        'automatic'                 => 'Atribúty boli automaticky aplikované zo šablóny atribútov :link.',
        'automatic_apply'           => '{1} Nasledujúci :count atribút bol automaticky prevzatý z :link | [2,4] Nasledujúce :count atribúty boli automaticky prevzaté z :link. | [5,*] Nasledujúcich :count atribútov bolo automaticky prevzatých z :link.',
        'entity_type'               => 'Po aktivovaní bude v novom objekte tohto typu automaticky aplikovaná táto šablóna atribútov.',
        'is_disabled'               => 'Táto šablóna je neaktívna.',
        'is_enabled'                => 'Aktivuj túto šablónu na použitie v kampani.',
        'parent_attribute_template' => 'Táto šablóna atribútov môže byť podradená inej šablóne atribútov. Ak bude aplikovaná táto šablóna atribútov, aplikujú sa zároveň s ňou aj všetky jej nadradené šablóny atribútov.',
    ],
    'index'                 => [],
    'lists'                 => [
        'empty' => 'Vytvor šablónu na používanie bežných vlastností vo viacerých objektoch.',
    ],
    'placeholders'          => [
        'name'  => 'Názov šablóny atribútov',
    ],
    'show'                  => [],
];
