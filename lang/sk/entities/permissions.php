<?php

return [
    'quick' => [
        'empty-permissions' => 'Žiadna rola alebo užívateľ mimo adminov kampane nemá prístup k tomuto objektu.',
        'field'             => 'Rýchla úprava',
        'options'           => [
            'private'   => 'Súkromné pre všetkých okrem adminov',
            'visible'   => 'Viditeľné pre nasledujúce',
        ],
        'private'           => 'Iba členovia role admin v kampani môžu aktuálne vidieť tento objekt.',
        'public'            => 'Tento objekt je aktuálne viditeľný pre všetkých užívateľov a role s prístupom k nemu.',
        'success'           => [
            'private'   => ':entity je teraz skryté.',
            'public'    => ':entity je teraz viditeľné.',
        ],
        'title'             => 'Oprávnenia',
        'viewable-by'       => 'Viditeľné pre',
    ],
];
