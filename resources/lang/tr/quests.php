<?php

return [
    'create'        => [
        'success'   => '\':name\' görevi yaratıldı.',
        'title'     => 'Yeni Görev',
    ],
    'destroy'       => [
        'success'   => '\':name\' görevi kaldırıldı.',
    ],
    'edit'          => [
        'success'   => '\':name\' görevi güncellendi.',
        'title'     => ':name Görevini Düzenle',
    ],
    'fields'        => [
        'character'     => 'Azmettirici',
        'copy_elements' => 'Göreve iliştirilmiş elementleri kopyala',
        'date'          => 'Tarih',
        'description'   => 'Açıklama',
        'image'         => 'Görsel',
        'is_completed'  => 'Tamamlandı',
        'name'          => 'Ad',
        'quest'         => 'Ana Görev',
        'quests'        => 'Alt Görevler',
        'role'          => 'Rol',
        'type'          => 'Tür',
    ],
    'helpers'       => [],
    'hints'         => [
        'quests'    => 'İç içe geçen bir görev ağı Ana Görev alanı aracılığı ile örülebilir.',
    ],
    'index'         => [
        'add'       => 'Yeni Görev',
        'header'    => ':name Görevleri',
        'title'     => 'Görevler',
    ],
    'placeholders'  => [
        'date'  => 'Görev için gerçek dünya tarihi',
        'name'  => 'Görevin adı',
        'quest' => 'Ana Görev',
        'role'  => 'Bu varlığın görevdeki rolü',
        'type'  => 'Karakter Arkı, Yangörev, Ana',
    ],
    'show'          => [
        'title' => ':name Görevi',
    ],
];
