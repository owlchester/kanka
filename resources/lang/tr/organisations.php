<?php

return [
    'create'        => [
        'description'   => 'Yeni bir organizasyon yarat',
        'success'       => '\':name\' organizasyonu yaratıldı.',
        'title'         => 'Yeni Organizasyon',
    ],
    'destroy'       => [
        'success'   => '\':name\' organizasyonu kaldırıldı.',
    ],
    'edit'          => [
        'success'   => '\':name\' organizasyonu güncellendi.',
        'title'     => '\':name\' Organizasyonunu Düzenle',
    ],
    'fields'        => [
        'image'         => 'Görsel',
        'location'      => 'Konum',
        'members'       => 'Üyeler',
        'name'          => 'Ad',
        'organisation'  => 'Ana Organizasyon',
        'organisations' => 'Alt Organizasyonlar',
        'relation'      => 'İlişki',
        'type'          => 'Tür',
    ],
    'helpers'       => [
        'descendants'   => 'Bu liste bu organizasyondan gelen tüm organizasyonları içerir, yalnızca doğrudan altında olanları değil.',
        'nested'        => 'İç İçe Görünüm\'de, Organizasyonlarınızı iç içe olacak şekilde görebilirsiniz. Ana Organizasyonu olmayan haritalar varsayılan olarak gösterilecektir. Alt Organizasyonu olan Organizasyonlar o alt Organizasyonları göstermek için tıklanabilir. Daha fazla alt Organizasyon kalmayana kadar tıklamaya devam edebilirsiniz.',
    ],
    'index'         => [
        'add'           => 'Yeni Organizasyon',
        'description'   => ':name organizasyonlarını yönet.',
        'header'        => ':name Organizasyonları',
        'title'         => 'Organizasyonlar',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Bir üye ekle',
        ],
        'create'        => [
            'description'   => 'Organizasyona bir üye ekle',
            'success'       => 'Üye organizasyona eklendi.',
            'title'         => ':name için Yeni Organizasyon Üyesi',
        ],
        'destroy'       => [
            'success'   => 'Üye organizasyondan kaldırıldı.',
        ],
        'edit'          => [
            'success'   => 'Organizasyon üyesi güncellendi.',
            'title'     => ':name için Üyeyi Güncelle',
        ],
        'fields'        => [
            'character'     => 'Karakter',
            'organisation'  => 'Organizasyon',
            'role'          => 'Rol',
        ],
        'helpers'       => [
            'all_members'   => 'Bu organizasyonun ve onun alt organizasyonlarının üyeleri olan tüm karakterler.',
            'members'       => 'Bu organizasyonun üyeleri olan tüm karakterler.',
        ],
        'placeholders'  => [
            'character' => 'Bir karakter seçin',
            'role'      => 'Lider, Üye, Baş Septon, İstihbarat Şefi',
        ],
        'title'         => ':name Üyeleri',
    ],
    'organisations' => [
        'title' => ':name Organizasyonları',
    ],
    'placeholders'  => [
        'location'  => 'Bir konum seçin',
        'name'      => 'Organizasyonun adı',
        'type'      => 'Kült, Çete, Ayaklanma, Hayran Kulübü',
    ],
    'quests'        => [
        'description'   => 'Organizasyonun bir parçası olduğu görevler.',
        'title'         => ':name Görevleri',
    ],
    'show'          => [
        'description'   => 'Organizasyona detaylı bir bakış.',
        'tabs'          => [
            'organisations' => 'Organizasyonlar',
            'quests'        => 'Görevler',
            'relations'     => 'İlişkiler',
        ],
        'title'         => ':name Organizasyonu',
    ],
];
