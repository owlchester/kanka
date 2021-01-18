<?php

return [
    'attribute_templates'   => [
        'title' => ':name šablony schopností',
    ],
    'create'                => [
        'description'   => 'Vytvořit novou šablonu schopbostí',
        'success'       => 'Šablona schopbostí :name vytvořená.',
        'title'         => 'Nová šablona schopností.',
    ],
    'destroy'               => [
        'success'   => 'Šablona schopnosti :name odstraněna.',
    ],
    'edit'                  => [
        'description'   => 'Upravit šablonu schopnosti',
        'success'       => 'Šablona schopnosti :name upravena.',
        'title'         => 'Upravit šablonu schopnosti :name',
    ],
    'fields'                => [
        'attribute_template'    => 'Nadřazená šablona schopbosti',
        'attributes'            => 'Schopnosti',
        'name'                  => 'Jméno',
    ],
    'hints'                 => [
        'automatic'                 => 'Schoposti byli automaticky aplikované ze šablony schopnosti :link.',
        'entity_type'               => 'Po aktivování bude v novém objektu tohoto typu automaticky aplikována tato šablona schopnosti.',
        'parent_attribute_template' => 'Tato šablona schopnosti může být podřazená jiné šabloně schopbosti. Pokud bude aplikovaná tato šablona schopnosti, aplikují se zároveň s ní i všechny nadřazené šablony schopností.',
    ],
    'index'                 => [
        'add'           => 'Nová šablona schopbosti',
        'description'   => 'Spravovat šablony schopbosti :name',
        'header'        => 'Šablony schopnosti :name',
        'title'         => 'Šablony schopnosti',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Vyber jednu ze šablon schopností',
        'name'                  => 'Jméno šablony schopnosti',
    ],
    'show'                  => [
        'description'   => 'Detailní náhled šablony schopbosti',
        'tabs'          => [
            'attribute_templates'   => 'Šablony schopností',
            'attributes'            => 'Schopnosti',
        ],
    ],
];
