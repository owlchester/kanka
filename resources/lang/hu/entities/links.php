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
        'goto'      => 'Menj ide: :name',
        'icon'      => 'Egyénire szabhatod az ikont a linkhez. Használd bármelyik ingyenes ikont a :fontawesome oldalról, vagy hagyd üresen ezt a mezőt az alapértelmezett ikon használatához.',
        'leaving'   => 'Épp elhagyod a Kankát, és egy másik oldalra mész. Az oldal, ahová mész, egy felhasználóé, mi nem vizsgáltuk meg.',
        'url'       => 'Az url, ahová mész: :url',
    ],
    'placeholders'  => [
        'icon'  => 'fab fa-d-and-d-beyond',
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'          => [
        'helper'    => 'A megerősített kampányok linkeket adhatnak az entitásokhoz, amelyek külső oldalakra mutatnak.',
        'title'     => ':name linkjei',
    ],
    'unboosted'     => [
        'text'  => 'Külső erőforrásra mutató link hozzáadása, ami közvetlenül az entitáson jelenik meg: ez a :boosted-campaigns számára van fenntartva.',
        'title' => 'Megerősített kampány lehetőség',
    ],
    'update'        => [
        'success'   => ':name linket frissítettük.',
        'title'     => ':name link frissítése',
    ],
];
