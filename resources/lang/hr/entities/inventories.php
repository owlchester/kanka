<?php

return [
    'actions'       => [
        'add'   => 'Dodaj predmet',
    ],
    'create'        => [
        'success'   => 'Predmet :item dodan :entity.',
        'title'     => 'Dodaj predmet :name',
    ],
    'destroy'       => [
        'success'   => 'Predmet :item uklonjen :entity.',
    ],
    'fields'        => [
        'amount'        => 'Količina',
        'description'   => 'Opis',
        'position'      => 'Pozicija',
    ],
    'placeholders'  => [
        'amount'        => 'Bilo koja količina',
        'description'   => 'Rabljen, oštećen, podešen',
        'position'      => 'Opremljeno, ruksak, spremište, banka',
    ],
    'show'          => [
        'helper'    => 'Entiteti mogu imati predmete priložene sebi kako bi kreirali inventar.',
        'title'     => 'Inventar entiteta :name',
    ],
    'update'        => [
        'success'   => 'Predmet :item ažuriran za :entity',
        'title'     => 'Ažuriraj predmet na :name',
    ],
];
