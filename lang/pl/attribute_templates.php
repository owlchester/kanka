<?php

return [
    'attribute_templates'   => [],
    'bulk'                  => [
        'entity_type'   => [
            'unset' => 'Odłącz',
        ],
    ],
    'create'                => [
        'title' => 'Nowy szablon cech',
    ],
    'destroy'               => [],
    'edit'                  => [],
    'fields'                => [
        'auto_apply'    => 'Stosuj automatycznie',
        'is_enabled'    => 'Aktywny',
    ],
    'hints'                 => [
        'automatic'                 => 'Zastosowano automatycznie :count cech zgodnie z szablonem :link.',
        'automatic_apply'           => '{1} Zastosowano automatycznie :count cechę z :link | [2,4] Zastosowano automatycznie :count cechy z :link | [5,] Zastosowano automatycznie :count cech z :link',
        'entity_type'               => 'Automatycznie stosuje ten szablon cech do nowych elementów wybranej kategorii.',
        'is_disabled'               => 'Szablon nieaktywny',
        'is_enabled'                => 'Aktywuj szablon by używać go w kampanii',
        'parent_attribute_template' => 'Ten szablon może pochodzić od innego szablonu cech. Kiedy przypisujesz szablon do jakieś elementu, wszystkie jego szablony źródłowe zostają również przypisane.',
    ],
    'index'                 => [],
    'lists'                 => [
        'empty' => 'Stwórz szablony, pozwalące nadać ten sam zestaw cech wielu elementom.',
    ],
    'placeholders'          => [
        'name'  => 'Nazwa szablonu cech',
    ],
    'show'                  => [],
];
