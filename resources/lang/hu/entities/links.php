<?php

return [
    'actions'       => [
        'add'   => 'Link hozzáadása',
    ],
    'create'        => [
        'success'   => ':name linket hozzáadtuk ehhez: :entity',
        'title'     => 'Link hozzáadása ehhez: :name',
    ],
    'destroy'       => [
        'success'   => ':name linket eltávolítottuk.',
    ],
    'fields'        => [
        'icon'      => 'Ikon',
        'name'      => 'Név',
        'position'  => 'Pozíció',
        'url'       => 'URL',
    ],
    'helpers'       => [
        'icon'  => 'Egyénire szabhatod az ikont a linkhez. Használd bármelyik ingyenes ikont a :fontawesome oldalról, vagy hagyd üresen ezt a mezőt az alapértelmezett ikon használatához.',
    ],
    'placeholders'  => [
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'          => [
        'helper'    => 'A megerősített kampányok linkeket adhatnak az entitásokhoz, amelyek külső oldalakra mutatnak.',
        'title'     => ':name linkjei',
    ],
    'unboosted'     => [],
    'update'        => [
        'success'   => ':name linket frissítettük.',
        'title'     => ':name link frissítése',
    ],
];
