<?php

return [
    'children'      => [
        'actions'   => [
            'add'   => 'Yeni bir etiket ekle',
        ],
        'create'    => [
            'title' => ':name için etiket ekle',
        ],
    ],
    'create'        => [
        'title' => 'Yeni Etiket',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'children'  => 'Bağlı not',
    ],
    'helpers'       => [],
    'hints'         => [
        'children'  => 'Bu liste bu etiketteki ve tüm iç içe etiketlerdeki varlıkları içerir.',
        'tag'       => 'Aşağıda bu etiketin doğrudan altında olan tüm etiketler görüntülenir.',
    ],
    'index'         => [],
    'placeholders'  => [
        'type'  => 'Bilgi, Savaşlar, Tarih, Din, Bayrakbilim',
    ],
    'show'          => [
        'tabs'  => [
            'children'  => 'Alt etiketler',
        ],
    ],
    'tags'          => [],
];
