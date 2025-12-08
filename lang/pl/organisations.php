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
    'lists'         => [
        'empty' => 'Twórz gildie, frakcje i tajne stowarzyszenia pływające na kształt świata.',
    ],
    'members'       => [
        'actions'       => [
            'add_multiple'  => 'Dodaj członków',
        ],
        'create'        => [
            'helper'            => 'Dodaje jednego lub więcej członków do :name.',
            'success_multiple'  => '{1} Dodano :count członka do :name.|[2,*] Dodano :count członków do :name.',
        ],
        'destroy'       => [
            'success'   => 'Usunięto członka organizacji.',
        ],
        'edit'          => [
            'helper'    => 'Zmienia status członkostwa elementu :name.',
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
