<?php

return [
    'attribute_templates'   => [
        'title' => ':name šablony atributů',
    ],
    'create'                => [
        'title' => 'Nová šablona atributů.',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'attribute_template'    => 'Nadřazená šablona atributů',
        'attributes'            => 'Atributy',
    ],
    'hints'                 => [
        'automatic'                 => 'Atributy byly automaticky aplikované ze šablony atributů :link.',
        'entity_type'               => 'Vybraný objekt automaticky získá tuto šablonu atributů.',
        'parent_attribute_template' => 'Tato šablona atributů může být podřazena jiné šabloně atributů. Přiřazení této šablony atributů, zároveň aplikuje i všechny nadřazené šablony.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'attribute_template'    => 'Vyber jednu ze šablon atributů',
        'name'                  => 'Název šablony atributů',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => 'Šablony atributů',
            'attributes'            => 'Atributy',
        ],
    ],
];
