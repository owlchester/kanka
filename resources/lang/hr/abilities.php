<?php

return [
    'abilities'     => [
        'title' => 'Sposobnosti djeca od :name',
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
    'fields'        => [
        'abilities' => 'Sposobnosti',
        'ability'   => 'Sposobnost roditelj',
        'charges'   => 'Punjenja',
        'name'      => 'Naziv',
        'type'      => 'Tip',
    ],
    'helpers'       => [
        'descendants'   => 'Popis sadrži sve sposobnosti koje su djeca trenutne sposobnosti, a ne samo one koje su direktno ispod nje.',
        'nested'        => 'U "Ugniježđenom pregledu" možeš vidjeti sposobnosti na ugniježđeni način. Sposobnosti bez sposobnosti roditelj će biti prikazane na osnovnom pregledu. Sposobnosti sa sposobnostima djecom se mogu kliknuti kako bi se prikazale te sposobnosti djeca. Možeš nastaviti klikati dok ima sposobnosti za prikazati.',
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
        ],
        'title' => 'Sposobnost :name',
    ],
];
