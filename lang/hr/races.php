<?php

return [
    'characters'    => [
        'helpers'   => [
            'all_characters'    => 'Prikaz svih likova povezanih s ovom rasom i njenim podrasama.',
            'characters'        => 'Prikazuju se svi likovi izravno povezani s ovom rasom.',
        ],
        'title'     => 'Likovi rase :name',
    ],
    'create'        => [
        'title' => 'Nova rasa',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'characters'    => 'Likovi',
        'race'          => 'Rasa roditelj',
        'races'         => 'Podrase',
    ],
    'helpers'       => [
        'nested_without'    => 'Prikazuju se sve rase koje nemaju rasu roditelj. Klikni redak da bi vidio/la rase djecu.',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Naziv rase',
        'type'  => 'Čovjek, Vila, Borg',
    ],
    'races'         => [
        'title' => 'Podrase rase :name',
    ],
    'show'          => [
        'tabs'  => [
            'characters'    => 'Likovi',
            'races'         => 'Podrase',
        ],
    ],
];
