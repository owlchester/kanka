<?php

return [
    'create'        => [
        'success'   => ':entity varlığına :target ilişkisi eklendi.',
        'title'     => ':name için yeni ilişki',
    ],
    'destroy'       => [
        'success'   => ':entity varlığından :target ilişkisi kaldırıldı.',
    ],
    'fields'        => [
        'attitude'  => 'Konum',
        'is_star'   => 'Sabitli',
        'relation'  => 'İlişki',
        'target'    => 'Hedef',
        'two_way'   => 'Yansıma ilişki yarat',
    ],
    'helper'        => 'Varlıklar arasında konumlar ve görünürlük ile ilişkiler kurun. İlişkiler aynı zamnda varlığın menüsüne de sabitlenebilir.',
    'hints'         => [
        'attitude'  => 'Bu isteğe bağlı alan ilişkilerin varsayılan sırasını azalan sıralama ile tanımlamak için kullanılabilir.',
        'mirrored'  => [
            'text'  => 'Bu ilişki :link sayfasını yansıtır.',
            'title' => 'Yansıma',
        ],
        'two_way'   => 'Eğer bir yansıma ilişki yaratmak isterseniz, aynı ilişki hedefte de yaratılacak. Ancak, eğer birini düzenlerseniz, yansıma güncellenmeyecek.',
    ],
    'placeholders'  => [
        'attitude'  => '-100 ile 100 arası, 100 çok olumlu',
        'relation'  => 'Düşman, En İyi Arkadaş, Kardeş',
        'target'    => 'Bir varlık seçin',
    ],
    'show'          => [
        'title' => ':name için İlişkiler',
    ],
    'teaser'        => 'İlişkiler gezginine erişim için serüveninizi destekleyin. Destekli serüvenler hakkında daha fazla bilgi için tıklayın.',
    'types'         => [
        'family_member'         => 'Aile Üyesi',
        'organisation_member'   => 'Organizasyon Üyesi',
    ],
    'update'        => [
        'success'   => ':entity için :target ilişkisi güncellendi.',
        'title'     => ':name için ilişkileri güncelle',
    ],
];
