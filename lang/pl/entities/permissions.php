<?php

return [
    'privacy'   => [
        'text'      => 'Ten element jest tajny. Wprawdzie można ustawiać dla niego indywidualne uprawnienia, ale póki nie zostanie ujawniony, będą ignorowane, a element będzie widoczny tylko dla administratorów kampanii.',
        'warning'   => 'Uwaga',
    ],
    'quick'     => [
        'empty-permissions' => 'Ten element mogą zobaczyć tylko administratorzy kampanii, i nikt inny.',
        'manage'            => 'Zarządzaj uprawnieniami',
        'screen-reader'     => 'Otwórz ustawienia prywatności',
        'success'           => [
            'private'   => 'Element :entity jest ukryty.',
            'public'    => 'Element :entity jest widoczny.',
        ],
        'title'             => 'Uprawnienia',
        'viewable-by'       => 'Widoczny dla',
    ],
    'toggle'    => [
        'label'     => 'Tajność elementu',
        'private'   => [
            'description'   => 'Widoczny tylko dla posiadaczy roli :admin.',
            'title'         => 'Tajny',
        ],
        'public'    => [
            'description'   => 'Widoczny dla poniższych ról i uczestników',
            'title'         => 'Jawny',
        ],
    ],
];
