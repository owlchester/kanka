<?php

return [
    'create'        => [
        'title' => 'Yeni Zar',
    ],
    'destroy'       => [
        'dice_roll' => 'Zar kaldırıldı',
    ],
    'edit'          => [],
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
        'actions'   => [
            'dice'      => 'Zarlar',
            'results'   => 'Sonuçlar',
        ],
        'title'     => ':Zarlar',
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
        'tabs'  => [
            'results'   => 'Sonuçlar',
        ],
    ],
];
