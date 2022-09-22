<?php

return [
    'create'        => [
        'title' => 'Yeni not',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'description'   => 'Açıklama',
        'image'         => 'Görsel',
        'is_pinned'     => 'Sabitli',
        'name'          => 'Ad',
        'note'          => 'Ana Not',
        'notes'         => 'Alt Notlar',
        'type'          => 'Tür',
    ],
    'helpers'       => [],
    'hints'         => [
        'is_pinned' => '3 taneye kadar not kontrol panelinde sergilenmek üzere sabitlenebilir.',
    ],
    'index'         => [
        'title' => 'Notlar',
    ],
    'placeholders'  => [
        'name'  => 'Notun adı',
        'note'  => 'Bir ana not seçin',
        'type'  => 'Din, Irk, Politika sistemi',
    ],
    'show'          => [],
];
