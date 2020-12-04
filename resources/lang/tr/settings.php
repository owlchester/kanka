<?php

return [
    'account'       => [
        'actions'           => [
            'social'            => 'Kanka Girişine Geç',
            'update_email'      => 'E-posta güncelle',
            'update_password'   => 'Şifre güncelle',
        ],
        'email'             => 'E-posta değiştir.',
        'email_success'     => 'E-posta güncellendi.',
        'password'          => 'Şifre değiştir',
        'password_success'  => 'Şifre güncellendi.',
        'social'            => [
            'error'     => 'Bu hesap için halihazırda Kanka Girişi kullanıyorsunuz.',
            'helper'    => 'Hesabınız şu anda :provider tarafından yönetiliyor. Bir şifre belirleyerek onu kullanmayı bırakıp standart Kanka girişini kullanmaya başlayabilirsiniz.',
            'success'   => 'Hesabınız artık Kanka girişini kullanıyor.',
            'title'     => 'Sosyal Medya\'dan Kanka\'ya',
        ],
        'title'             => 'Hesap',
    ],
    'api'           => [
        'experimental'          => 'Kanka API\'larına hoşgeldiniz! Bu özellikler hala deneysel ancak sizin API\'lar ile bağ kurmanıza yetecek kadar stabil olmalılar. Kendi API istekleriniz için Şahsi Erişim Tokeni oluşturun, ya da uygulanmanızın kullanıcı verisine erişimi olması için İstemci tokeni oluşturun.',
        'help'                  => 'Kanka yakın zamanda üçüncü parti uygulamaların uygulamaya bağlanabilmesi için bir RESTful API sağlayacak. API anahtarlarınızı nasıl yöneteceğinizin detayları aşağıda gösterilecek.',
        'link'                  => 'API dokümentasyonunu okuyun',
        'request_permission'    => 'Şu anda üçüncü parti uygulamalar uygulamaya bağlanabilsin diye güçlü bir RESTful API oluşturuyoruz. Ancak, biz API altyapısını düzenlerken, şu anda API ile etkileşebilecek kullanıcıların sayısını sınırlıyoruz. Eğer API erişimi kazanmak ve Kanka ile konuşan havalı uygulamalar yaratmak istiyorsanız, lütfen bizimle iletişime geçin ve biz de size ihtiyacınız olan tüm bilgiyi sağlayalım.',
        'title'                 => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Bağla',
            'remove'    => 'Kaldır',
        ],
        'benefits'  => 'Kanka üçüncü parti hizmetlere bazı entegrasyonlar sağlar. Daha fazla entegrasyon gelecek için planlanmıştır.',
        'discord'   => [
            'errors'    => [
                'add'   => 'Discord hesabınızı Kanka ile bağlarken bir hata meydana geldi. Lütfen tekrar deneyin.',
            ],
            'success'   => [
                'add'       => 'Discord hesabınız bağlandı.',
                'remove'    => 'Discord hesabınızın bağlantısı kesildi.',
            ],
            'text'      => 'Abonelik rollerinize otomatik olarak erişin.',
        ],
        'title'     => 'Uygulama Entegrasyonu',
    ],
    'boost'         => [
        'benefits'      => [
            'campaign_gallery'  => 'Serüven süresince tekrar tekrar kullanabileceğiniz görsellerle dolu bir serüven galerisi.',
            'entity_files'      => 'Varlık başına 10 dosyaya kadar karşıya yükleyin.',
            'entity_logs'       => 'Bir varlığa yapılan her bir güncelleme ile varlıkta neyin değiştiğini gösteren tam değişiklik listeleri.',
            'first'             => 'Kanka\'da sürekli ilerlemenin güvence altına alınması için, bazı serüven özelliklerinin kilidi yalnızca bir serüveni destekleyerek açılır. Destekler abonelikler aracılığı ile açılır. Bir serüveni görüntüleyebilen herhangi biri serüveni destekleyebilir, böylece hesap yalnızca DM\'e kilitlenmemiş olur. Bir serüven bir kullanıcı onu desteklediği ve kullanıcı Kanka\'yı desteklediği sürece destekli kalır. Eğer bir serüven artık destekli değilse, veri kaybolmaz, yalnızca serüven tekrar desteklenene kadar saklı kalır.',
            'header'            => 'Varlık kapak görselleri.',
            'images'            => 'Özel varsayılan varlık görselleri.',
            'more'              => 'Bütün özellikler hakkında daha fazla bilgi edinin.',
            'second'            => 'Bir serüveni desteklemek aşağıdaki faydaları sağlar:',
            'superboost'        => 'Bir serüveni süperdesteklemek 3 desteğinizin tamamını harcar ve destekli serüvenlerin üstüne ek özelliklerin de kilidini açar.',
            'theme'             => 'Serüven seviyesinde tema ve özel tasarım.',
            'third'             => 'Bir serüveni desteklemek için, serüvenin sayfasına gidin, ve ":edit_button" butonunun üstündeki ":boost_button" butonuna tıklayın.',
            'tooltip'           => 'Varlıklar için özel bilgi çubukları',
            'upload'            => 'Serüvendeki her bir üye için arttırılmış karşıya yükleme boyut limiti.',
        ],
        'buttons'       => [
            'boost'         => 'Destek',
            'superboost'    => 'Süperdestek',
            'tooltips'      => [
                'boost'         => 'Bir serüveni desteklemek desteklerinizin :amount kadarını kullanır.',
                'superboost'    => 'Bir serüveni süperdesteklemek desteklerinizin :amount kadarını kullanır.',
            ],
        ],
        'campaigns'     => 'Desteklenen Serüvenler :count / :max',
        'exceptions'    => [
            'already_boosted'       => ':name serüveni zaten desteklenmiş.',
            'exhausted_boosts'      => 'Verecek desteğiniz kalmadı. Bir başka serüveni desteklemeden önce desteklerinizden birini kaldırın.',
            'exhausted_superboosts' => 'Desteğiniz tükenmiş. Bir serüveni süperdesteklemek için 3 desteğe ihtiyacınız var.',
        ],
        'success'       => [
            'boost'         => ':name serüveni desteklendi.',
            'delete'        => ':name serüveninden destek kaldırıldı.',
            'superboost'    => ':name serüveni süperdesteklendi.',
        ],
        'title'         => 'Destek',
    ],
    'countries'     => [
        'austria'       => 'Avusturya',
        'belgium'       => 'Belçika',
        'france'        => 'Fransa',
        'germany'       => 'Almanya',
        'italy'         => 'İtalya',
        'netherlands'   => 'Hollanda',
        'spain'         => 'İspanya',
    ],
    'invoices'      => [
        'actions'   => [
            'download'  => 'PDF Olarak İndir',
            'view_all'  => 'Hepsini görüntüle',
        ],
        'empty'     => 'Fatura yok',
        'fields'    => [
            'amount'    => 'Tutar',
            'date'      => 'Tarih',
            'invoice'   => 'Fatura',
            'status'    => 'Durum',
        ],
        'header'    => 'Aşağıda indirebileceğiniz son 24 faturanızın bir listesi mevcuttur.',
        'status'    => [
            'paid'      => 'Ödendi',
            'pending'   => 'Beklemede',
        ],
        'title'     => 'Faturalar',
    ],
    'layout'        => [
        'success'   => 'Düzen seçenekleri güncellendi.',
        'title'     => 'Düzen',
    ],
    'marketplace'   => [
        'fields'    => [
            'name'  => 'Market Adı',
        ],
        'helper'    => 'Varsayılan olarak :marketplace üzerinde sizin kullanıcı adınız gösterilir. Bu alanda bu değeri değiştirebilirsiniz.',
        'title'     => 'Market Seçenekleri',
        'update'    => 'Market seçenekleri kaydedildi.',
    ],
    'menu'          => [
        'account'               => 'Hesap',
        'api'                   => 'API',
        'apps'                  => 'Uygulamalar',
        'billing'               => 'Ödeme Yöntemi',
        'boost'                 => 'Destek',
        'invoices'              => 'Faturalar',
        'layout'                => 'Düzen',
        'marketplace'           => 'Market',
        'other'                 => 'Diğer',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Ödeme Seçenekleri',
        'personal_settings'     => 'Kişisel Seçenekler',
        'profile'               => 'Profil',
        'subscription'          => 'Abonelik',
        'subscription_status'   => 'Abonelik Durumu',
    ],
    'patreon'       => [
        'actions'           => [
            'link'  => 'Hesabı Bağla',
            'view'  => 'Kanka\'yı Patreon\'da Görüntüle',
        ],
        'benefits'          => 'Bizi :patreon üzerinde desteklemek sizin ve serüvenleriniz için her türlü :features kilidini açar, ve Kanka\'nın üstünde çalışmak ve onu geliştirmek için daha fazla zaman geçirmemize yardımcı olur.',
        'benefits_features' => 'harika özellikler',
        'deprecated'        => 'Artık kullanılmayan özellik - eğer Kanka\'yı desteklemek istiyorsanız, lütfen bunu :subscription ile yapın. Patreon bağlama biz Patreon\'dan ayrılmadan önce hesaplarını bağlamış Patron\'lar için hala aktiftir.',
        'description'       => 'Patreon ile Senkronizasyon',
        'linked'            => 'Kanka\'yı Patreon\'da desteklediğiniz için teşekkür ederiz! Hesabınız bağlandı.',
        'pledge'            => ':name vaadi',
        'remove'            => [
            'button'    => 'Patreon hesabınızın bağlantısını kesin.',
            'success'   => 'Patreon hesabınızın bağlantısı kesildi.',
            'text'      => 'Patreon hesabınızın Kanka ile bağını koparmak bonuslarınızı, onur duvarından adınızı, serüven destekleriniz, ve Kanka\'yı desteklemek ile alakalı diğer özelliklerinizi kaldırır. Destekli hiçbir içeriğiniz kaybolmaz (örn. varlık kapakları). Tekrar abone olarak önceki serüvenlerinizi desteklemek dahil olmak üzere önceki verilerinizin tamamına erişim kazanacaksınız.',
            'title'     => 'Patreon hesabınızın Kanka ile olan bağını koparın.',
        ],
        'success'           => 'Kanka\'yı Patreon\'da desteklediğiniz için teşekkür ederiz!',
        'title'             => 'Patreon',
        'wrong_pledge'      => 'Vaat seviyeniz bizim tarafımızdan elle ayarlanmıştır, bundan ötürü lütfen bize doğru şekilde ayarlamamız için birkaç güne kadar zaman tanıyın. Eğer bir süre boyunca yanlış kalırsa, lütfen bizimle iletişime geçin.',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Profili güncelle',
        ],
        'avatar'    => 'Profil Resmi',
        'success'   => 'Profil güncellendi.',
        'title'     => 'Kişisel Profil',
    ],
    'subscription'  => [
        'actions'   => [
            'cancel_sub'        => 'Aboneliği iptal et',
            'subscribe'         => 'Abone Ol',
            'update_currency'   => 'Tercih edilen kuru kaydet.',
        ],
        'benefits'  => 'Bizi destekleyerek bazı yeni :features açabilir ve Kanka\'yı geliştirmek için daha fazla zaman ayırmamıza yardımcı olabilirsiniz. Sunucularımızda hiçbir kredi kartı bilgisi saklanmaz ya da üzerinden geçer. Bütün faturalandırma hizmetlerimiz için :stripe kullanıyoruz.',
        'billing'   => [
            'helper'    => 'Faturalandırma bilgileriniz :stripe tarafından işlenir güvenle korunur. Bu ödeme yöntemi bütün abonelikleriniz için kullanılır.',
            'saved'     => 'Kaydedilen ödeme yöntemi',
            'title'     => 'Ödeme Yöntemini Düzenle',
        ],
        'cancel'    => [
            'text'  => 'Gittiğinizi görmek üzücü! Aboneliğinizi iptal etmek aboneliğinizi bir sonraki faturalandırma dönemine kadar aktif tutacaktır, bundan itibaren serüven desteklerinizi ve Kanka\'yı desteklemek ile beraber gelen diğer faydaları kaybedeceksiniz. Neyi daha iyi yapabileceğimiz ya da kararınızı neyin etkilediği hakkında bizi bilgilendirebileceğiniz, aşağıdaki formu doldurmaktan lütfen çekinmeyin.',
        ],
        'cancelled' => 'Aboneliğiniz iptal edildi. Mevcut aboneliğiniz bittikten sonra aboneliğinizi yenileyebilirsiniz.',
        'change'    => [
            'text'  => [
                'monthly'   => 'Her ay :amount karşılığında :tier seviyesinde abonesiniz.',
                'yearly'    => 'Her yıl :amount karşılığında :tier seviyesinde abonesiniz.',
            ],
            'title' => 'Abonelik Seviyesini Değiştir',
        ],
        'currencies'=> [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'  => [
            'title' => 'Tercih edilen faturalandırılma kurunuzu seçin.',
        ],
        'errors'    => [
            'callback'      => 'Ödeme sağlayıcımız bir hata bildirdi. Lütfen tekrar deneyin ya da sorun tekrar ediyorsa bizimle iletişime geçin.',
            'subscribed'    => 'Aboneliğiniz işlenemedi. Stripe aşağıdaki ipucunu bıraktı.',
        ],
        'fields'    => [
            'active_since'      => 'Tarihinden beri aktif',
            'active_until'      => 'Tarihine kadar aktif',
            'billing'           => 'Faturalandırma',
            'currency'          => 'Faturalandırma Kuru',
            'payment_method'    => 'Ödeme yöntemi',
            'plan'              => 'Mevcut plan',
            'reason'            => 'Sebep',
        ],
    ],
];
