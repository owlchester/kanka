<?php

return [
    'create'        => [
        'title' => 'Yeni Görev',
    ],
    'destroy'       => [],
    'edit'          => [],
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
        'title' => 'Görevler',
    ],
    'placeholders'  => [
        'date'  => 'Görev için gerçek dünya tarihi',
        'name'  => 'Görevin adı',
        'quest' => 'Ana Görev',
        'role'  => 'Bu varlığın görevdeki rolü',
        'type'  => 'Karakter Arkı, Yangörev, Ana',
    ],
    'show'          => [],
];
