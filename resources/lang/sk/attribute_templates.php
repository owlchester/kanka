<?php

return [
    'attribute_templates'   => [
        'title' => ':name Šablóny atribútov',
    ],
    'create'                => [
        'description'   => 'Vytvoriť novú šablónu atribútov',
        'success'       => 'Šablóna atribútov :name vytvorená.',
        'title'         => 'Nová šablóna atribútov',
    ],
    'destroy'               => [
        'success'   => 'Šablóna atribútov :name odstránená.',
    ],
    'edit'                  => [
        'description'   => 'Upraviť šablónu atribútov',
        'success'       => 'Šablóna atribútov :name upravená.',
        'title'         => 'Upraviť šablónu atribútov :name',
    ],
    'fields'                => [
        'attribute_template'    => 'Nadradená šablóna atribútov',
        'attributes'            => 'Atribúty',
        'name'                  => 'Názov',
    ],
    'hints'                 => [
        'automatic'                 => 'Atribúty boli automaticky aplikované zo šablóny atribútov :link.',
        'entity_type'               => 'Po aktivovaní bude v novom objekte tohto typu automaticky aplikovaná táto šablóna atribútov.',
        'parent_attribute_template' => 'Táto šablóna atribútov môže byť podradená inej šablóne atribútov. Ak bude aplikovaná táto šablóna atribútov, aplikujú sa zároveň s ňou aj všetky jej nadradené šablóny atribútov.',
    ],
    'index'                 => [
        'add'           => 'Nová šablóna atribútov',
        'description'   => 'Spravovať šablóny atribútov :name',
        'header'        => 'Šablóny atribútov :name',
        'title'         => 'Šablóny atribútov',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Vyber jednu zo šablón atribútov',
        'name'                  => 'Názov šablóny atribútov',
    ],
    'show'                  => [
        'description'   => 'Detailný náhľad šablóny atribútov',
        'tabs'          => [
            'attribute_templates'   => 'Šablóny atribútov',
            'attributes'            => 'Atribúty',
        ],
        'title'         => 'Šablóna atribútov :name',
    ],
];
