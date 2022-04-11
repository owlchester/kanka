<?php

return [
    'actions'       => [
        'follow'    => 'Takip et',
        'unfollow'  => 'Takipten çık',
    ],
    'campaigns'     => [
        'tabs'  => [
            'modules'   => ':count Modül',
            'roles'     => ':count Rol',
            'users'     => ':count Kullanıcı',
        ],
    ],
    'dashboards'    => [
        'actions'       => [
            'edit'      => 'Düzenle',
            'new'       => 'Yeni Ana Panel',
            'switch'    => 'Ana panele geç',
        ],
        'boosted'       => ':boosted_campaigns serüvendeki rollerin her birine özel ana paneller yaratabilir.',
        'create'        => [
            'success'   => ':name adlı yeni serüven ana paneli yaratıldı.',
            'title'     => 'Yeni Serüven Ana Paneli',
        ],
        'custom'        => [
            'text'  => 'Şu anda serüvenin :name ana panelini düzenliyorsunuz.',
        ],
        'default'       => [
            'text'  => 'Şu anda serüvenin varsayılan ana panelini düzenliyorsunuz.',
            'title' => 'Varsayılan Ana Panel',
        ],
        'delete'        => [
            'success'   => ':name ana paneli kaldırıldı.',
        ],
        'fields'        => [
            'name'          => 'Ana panel adı',
            'visibility'    => 'Görünürlük',
        ],
        'placeholders'  => [
            'name'  => 'Ana panelin adı',
        ],
        'update'        => [
            'success'   => ':name serüven ana paneli güncellendi.',
            'title'     => ':name serüven ana panelini güncelle',
        ],
        'visibility'    => [
            'default'   => 'Varsayılan',
            'none'      => 'Yok',
            'visible'   => 'Görünür',
        ],
    ],
    'helpers'       => [
        'follow'    => 'Bir serüveni takip etmek o serüvenin serüven değiştiricide (sol üstte) sizin serüvenlerinizin altında belirmesini sağlar.',
        'setup'     => 'Serüveninizin ana panelini ayarlayın.',
    ],
    'notifications' => [
        'modal' => [
            'confirm'   => 'Anladım',
            'title'     => 'Önemli Bildirim',
        ],
    ],
    'recent'        => [
        'title' => ':name En Son Değişiklik',
    ],
    'settings'      => [
        'title' => 'Ana Panel Ayarları',
    ],
    'setup'         => [
        'actions'   => [
            'add'               => 'Bir ufak eklenti ekle',
            'back_to_dashboard' => 'Ana panele geri dön',
            'edit'              => 'Bir ufak eklentiyi düzenle',
        ],
        'title'     => 'Serüven Ana Paneli Ayarlama',
        'widgets'   => [
            'calendar'      => 'Takvim',
            'campaign'      => 'Serüven başlığı',
            'header'        => 'Başlık',
            'preview'       => 'Varlık önizleme',
            'random'        => 'Rastgele varlık',
            'recent'        => 'En son değişiklik',
            'unmentioned'   => 'Bahsedilmemiş varlıklar',
        ],
    ],
    'title'         => 'Ana panel',
    'widgets'       => [
        'calendar'      => [
            'actions'           => [
                'next'      => 'Tarihi sonraki güne değiştir',
                'previous'  => 'Tarihi önceki güne değiştir',
            ],
            'events_today'      => 'Bugün',
            'previous_events'   => 'Önceki',
            'upcoming_events'   => 'Gelecek',
        ],
        'campaign'      => [
            'helper'    => 'Bu ufak eklenti serüven başlığını gösterir. Bu küçük eklenti varsayılan ana panelde her zaman gösterilir.',
        ],
        'create'        => [
            'success'   => 'Küçük eklenti ana panele eklendi.',
        ],
        'delete'        => [
            'success'   => 'Küçük eklenti ana panelden kaldırıldı.',
        ],
        'fields'        => [
            'name'  => 'Özel küçük eklenti adı',
            'text'  => 'Metin',
            'width' => 'Genişlik',
        ],
        'recent'        => [
            'entity-header' => 'Varlık başlığını görsel olarak kullan',
            'full'          => 'Tümü',
            'help'          => 'Yalnızca en son güncellenen varlığı göster, ancak varlığın tam bir önizlemesini göster',
            'helpers'       => [
                'entity-header' => 'Eğer varlığınızın bir varlık başlığı (desteklenmiş serüven özelliği) varsa, bu küçük eklentiyi varlığın görseli yerine o görseli kullanacak şekilde ayarlar.',
                'full'          => 'Bir önizlemenin yerine varlığın girdisinin tamamını görüntüler.',
            ],
            'singular'      => 'Tekil',
            'tags'          => 'En son değişiklik yapılan varlıklar listesini belirlenen etiketlere göre filtrele',
            'title'         => 'En son değiştirilenler',
        ],
        'unmentioned'   => [
            'title' => 'Bahsedilmemiş varlıklar',
        ],
        'update'        => [
            'success'   => 'Küçük eklenti düzenlendi.',
        ],
        'widths'        => [
            '0' => 'Otomatik',
            '12'=> 'Tam (%100)',
            '3' => 'Ufak (%25)',
            '4' => 'Küçük (%33)',
            '6' => 'Yarım (%50)',
            '8' => 'Geniş (%66)',
        ],
    ],
];
