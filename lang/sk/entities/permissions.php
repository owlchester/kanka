<?php

return [
    'privacy'   => [
        'text'      => 'Tento objekt je nastavený ako súkromný. Vlastné oprávnenia môžu byť ešte stále definované, ale pokiaľ je objekt súkromný, budú tieto ignorované a iba členstvo role :admin bude tento objekt vidieť.',
        'warning'   => 'Varovanie',
    ],
    'quick'     => [
        'empty-permissions' => 'Žiadna rola alebo užívateľ mimo adminov kampane nemá prístup k tomuto objektu.',
        'field'             => 'Rýchla úprava',
        'manage'            => 'Manažovať oprávnania',
        'options'           => [
            'private'   => 'Súkromné pre všetkých okrem adminov',
            'visible'   => 'Viditeľné pre nasledujúce',
        ],
        'private'           => 'Iba členovia role admin v kampani môžu aktuálne vidieť tento objekt.',
        'public'            => 'Tento objekt je aktuálne viditeľný pre všetkých užívateľov a role s prístupom k nemu.',
        'screen-reader'     => 'Otvoriť nastavenia súkromia',
        'success'           => [
            'private'   => ':entity je teraz skryté.',
            'public'    => ':entity je teraz viditeľné.',
        ],
        'title'             => 'Oprávnenia',
        'viewable-by'       => 'Viditeľné pre',
    ],
];
