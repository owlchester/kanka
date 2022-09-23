<?php

return [
    'actions'       => [
        'copy'  => 'Másolás',
        'move'  => 'Mozgatás',
    ],
    'errors'        => [
        'permission'        => 'Nem hozhatsz létre ilyen entitásokat ebben a célpont kampányban.',
        'permission_update' => 'Nem mozgathatod ezt az entitást.',
        'same_campaign'     => 'Ki kell választanod egy másik kampányt, ahová mozgatod az entitást.',
        'unknown_campaign'  => 'Ismeretlen kampány.',
    ],
    'fields'        => [
        'campaign'      => 'Célpont kapmány',
        'copy'          => 'Másolat készítése',
        'select_one'    => 'Kampány kiválasztása',
    ],
    'panel'         => [
        'description'           => 'Válaszd ki a kampányt, ahová mozgatni vagy másolni szeretnéd ezt az entitást.',
        'description_bulk_copy' => 'Válaszd ki a kampányt, ahová másolni szeretnéd a kiválasztott entitásokat.',
        'title'                 => 'Mozgass vagy másolj egy entitást egy másik kampányba.',
    ],
    'success'       => ':name entitást átmozgattuk.',
    'success_copy'  => ':name entitást átmásoltuk.',
    'title'         => ':name mozgatása',
];
