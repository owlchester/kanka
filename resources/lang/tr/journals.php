<?php

return [
    'create'        => [
        'description'   => 'Yeni bir günlük yarat',
        'success'       => '\':name\' günlüğü yaratıldı.',
        'title'         => 'Yeni Günlük',
    ],
    'destroy'       => [
        'success'   => '\':name\' günlüğü kaldırıldı.',
    ],
    'edit'          => [
        'success'   => '\':name\' günlüğü güncellendi.',
        'title'     => ':name Günlüğünü Düzenle',
    ],
    'fields'        => [
        'author'    => 'Yazar',
        'date'      => 'Tarih',
        'image'     => 'Görsel',
        'name'      => 'Ad',
        'relation'  => 'İlişki',
        'type'      => 'Tür',
    ],
    'index'         => [
        'add'           => 'Yeni Günlük',
        'description'   => ':name günlüklerini yönet',
        'header'        => ':name Günlükleri',
        'title'         => 'Günlükler',
    ],
    'placeholders'  => [
        'author'    => 'Günlüğü kim yazdı',
        'date'      => 'Günlüğün gerçek dünyada tarihi',
        'name'      => 'Günlüğün adı',
        'type'      => 'Oturum, Tek Seferlik, Taslak',
    ],
    'show'          => [
        'description'   => 'Günlüğe detaylı bir bakış',
        'title'         => ':name Günlüğü',
    ],
];
