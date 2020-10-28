<?php

return [
    'children'      => [
        'actions'       => [
            'add'   => 'Yeni bir etiket ekle',
        ],
        'create'        => [
            'title' => ':name için etiket ekle',
        ],
        'description'   => 'Etikete ait varlıklar',
        'title'         => ':name Etiketine Bağlı Notlar',
    ],
    'create'        => [
        'description'   => 'Yeni bir etiket yarat',
        'success'       => '\':name\' etiketi yaratıldı.',
        'title'         => 'Yeni Etiket',
    ],
    'destroy'       => [
        'success'   => '\':name\' etiketi kaldırıldı.',
    ],
    'edit'          => [
        'success'   => '\':name\' etiketi güncellendi.',
        'title'     => ':name Etiketini Düzenle',
    ],
    'fields'        => [
        'characters'    => 'Karakterler',
        'children'      => 'Bağlı not',
        'name'          => 'Ad',
        'tag'           => 'Ana Etiket',
        'tags'          => 'Alt Etiket',
        'type'          => 'Tür',
    ],
    'helpers'       => [
        'nested'    => 'İç İçe Görünüm\'de, etiketlerinizi iç içe olacak şekilde görebilirsiniz. Ana etiketi olmayan etiketler varsayılan olarak gösterilecektir. Alt etiketi olan etiketler o alt etiketleri göstermek için tıklanabilir. Daha fazla alt etiket kalmayana kadar tıklamaya devam edebilirsiniz.',
    ],
    'hints'         => [
        'children'  => 'Bu liste bu etiketteki ve tüm iç içe etiketlerdeki varlıkları içerir.',
        'tag'       => 'Aşağıda bu etiketin doğrudan altında olan tüm etiketler görüntülenir.',
    ],
    'index'         => [
        'actions'       => [
            'explore_view'  => 'İç İçe Görünüm',
        ],
        'add'           => 'Yeni Etiket',
        'description'   => ':name etiketlerini yönet.',
        'header'        => ':name içindeki etiketler',
        'title'         => 'Etiketler',
    ],
    'new_tag'       => 'Yeni Etiket',
    'placeholders'  => [
        'name'  => 'Etiketin adı',
        'tag'   => 'Bir ana etiket seçin',
        'type'  => 'Bilgi, Savaşlar, Tarih, Din, Bayrakbilim',
    ],
    'show'          => [
        'description'   => 'Etikete detaylı bir bakış',
        'tabs'          => [
            'children'      => 'Alt etiketler',
            'information'   => 'Bilgi',
            'tags'          => 'Etiketler',
        ],
        'title'         => ':name Etiketi',
    ],
    'tags'          => [
        'description'   => 'Alt Etiketler',
        'title'         => ':name Alt Etiketleri',
    ],
];
