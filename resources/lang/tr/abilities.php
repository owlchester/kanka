<?php

return [
    'abilities'     => [
        'title' => ':name yeteneğinin alt yetenekleri',
    ],
    'create'        => [
        'success'   => '\':name\' yeteneği yaratıldı.',
        'title'     => 'Yeni Yetenek',
    ],
    'destroy'       => [
        'success'   => '\':name\' yeteneği kaldırıldı.',
    ],
    'edit'          => [
        'success'   => '\':name\' yeteneği güncellendi.',
        'title'     => ':name Yeteneğini Düzenle',
    ],
    'fields'        => [
        'abilities' => 'Yetenekler',
        'ability'   => 'Ana Yetenek',
        'charges'   => 'Yük Sayısı',
        'name'      => 'Ad',
        'type'      => 'Tür',
    ],
    'helpers'       => [
        'descendants'   => 'Bu liste bu yetenekten gelen tüm yetenekleri içerir, yalnızca doğrudan altında olanları değil.',
    ],
    'index'         => [
        'add'           => 'Yeni Yetenek',
        'header'        => ':name Yetenekleri',
        'title'         => 'Yetenekler',
    ],
    'placeholders'  => [
        'charges'   => 'Yük miktarı. {Level}*{CHA} aracılığı ile özelliklere gönderme yapabilirsiniz.',
        'name'      => 'Alevtopu, Uyanık, Kurnaz Saldırı',
        'type'      => 'Büyü, Hüner, Saldırı',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Yetenekler',
        ],
        'title' => ':name Yeteneği',
    ],
];
