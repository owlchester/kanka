<?php

return [
    'privacy'   => [
        'text'      => 'Ten element jest tajny. Można ustawiać dla niego indywidualne uprawnienia, ale póki nie zostanie ujawniony, będą ignorowane, a element pozostanie widoczny tylko dla administratorów.',
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
        'current'   => 'Obecnie',
        'label'     => 'Tajność elementu',
        'private'   => [
            'description'   => 'Widoczny tylko dla posiadaczy roli :admin.',
            'title'         => 'Tajny',
        ],
        'public'    => [
            'description'   => 'Widoczny dla poniższych ról i uczestników',
            'helper'        => 'Kaźda osoba z dostępem do świata widzi ten element zgodnie ze swoją rolą.',
            'title'         => 'Jawny',
        ],
    ],
];
