<?php

return [
    'characters'    => [
        'description'   => 'Likovi koji pripadaju toj rasi.',
        'helpers'       => [
            'all_characters'    => 'Prikaz svih likova povezanih s ovom rasom i njenim podrasama.',
            'characters'        => 'Prikazuju se svi likovi izravno povezani s ovom rasom.',
        ],
        'title'         => 'Likovi rase :name',
    ],
    'create'        => [
        'description'   => 'Kreiraj novu rasu',
        'success'       => 'Kreirana rasa ":name".',
        'title'         => 'Nova rasa',
    ],
    'destroy'       => [
        'success'   => 'Uklonjena rasa ":name".',
    ],
    'edit'          => [
        'success'   => 'Ažurirana rasa ":name".',
        'title'     => 'Uredi rasu :name',
    ],
    'fields'        => [
        'characters'    => 'Likovi',
        'name'          => 'Naziv',
        'race'          => 'Rasa roditelj',
        'races'         => 'Podrase',
        'type'          => 'Tip',
    ],
    'helpers'       => [
        'nested_parent' => 'Prikaz rasa od :parent.',
        'nested_without'=> 'Prikazuju se sve rase koje nemaju rasu roditelj. Klikni redak da bi vidio/la rase djecu.',
    ],
    'index'         => [
        'add'           => 'Nova rasa',
        'description'   => 'Upravljanje rasama u :name',
        'header'        => 'Rase od :name',
        'title'         => 'Rase',
    ],
    'placeholders'  => [
        'name'  => 'Naziv rase',
        'type'  => 'Čovjek, Vila, Borg',
    ],
    'races'         => [
        'description'   => 'Rase koje pripadaju rasi.',
        'title'         => 'Podrase rase :name',
    ],
    'show'          => [
        'description'   => 'Detaljan pregled rase',
        'tabs'          => [
            'characters'    => 'Likovi',
            'menu'          => 'Izbornik',
            'races'         => 'Podrase',
        ],
        'title'         => 'Rasa :name',
    ],
];
