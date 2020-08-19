<?php

return [
    'account'       => [
        'actions'           => [
            'social'            => 'Kanka bejelentkezésre váltás',
            'update_email'      => 'E-mail megváltoztatása',
            'update_password'   => 'Jelszó megváltoztatása',
        ],
        'description'       => 'Fiók szerkesztése',
        'email'             => 'Email-cím megváltoztatása',
        'email_success'     => 'Az email-címet sikeresen megváltoztattuk',
        'password'          => 'Jelszó megváltoztatása',
        'password_success'  => 'A jelszót sikeresen megváltoztattuk',
        'social'            => [
            'error'     => 'Ehhez a fiókhoz már Kanka bejelentkezést használsz.',
            'helper'    => 'A fiókodat jelenleg a(z) :provider kezeli. Hagyományos Kanka bejelentkezésre válthatsz egy jelszó megadásával.',
            'success'   => 'A fiókod mostantól a Kanka bejelentkezést használja.',
            'title'     => 'Közösségiről Kanka',
        ],
        'title'             => 'Fiók',
    ],
    'api'           => [
        'description'           => 'API beállítások frissítése',
        'experimental'          => 'Üdvözlünk a Kanka APIkban! Ezek a funkciók még kísérleti állapotban vannak, de elég stabilak kell, hogy legyenek ahhoz, hogy elkezdhess kommunikálni a Kanka APIval. Hozz létre egy Személyes Hozzáférés Tokent, amit az api hívásaidban használhatsz, vagy használd a Kliens Tokent, ha azt szeretnéd, hogy az alkalmazásod hozzáférjen a felhasználó adataihoz.',
        'help'                  => 'A Kanka rövidesen egy teljes REST API-t fog biztosítani, hogy harmadik féltől származó alkalmazások tudjanak csatlakozni hozzá. Az API kulcsok kezelésének részleteiről rövidesen itt olvashatsz.',
        'link'                  => 'Olvasd el az API dokumentációt',
        'request_permission'    => 'Jelenleg is dolgozunk egy REST API-n amivel harmadik féltől származó alkalmazások is csatlakozhatnak a Kankához, azonban amíg az utolsó simításokat végezzük rajta, addig korlátozzuk a hozzáférések számát. Ha szeretnél hozzáférni az APIhoz és király alkalmazásokat fejleszteni, amelyek a Kankával kommunikálnak, kérjük, hogy lépj kapcsolatba velünk, és elküldünk minden információt, amire szükséged lehet.',
        'title'                 => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Kapcsolódás',
            'remove'    => 'Eltávolítás',
        ],
        'benefits'  => 'A Kanka integrációt nyújt néhány harmadik fél szolgáltatásához. További ilyen integrációkra lehet számítani a jövőben.',
        'discord'   => [
            'errors'    => [
                '0'     => '1',
                'add'   => 'Hiba történt a Kanka és a Discord fiókod összekapcsolása során. Kérlek próbáld meg ismét.',
            ],
            'success'   => [
                'add'       => 'A Discord fiókod össze lett kapcsolva.',
                'remove'    => 'A Discord fiókod le lett választva.',
            ],
            'text'      => 'Férj hozzá az előfizetői szerepekhez automatikusan.',
        ],
        'title'     => 'App Integráció',
    ],
    'boost'         => [
        'benefits'      => [
            'first'     => 'Hogy biztosítsuk a Kanka folyamatos fejlődését, bizonyos funkciók az adott kampány boost-olása után válnak elérhetővé. A boost-olás lehetőségégének megszerzése :patreon-on keresztül történik. Egy kampányt akárki boost-olhatja is, ha van joga megtekinteni azt, így nem minden esetben a Mesélőnek kell állnia a cehhet. Egy kampány addig marad boost-olva, amíg egy felhasználó fenntartja rajta a boost-ját, valamint a támogatását is :patreon-on keresztül. Ha egy kampány boost-olása megszűnik, az adatok nem vesznek el, csupán eltűnnek szem elől, amíg ismét nem kerül boost-olásra.',
            'header'    => 'Entitás fejléc képek.',
            'images'    => 'Egyedi alapérzelmezett entitás képek.',
            'more'      => 'Tudj meg többet a funkciókról.',
            'second'    => 'Egy kampány Boost-olása az alábbi előnyöket biztosítja:',
            'theme'     => 'Kampány-szintű téma, és egyedi megjelenítési stílus.',
            'third'     => 'A kampány boost-olásához keresd fel a kampány oldalát, kattints a ":boost_button" gombra, amely a ":edit_button" felett helyezkedik el.',
            'tooltip'   => 'Egyedi entitás tooltip-ek.',
            'upload'    => 'Megnövelt fájlfeltöltési korlát az összes Tag számára.',
        ],
        'buttons'       => [
            'boost' => 'Boost',
        ],
        'campaigns'     => 'Boost-olt kapányok száma: :count / :max',
        'exceptions'    => [
            'already_boosted'   => ':name kampány már boost-olva van.',
            'exhausted_boosts'  => 'Elfogytak a kiosztható Boost-jaid. Vond vissza egy boost-od valamelyik kampányról, mielőtt egy újnak adnál egyet.',
        ],
        'success'       => [
            'boost' => ':name kampány boost-olva lett.',
            'delete'=> 'Boost visszavonva innen: :name',
        ],
        'title'         => 'Boost',
    ],
    'countries'     => [
        'austria'       => 'Ausztria',
        'belgium'       => 'Belgium',
        'france'        => 'Franciaország',
        'germany'       => 'Németország',
        'italy'         => 'Olaszország',
        'netherlands'   => 'Hollandia',
        'spain'         => 'Spanyolország',
    ],
    'invoices'      => [
        'actions'   => [
            'download'  => 'PDF letöltése',
            'view_all'  => 'Összes megtekintése',
        ],
        'empty'     => 'Nincs számla',
        'fields'    => [
            'amount'    => 'Mennyiség',
            'date'      => 'Dátum',
            'invoice'   => 'Számla',
            'status'    => 'Állapot',
        ],
        'header'    => 'Alább található a legutolsó 24 számla listája, melyek letölthetőek.',
        'status'    => [
            'paid'      => 'Fizetve',
            'pending'   => 'Függőben',
        ],
        'title'     => 'Számlák',
    ],
    'layout'        => [
        'description'   => 'Elrendezési beállítások frissítése',
        'success'       => 'Az elrendezési beállításokat frissítettük.',
        'title'         => 'Elrendezés',
    ],
    'menu'          => [
        'account'               => 'Fiók',
        'api'                   => 'API',
        'apps'                  => 'Appok',
        'billing'               => 'Fizetési Mód',
        'boost'                 => 'Boost',
        'invoices'              => 'Számlák',
        'layout'                => 'Elrendezés',
        'other'                 => 'Egyéb',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Fizetési lehetőségek',
        'personal_settings'     => 'Személyes beállítások',
        'profile'               => 'Profil',
        'subscription'          => 'Előfizetés',
        'subscription_status'   => 'Előfizetés állapota',
    ],
    'patreon'       => [
        'actions'           => [
            'link'  => 'Fiókok összekapcsolása',
            'view'  => 'Látogasd meg a Kankát a Patreonon!',
        ],
        'benefits'          => 'A Patreon támogatóink nagyobb képeket tölthetnek fel, segítenek nekünk fedezni a szerverköltségeket, valamint lehetővé teszik, hogy több időt fordíthassunk a Kankán végzett munkánkra.',
        'benefits_features' => 'csodálatos képességek',
        'deprecated'        => 'Elavult funkció - ha támogatni szeretnéd a Kankát, kérlek tedd az :subscription segítségével. A Patreon-on keresztüli fizetés természetesen aktív marad azon támogatóinknak, akik még az új előfizetési rendszer élesbe állítása előtt kezdték a támogatást.',
        'description'       => 'Szinkronizálás a Patreonnal',
        'errors'            => [
            'invalid_token' => 'Érvénytelen token! A Patreon nem tudta érvényesíteni a kérésed.',
            'missing_code'  => 'Hiányzó kód! A Patreon nem küldött vissza kódot, amely a fiókodat azonosítja.',
            'no_pledge'     => 'Nincs támogatás! A Patreon azonosította a fiókodat, de nem tud aktív támogatásról.',
        ],
        'link'              => 'Nyomd meg ezt a gombot, ha jelenleg támogatod a Kankát a Patreonon, aktiválva a bónuszaid.',
        'linked'            => 'Köszönjük, hogy támogatsz minket a Patreonon! A fiókjaid összekapcsoltuk.',
        'pledge'            => ':name támogatási szint',
        'remove'            => [
            'button'    => 'Patreon fiók leválasztása',
            'success'   => 'A Patreon fiókod le lett választva.',
            'text'      => 'A Patreon fiók leválasztása megszűntet minden bónuszt, a Dicsőségcsarnokbeli jelenléted, kampány boost-ot, és egyéb, a támogatással szerzett funkciókat a Kankán. Fontos megjegyezni, hogy egyik boost-tal kihelyezett tartalmad sem fog elveszni (pl. entitás fejlécek). Amint ismét előfizetővé válasz, újra hozzá fogsz férni ezekhez az adatokhoz, beleértve a lehetőségét, hogy boost-olj, egy korábban boostolt kampányodat.',
            'title'     => 'A Patreon fiókod leválasztása a Kankáról',
        ],
        'success'           => 'Köszönjük, hogy támogatsz minket a Patreonon!',
        'title'             => 'Patreon',
        'wrong_pledge'      => 'A támogatási szintedet manuálisan állítjuk be, így kérjük, adj nekünk pár napot, hogy megfelelően beállíthassuk. Ha továbbra is helytelennek látod, lépj velünk kapcsolatba.',
    ],
    'profile'       => [
        'actions'       => [
            'update_profile'    => 'Profil módosítása',
        ],
        'avatar'        => 'Profilkép',
        'description'   => 'Profil módosítása',
        'success'       => 'A profilodat sikeresen módosítottuk.',
        'title'         => 'Személyes profil',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Előfizetés lemondása',
            'subscribe'         => 'Előfizetés',
            'update_currency'   => 'Választott pénznem mentése',
        ],
        'benefits'              => 'Támogatásoddal lehetőséged nyílik, hogy hozzáférj új :featureshez, valamint ezzel is segítesz minket, hogy több időt szentelhessünk a Kanka fejlesztésének. A szerverünkön nem tárolunk, és nem küldünk keresztül semmilyen bankkártya információt. A számlázáshoz a :stripe vesszük segítségül.',
        'billing'               => [
            'helper'    => 'A számlázási információid tárolása, és feldolgozása a :stripe-on keresztül történik, biztonságos formában. Ez a fizetési mód kerül felhasználásra minden előfizetésed esetében.',
            'saved'     => 'Mentett fizetési mód',
            'title'     => 'Fizetési mód szerkesztése',
        ],
        'cancel'                => [
            'text'  => 'Sajnáljuk, hogy mész! Az előfizetésed lemondása aktívan tartja előfizetésed a következő számlázási ciklusig, amikor is megszűnnek a kampány boost-jait, és minden egyéb előnyöd, amelyet a Kanka támogatásával szereztél. Ha van kedved, kérlek töltsd ki az alábbi kérdőívet, hogy megtudhassuk, hogy mit csinálhatnánk jobban a jövőben, illetve hogy mi vezetett arra a döntésre, hogy megszüntesd az előfizetésed.',
        ],
        'cancelled'             => 'Az előfizetésed felmondásra került. Ismét megújíthatod előfizetésed, amint a jelenlegi előfizetésed lejár.',
        'change'                => [
            'text'  => [
                'monthly'   => 'A :tier szintre vagy előfizetve, a számlázás havonta történik, :amount értékben.',
                'yearly'    => 'A :tier szintre vagy előfizetve, a számlázás évente történik, :amount értékben.',
            ],
            'title' => 'Előfizetői szint megváltoztatása',
        ],
        'currencies'            => [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Változtasd meg a számlázás kívánt pénznemét.',
        ],
        'errors'                => [
            'callback'      => 'A fizetési szolgáltatónk hibát jelzett. Kérlek próbáld meg újra, vagy vedd fel velünk a kapcsolatot, amennyiben a hiba továbbra is fennáll.',
            'subscribed'    => 'Nem sikerült feldolgoznunk az előfizetésed. A Stripe az alábbi hibaokot feltételezi:',
        ],
        'fields'                => [
            'active_since'      => 'Előfizetés kezdete',
            'active_until'      => 'Előfizetés vége',
            'billed_monthly'    => 'Havonta számlázva',
            'billing'           => 'Számlázás',
            'currency'          => 'Számlázott összeg pénzneme',
            'payment_method'    => 'Fizetési mód',
            'plan'              => 'Aktuális terv',
            'reason'            => 'Indok',
        ],
        'helpers'               => [
            'alternatives'          => 'Az előfizetésed fizetése a következővel :method. Ez a fizetési mód nem fog automatikusan megújulni az előfizetésed végén. :method csak Euróval történő fizetés esetén elérhető.',
            'alternatives_warning'  => 'Az előfizetésed fejlesztése ezzel a fizetési móddal nem lehetséges. Kérlek válassz új előfizetést, amikor a jelenlegi előfizetésed lejárna.',
            'alternatives_yearly'   => 'A megújuló előfizetés korlátozásai miatt, a(z) :metod csak éves előfizetéssel használható.',
        ],
        'manage_subscription'   => 'Előfizetés menedzselése',
        'payment_method'        => [
            'actions'       => [
                'add_new'           => 'Új fizetési mód hozzáadása',
                'change'            => 'Fizetési mód megváltoztatása',
                'save'              => 'Fizetési mód mentése',
                'show_alternatives' => 'Alternatív fizetési lehetőségek.',
            ],
            'add_one'       => 'Jelenleg nincs mentett fizetési módod.',
            'alternatives'  => 'Előfizethetsz ezeket az alternatív előfizetési lehetőségeket választva. Ebben az esetben csupán egyszer kerül terhelésre a számlád, és nem fog automatikusan megújulni az előfizetésed minden hónapban.',
            'card'          => 'Kártya',
            'card_name'     => 'A kártyán szereplő név',
            'country'       => 'Tartózkodási hely',
            'ending'        => 'Lejárat',
            'helper'        => 'Ez a kártya kerül használatra minden előfizetésed esetén.',
            'new_card'      => 'Új fizetési mód hozzáadása',
            'saved'         => ':brand utolsó számjegyei: :last4',
        ],
        'placeholders'          => [
            'reason'    => 'Opcionálisan kérlek mondd el, miért nem támogatod tovább a Kankát. Esetleg anyagi okokból döntöttél így?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':amount :currency havonta kiszámlázva.',
            'cost_yearly'   => ':amount :currency évente kiszámlázva.',
        ],
        'sub_status'            => 'Előfizetési információk',
        'subscription'          => [
            'actions'   => [
                'downgrading'       => 'Kérlek vedd fel velünk a kapcsolatot az alacsonyabb szintre váltáshoz',
                'rollback'          => 'Kobold előfizetői szintre váltás',
                'subscribe'         => ':tier előfizetői szintre váltás havi számlázással',
                'subscribe_annual'  => ':tier előfizetői szintre váltás éves számlázással',
            ],
        ],
        'success'               => [
            'alternative'   => 'A fizetésed regisztrálásra került. Értesítést fogsz kapni, amint feldolgozásra került, és az előfizetésed aktiválódott.',
            'callback'      => 'Az előfizetés sikeresen megtörtént. A fiókod frissülni fog, amint a fizetési szolgáltatónk tudatja velünk a változást. (Ez néhány percet igénybe vehet.)',
            'cancel'        => 'Az előfizetésed lemondásra került. A jelenlegi előfizetés továbbra is aktív marad a számlázási periódus végéig.',
            'currency'      => 'A kívánt pénznem beállítása frissült.',
            'subscribed'    => 'Az előfizetés sikeres volt. Ne feledkezz el feliratkozni a Közösségi szavazás hírlevelére, hogy értesülj, amikor egy szavazás elindul. A hírlevél beállításait a Profilodnál tudod szerkeszteni.',
        ],
        'tiers'                 => 'Előfizetői szintek',
        'trial_period'          => 'Az éves előfizetésekre 14 napos visszamondási jog él. Vedd fel velünk a kapcsolatot a következő címen: :email amennyiben szeretnéd lemondani az éves előfizetésed, és az összeg visszatérítését kérvényezni.',
        'upgrade_downgrade'     => [
            'button'    => 'Magasabb, vagy Alacsonyabb szintre váltás információi',
            'downgrade' => [
                'bullets'   => [
                    'end'   => 'Az aktuális szintednek megfelelő előnyök a jelenlegi számlázási ciklusod végéig érvényben maradnak, amelyet követően az alacsonyabb szintű előfizetés lép érvénybe.',
                ],
                'title'     => 'Amikor egy alacsonyabb szintű előfizetésre váltasz',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'A fizetési módod azonnal kiszámlázásra kerül, és egyből hozzáférsz az új előfizetői szint előnyeihez.',
                    'prorate'   => 'Amikor Bagolymedvéből Elementállá emeled az előfizetésed, csak a szintek közötti különbség kerül kiszámlázásra.',
                ],
                'title'     => 'Amikor magasabb szintű előfizetésre váltasz',
            ],
        ],
        'warnings'              => [
            'incomplete'    => 'Nem sikerült az előfizetés összegét a kártyádra terhelni. Kérlek frissítsd a bakkártya adataidat, és a következő pár napban ismételten megpróbáljuk megterhelni az előfizetés összegével. Ha ismét sikertelen a tranzakció, az előfizetésed lemondásra kerül.',
            'patreon'       => 'A fiókod jelenleg a Patreon-nal van összekapcsolva. Kérlek csatlakoztasd le a fiókod a :patreon beállításaiban, mielőtt Kanka előfizetésre váltanál!',
        ],
    ],
];
