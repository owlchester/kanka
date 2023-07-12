<?php

return [
    'attribute_templates'   => [],
    'create'                => [
        'title' => 'Nowy szablon cech',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'attributes'    => 'Cechy',
        'auto_apply'    => 'Stosuj automatycznie',
    ],
    'hints'                 => [
        'automatic'                 => 'Cechy przypisane automatycznie według szablonu :link.',
        'entity_type'               => 'Po ustawieniu, ten szablon cech będzie automatycznie przypisywany do nowych elementów wybranego typu.',
        'parent_attribute_template' => 'Ten szablon może pochodzić od innego szablonu cech. Kiedy przypisujesz szablon do jakieś elementu, wszystkie jego szablony źródłowe zostają również przypisane.',
    ],
    'index'                 => [],
    'placeholders'          => [
        'name'  => 'Nazwa szablonu cech',
    ],
    'show'                  => [
        'tabs'  => [
            'attributes'    => 'Cechy',
        ],
    ],
];
