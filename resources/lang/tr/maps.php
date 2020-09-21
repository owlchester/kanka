<?php

return [
    'actions'   => [
        'back'      => ':name Sayfasına Geri Dön',
        'edit'      => 'Haritayı düzenle',
        'explore'   => 'Keşfet',
    ],
    'create'    => [
        'success'   => ':name haritası yaratıldı.',
        'title'     => 'Yeni Harita',
    ],
    'destroy'   => [
        'success'   => ':name haritası kaldırıldı.',
    ],
    'edit'      => [
        'success'   => ':name haritası güncellendi.',
        'title'     => ':name Haritasını Düzenle',
    ],
    'errors'    => [
        'dashboard' => [
            'missing'   => 'Bu haritanın kontrol panelinde görüntülenebilmesi için bir görsele ihtiyacı var.',
        ],
        'explore'   => [
            'missing'   => 'Haritayı keşfedebilmek için önce lütfen haritaya bir görsel ekleyin.',
        ],
    ],
    'fields'    => [
        'distance_measure'  => 'Uzaklık Ölçüsü',
        'distance_name'     => 'Uzaklık Birimi',
        'grid'              => 'Izgara',
        'initial_zoom'      => 'Temel yakınlaştırma',
        'map'               => 'Ana Harita',
        'maps'              => 'Haritalar',
        'max_zoom'          => 'Azami yakınlaştırma',
        'min_zoom'          => 'Asgari yakınlaştırma',
        'name'              => 'Ad',
        'type'              => 'Tür',
    ],
    'helpers'   => [
        'descendants'       => 'Bu liste bu haritadan gelen tüm haritaları, ve doğrudan altında olmayanları içerir.',
        'distance_measure'  => 'Haritaya bir uzaklık ölçüsü vermek keşif modunda ölçü aletini kullanmanıza olanak sağlar.',
        'grid'              => 'Keşif modunda görüntülenecek ızgara için bir boyut belirleyin.',
        'initial_zoom'      => 'Haritanın beraberinde yüklendiği temel yakınlaştırma oranı. Varsayılan değer :default, izin verilen azami değer :max, ve izin verilen asgari değer :min',
    ],
];
