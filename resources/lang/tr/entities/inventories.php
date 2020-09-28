<?php

return [
    'actions'       => [
        'add'   => 'Eşya Ekle',
    ],
    'create'        => [
        'success'   => ':item Eşyası :entity varlığına eklendi.',
        'title'     => ':name için eşya ekle',
    ],
    'destroy'       => [
        'success'   => ':item eşyası :entity varlığından kaldırıldı.',
    ],
    'fields'        => [
        'amount'        => 'Miktar',
        'description'   => 'Açıklama',
        'is_equipped'   => 'Giyili',
        'name'          => 'Ad',
        'position'      => 'Konum',
    ],
    'placeholders'  => [
        'amount'        => 'Herhangi bir miktar',
        'description'   => 'Kullanılmış, Hasarlı, Bağlı',
        'name'          => 'Eğer hiçbir eşya seçili değilse gereklidir.',
        'position'      => 'Giyili, Sırt Çantası, Depo, Banka',
    ],
    'show'          => [
        'helper'    => 'Varlıklara bir envanter oluşturmak için eşyalar iliştirilebilir.',
        'title'     => ':name Varlık Envanteri',
        'unsorted'  => 'Sırasız',
    ],
    'update'        => [
        'success'   => ':item eşyası :entity için güncellendi.',
        'title'     => ':name üzerindeki bir eşyayı güncelle',
    ],
];
