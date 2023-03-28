<?php

return [
    'actions'   => [
        'show-old'  => 'Zmeny',
    ],
    'cta'       => 'Zobraziť report všetkých nedávnych zmien v kampani.',
    'empty'     => 'Bez hodnoty',
    'filters'   => [
        'all-actions'   => 'Všetky akcie',
        'all-users'     => 'Všetci členovia',
        'no-results'    => 'Žiadne výsledky na zobrazenie. Vyskúšaj iné filtre alebo sa sem vráť, keď niečo v kampani zmeníš.',
    ],
    'helpers'   => [
        'base'      => 'Obrazovka ponúka prehľad nedávnych zmien v objektoch kampane až do :amount mesiacov, pričom najaktuálnejšie sa zobrazujú ako prvé.',
        'changes'   => 'Nasledujúce polia obsahovali predtým tieto hodnoty.',
    ],
    'log'       => [
        'create'        => ':user vytvorili :entity',
        'create_post'   => ':user vytvorili poznámku ":post" v :entity',
        'delete'        => ':user zmazali :entity',
        'delete_post'   => ':user zmazali poznámku v :entity',
        'reorder_post'  => ':user zmenili poradie poznámok v :entity',
        'restore'       => ':user obnovili :entity',
        'update'        => ':user aktualizovali :entity',
        'update_post'   => ':user aktualizovali poznámku ":post" v :entity',
    ],
    'title'     => 'História',
    'unknown'   => [
        'entity'    => 'neznámy objekt',
    ],
];
