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
        'warning'   => [
            'editing'   => [
                'description'   => 'Najwyraźniej ktoś inny edytuje właśnie to zadanie! Chcesz się wycofać czy zignorować to ostrzeżenie, ryzykując utratę danych? Członkowie obecnie edytujący zadanie:',
            ],
        ],
    ],
    'fields'        => [
        'character'     => 'Donator',
        'copy_elements' => 'Kopiuj elementy związane z zadaniem',
        'date'          => 'Data',
        'element_role'  => 'Rola',
        'is_completed'  => 'Ukończona',
        'role'          => 'Rola',
    ],
    'helpers'       => [
        'is_completed'      => 'Wybierz, jeżeli zadanie można uznać za ukończone.',
        'nested_without'    => 'Wyświetlono wszystkie zadnia nieposiadające źródła. Kliknij na rząd, by wyświetlić zadania pochodne.',
    ],
    'hints'         => [
        'quests'    => 'Przy użyciu pola Zadania źródłowego można stworzyć sieć zazębiających się zadań.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'      => 'Data zadania w prawdziwym świecie',
        'entity'    => 'Nazwa elementu z tego zadania',
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
