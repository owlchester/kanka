<?php

return [
    'create'        => [
        'description'   => 'Yeni bir olay oluştur',
        'success'       => '\':name\' olayı oluşturuldu.',
        'title'         => 'Yeni Olay',
    ],
    'destroy'       => [
        'success'   => '\':name\' olayı kaldırıldı.',
    ],
    'edit'          => [
        'success'   => '\':name\' olayı güncellendi.',
        'title'     => ':name Olayını Düzenle',
    ],
    'fields'        => [
        'date'      => 'Tarih',
        'image'     => 'Görsel',
        'location'  => 'Konum',
        'name'      => 'Ad',
        'type'      => 'Tür',
    ],
    'helpers'       => [
        'date'  => 'Bu alan her şeyi içinde bulundurabilir ve serüvenin takvimlerine bağlı değildir. Bu olayı bir takvime bağlamak için, olayı takvimde ya da bu olayın hatırlatıcılar sekmesinde ekleyin.',
    ],
    'index'         => [
        'add'           => 'Yeni Olay',
        'description'   => ':name olaylarını yönet.',
        'header'        => ':name Olayları',
        'title'         => 'Olaylar',
    ],
    'placeholders'  => [
        'date'      => 'Olayınız için bir tarih',
        'location'  => 'Bir konum seçin',
        'name'      => 'Olayın adı',
        'type'      => 'Seremoni, Festival, Felaket, Savaş, Doğum',
    ],
    'show'          => [
        'description'   => 'Olaya detaylı bir bakış',
        'tabs'          => [
            'information'   => 'Bilgi',
        ],
        'title'         => ':name Olayı',
    ],
    'tabs'          => [
        'calendars' => 'Takvim Girdileri',
    ],
];
