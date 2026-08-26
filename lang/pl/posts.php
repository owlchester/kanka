<?php

return [
    'create'        => [
        'title' => 'Nowy komentarz',
    ],
    'fields'        => [
        'description'   => 'Ogólne',
        'layout'        => 'Umiejscowienie komentarza',
        'name'          => 'Tytuł',
    ],
    'helpers'       => [
        'new'           => 'Dodaj nowy komentarz do tego elementu.',
        'visibility'    => 'Zmienia widoczność komentarza :name.',
    ],
    'move'          => [
        'copy'      => [
            'helper'    => 'Zachowuje kopię komentarza w :name',
        ],
        'helper'    => 'Przenosi lub kopiuje komentarz :name do innego elementu',
        'title'     => 'Przenoszenie komentarza',
    ],
    'permissions'   => [
        'actions'   => [
            'members'   => 'Dodaj uczestników',
            'roles'     => 'Dodaj role',
        ],
        'helpers'   => [
            'members'   => 'Zapewnia jednemu lub kilku uczestnikom specjalnie uprawnienia w tym komentarzu.',
            'roles'     => 'Zapewnia jednej lub kilku rolom specjalnie uprawnienia w tym komentarzu.',
        ],
    ],
    'placeholders'  => [
        'name'  => 'Tytuł komentarza',
    ],
    'position'      => [
        'dont_change'   => 'Nie zmienaj',
        'first'         => 'Pierwszy',
        'last'          => 'Ostatni',
    ],
    'remove'        => [
        'title' => 'Usuwanie komentarza',
    ],
    'visibility'    => [
        'helper'    => 'Zmienia widoczność komentarza :name',
        'title'     => 'Widoczność komentarza',
    ],
];
