<?php

return [
    'abilities'     => [
        'title' => ':name yeteneğinin alt yetenekleri',
    ],
    'create'        => [
        'success'   => '\':name\' yeteneği yaratıldı.',
        'title'     => 'Yeni Yetenek',
    ],
    'destroy'       => [
        'success'   => '\':name\' yeteneği kaldırıldı.',
    ],
    'edit'          => [
        'success'   => '\':name\' yeteneği güncellendi.',
        'title'     => ':name Yeteneğini Düzenle',
    ],
    'fields'        => [
        'abilities' => 'Yetenekler',
        'ability'   => 'Ana Yetenek',
        'charges'   => 'Yük Sayısı',
        'name'      => 'Ad',
        'type'      => 'Tür',
    ],
    'helpers'       => [
        'descendants'   => 'Bu liste bu yetenekten gelen tüm yetenekleri içerir, yalnızca doğrudan altında olanları değil.',
        'nested'        => 'İç İçe Görünüm\'de, Yeteneklerinizi iç içe olacak şekilde görebilirsiniz. Ana yeteneği olmayan yetenekler varsayılan olarak gösterilecektir. Alt yeteneği olan yetenekler o alt yetenekleri göstermek için tıklanabilir. Daha fazla alt yetenek kalmayana kadar tıklamaya devam edebilirsiniz.',
    ],
    'index'         => [
        'add'           => 'Yeni Yetenek',
        'description'   => 'Varlıklarınız için güçler, büyüler, hünerler ve daha fazlasını yaratın.',
        'header'        => ':name Yetenekleri',
        'title'         => 'Yetenekler',
    ],
    'placeholders'  => [
        'charges'   => 'Yük miktarı. {Level}*{CHA} aracılığı ile özelliklere gönderme yapabilirsiniz.',
        'name'      => 'Alevtopu, Uyanık, Kurnaz Saldırı',
        'type'      => 'Büyü, Hüner, Saldırı',
    ],
    'show'          => [
        'tabs'  => [
            'abilities' => 'Yetenekler',
        ],
        'title' => ':name Yeteneği',
    ],
];
