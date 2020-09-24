<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Bir karakteri bir Göreve ekle',
            'success'       => ':name için karakter eklendi.',
            'title'         => ':name için Yeni Karakter',
        ],
        'destroy'   => [
            'success'   => ':name için görev karakteri kaldırıldı.',
        ],
        'edit'      => [
            'description'   => 'Bir görevin karakterini güncelle',
            'success'       => ':name için görev karakteri güncellendi.',
            'title'         => ':name için karakteri güncelle.',
        ],
        'fields'    => [
            'character'     => 'Karakter',
            'description'   => 'Açıklama',
        ],
        'title'     => ':name görevindeki karakterler',
    ],
    'create'        => [
        'description'   => 'Yeni bir görev yarat',
        'success'       => '\':name\' görevi yaratıldı.',
        'title'         => 'Yeni Görev',
    ],
    'destroy'       => [
        'success'   => '\':name\' görevi kaldırıldı.',
    ],
    'edit'          => [
        'description'   => 'Bir görevi düzenle',
        'success'       => '\':name\' görevi güncellendi.',
        'title'         => ':name Görevini Düzenle',
    ],
    'fields'        => [
        'character'     => 'Azmettirici',
        'characters'    => 'Karakterler',
        'copy_elements' => 'Göreve iliştirilmiş elementleri kopyala',
        'date'          => 'Tarih',
        'description'   => 'Açıklama',
        'image'         => 'Görsel',
        'is_completed'  => 'Tamamlandı',
        'items'         => 'Eşyalar',
        'locations'     => 'Konumlar',
        'name'          => 'Ad',
        'organisations' => 'Organizasyonlar',
        'quest'         => 'Ana Görev',
        'quests'        => 'Alt Görevler',
        'role'          => 'Rol',
        'type'          => 'Tür',
    ],
    'helpers'       => [
        'nested'    => 'İç İçe Görünüm\'de, Görevlerinizi iç içe olacak şekilde görebilirsiniz. Ana Görevi olmayan görevler varsayılan olarak gösterilecektir. Alt Görevi olan görevler o alt görevler göstermek için tıklanabilir. Daha fazla alt görev kalmayana kadar tıklamaya devam edebilirsiniz.',
    ],
    'hints'         => [
        'quests'    => 'İç içe geçen bir görev ağı Ana Görev alanı aracılığı ile örülebilir.',
    ],
    'index'         => [
        'add'           => 'Yeni Görev',
        'description'   => ':name Görevlerini yönet.',
        'header'        => ':name Görevleri',
        'title'         => 'Görevler',
    ],
    'items'         => [
        'create'    => [
            'description'   => 'Bir eşyayı bir göreve ata.',
            'success'       => 'Eşya :name görevine eklendi.',
            'title'         => ':name için Yeni Eşya',
        ],
        'destroy'   => [
            'success'   => ':name için görev eşyası kaldırıldı.',
        ],
        'edit'      => [
            'description'   => 'Bir görevin eşyasını güncelle',
            'success'       => ':name için görev eşyası güncellendi.',
            'title'         => ':name için eşyayı güncelle',
        ],
        'fields'    => [
            'description'   => 'Açıklama',
            'item'          => 'Eşya',
        ],
        'title'     => ':name içindeki eşyalar',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Bir Göreve bir konum ekle',
            'success'       => ':name için konum eklendi.',
            'title'         => ':name için Yeni Konum',
        ],
        'destroy'   => [
            'success'   => ':name için görev konumu kaldırıldı.',
        ],
        'edit'      => [
            'description'   => 'Bir görevin konumunu güncelle.',
            'success'       => ':name için görev konumu güncellendi.',
            'title'         => ':name için konum güncelle',
        ],
        'fields'    => [
            'description'   => 'Açıklama',
            'location'      => 'Konum',
        ],
        'title'     => ':name içindeki konumlar',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Bir organizasyonu bir Göreve ekle',
            'success'       => ':name için organizasyon eklendi.',
            'title'         => ':name için Yeni Organizasyon',
        ],
        'destroy'   => [
            'success'   => ':name için görev organizasyonu kaldıldı.',
        ],
        'edit'      => [
            'description'   => 'Bir görevin organizasyonunu güncelle',
            'success'       => ':name için görev organizasyonu güncellendi.',
            'title'         => ':name için organizasyonu güncelle',
        ],
        'fields'    => [
            'description'   => 'Açıklama',
            'organisation'  => 'Organizasyon',
        ],
        'title'     => ':name içindeki organizasyonlar',
    ],
    'placeholders'  => [
        'date'  => 'Görev için gerçek dünya tarihi',
        'name'  => 'Görevin adı',
        'quest' => 'Ana Görev',
        'role'  => 'Bu varlığın görevdeki rolü',
        'type'  => 'Karakter Arkı, Yangörev, Ana',
    ],
    'show'          => [
        'actions'       => [
            'add_character'     => 'Bir karakter ekle',
            'add_item'          => 'Bir eşya ekle',
            'add_location'      => 'Bir konum ekle',
            'add_organisation'  => 'Bir organizasyon ekle',
        ],
        'description'   => 'Göreve detaylı bir bakış',
        'tabs'          => [
            'characters'    => 'Karakterler',
            'information'   => 'Bilgi',
            'items'         => 'Eşyalar',
            'locations'     => 'Konumlar',
            'organisations' => 'Organizasyonlar',
            'quests'        => 'Görevler',
        ],
        'title'         => ':name Görevi',
    ],
];
