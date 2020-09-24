<?php

return [
    'create'                            => [
        'description'           => 'Yeni bir serüven yaratın',
        'helper'                => [
            'title'     => ':name\'ya hoşgeldiniz',
            'welcome'   => <<<'TEXT'
Devam etmeden önce, serüveniniz için bir isim seçmelisiniz. Bu dünyanızın adı olacak. Eğer henüz iyi bir isim seçmediyseniz endişelenmeyin, ileride istediğiniz zaman değiştirebilir, ya da yeni serüvenler yaratabilirsiniz.

Kanka'ya katıldığınız için teşekkür ediyor, ve sürekli büyüyen topluğumuza içten dileklerimizle karşılıyoruz!
TEXT
,
        ],
        'success'               => 'Serüven yaratıldı.',
        'success_first_time'    => 'Serüveniniz yaratıldı! Bu sizin ilk serüveniniz olduğu için, size başlangıçta yardımcı olacak ve umarız neler yapabileceğinize dair size ilham verecek birkaç şey yarattık.',
        'title'                 => 'Yeni Serüven',
    ],
    'destroy'                           => [
        'success'   => 'Serüven kaldırıldı',
    ],
    'edit'                              => [
        'description'   => 'Serüveninizi düzenleyin',
        'success'       => 'Serüven güncellendi.',
        'title'         => ':campaign Serüvenini Düzenle',
    ],
    'entity_personality_visibilities'   => [
        'private'   => 'Yeni karakterlerin kişilikleri varsayılan olarak özeldir.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Yeni varlıklar özeldir',
    ],
    'errors'                            => [
        'access'        => 'Bu serüvene erişiminiz yok.',
        'unknown_id'    => 'Bilinmeyen Serüven.',
    ],
    'export'                            => [
        'description'   => 'Serüveni dışa aktar.',
        'errors'        => [
            'limit' => 'Günlük maksimum bir dışa akarma hakkınızı tükettiniz. Lütfen yarın tekrar deneyin.',
        ],
        'helper'        => 'Serüveninizi dışa aktarın. Bir indirme linki ile beraber bir bildirim gelecek.',
        'success'       => 'Serüven dışa aktarmanız hazırlanıyor. İndirilebilir bir sıkıştırılmış dosya',
        'title'         => ':name Serüvenini Dışa Aktarma',
    ],
    'fields'                            => [
        'boosted'                       => 'Destekleyen',
        'css'                           => 'CSS',
        'description'                   => 'Açıklama',
        'entity_count'                  => 'Varlık Sayısı',
        'entity_personality_visibility' => 'Karakter Kişiliği Görünürlüğü',
        'entity_visibility'             => 'Varlık Görünürlüğü',
        'excerpt'                       => 'Özet',
        'followers'                     => 'Takipçiler',
        'header_image'                  => 'Başlık Görseli',
        'hide_history'                  => 'Varlık geçmişini gizle',
        'hide_members'                  => 'Serüven üyelerini gizle',
        'image'                         => 'Görsel',
        'locale'                        => 'Dil',
        'name'                          => 'Ad',
        'public_campaign_filters'       => 'Açık Serüven Filtreleri',
        'rpg_system'                    => 'RYO Sistemleri',
        'system'                        => 'Sistem',
        'theme'                         => 'Tema',
        'tooltip_family'                => 'Bilgi çubuklarında aile adlarını engelle.',
        'tooltip_image'                 => 'Bilgi çubuklarında varlık görselini göster',
        'visibility'                    => 'Görünürlük',
    ],
    'following'                         => 'Takip ediyor',
    'helpers'                           => [
        'boost_required'                => 'Bu özellik serüvenin desteklenmesini gerektirir. Daha fazla bilgi :settings sayfasında mevcuttur.',
        'boosted'                       => 'Bazı özelliklerin kilidi bu serüven desteklendiği için açıktır. :settings sayfasında daha fazlasını bulabilirsiniz.',
        'css'                           => 'Serüven sayfalarınızla beraber yüklenecek kendi CSS\'inizi yazın. Lütfen bu özelliğin istismarının özel CSS\'inizin kaldırılmasına yol açabileceğini unutmayın. Sürekli ya da aşırı ağır ihlaller serüveninizin kaldırılmasına yol açabilir.',
        'entity_personality_visibility' => 'Yeni bir karakter yaratırken, "Kişiliği Görünür" seçeneği otomatik olarak seçimi kaldırılmış olarak gelecek.',
        'entity_visibility'             => 'Yeni bir varlık yaratırken, "Özel" seçeneği otomatik olarak işaretlenecek.',
        'excerpt'                       => 'Serüven özeti ana sayfanızda görüntülenecek, o yüzden dünyanızı tanıtan birkaç cümle yazın. En iyi sonuç için kısa tutun.',
        'hide_history'                  => 'Serüvenin yönetici olmayan üyelerinden varlıkların geçmişini saklamak için bu seçeneği aktifleştirin.',
        'hide_members'                  => 'Bu serüvenin serüven üye listesini yönetici olmayan üyelerden saklamak için bu seçeneği aktifleştirin.',
        'locale'                        => 'Serüvenin yazıldığı dil. Bu içerik üretmek ve açık serüvenleri gruplandırmak için kullanılır.',
        'name'                          => 'Serüveniniz/Dünyanız en az 4 harf ya da sayı içerdiği sürece istediğiniz ada sahip olabilir.',
        'public_campaign_filters'       => 'Diğerlerinin serüveninizi diğer serüvenlerin arasında bulabilmesi için aşağıdaki bilgileri doldurun.',
        'system'                        => 'Eğer serüveniniz herkese görünür ise, sistem onu :link sayfasında görüntüler.',
    ],
];
