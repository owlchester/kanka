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
        'title' => 'Nova sposobnost',
    ],
    'destroy'       => [],
    'edit'          => [],
    'entities'      => [
        'title' => 'Entiteti sa sposobnošću :name',
    ],
    'fields'        => [
        'abilities' => 'Sposobnosti',
        'ability'   => 'Sposobnost roditelj',
        'charges'   => 'Punjenja',
    ],
    'helpers'       => [
        'nested_without'    => 'Prikaz svih sposobnosti koje nemaju roditeljske sposobnosti. Klikni red da bi vidio/vidjela sposobnosti djecu.',
    ],
    'index'         => [],
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
    ],
];
