<?php

return [
    'create'        => [
        'description'   => 'Yeni bir muhabbet yarat',
        'success'       => '\':name\' muhabbeti yaratıldı.',
        'title'         => 'Yeni Muhabbet',
    ],
    'destroy'       => [
        'success'   => '\':name\' muahbbeti kaldırıldı.',
    ],
    'edit'          => [
        'description'   => 'Muhabbeti güncelle',
        'success'       => '\':name\' muhabbeti güncellendi.',
        'title'         => ':name Muhabbeti',
    ],
    'fields'        => [
        'messages'      => 'Mesajlar',
        'name'          => 'Ad',
        'participants'  => 'Katılımcılar',
        'target'        => 'Hedef',
        'type'          => 'Tür',
    ],
    'hints'         => [
        'participants'  => 'Lütfen sağ-üstteki :icon ikonuna tıklayarak muhabbetinize katılımcılar ekleyin.',
    ],
    'index'         => [
        'add'           => 'Yeni Muhabbet',
        'description'   => ':name kategorisini yönet.',
        'header'        => ':name Muhabbetleri',
        'title'         => 'Muhabbetler',
    ],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Mesaj kaldırıldı.',
        ],
        'is_updated'    => 'Güncellendi',
        'load_previous' => 'Önceki mesajları yükle',
        'placeholders'  => [
            'message'   => 'Mesajınız',
        ],
    ],
    'participants'  => [
        'create'        => [
            'success'   => ':entity katılımcısı muhabbete eklendi.',
        ],
        'description'   => 'Bir muhabbetin katılımcılarını ekle veya kaldır',
        'destroy'       => [
            'success'   => ':name katılımcısı muhabbetten kaldırıldı.',
        ],
        'modal'         => 'Katılımcılar',
        'title'         => ':name Katılımcıları',
    ],
    'placeholders'  => [
        'name'  => 'Muhabbetin adı',
        'type'  => 'Oyun İçi, Hazırlık, Plan',
    ],
    'show'          => [
        'description'   => 'Muhabbete detaylı bir bakış',
        'title'         => ':name Muhabbeti',
    ],
    'tabs'          => [
        'conversation'  => 'Muhabbet',
        'participants'  => 'Katılımcılar',
    ],
    'targets'       => [
        'characters'    => 'Karakterler',
        'members'       => 'Üyeler',
    ],
];
