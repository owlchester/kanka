<?php

return [
    'abilities'     => [
        'title' => ':name yeteneğinin alt yetenekleri',
    ],
    'create'        => [
        'title' => 'Yeni Yetenek',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'abilities' => 'Yetenekler',
        'ability'   => 'Ana Yetenek',
        'charges'   => 'Yük Sayısı',
    ],
    'helpers'       => [],
    'index'         => [],
    'placeholders'  => [
        'charges'   => 'Yük miktarı. {Level}*{CHA} aracılığı ile özelliklere gönderme yapabilirsiniz.',
        'name'      => 'Alevtopu, Uyanık, Kurnaz Saldırı',
        'type'      => 'Büyü, Hüner, Saldırı',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Yetenekler',
        ],
    ],
];
