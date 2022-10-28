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
        'title' => 'Yeni Etiket',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'  => 'Bağlı not',
        'tag'       => 'Ana Etiket',
        'tags'      => 'Alt Etiket',
    ],
    'helpers'       => [],
    'hints'         => [
        'children'  => 'Bu liste bu etiketteki ve tüm iç içe etiketlerdeki varlıkları içerir.',
        'tag'       => 'Aşağıda bu etiketin doğrudan altında olan tüm etiketler görüntülenir.',
    ],
    'index'         => [],
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
    ],
    'tags'          => [
        'title' => ':name Alt Etiketleri',
    ],
];
