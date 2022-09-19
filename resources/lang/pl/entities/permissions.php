<?php

return [
    'quick' => [
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
