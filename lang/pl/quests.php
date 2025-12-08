<?php

return [
    'create'        => [
        'title' => 'Nowe zadanie',
    ],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'    => [
            'success'   => 'Nowy element zadania :name',
            'title'     => 'Nowy element zadania :name',
        ],
        'destroy'   => [
            'success'   => 'Usunięto element zadania :entity.',
        ],
        'edit'      => [
            'success'   => 'Zmieniono element zadania :entity.',
            'title'     => 'Zmień element zadania :name',
        ],
        'fields'    => [
            'description'       => 'Szczegóły',
            'entity_or_name'    => 'Wybierz inny element kampanii albo nadaj nazwę temu elementowi.',
            'name'              => 'Nazwa',
        ],
    ],
    'fields'        => [
        'copy_elements' => 'Kopiuj elementy związane z zadaniem',
        'date'          => 'Data',
        'element_role'  => 'Rola',
        'instigator'    => 'Zleceniodawna',
        'is_completed'  => 'Ukończona',
        'location'      => 'Miejsce rozpoczęcia',
        'role'          => 'Rola',
    ],
    'helpers'       => [
        'is_completed'  => 'Wybierz, jeżeli zadanie można uznać za ukończone.',
    ],
    'hints'         => [],
    'index'         => [],
    'lists'         => [
        'empty' => 'Twórz zadania, by dokumentować cele drużyny, przebieg zdarzeń oraz motywacje postaci.',
    ],
    'placeholders'  => [
        'date'      => 'Data zadania w prawdziwym świecie',
        'entity'    => 'Nazwa elementu z tego zadania',
        'location'  => 'Miejsce, w którym rozpoczyna się zadanie.',
        'role'      => 'Rola elementu w tym zadaniu',
        'type'      => 'Wątek osobisty, misja poboczna, zadanie główne',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Dodaj element',
        ],
        'tabs'      => [
            'elements'  => 'Elementy',
        ],
    ],
];
