<?php

return [
    'actions'       => [],
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
        'is_equipped'   => 'Opremljen',
        'name'          => 'Naziv',
        'position'      => 'Pozicija',
    ],
    'placeholders'  => [
        'amount'        => 'Bilo koja količina',
        'description'   => 'Rabljen, oštećen, podešen',
        'name'          => 'Obavezno ako nije odabran nijedan predmet',
        'position'      => 'Opremljeno, ruksak, spremište, banka',
    ],
    'show'          => [
        'helper'    => 'Entiteti mogu imati predmete priložene sebi kako bi kreirali inventar.',
        'title'     => 'Inventar entiteta :name',
        'unsorted'  => 'Nesortirano',
    ],
    'update'        => [
        'success'   => 'Predmet :item ažuriran za :entity',
        'title'     => 'Ažuriraj predmet na :name',
    ],
];
