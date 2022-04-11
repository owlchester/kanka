<?php

return [
    'actions'       => [
        'add_appearance'    => 'Bir görünüm ekle',
        'add_organisation'  => 'Bir organizasyon ekle',
        'add_personality'   => 'Bir kişilik ekle',
    ],
    'conversations' => [
        'title' => ':name Karakterinin Muhabbetleri',
    ],
    'create'        => [
        'success'   => '\':name\' karakteri yaratıldı.',
        'title'     => 'Yeni Karakter',
    ],
    'destroy'       => [
        'success'   => '\':name\' karakteri kaldırıldı.',
    ],
    'dice_rolls'    => [
        'hint'  => 'Zarlar oyun içi kullanım için karakterlere bağlanabilir.',
        'title' => ':name Karakteri Zarları',
    ],
    'edit'          => [
        'success'   => '\':name\' karakteri güncellendi.',
        'title'     => ':name Karakterini Düzenle',
    ],
    'fields'        => [
        'age'                       => 'Yaş',
        'family'                    => 'Aile',
        'image'                     => 'Görsel',
        'is_dead'                   => 'Ölü',
        'is_personality_visible'    => 'Kişiliği görünür',
        'life'                      => 'Hayat',
        'location'                  => 'Konum',
        'name'                      => 'Ad',
        'physical'                  => 'Fiziksel',
        'race'                      => 'Irk',
        'relation'                  => 'İlişki',
        'sex'                       => 'Cinsiyet',
        'title'                     => 'Ünvan',
        'traits'                    => 'Nitelik',
        'type'                      => 'Tür',
    ],
    'helpers'       => [
        'age'   => 'Bu varlığın yaşını serüveninizin bir takvimine bağlayarak da yaşını hesaplayabilirsiniz. :more.',
    ],
    'hints'         => [
        'is_dead'                   => 'Bu karakter ölü',
        'is_personality_visible'    => 'Bütün kişilik sekmesini "Yönetici" olmayan kullanıcılardan saklayabilirsiniz.',
        'personality_not_visible'   => 'Bu karakterin kişilik özellikleri şu anda yalnızca Yönetici kullanıcılara görünür.',
        'personality_visible'       => 'Bu karakterin kişilik özelliklere herkese görünür.',
    ],
    'index'         => [
        'actions'   => [
            'random'    => 'Yeni Rastgele Karakter',
        ],
        'add'       => 'Yeni Karakter',
        'header'    => ':name karakterleri',
        'title'     => 'Karakterler',
    ],
    'items'         => [
        'hint'  => 'Eşyalar karakterlere atanabilir ve burada görüntülenebilir.',
        'title' => ':name Karakterinin Eşyaları',
    ],
    'journals'      => [
        'title' => ':name Karakterinin Günlükleri',
    ],
    'maps'          => [
        'title' => ':name Karakter İlişki Haritası',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Organizasyon ekle',
        ],
        'create'        => [
            'success'   => 'Karakter organizasyona eklendi.',
            'title'     => ':name için Yeni Organizasyon',
        ],
        'destroy'       => [
            'success'   => 'Karakter organizasyonu kaldırıldı.',
        ],
        'edit'          => [
            'success'   => 'Karakter organizasyonu güncellendi.',
            'title'     => ':name için Organizasyonu Güncelle',
        ],
        'fields'        => [
            'organisation'  => 'Organizasyon',
            'role'          => 'Rol',
        ],
        'hint'          => 'Karakterler kimin için çalıştıklarını ya da hangi gizli topluluğun bir parçası olduklarını belirten pek çok organizasyonun parçası olabilirler.',
        'placeholders'  => [
            'organisation'  => 'Bir organizasyon seçin...',
        ],
        'title'         => ':name Karakterinin Organizasyonları',
    ],
    'placeholders'  => [
        'age'               => 'Yaş',
        'appearance_entry'  => 'Tasvir',
        'appearance_name'   => 'Saç, Gözler, Ten, Boy',
        'family'            => 'Bir karakter seçin',
        'image'             => 'Görsel',
        'location'          => 'Bir konum seçin',
        'name'              => 'Ad',
        'personality_entry' => 'Detaylar',
        'personality_name'  => 'Hedefler, Tavırlar, Korkular, Bağlar',
        'physical'          => 'Fiziksel',
        'race'              => 'Irk',
        'sex'               => 'Cinsiyet',
        'title'             => 'Ünvan',
        'traits'            => 'Özellikler',
        'type'              => 'NPC, Oyuncu Karakteri, Tanrı',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Karakterin görev verici olduğu görevler.',
            'quest_member'  => 'Karakterin bir üyesi olduğu görevler.',
        ],
    ],
    'sections'      => [
        'appearance'    => 'Görünüm',
        'general'       => 'Genel bilgi',
        'personality'   => 'Kişilik',
    ],
    'show'          => [
        'tabs'  => [
            'map'           => 'İlişki Haritası',
            'organisations' => 'Organizasyonlar',
        ],
        'title' => ':name Karakteri',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Bu karakterde kişilik özelliklerini düzenleme izniniz yok.',
    ],
];
