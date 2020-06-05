<?php

return [
    'sync'  => [
        'actions'   => [
            'sync'  => 'Szinkronizálás',
        ],
        'errors'    => [
            'invalid_uuid'  => 'Érvénytelen LFGM kampány azonosító. Kérlek próbáld újra.',
        ],
        'helper'    => 'Válassz ki ewgy kampányt, hogy összeszinkronizáld a jövőbeli :lfgm eseményeiddel. Ez létrehoz majd egy Jegyzet-et a kampányodhoz tartozó jövőbeli eseményeiddel, és ki is tűzi a kampány Főoldalára.',
        'successes' => [
            'sync'  => 'LFGM naptár szinkronizációja sikeres.',
        ],
        'title'     => 'LookingForFM.com Kampány Szinkronizáló',
    ],
];
