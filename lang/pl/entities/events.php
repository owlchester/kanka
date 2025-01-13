<?php

return [
    'fields'    => [
        'type'  => 'Rodzaj wydarzenia',
    ],
    'helpers'   => [
        'characters'    => 'Ustawienie rodzaju jako daty narodzin albo śmieci tej postaci automatycznie wyliczy jej wiek. :more.',
        'founding'      => 'Ustawienie typu :type automatycznie przeliczy wiek elementu od chwili powstania.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Dodaj datę',
        ],
        'title'     => 'Ważne daty :name',
    ],
    'types'     => [
        'birth'     => 'Narodziny',
        'birthday'  => 'Urodziny',
        'death'     => 'Śmierć',
        'founded'   => 'Powstanie',
        'primary'   => 'Główna',
    ],
    'years-ago' => '{1} :count rok temu|[2,3,4] :count lata temu|[5,*] :count lat temu',
];
