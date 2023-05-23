<?php

return [
    'create'        => [
        'title' => 'Yeni Organizasyon',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'members'   => 'Üyeler',
    ],
    'helpers'       => [
        'descendants'   => 'Bu liste bu organizasyondan gelen tüm organizasyonları içerir, yalnızca doğrudan altında olanları değil.',
    ],
    'index'         => [],
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
            'role'  => 'Rol',
        ],
        'helpers'       => [
            'all_members'   => 'Bu organizasyonun ve onun alt organizasyonlarının üyeleri olan tüm karakterler.',
            'members'       => 'Bu organizasyonun üyeleri olan tüm karakterler.',
        ],
        'placeholders'  => [
            'role'  => 'Lider, Üye, Baş Septon, İstihbarat Şefi',
        ],
    ],
    'organisations' => [],
    'placeholders'  => [
        'type'  => 'Kült, Çete, Ayaklanma, Hayran Kulübü',
    ],
    'show'          => [],
];
