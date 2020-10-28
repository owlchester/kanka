<?php

return [
    'create'        => [
        'description'   => 'Yeni bir eşya yarat',
        'success'       => '\':name\' eşyası yaratıldı.',
        'title'         => 'Yeni Eşya',
    ],
    'destroy'       => [
        'success'   => '\':name\' eşyası kaldırıldı.',
    ],
    'edit'          => [
        'success'   => '\':name\' eşyası güncellendi.',
        'title'     => ':name Eşyasını Düzenle',
    ],
    'fields'        => [
        'character' => 'Karakter',
        'image'     => 'Görsel',
        'location'  => 'Konum',
        'name'      => 'Ad',
        'price'     => 'Fiyat',
        'relation'  => 'İlişki',
        'size'      => 'Boyut',
        'type'      => 'Tür',
    ],
    'index'         => [
        'add'           => 'Yeni Eşya',
        'description'   => ':name eşyalarını yönet',
        'header'        => ':name Eşyaları',
        'title'         => 'Eşyalar',
    ],
    'inventories'   => [
        'description'   => 'Eşyanın içinde bulunduğu Varlık Envanterleri',
        'title'         => ':name Eşyası Envanterleri',
    ],
    'placeholders'  => [
        'character' => 'Bir karakter seçin',
        'location'  => 'Bir konum seçin',
        'name'      => 'Eşyanın adı',
        'price'     => 'Eşyanın fiyatı',
        'size'      => 'Boyut, Ağırlık, Ölçüler',
        'type'      => 'Silah, İksir, Artifakt',
    ],
    'quests'        => [
        'description'   => 'Eşyanın bir parçası olduğu görevler.',
        'title'         => ':name Eşyasının Görevleri',
    ],
    'show'          => [
        'description'   => 'Eşyaya detaylı bir bakış',
        'tabs'          => [
            'information'   => 'Bilgi',
            'inventories'   => 'Envanterler',
            'quests'        => 'Görevler',
        ],
        'title'         => ':name Eşyası',
    ],
];
