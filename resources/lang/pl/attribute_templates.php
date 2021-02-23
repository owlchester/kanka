<?php

return [
    'attribute_templates'   => [
        'title' => 'Szablony cech :name',
    ],
    'create'                => [
        'description'   => 'Dodaj szablon cech',
        'success'       => 'Dodano szablon cech \':name\'.',
        'title'         => 'Nowy szablon cech',
    ],
    'destroy'               => [
        'success'   => 'Usunięto szablon cech \':name\'.',
    ],
    'edit'                  => [
        'description'   => 'Edytuj szablon cech',
        'success'       => 'Zmieniono szablon cech \':name\'.',
        'title'         => 'Edycja szablonu cech :name',
    ],
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
        'add'           => 'Nowy szablon cech',
        'description'   => 'Zarządzaj szablonami cech elementu :name',
        'header'        => 'Szablony cech elementu :name',
        'title'         => 'Szablony cech',
    ],
    'placeholders'          => [
        'attribute_template'    => 'Wybierz szablon cech',
        'name'                  => 'Nazwa szablonu cech',
    ],
    'show'                  => [
        'description'   => 'Widok szczegółowy szablonu cech',
        'tabs'          => [
            'attribute_templates'   => 'Szablony cech',
            'attributes'            => 'Cechy',
        ],
        'title'         => 'Szablon cech :name',
    ],
];
