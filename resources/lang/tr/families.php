<?php

return [
    'create'        => [
        'description'   => 'Yeni bir aile yarat',
        'success'       => ':name ailesi oluşturuldu.',
        'title'         => 'Yeni Aile',
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
        'nested'        => 'İç İçe Görünüm\'de, Ailelerinizi iç içe olacak şekilde görebilirsiniz. Ana Ailesi olmayan Aileler varsayılan olarak gösterilecektir. Alt Aileleri olan Aileler o alt Aileleri göstermek için tıklanabilir. Daha fazla alt Aile kalmayana kadar tıklamaya devam edebilirsiniz.',
    ],
    'hints'         => [
        'members'   => 'Aile üyeleri burada listelenir. Bir karakter bir aileye istenen karakteri düzenlerken "Aile" açılır listesi kullanılarak eklenebilir.',
    ],
    'index'         => [
        'add'           => 'Yeni Aile',
        'description'   => ':name ailelerini yönet.',
        'header'        => ':name Aileleri',
        'title'         => 'Aileler',
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
        'description'   => 'Aileye detaylı bir bakış',
        'tabs'          => [
            'all_members'   => 'Tüm Üyeler',
            'families'      => 'Aileler',
            'members'       => 'Üyeler',
            'relation'      => 'İlişkiler',
        ],
        'title'         => ':name Ailesi',
    ],
];
