<?php

return [
    'abilities'     => [
        'title' => 'Sposobnosti djeca od :name',
    ],
    'children'      => [
        'actions'       => [
            'add'   => 'Dodaj sposobnost entitetu',
        ],
        'create'        => [
            'success'   => 'Entitetu je dodana sposobnost :name.',
            'title'     => 'Dodaj entitet u :name',
        ],
        'description'   => 'Entiteti koji imaju sposobnost',
        'title'         => 'Sposobnost :name entiteta',
    ],
    'create'        => [
        'success'   => 'Kreirana sposobnost ":name".',
        'title'     => 'Nova sposobnost',
    ],
    'destroy'       => [
        'success'   => 'Uklonjena sposobnost ":name".',
    ],
    'edit'          => [
        'success'   => 'Ažurirana sposobnost ":name".',
        'title'     => 'Uredi sposobnost :name',
    ],
    'entities'      => [
        'title' => 'Entiteti sa sposobnošću :name',
    ],
    'fields'        => [
        'abilities' => 'Sposobnosti',
        'ability'   => 'Sposobnost roditelj',
        'charges'   => 'Punjenja',
        'name'      => 'Naziv',
        'type'      => 'Tip',
    ],
    'helpers'       => [
        'descendants'   => 'Popis sadrži sve sposobnosti koje su djeca trenutne sposobnosti, a ne samo one koje su direktno ispod nje.',
        'nested_parent' => 'Prikaz sposobnosti :parent.',
        'nested_without'=> 'Prikaz svih sposobnosti koje nemaju roditeljske sposobnosti. Klikni red da bi vidio/vidjela sposobnosti djecu.',
    ],
    'index'         => [
        'add'           => 'Nova sposobnost',
        'description'   => 'Kreiraj moći, čarolije, podvige i drugo za svoje entitete.',
        'header'        => 'Sposobnosti :name',
        'title'         => 'Sposobnosti',
    ],
    'placeholders'  => [
        'charges'   => 'Broj punjenja. Referenciraj se na atribute s {Level}*{CHA}',
        'name'      => 'Vatrena kugla, Upozorenje, Lukavi udarac',
        'type'      => 'Čarolija, podvig, napad',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Sposobnosti',
            'entities'  => 'Entiteti',
        ],
        'title' => 'Sposobnost :name',
    ],
];
