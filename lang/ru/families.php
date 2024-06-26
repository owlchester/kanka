<?php

return [
    'create'        => [
        'title' => 'Новая cемья',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [],
    'fields'        => [
        'members'   => 'Члены',
    ],
    'helpers'       => [],
    'hints'         => [
        'members'   => 'Это список членов семьи. Персонажа можно добавить в семью при его редактировании через поле "Семья".',
    ],
    'index'         => [],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Это список всех персонажей-членов этой семьи и всех ее подсемей.',
            'direct_members'    => 'Во многих семьях есть те, кто чем-нибудь отличился. Это список всех персонажей-членов непосредственно этой семьи.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Название семьи',
        'type'  => 'Королевская, знатная, исчезнувшая',
    ],
    'show'          => [
        'tabs'  => [
            'members'   => 'Члены',
        ],
    ],
];
