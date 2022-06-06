<?php

return [
    'attribute_templates'   => [
        'title' => 'Szablony cech :name',
    ],
    'create'                => [
        'title' => 'Nowy szablon cech',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'attribute_template'    => 'Źródłowy szablon cech',
        'attributes'            => 'Cechy',
        'name'                  => 'Nazwa',
    ],
    'hints'                 => [
        'automatic'                 => 'Cechy przypisane automatycznie według szablonu :link.',
        'entity_type'               => 'Po ustawieniu, ten szablon cech będzie automatycznie przypisywany do nowych elementów wybranego typu.',
        'parent_attribute_template' => 'Ten szablon może pochodzić od innego szablonu cech. Kiedy przypisujesz szablon do jakieś elementu, wszystkie jego szablony źródłowe zostają również przypisane.',
    ],
    'index'                 => [
        'title' => 'Szablony cech',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Wybierz szablon cech',
        'name'                  => 'Nazwa szablonu cech',
    ],
    'show'                  => [
        'tabs'  => [
            'attribute_templates'   => 'Szablony cech',
            'attributes'            => 'Cechy',
        ],
    ],
];
