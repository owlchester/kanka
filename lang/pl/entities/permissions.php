<?php

return [
    'privacy'   => [
        'text'      => 'Ten element jest tajny. Wprawdzie można ustawiać dla niego indywidualne uprawnienia, ale póki nie zostanie ujawniony, będą ignorowane, a element będzie widoczny tylko dla administratorów kampanii.',
        'warning'   => 'Uwaga',
    ],
    'quick'     => [
        'empty-permissions' => 'Ten element mogą zobaczyć tylko administratorzy kampanii, i nikt inny.',
        'field'             => 'Szybka edycja',
        'options'           => [
            'private'   => 'Ukryty dla wszystkich oprócz administratorów',
            'visible'   => 'Widoczny dla następujących',
        ],
        'private'           => 'Ten element widzą obecnie tylko uczestnicy posiadający rolę administratora',
        'public'            => 'Ten element widzą obecnie wszyscy uczestnicy i role, które posiadają dostęp.',
        'success'           => [
            'private'   => 'Element :entity jest ukryty.',
            'public'    => 'Element :entity jest widoczny.',
        ],
        'title'             => 'Uprawnienia',
        'viewable-by'       => 'Widoczny dla',
    ],
];
