<?php

return [
    'sync'  => [
        'actions'   => [
            'sync'  => 'Sinkroniziraj',
        ],
        'errors'    => [
            'invalid_uuid'  => 'Nevažeći ID LFGM kampanje. Pokušaj ponovno.',
        ],
        'helper'    => 'Odaberi kampanju za sinkronizaciju svojih nadolazećih događaja iz :lfgm. Ovo će dodati Bilješku s nadolazećim događajima u tu kampanju i pribiti je na nadzornu ploču kampanje.',
        'successes' => [
            'sync'  => 'LFGM kalendar sinkroniziran.',
        ],
        'title'     => 'Sinkronizacija LookingForGM.com kampanje',
    ],
];
