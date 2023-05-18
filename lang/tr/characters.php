<?php

return [
    'actions'       => [
        'add_appearance'    => 'Bir görünüm ekle',
        'add_personality'   => 'Bir kişilik ekle',
    ],
    'conversations' => [],
    'create'        => [
        'title' => 'Yeni Karakter',
    ],
    'destroy'       => [],
    'dice_rolls'    => [],
    'edit'          => [],
    'fields'        => [
        'age'                       => 'Yaş',
        'is_dead'                   => 'Ölü',
        'is_personality_visible'    => 'Kişiliği görünür',
        'life'                      => 'Hayat',
        'physical'                  => 'Fiziksel',
        'sex'                       => 'Cinsiyet',
        'title'                     => 'Ünvan',
        'traits'                    => 'Nitelik',
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
    'index'         => [],
    'items'         => [],
    'journals'      => [],
    'maps'          => [],
    'organisations' => [
        'create'    => [
            'success'   => 'Karakter organizasyona eklendi.',
            'title'     => ':name için Yeni Organizasyon',
        ],
        'destroy'   => [
            'success'   => 'Karakter organizasyonu kaldırıldı.',
        ],
        'edit'      => [
            'success'   => 'Karakter organizasyonu güncellendi.',
            'title'     => ':name için Organizasyonu Güncelle',
        ],
        'fields'    => [
            'role'  => 'Rol',
        ],
    ],
    'placeholders'  => [
        'age'               => 'Yaş',
        'appearance_entry'  => 'Tasvir',
        'appearance_name'   => 'Saç, Gözler, Ten, Boy',
        'personality_entry' => 'Detaylar',
        'personality_name'  => 'Hedefler, Tavırlar, Korkular, Bağlar',
        'physical'          => 'Fiziksel',
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
        'personality'   => 'Kişilik',
    ],
    'show'          => [],
    'warnings'      => [
        'personality_hidden'    => 'Bu karakterde kişilik özelliklerini düzenleme izniniz yok.',
    ],
];
