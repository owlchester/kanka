<?php

return [
    'attribute_templates'   => [],
    'create'                => [
        'title' => 'Nová šablóna atribútov',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'auto_apply'    => 'Autom. prevziať',
    ],
    'hints'                 => [
        'automatic'                 => 'Atribúty boli automaticky aplikované zo šablóny atribútov :link.',
        'automatic_apply'           => '{1} Nasledujúci :count atribút bol automaticky prevzatý z :link | [2,4] Nasledujúce :count atribúty boli automaticky prevzaté z :link. | [5,*] Nasledujúcich :count atribútov bolo automaticky prevzatých z :link.',
        'entity_type'               => 'Po aktivovaní bude v novom objekte tohto typu automaticky aplikovaná táto šablóna atribútov.',
        'parent_attribute_template' => 'Táto šablóna atribútov môže byť podradená inej šablóne atribútov. Ak bude aplikovaná táto šablóna atribútov, aplikujú sa zároveň s ňou aj všetky jej nadradené šablóny atribútov.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'name'  => 'Názov šablóny atribútov',
    ],
    'show'                  => [],
];
