<?php

return [
    'create'        => [
        'title' => 'Nowe zadanie',
    ],
    'destroy'       => [],
    'edit'          => [],
    'elements'      => [
        'create'        => [
            'success'   => 'Do zadania dodano część :name',
            'title'     => 'Nowa część zadania :name',
        ],
        'destroy'       => [
            'success'   => 'Usunięto część zadania :entity.',
        ],
        'edit'          => [
            'success'   => 'Zmieniono część zadania :entity.',
            'title'     => 'Zmień część zadania :name',
        ],
        'fields'        => [
            'copy_entity_entry' => 'Użyj opisu elementu',
            'entity_or_name'    => 'Wybierz inny element kampanii albo nadaj nazwę tej części.',
        ],
        'helpers'       => [
            'copy_entity_entry' => 'Wyświetla opis powiązanego elementu zamiast opisu części zadania.',
        ],
        'placeholders'  => [
            'name'  => 'Nazwa części zadania',
        ],
    ],
    'fields'        => [
        'copy_elements' => 'Kopiuj części zadania',
        'date'          => 'Data',
        'element_role'  => 'Rola',
        'instigator'    => 'Zleceniodawna',
        'is_completed'  => 'Ukończono',
        'location'      => 'Miejsce rozpoczęcia',
        'role'          => 'Rola',
        'status'        => 'Status',
    ],
    'helpers'       => [
        'is_completed'  => 'Zadanie można uznać za ukończone.',
        'status'        => 'Obecny status zadania.',
    ],
    'hints'         => [
        'is_abandoned'  => 'Zadanie zostało porzucone.',
        'is_completed'  => 'Zadanie ukończono.',
        'is_ongoing'    => 'Zadanie jest właśnie realizowane.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Twórz zadania, by dokumentować cele drużyny, przebieg zdarzeń oraz motywacje postaci.',
    ],
    'placeholders'  => [
        'date'      => 'Data zadania w prawdziwym świecie',
        'entity'    => 'Nazwa części tego zadania',
        'location'  => 'Miejsce, w którym rozpoczyna się zadanie.',
        'role'      => 'Rola elementu w tym zadaniu',
        'type'      => 'Wątek osobisty, misja poboczna, zadanie główne',
    ],
    'show'          => [
        'actions'   => [
            'add_element'   => 'Dodaj część',
        ],
        'tabs'      => [
            'elements'  => 'Części',
        ],
    ],
    'status'        => [
        'abandoned'     => 'Porzucono',
        'completed'     => 'Ukończono',
        'not_started'   => 'Nie podjęto',
        'ongoing'       => 'W toku',
    ],
];
