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
        'success'   => 'Serüven güncellendi.',
        'title'     => ':campaign Serüvenini Düzenle',
    ],
    'entity_personality_visibilities'   => [
        'private'   => 'Yeni karakterlerin kişilikleri varsayılan olarak özeldir.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Yeni varlıklar özeldir',
    ],
    'errors'                            => [
        'access'        => 'Bu serüvene erişiminiz yok.',
        'superboosted'  => 'Bu özellik yalnızca süperdesteklenmiş serüvenler için mevcuttur.',
        'unknown_id'    => 'Bilinmeyen Serüven.',
    ],
    'export'                            => [
        'errors'    => [
            'limit' => 'Günlük maksimum bir dışa akarma hakkınızı tükettiniz. Lütfen yarın tekrar deneyin.',
        ],
        'helper'    => 'Serüveninizi dışa aktarın. Bir indirme linki ile beraber bir bildirim gelecek.',
        'success'   => 'Serüven dışa aktarmanız hazırlanıyor. İndirilebilir bir sıkıştırılmış dosya',
        'title'     => ':name Serüvenini Dışa Aktarma',
    ],
    'fields'                            => [
        'boosted'                   => 'Destekleyen',
        'css'                       => 'CSS',
        'description'               => 'Açıklama',
        'entity_count'              => 'Varlık Sayısı',
        'excerpt'                   => 'Özet',
        'followers'                 => 'Takipçiler',
        'header_image'              => 'Başlık Görseli',
        'image'                     => 'Görsel',
        'locale'                    => 'Dil',
        'name'                      => 'Ad',
        'public_campaign_filters'   => 'Açık Serüven Filtreleri',
        'rpg_system'                => 'RYO Sistemleri',
        'system'                    => 'Sistem',
        'theme'                     => 'Tema',
        'visibility'                => 'Görünürlük',
    ],
    'following'                         => 'Takip ediyor',
    'helpers'                           => [
        'boost_required'            => 'Bu özellik serüvenin desteklenmesini gerektirir. Daha fazla bilgi :settings sayfasında mevcuttur.',
        'boosted'                   => 'Bazı özelliklerin kilidi bu serüven desteklendiği için açıktır. :settings sayfasında daha fazlasını bulabilirsiniz.',
        'css'                       => 'Serüven sayfalarınızla beraber yüklenecek kendi CSS\'inizi yazın. Lütfen bu özelliğin istismarının özel CSS\'inizin kaldırılmasına yol açabileceğini unutmayın. Sürekli ya da aşırı ağır ihlaller serüveninizin kaldırılmasına yol açabilir.',
        'excerpt'                   => 'Serüven özeti ana sayfanızda görüntülenecek, o yüzden dünyanızı tanıtan birkaç cümle yazın. En iyi sonuç için kısa tutun.',
        'hide_history'              => 'Serüvenin yönetici olmayan üyelerinden varlıkların geçmişini saklamak için bu seçeneği aktifleştirin.',
        'hide_members'              => 'Bu serüvenin serüven üye listesini yönetici olmayan üyelerden saklamak için bu seçeneği aktifleştirin.',
        'locale'                    => 'Serüvenin yazıldığı dil. Bu içerik üretmek ve açık serüvenleri gruplandırmak için kullanılır.',
        'name'                      => 'Serüveniniz/Dünyanız en az 4 harf ya da sayı içerdiği sürece istediğiniz ada sahip olabilir.',
        'public_campaign_filters'   => 'Diğerlerinin serüveninizi diğer serüvenlerin arasında bulabilmesi için aşağıdaki bilgileri doldurun.',
        'system'                    => 'Eğer serüveniniz herkese görünür ise, sistem onu :link sayfasında görüntüler.',
        'systems'                   => 'Kullanıcıları seçeneklerle boğmamak için Kanka\'nın bazı özellikleri sadece belirli RYO sistemleri ile beraber (örn. D&D 5e canavar kağıtları) mevcuttur. Desteklenen sistemler eklemek bu özellikleri devreye sokar.',
        'theme'                     => 'Serüven için bir kullanıcının seçeneği yerine bir temayı zorunlu tutun.',
        'view_public'               => 'Serüveninizi dışarıdan bir kullanıcının gözünden görmek için :link linkini gizli sekmede açın.',
        'visibility'                => 'Bir serüveni açık yapmak linkine sahip olan herkesin onu görebileceği anlamına gelir.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Yeni Serüven',
            ],
        ],
        'title'     => 'Serüven',
    ],
    'invites'                           => [
        'actions'               => [
            'add'   => 'Davet Et',
            'copy'  => 'Linki panoya kopyala',
            'link'  => 'Yeni Link',
        ],
        'create'                => [
            'success'   => 'Davet gönderildi.',
            'title'     => 'Birini serüveninize davet edin',
        ],
        'destroy'               => [
            'success'   => 'Davet kaldırıldı.',
        ],
        'email'                 => [
            'subject'   => ':name sizi kanka.io\'daki \':campaign\' serüvenine katılmanız için davet etti! Kabul etmek için aşağıdaki linke tıklayın.',
            'title'     => ':name tarafından davet',
        ],
        'error'                 => [
            'already_member'    => 'Zaten bu serüvenin bir üyesisiniz.',
            'inactive_token'    => 'Bu token zaten kullanıldı, ya da serüven artık mevcut değil.',
            'invalid_token'     => 'Bu token artık geçerli değil.',
            'login'             => 'Bu serüvene katılmak için lüften giriş yapın ya da kaydolun.',
        ],
        'fields'                => [
            'created'   => 'Gönderildi',
            'email'     => 'E-posta',
            'role'      => 'Rol',
            'type'      => 'Tür',
        ],
        'helpers'               => [
            'email'     => 'E-postalarımız sık sık spam olarak işaretlenir ve gelen kutunuzda belirmesi birkaç saati bulabilir.',
            'validity'  => 'Bu link geçersiz kılınana kadar kaç tane kullanıcının bu linki kullanabileceği. Sınırsız olması için boş bırakın.',
        ],
        'placeholders'          => [
            'email' => 'Davet etmek istediğiniz kişinin e-posta adresi',
        ],
        'types'                 => [
            'email' => 'E-posta',
            'link'  => 'Link',
        ],
        'unlimited_validity'    => 'Sınırsız',
    ],
    'leave'                             => [
        'confirm'   => ':name serüveninden ayrılmak istediğinize emin misiniz? Bir Yönetici sizi tekrar davet edene kadar serüvene tekrar erişemeyeceksiniz.',
        'error'     => 'Serüvenden ayrılma başarısız.',
        'success'   => 'Serüvenden ayrıldınız.',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'Geçiş yap',
            'switch-back'   => 'Kullanıcıma geri dön',
        ],
        'create'                => [
            'title' => 'Serüveninize bir üye ekleyin',
        ],
        'edit'                  => [
            'title' => ':name üyesini düzenle',
        ],
        'fields'                => [
            'joined'        => 'Katıldı',
            'last_login'    => 'Son Giriş',
            'name'          => 'Kullanıcı',
            'role'          => 'Rol',
            'roles'         => 'Roller',
        ],
        'help'                  => 'Serüvenler sınırsız sayıda üyeye sahip olabilir.',
        'helpers'               => [
            'admin' => 'Serüvenin yönetici rolüne sahip bir üyesi olarak yeni üyeler davet edebilir, inaktif olanları kaldırabilir, ve yetkilerini değiştirebilirsiniz. Bir üyenin yetkilerini test etmek için Geçiş yap butonunu kullanın. Bu özellik hakkında daha fazla bilgiye :link sayfasından erişebilirsiniz.',
            'switch'=> 'Bu kullanıcıya geçiş yap',
        ],
        'impersonating'         => [
            'message'   => 'Serüveni başka bir kullanıcı olarak görüntülüyorsunuz. Bazı özellikler devre dışı bırakıldı, ancak geri kalanı kullanıcının göreceği ile aynı. Kendi kullanıcınıza geri dönmek için normalde Çıkış Yap butonunun yerinde olan Geri Dön butonunu tıklayın.',
            'title'     => ':name kılığındasınız',
        ],
        'invite'                => [
            'description'   => 'Dostlarınızı serüveninize Davet Linki aracılığı ile davet edebilirsiniz. Davetinizi kabul ettiklerinde, istenen rolde bir üye olarak eklenecekler. Onlara davet isteğinizi Hotmail adresi olmadığı sürece e-posta ile gönderebilirsiniz, zira onlar Kanka\'nın e-postalarını her zaman engelliyor.',
            'more'          => ':link sayfasında daha fazla rol ekleyebilirsiniz.',
            'roles_page'    => 'Roller sayfası',
            'title'         => 'Davet Et',
        ],
        'roles'                 => [
            'member'    => 'Üye',
            'owner'     => 'Yönetici',
            'player'    => 'Oyuncu',
            'public'    => 'Genel',
            'viewer'    => 'Seyirci',
        ],
        'switch_back_success'   => 'Artık tekrar orijinal kullanıcınızdasınız.',
        'title'                 => ':name Serüveni Üyeleri',
        'your_role'             => 'Rolünüz: <i>:role</i>',
    ],
    'panels'                            => [
        'boosted'   => 'Destekli',
        'dashboard' => 'Kontrol Paneli',
        'permission'=> 'İzin',
        'sharing'   => 'Paylaşım',
        'systems'   => 'Sistemler',
        'ui'        => 'Arayüz',
    ],
    'placeholders'                      => [
        'description'   => 'Serüveninizin kısa bir özeti',
        'locale'        => 'Dil kodu',
        'name'          => 'Serüveninizin adı',
        'system'        => 'D&D, Pathfinder, Fate, DSA',
    ],
    'roles'                             => [
        'actions'       => [
            'add'   => 'Bir rol ekleyin',
        ],
        'create'        => [
            'success'   => 'Rol yaratıldı.',
            'title'     => ':name için bir rol yarat',
        ],
        'destroy'       => [
            'success'   => 'Rol kaldırıldı',
        ],
        'edit'          => [
            'success'   => 'Rol güncellendi.',
            'title'     => ':name Rolünü Düzenle',
        ],
        'fields'        => [
            'name'          => 'Ad',
            'permissions'   => 'İzinler',
            'type'          => 'Tür',
            'users'         => 'Kullanıcılar',
        ],
        'helper'        => [
            '1' => 'Bir serüven istediğiniz kadar fazla role sahip olabilir. "Yönetici" rolünün otomatik olarak serüvendeki her şeye erişimi vardır, ancak diğer her rol değişik varlık türlerinde (karakter, konum, vs.) özel izinlere sahip olabilir.',
            '2' => 'Varlıklar varlığın "İzinler" sekmesi aracılığı ile daha ince ayarlı izinlere sahip olabilir. Bu sekme serüveninizde birkaç rol ya da üye olduğu zaman ortaya çıkar.',
            '3' => 'Rollerin tüm varlıkları görüntüleme yetkisinin olduğu, ve sizin varlıklardaki "Özel" kutucuğunu onları saklamak için kullandığınız bir "dışta kalma" sistemi ile işinizi yürütebilirsiniz. Ya da rollere fazla izin vermeyebilir, ama her bir varlığı bireysel olarak görünür olacak şekilde ayarlayabilirsiniz.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'Açık rolü izinlere sahip ancak serüven özel. Bu ayarı serüveni düzenlerken Paylaşım sekmesinden değiştirebilirsiniz.',
            'public'                => 'Açık rolü birisi sizin açık serüveninize bakarken kullanılır. :more',
            'role_permissions'      => '\':name\' rolüne aşağıdaki eylemleri yapabilme yetkisi verin.',
        ],
        'members'       => 'Üyeler',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Yarat',
                'delete'        => 'Kaldır',
                'edit'          => 'Düzenle',
                'entity-note'   => 'Varlık Notu',
                'permission'    => 'İzinler',
                'read'          => 'Görünüm',
                'toggle'        => 'Herkes için değiştir',
            ],
            'helpers'   => [
                'entity_note'   => 'Bu, bir Varlık için Düzenle yetkisine sahip olmayan kullanıcıların da Varlıklara Varlık Notu eklemelerine izin verir.',
            ],
            'hint'      => 'Bu rol otomatik olarak her şeye erişim sahibidir.',
        ],
        'placeholders'  => [
            'name'  => 'Rolün adı',
        ],
        'show'          => [
            'title' => '\':name\' Serüven Rolü',
        ],
        'title'         => ':name Serüveni Rolleri',
        'types'         => [
            'owner'     => 'Yönetici',
            'public'    => 'Açık',
            'standard'  => 'Standart',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Bir üye ekle',
            ],
            'create'    => [
                'success'   => 'Kullanıcı role eklendi.',
                'title'     => ':name rolüne bir kullanıcı ekle',
            ],
            'destroy'   => [
                'success'   => 'Kullanıcı rolden kaldırıldı.',
            ],
            'fields'    => [
                'name'  => 'Ad',
            ],
        ],
    ],
    'settings'                          => [
        'actions'   => [
            'enable'    => 'Etkinleştir',
        ],
        'boosted'   => 'Bu özellik şu anda erken erişimde ve yalnızca :boosted aracılığı ile mevcut.',
        'edit'      => [
            'success'   => 'Serüven seçenekleri güncellendi.',
        ],
        'helper'    => 'Bir serüvenin tüm modülleri istediğiniz zaman etkinletirilebilir ya da devre dışı bırakılabilir. Bir modülü devre dışı bırakmak onunla alakalı bütün arayüz ögelerini saklar, ve halihazırda mevcut varlıklar ileride fikrinizi değiştirmeniz durumuna karşı arka planda varlıklarını korur ama saklanır. Bu değişiklikler serüveninizin tüm üyelerini, Yöneticiler dahil olmak üzere, etkiler.',
        'helpers'   => [
            'abilities'     => 'Varlıklara atayabileceğiniz yetenekler oluşturun; hünerler, büyüler, ya da güçler gibi.',
            'calendars'     => 'Dünyanızın takvimlerini tanımlayabileceğiniz bir yer.',
            'characters'    => 'Dünyanızda yaşayan kişiler.',
            'conversations' => 'Karakterler ya da serüven kullanıcı arasındaki hayali konuşmalar. Bu modül kullanım dışıdır.',
            'dice_rolls'    => 'Kanka\'yı RYO serüvenleri için kullananlar için, zar atışlarını halletmenin bir yolu. Bu modül kullanım dışıdır.',
            'events'        => 'Tatiller, festivaller, felaketler, doğum günleri, savaşlar.',
            'families'      => 'Klanlar ya da aileler, ilişkileri ve üyeleri.',
            'items'         => 'Silahlar, araçlar, yadigârlar, iksirler.',
            'journals'      => 'Karakterler tarafından yapılan yazılı gözlemler, ya da zindan efendisi için oturum notları.',
            'locations'     => 'Gezegenler, düzlemler, kıtalar, nehirler, eyaletler, yerleşkeler, tapınaklar, hanlar.',
            'maps'          => 'Katmanları ve serüvenin diğer varlıklarına yönlendiren işaretleri olan haritalar yükleyin.',
            'menu_links'    => 'Yan çubukta gösterilecek özel menü linkleri.',
            'notes'         => 'İlim, din, tarih, sihir, ırklar.',
            'organisations' => 'Kültler, askeri birimler, gruplar, loncalar.',
            'quests'        => 'Karakterleri ve konumları ile bir çok görevi takip etmek için.',
            'races'         => 'Eğer serüveninizde birden fazla ırk varsa, bu onları takip etmeyi kolaylaştıracak.',
            'tags'          => 'Her bir varlık birden fazla etikete sahip olabilir. Etiketler diğer etiketlere ait olabilir, ve varlıklar etiketlerine göre filtrelenebilir.',
            'timelines'     => 'Dünyanızın tarihçesini zaman çizgileri ile temsil edin.',
        ],
        'title'     => ':name Serüven Modülleri',
    ],
    'show'                              => [
        'actions'   => [
            'boost' => 'Serüveni destekle',
            'edit'  => 'Serüveni Düzenle',
            'leave' => 'Serüvenden ayrıl',
        ],
        'tabs'      => [
            'achievements'      => 'Başarımlar',
            'default-images'    => 'Varsayılan Görseller',
            'export'            => 'Dışa Aktar',
            'information'       => 'Bilgi',
            'members'           => 'Üyeler',
            'plugins'           => 'Eklentiler',
            'recovery'          => 'Kurtarma',
            'roles'             => 'Roller',
            'settings'          => 'Modüller',
        ],
        'title'     => ':name Serüveni',
    ],
    'superboosted'                      => [
        'gallery'   => [
            'error' => [
                'text'  => 'Metin düzenleyicide görsel yükleme yalnızca :superboosted serüvenler için mevcut bir özelliktir.',
                'title' => 'Serüven Galerisi Görsel Yükleme',
            ],
        ],
    ],
    'ui'                                => [],
    'visibilities'                      => [
        'private'   => 'Özel',
        'public'    => 'Açık',
        'review'    => 'İnceleme Bekliyor',
    ],
];
