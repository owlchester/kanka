<?php

return [
    'create'        => [
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
        'header'        => ':note Notları',
        'title'         => 'Notlar',
    ],
    'placeholders'  => [
        'name'  => 'Notun adı',
        'note'  => 'Bir ana not seçin',
        'type'  => 'Din, Irk, Politika sistemi',
    ],
    'show'          => [
        'title'         => ':name Notu',
    ],
];
