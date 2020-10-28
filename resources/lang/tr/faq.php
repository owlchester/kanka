<?php

return [
    'app_backup'            => [
        'answer'    => 'Herhangi bir veri kaybını engellemek için günde iki yedekleme yapıyoruz. Kendi serüvenlerimiz bu sunucuda, o yüzden hiçbir risk almak istemiyoruz!',
        'question'  => 'Kanka\'daki veriler ne sıklıkla yedekleniyor?',
    ],
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
Özellik Şemalarını açıklamanın en iyi yolu bir örnek ile olur. Diyelim ki dünyamızda tomarla Konum var, ve bu konumların çoğunda "Nüfus", "İklim" ve "Suç Oranı" için özel bir Özellik yaratmayı hatırlamak istiyorsunuz.

Şimdi, bunu her bir Konuma gidip kolaylıkla ekleyebilirsiniz, ancak bu hızla can ıskıcı olabilir, ve bazen "Suç Oranı" özelliğini yaratmayı unutabilirsiniz. Özellik Şemaları bu noktada devreye giriyor.

Bu özellikleri (Nüfus, İklim, Suç Oranı) içeren bir Özellik Şeması yaratabilir, ve daha sonra bu şemaları o konumlara uygulayabilirsiniz. Bu, şemadaki özellikleri konumlarda yaratacak, böylece tek yapmanız gereken değerleri değiştirmek, özellikleri hatırlamak zorunda kalmak değil!
TEXT
,
        'question'  => 'Özellik Şemaları, nedir bunlar?',
    ],
    'backup'                => [
        'answer'    => 'Günde bir sefer, serüveninizin tüm verilerini bir ZIP dosyası olarak dışa aktarabilirsiniz. Uygulamada, soldaki menüdeki "Serüven" sekmesine tıklayın, ve ardından "Dışa Aktar" seçeneğine tıklayın. Bu dışa aktarılmış veriyi Kanka\'ya geri yükleyemezsiniz, bu yalnızca kendi gönül rahatlığınız ya da olur da uygulamayı daha fazla kullanmayı planlamadığınız durumlar içindir.',
        'question'  => 'Serüvenimi nasıl yedekleyebilir ya da dışa aktarabilirim?',
    ],
    'bugs'                  => [
        'answer'    => ':discord sunucumuza katılın ve hatayı #error-and-bugs kanalına bildirin.',
        'question'  => 'Bir hatayı nasıl bildirebilirim?',
    ],
    'campaign-sync'         => [
        'answer'    => 'Kanka bu özelliğe sahip değil. Ancak, eğer aynı dünyada birden fazla oyun grubu bulundurmaya çalışıyorsanız, onları aynı serüvende farklı bir görevler, etiketler ve izinler kombinasyonu ile birbirlerinden ayırmayı düşünün.',
        'question'  => 'Varlıkları birden fazla serüvende senkronize edebilir miyim?',
    ],
    'conversations'         => [
        'answer'    => 'Muhabbetler Karaktelrer ya da Serüven Üyeleri arasında konuşmalar şeklinde ayarlanabilir. Örneğin eğer önemli bir NPC ile PC\'ler arasındaki bir konuşmayı belgelemek isterseniz, bu modül aracılığı ile bunu yapabilirsiniz. Bunu metin üzerinden oynanan serüvenler için de kullanabilirsiniz.',
        'question'  => 'Muhabbetler nedir?',
    ],
    'custom'                => [
        'answer'    => 'Kanka birbirleri ile etkileşim halinde olan bir grup önceden belirlenmiş varlık türü ile beraber gelir. Özel varlık türlerine izin vermek uygulamayı sıfırdan yeniden inşa etmeyi gerektirir ve bir şeyleri nasıl düzenleyeceğiniz hakkında bir alet yerine önceden belirlenmiş türler ile insanların dünya yaratmasına yardımcı olacak bir alet olma hedefinden sapmasına sebep olur. Dahası, Kanka Etiketler ile çoğu özel varlık türü senaryosunu temsil edebiliecek kadar esnektir.',
        'question'  => 'Özel varlık türleri yaratabilir miyim?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Serüven kontrol panelinize gidin, ve soldaki menüde "Serüven" seçeneğine tıklayın. Bir serüveni "Sil" butonu eğer serüvendeki son üye iseniz ortaya çıkacak. Serüveni silmek sunucularımızdaki tüm verilerinizi, görseller dahil, silecek olan kalıcı bir eylemdir.',
        'question'  => 'Bir serüveni nasıl silebilirim?',
    ],
    'early-access'          => [
        'answer'    => 'Erken Erişim bizim harika abonelerimizi ödüllendirmek için en son modülleri herkesten önce deneyebilmeleri için verdiğimiz 30 günlük bir zaman aralığıdır.',
        'question'  => 'Erken Erişim nedir?',
    ],
    'entity-notes'          => [
        'answer'    => 'Bütün varlıklar \'Varlık Notları\' adında yalnızca sizler tarafından (yan-DMlik yaparken harikadır), yalnızca yönetici rolüne sahip üyeler tarafından, ya da herkes tarafından görüntülenebilecek şekilde ayarlanabilen küçük metin parçalarına sahip bir sekmeye sahiptir. Aynı zamanda oyuncularınıza bütün varlığı düzenleme yetkisi vermek yerine varlık notlarını yaratma ve düzenleme yetkisi verebilirsiniz.',
        'question'  => 'Kanka kısmen saklı bilgileri nasıl idare ediyor?',
    ],
    'fields'                => [
        'answer'    => 'Cevap',
        'category'  => 'Kategori',
        'locale'    => 'Dil',
        'order'     => 'Sıra',
        'question'  => 'Soru',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'
Evet! Finansal durumunuzun RYO'lardan ya da dünya yaratmadan aldığınız zevki azaltmaması gerektiğine şiddetle inanıyoruz ve temel uygulamayı her zaman bedava tutacağız. Ancak, eğer ki bu yolculukta daha aktif bir rol almak istiyorsanız bizi destekleyin ve sizin için daha önemli olan özellikler için oy verin; bunu aboneliklerimiz aracılığı ile yapabilirsiniz.

Kanka'nın alacağı yol hakkında oy vermek dışınca, bizi desteklemek sizlere :boosters erişimiz sağlar, dosya yükleme sınırınızı arttırır, adınızı onur listesine ekler, daha güzel varsayılan ikonları açar, ve daha fazlasını yapar!
TEXT
,
        'question'  => 'Uygulama bedava kalacak mı?',
    ],
    'gods-and-religions'    => [
        'answer'    => 'Tanrıları Karakterler, dinleri de Organizasyonlar olarak yaratmanızı tavsiye ediyoruz. Eğer tanrılarınızı çabucak bulmak istiyorsanız, onları uygun bir Etiket ve/ya tür ile etiketlemenizi tavsiye ediyoruz.',
        'question'  => 'Tanrılar ve dinler nerede yaratılır?',
    ],
    'help'                  => [
        'answer'    => 'Öncelikle, yardım etmeyi istediğiniz için teşekkür ederiz! Her zaman çeviriler hakkında yardım edebilecek, yeni özellikleri test edecek, ya da yeni kullanıcılara yardım edebilecek kişileri arıyoruz. Aynı zamanda insanlar Kanka\'yı bizim aklımıza gelmeyen yerlerde tanıtan insanları da çok seviyoruz. Elinizden gelen en iyi yol bize yardım edebileceğiniz kanalların olduğu :discord sunucumuzda bize katılmanız.',
        'question'  => 'Nasıl yardım edebilirim?',
    ],
    'map'                   => [
        'answer'    => 'Haritalar modülü PNG, JPG, ve SVG dosya türlerini destekliyor. bu haritalar katmanlar, gruplar ve serüvendeki diğer varlıklara yönlendiren pek çok farklı boyda ve şekilde işaretlere sahip olabilir',
        'question'  => 'Kanka\'ya haritalar yükleyebilir miyim?',
    ],
    'mobile'                => [
        'answer'    => 'Kanka için özel bir mobil uygulama mevcut değil, ancak uygulamanın büyük kısmı bir mobil cihazda çalışıyor. Umuyoruz ki aboneliklerden gelen destek günün birinde birine bir mobil uygulama geliştirmesi için gereken parayı ödememize olanak sağlayacak, ancak bunun yakın gelecekte olacağını öngörmüyoruz.',
        'question'  => 'Mobil bir uygulama var mı? Planlanıyor mu?',
    ],
    'monsters'              => [
        'answer'    => 'Irklar modülünü halklar, türler, canavarlar, ve bir karakter olmayan her türlü yaşayan şey için kulllanmanızı tavsiye ediyoruz.',
        'question'  => 'Canavarlar nerede yaratılır?',
    ],
    'multiworld'            => [
        'answer'    => 'İstediğiniz kadar serüvene dahil olabilirsiniz, sizin yarattıklarınız da dahil. Yeni bir serüvene katılmak ya da serüveni değiştirmek için serüven kontrol panelinize gidin ve sağ üstte mevcut serüveninize tıklayarak serüven değiştirme arayüzünü görüntüleyin.',
        'question'  => 'Birden fazla serüvene sahip olabilir miyim?',
    ],
    'nested'                => [
        'answer'    => 'Eğer varlıklarınızı varsayılan olarak iç içe görüntülemeyi tercih ediyorsanız (örneğin konumlar listesindeki İç İçe Görünüm butonu), Proflinize ve orada Düzen sekmesine giderek bunu yapabilirsiniz. Bu yalnızca sizin hesabınız içindir, serüvenleriniz için değil.',
        'question'  => 'Listeler varsayılan olarak iç içe olacak şekilde ayarlanabilir mi?',
    ],
    'organise_play'         => [
        'answer'    => 'Grubunuz ile yaptığınız oturumları organize etmenize olanak sağlayan :lfgm ile ortaklık kurduk. Boş olduğunuz aralıkları doğrudan serüven kontrol panelinde görüntülemek için Kanka serüveninizi LFGM serüveniniz ile senkronize edebilirsiniz',
        'question'  => 'Oturumlarımı oynatırken nasıl düzenleme yapabilirim?',
    ],
    'permissions'           => [
        'answer'    => 'Elbette, Kanka\'yı bu yüzden yarattık! Tüm oyuncularınızı serüveninize davet edebilir ve onlara roller ve izinler verebilirsiniz. Sistemi olabildiğince fazla ihtiyaç ve durumu karşılayabilecek, son derece esnek olacak şekilde (hem dahil olunabilir hem de dışarıda aklınabilir konfigürasyonunu kullanabilirsiniz) yarattık.',
        'question'  => 'Oyuncularımın serüvenimde gördükleri bilgi miktarını kısıtlayabilir miyim?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
Kanka için uzun dönem planımız içeriği topluluk tarafından "Topluluk Şemaları" aracılığı ile yönetilen sistem çekmser bir dünya yaratma ve serüven yönetimi aracı yaratmak. Başka bir hedefimiz ise Sanal Masa Üstü uygulamaları gibi diğer platformlar ile entegre çalışan araçlar yaratmak.

Kanka'yı biz kendimiz de kullanıyoruz, bu yüzden onu geliştirmeyi ve ilerletmeyi durdurmak gibi bir planımız hiç olmadı. Ancak, sırf güvende olmak için, proje aynı zamanda açık kaynak ve eğer başımıza bir şey gelirse topluluk tarafından üstünde çalışılabilir.
TEXT
,
        'question'  => 'Uzun dönem planlarınız nedir?',
    ],
    'public-campaigns'      => [
        'answer'    => ':public-campaigns sayfasına igdip diğerlerinin Kanka\'yı serüvenleri için nasıl kullandığını görebilirsiniz.',
        'question'  => 'Diğerleri Kanka\'yı nasıl kullanıyor?',
    ],
    'renaming-modules'      => [
        'answer'    => 'Bunu İngilizce ve cinsiyetli isimler kullanmayan diller için yapmak kolay olacak olsa da, modüllerin adlarını değiştirebilmek dilbilgisel doğruluğu ve Kanka\'nın mevcut olduğu dillerin çoğunluğunda kullanıcı deneyimini bozar.',
        'question'  => 'Modüllerin adını değiştirebilir miyim? Örneğin Aileleri Klanlara ya da Organizasyonları Fraksiyonlara?',
    ],
    'sections'              => [
        'community'     => 'Topluluk',
        'general'       => 'Genel',
        'other'         => 'Diğer',
        'permissions'   => 'İzinler',
        'pricing'       => 'Fiyatlandırma',
        'worldbuilding' => 'Dünya Yaratma',
    ],
    'show'                  => [
        'return'    => 'SSS\'e Geri Dön',
        'timestamp' => 'Son güncelleme :date',
        'title'     => ':name SSS',
    ],
    'user-switch'           => [
        'answer'    => 'İzinler incelik ister, özellikle büyük serüvenlerde. Serüven yöneticisi olarak, serüveninizin üyeler sayfasına gidebilir ve yönetici olmayan kullanıcıların yanında beliren "Değiş" butonuna tıklayabilirsiniz. Bu sizi o kullanıcı olarak giriş yapmanızı ve serüveni onların gözünden görmenize olanak sağlar. Serüveninizin izinlerini kontrol etmenin en kolay yolu budur.',
        'question'  => 'Serüvenimin izinleri ayarlandı, onları nasıl test edebilirim?',
    ],
    'visibility'            => [
        'answer'    => 'Yalnızca serüveninize davet ettiğiniz kişiler yarattıklarını görebilir ve onlarla etkileşim kurabilir. Verileriniz kişiye özeldir ve her zaman sizin kontrolünüzdedir. Aynı zamanda serüveninizi kayıtlı olmayan kullanıcıların da görüntüleyebilmesi için herkese açık olarak ayarlayabilirsiniz.',
        'question'  => 'Herkes dünyamı görebilir mi?',
    ],
];
