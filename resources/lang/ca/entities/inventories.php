<?php

return [
    'actions'       => [
        'add'   => 'Afegeix un objecte',
    ],
    'create'        => [
        'success'   => 'S\'ha afegit l\'objecte :item a :name',
        'title'     => 'Afegeix un objecte a :name',
    ],
    'destroy'       => [
        'success'   => 'S\'ha tret l\'objecte :item de :entity.',
    ],
    'fields'        => [
        'amount'        => 'Quantitat',
        'description'   => 'Observacions',
        'is_equipped'   => 'Equipat',
        'name'          => 'Nom',
        'position'      => 'Lloc',
    ],
    'placeholders'  => [
        'amount'        => 'Qualsevol quantitat',
        'description'   => 'Utilitzat, estripat, trencat...',
        'name'          => 'Requerit si no hi ha cap objecte seleccionat',
        'position'      => 'Equipat, motxilla, emmagatzemat, banc...',
    ],
    'show'          => [
        'helper'    => 'Per a crear un inventari, afegiu objectes a una entitat.',
        'title'     => 'Inventari de :name',
        'unsorted'  => 'Sense classificar',
    ],
    'update'        => [
        'success'   => 'S\'ha actualitzat l\'objecte :item a :entity.',
        'title'     => 'Actualiza un objecte de :name',
    ],
];
