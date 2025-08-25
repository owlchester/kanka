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
        'is_enabled'    => 'Aktywny',
    ],
    'hints'                 => [
        'automatic'                 => 'Cechy przypisane automatycznie według szablonu :link.',
        'automatic_apply'           => '{1} Zastosowano automatycznie :count cechę z :link | [2,4] Zastosowano automatycznie :count cechy z :link | [5,] Zastosowano automatycznie :count cech z :link',
        'entity_type'               => 'Po ustawieniu, ten szablon cech będzie automatycznie przypisywany do nowych elementów wybranego typu.',
        'is_disabled'               => 'Ten szablon nie jest aktywny',
        'is_enabled'                => 'Aktywuj szablon by używać go w kampanii',
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
