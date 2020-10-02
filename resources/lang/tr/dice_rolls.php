<?php

return [
    'create'        => [
        'description'   => 'Yeni bir zar ekle',
        'success'       => '\':name\' zarı yaratıldı.',
        'title'         => 'Yeni Zar',
    ],
    'destroy'       => [
        'dice_roll' => 'Zar kaldırıldı',
        'success'   => '\':name\' zarı kaldırıldı.',
    ],
    'edit'          => [
        'description'   => 'Bir zarı düzenle',
        'success'       => '\':name\' zarı güncellendi.',
        'title'         => ':name Zarını Düzenle',
    ],
    'fields'        => [
        'created_at'    => 'Atıldığı An',
        'name'          => 'Ad',
        'parameters'    => 'Parametreler',
        'results'       => 'Sonuçlar',
        'rolls'         => 'Atışlar',
    ],
    'hints'         => [
        'parameters'    => 'Zar seçeneklerim nelerdir?',
    ],
    'index'         => [
        'actions'       => [
            'dice'      => 'Zarlar',
            'results'   => 'Sonuçlar',
        ],
        'add'           => 'Yeni Zar',
        'description'   => ':name Zarlarını Düzenle',
        'header'        => ':name Zarları',
        'title'         => ':Zarlar',
    ],
    'placeholders'  => [
        'dice_roll' => 'Zar atışı',
        'name'      => 'Zar Atışının Adı',
        'parameters'=> '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Zar at',
        ],
        'error'     => 'Zar atışı başarısız. Parametreler okunamadı.',
        'fields'    => [
            'creator'   => 'Yaratıcı',
            'date'      => 'Tarih',
            'result'    => 'Sonuç',
        ],
        'hint'      => 'Bu zar taslağı için yapılmış tüm atışlar.',
        'success'   => 'Zar atıldı.',
    ],
    'show'          => [
        'description'   => 'Zara detaylı bir bakış',
        'tabs'          => [
            'results'   => 'Sonuçlar',
        ],
        'title'         => ':name Zarı',
    ],
];
