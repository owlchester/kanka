<?php

return [
    'actions'       => [
        'add_appearance'    => 'Bir görünüm ekle',
        'add_organisation'  => 'Bir organizasyon ekle',
        'add_personality'   => 'Bir kişilik ekle',
    ],
    'conversations' => [
        'description'   => 'Karakterin katıldığı muhabbetler',
        'title'         => ':name Karakterinin Muhabbetleri',
    ],
    'create'        => [
        'description'   => 'Yeni bir karakter yarat',
        'success'       => '\':name\' karakteri yaratıldı.',
        'title'         => 'Yeni Karakter',
    ],
    'destroy'       => [
        'success'   => '\':name\' karakteri kaldırıldı.',
    ],
    'dice_rolls'    => [
        'description'   => 'Karaktere bağlanmış zarlar',
        'hint'          => 'Zarlar oyun içi kullanım için karakterlere bağlanabilir.',
        'title'         => ':name Karakteri Zarları',
    ],
    'edit'          => [
        'description'   => 'Bir karakteri düzenle',
        'success'       => '\':name\' karakteri güncellendi.',
        'title'         => ':name Karakterini Düzenle',
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
        'hide_personality'          => 'Bu sekme "Yönetici" olmayan kullanıcılardan "Kişiliği Görünür" seçeneği karakteri düzenlerken kaldırılarak saklanabilir.',
        'is_dead'                   => 'Bu karakter ölü',
        'is_personality_visible'    => 'Bütün kişilik sekmesini "Yönetici" olmayan kullanıcılardan saklayabilirsiniz.',
    ],
    'index'         => [
        'actions'       => [
            'random'    => 'Yeni Rastgele Karakter',
        ],
        'add'           => 'Yeni Karakter',
        'description'   => ':name karakterlerini yönet.',
        'header'        => ':name karakterleri',
        'title'         => 'Karakterler',
    ],
    'items'         => [
        'description'   => 'Karakter tarafından taşınan ya da sahiplenilen eşyalar.',
        'hint'          => 'Eşyalar karakterlere atanabilir ve burada görüntülenebilir.',
        'title'         => ':name Karakterinin Eşyaları',
    ],
    'journals'      => [
        'description'   => 'Karakterin yazarı olduğu günlükler.',
        'title'         => ':name Karakterinin Günlükleri',
    ],
    'maps'          => [
        'description'   => 'Bir karakterin ilişkiler haritası.',
        'title'         => ':name Karakter İlişki Haritası',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Organizasyon ekle',
        ],
        'create'        => [
            'description'   => 'Bir organizasyonu bir karaktere ilişkilendir.',
            'success'       => 'Karakter organizasyona eklendi.',
            'title'         => ':name için Yeni Organizasyon',
        ],
        'description'   => 'Karakterin bir parçası olduğu organizasyonlar.',
        'destroy'       => [
            'success'   => 'Karakter organizasyonu kaldırıldı.',
        ],
        'edit'          => [
            'description'   => 'Bir karakterin organizasyonunu güncelle',
            'success'       => 'Karakter organizasyonu güncellendi.',
            'title'         => ':name için Organizasyonu Güncelle',
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
        'description'   => 'Karakterin bir parçası olduğu görevler.',
        'helpers'       => [
            'quest_giver'   => 'Karakterin görev verici olduğu görevler.',
            'quest_member'  => 'Karakterin bir üyesi olduğu görevler.',
        ],
        'title'         => ':name Karakterinin Görevleri',
    ],
    'sections'      => [
        'appearance'    => 'Görünüm',
        'general'       => 'Genel bilgi',
        'personality'   => 'Kişilik',
    ],
    'show'          => [
        'description'   => 'Karakterin detaylı bir görünümü',
        'tabs'          => [
            'conversations' => 'Muhabbetler',
            'dice_rolls'    => 'Zarlar',
            'items'         => 'Eşyalar',
            'journals'      => 'Günlükler',
            'map'           => 'İlişki Haritası',
            'organisations' => 'Organizasyonlar',
            'personality'   => 'Kişilik',
            'quests'        => 'Görevler',
        ],
        'title'         => ':name Karakteri',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Bu karakterde kişilik özelliklerini düzenleme izniniz yok.',
    ],
];
