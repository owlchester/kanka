<?php

return [
    'create'        => [
        'title' => 'Nowa organizacja',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_defunct'    => 'Nie funkcjonuje',
        'members'       => 'Członkowie',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_defunct'    => 'Ta organizacja obecnie nie działa',
    ],
    'index'         => [],
    'members'       => [
        'actions'       => [
            'add'   => 'Dodaj członka',
        ],
        'destroy'       => [
            'success'   => 'Usunięto członka organizacji.',
        ],
        'edit'          => [
            'success'   => 'Zmieniono członka organizacji.',
            'title'     => 'Edycja członka :name',
        ],
        'fields'        => [
            'parent'    => 'Zwierzchnik',
            'pinned'    => 'Przypnij',
            'role'      => 'Rola',
            'status'    => 'Rodzaj członkostwa',
        ],
        'helpers'       => [
            'all_members'   => 'Wszystkie postaci należące do tej organizacji i organizacji pochodnych.',
            'members'       => 'Wszystkie postaci należące do tej organizacji.',
            'pinned'        => 'Wybierz czy członkostwo ma być wyświetlane w sekcji "przypięte" wskazanych elementów.',
        ],
        'pinned'        => [
            'both'  => 'Do obu',
            'none'  => 'Do żadnego',
        ],
        'placeholders'  => [
            'parent'    => 'Zwierzchnik tego członka',
            'role'      => 'Przywódca, członek, Wielki Septon, mistrz szpiegów',
        ],
        'status'        => [
            'active'    => 'Aktywna działalność',
            'inactive'  => 'Była działalność',
            'unknown'   => 'Nieznany',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [
        'type'  => 'Kult, gang, podziemie niepodległościowe, fandom',
    ],
    'show'          => [],
];
