<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Yeni bir etiket ekle',
        ],
        'create'    => [
            'title' => ':name için etiket ekle',
        ],
        'title'     => ':name Etiketine Bağlı Notlar',
    ],
    'create'        => [
        'success'   => '\':name\' etiketi yaratıldı.',
        'title'     => 'Yeni Etiket',
    ],
    'destroy'       => [
        'success'   => '\':name\' etiketi kaldırıldı.',
    ],
    'edit'          => [
        'success'   => '\':name\' etiketi güncellendi.',
        'title'     => ':name Etiketini Düzenle',
    ],
    'fields'        => [
        'children'  => 'Bağlı not',
        'name'      => 'Ad',
        'tag'       => 'Ana Etiket',
        'tags'      => 'Alt Etiket',
        'type'      => 'Tür',
    ],
    'helpers'       => [],
    'hints'         => [
        'children'  => 'Bu liste bu etiketteki ve tüm iç içe etiketlerdeki varlıkları içerir.',
        'tag'       => 'Aşağıda bu etiketin doğrudan altında olan tüm etiketler görüntülenir.',
    ],
    'index'         => [
        'actions'   => [
            'explore_view'  => 'İç İçe Görünüm',
        ],
        'add'       => 'Yeni Etiket',
        'header'    => ':name içindeki etiketler',
        'title'     => 'Etiketler',
    ],
    'new_tag'       => 'Yeni Etiket',
    'placeholders'  => [
        'name'  => 'Etiketin adı',
        'tag'   => 'Bir ana etiket seçin',
        'type'  => 'Bilgi, Savaşlar, Tarih, Din, Bayrakbilim',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Alt etiketler',
            'tags'      => 'Etiketler',
        ],
        'title' => ':name Etiketi',
    ],
    'tags'          => [
        'title' => ':name Alt Etiketleri',
    ],
];
