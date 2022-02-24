<?php

return [
    'create'        => [
        'success'   => ':name ailesi oluşturuldu.',
        'title'     => 'Yeni Aile',
    ],
    'destroy'       => [
        'success'   => '\':name\' ailesi kaldırıldı.',
    ],
    'edit'          => [
        'success'   => '\':name\' ailesi güncellendi',
        'title'     => ':name Ailesini Düzenle',
    ],
    'families'      => [
        'title' => ':name Aileleri',
    ],
    'fields'        => [
        'families'  => 'Alt Aileler',
        'family'    => 'Ana Aile',
        'image'     => 'Görsel',
        'location'  => 'Konum',
        'members'   => 'Üyeler',
        'name'      => 'Ad',
        'relation'  => 'İlişki',
        'type'      => 'Tür',
    ],
    'helpers'       => [
        'descendants'   => 'Bu liste bu aileden gelen tüm aileleri içerir, yalnızca doğrudan altında olanları değil.',
    ],
    'hints'         => [
        'members'   => 'Aile üyeleri burada listelenir. Bir karakter bir aileye istenen karakteri düzenlerken "Aile" açılır listesi kullanılarak eklenebilir.',
    ],
    'index'         => [
        'add'       => 'Yeni Aile',
        'header'    => ':name Aileleri',
        'title'     => 'Aileler',
    ],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Aşağıdaki liste bu ailede ve bu aileden gelen ailelerde bulunan karakterlerin listesidir.',
            'direct_members'    => 'Pek çok aile onu yöneten ya da onu ünlü yapan üyelere sahiptir. Aşağıdaki liste doğrudan bu ailede olan karakterlerin listesidir.',
        ],
        'title'     => ':name Üyeleri',
    ],
    'placeholders'  => [
        'location'  => 'Bir konum seçin',
        'name'      => 'Ailenin adı',
        'type'      => 'Asil, Soylu, Soyu Kurumuş',
    ],
    'show'          => [
        'tabs'  => [
            'all_members'   => 'Tüm Üyeler',
            'families'      => 'Aileler',
            'members'       => 'Üyeler',
            'relation'      => 'İlişkiler',
        ],
        'title' => ':name Ailesi',
    ],
];
