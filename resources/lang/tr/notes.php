<?php

return [
    'create'        => [
        'description'   => 'Yeni bir not oluştur',
        'success'       => '\':name\' notu oluşturuldu.',
        'title'         => 'Yeni not',
    ],
    'destroy'       => [
        'success'   => '\':name\' notu kaldırıldı.',
    ],
    'edit'          => [
        'success'   => '\':name\' notu güncellendi.',
        'title'     => ':name Notunu Düzenle',
    ],
    'fields'        => [
        'description'   => 'Açıklama',
        'image'         => 'Görsel',
        'is_pinned'     => 'Sabitli',
        'name'          => 'Ad',
        'note'          => 'Ana Not',
        'notes'         => 'Alt Notlar',
        'type'          => 'Tür',
    ],
    'helpers'       => [
        'nested'    => 'Önce ana notu olmayan notları gösteriyor. Bir notun alt notlarını keşfetmek için nota tıklayın.',
    ],
    'hints'         => [
        'is_pinned' => '3 taneye kadar not kontrol panelinde sergilenmek üzere sabitlenebilir.',
    ],
    'index'         => [
        'add'           => 'Yeni Not',
        'description'   => ':name notlarını yönet.',
        'header'        => ':note Notları',
        'title'         => 'Notlar',
    ],
    'placeholders'  => [
        'name'  => 'Notun adı',
        'note'  => 'Bir ana not seçin',
        'type'  => 'Din, Irk, Politika sistemi',
    ],
    'show'          => [
        'description'   => 'Nota detaylı bir bakış',
        'tabs'          => [
            'description'   => 'Açıklama',
        ],
        'title'         => ':name Notu',
    ],
];
