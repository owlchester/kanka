<?php

return [
    'create'        => [
        'success'   => '\':name\' organizasyonu yaratıldı.',
        'title'     => 'Yeni Organizasyon',
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
    ],
    'index'         => [
        'add'       => 'Yeni Organizasyon',
        'header'    => ':name Organizasyonları',
        'title'     => 'Organizasyonlar',
    ],
    'members'       => [
        'actions'       => [
            'add'   => 'Bir üye ekle',
        ],
        'create'        => [
            'success'   => 'Üye organizasyona eklendi.',
            'title'     => ':name için Yeni Organizasyon Üyesi',
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
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organizasyonlar',
            'quests'        => 'Görevler',
            'relations'     => 'İlişkiler',
        ],
        'title' => ':name Organizasyonu',
    ],
];
