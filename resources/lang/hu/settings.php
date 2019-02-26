<?php

return [
    'account'   => [
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
    'api'       => [
        'description'           => 'API beállítások frissítése',
        'experimental'          => 'Üdvözlünk a Kanka APIkban! Ezek a funkciók még kísérleti állapotban vannak, de elég stabilak kell, hogy legyenek ahhoz, hogy elkezdhess kommunikálni a Kanka APIval. Hozz létre egy Személyes Hozzáférés Tokent, amit az api hívásaidban használhatsz, vagy használd a Kliens Tokent, ha azt szeretnéd, hogy az alkalmazásod hozzáférjen a felhasználó adataihoz.',
        'help'                  => 'A Kanka rövidesen egy teljes REST API-t fog biztosítani, hogy harmadik féltől származó alkalmazások tudjanak csatlakozni hozzá. Az API kulcsok kezelésének részleteiről rövidesen itt olvashatsz.',
        'link'                  => 'Olvasd el az API dokumentációt',
        'request_permission'    => 'Jelenleg is dolgozunk egy REST API-n amivel harmadik féltől származó alkalmazások is csatlakozhatnak a Kankához, azonban amíg az utolsó simításokat végezzük rajta, addig korlátozzuk a hozzáférések számát. Ha szeretnél hozzáférni az APIhoz és király alkalmazásokat fejleszteni, amelyek a Kankával kommunikálnak, kérjük, hogy lépj kapcsolatba velünk, és elküldünk minden információt, amire szükséged lehet.',
        'title'                 => 'API',
    ],
    'layout'    => [
        'description'   => 'Elrendezési beállítások frissítése',
        'success'       => 'Az elrendezési beállításokat frissítettük.',
        'title'         => 'Elrendezés',
    ],
    'menu'      => [
        'account'           => 'Fiók',
        'api'               => 'API',
        'layout'            => 'Elrendezés',
        'patreon'           => 'Patreon',
        'personal_settings' => 'Személyes beállítások',
        'profile'           => 'Profil',
    ],
    'patreon'   => [
        'actions'       => [
            'link'  => 'Fiókok összekapcsolása',
            'view'  => 'Látogasd meg a Kankát a Patreonon!',
        ],
        'benefits'      => 'A Patreon támogatóink nagyobb képeket tölthetnek fel, segítenek nekünk fedezni a szerverköltségeket, valamint lehetővé teszik, hogy több időt fordíthassunk a Kankán végzett munkánkra.',
        'description'   => 'Szinkronizálás a Patreonnal',
        'errors'        => [
            'invalid_token' => 'Érvénytelen token! A Patreon nem tudta érvényesíteni a kérésed.',
            'missing_code'  => 'Hiányzó kód! A Patreon nem küldött vissza kódot, amely a fiókodat azonosítja.',
            'no_pledge'     => 'Nincs támogatás! A Patreon azonosította a fiókodat, de nem tud aktív támogatásról.',
        ],
        'link'          => 'Nyomd meg ezt a gombot, ha jelenleg támogatod a Kankát a Patreonon, aktiválva a bónuszaid.',
        'linked'        => 'Köszönjük, hogy támogatsz minket a Patreonon! A fiókjaid összekapcsoltuk.',
        'pledge'        => ':name támogatása',
        'success'       => 'Köszönjük, hogy támogatsz minket a Patreonon!',
        'title'         => 'Patreon',
        'wrong_pledge'  => 'A támogatási szintedet manuálisan állítjuk be, így kérjük, adj nekünk pár napot, hogy megfelelően beállíthassuk. Ha továbbra is helytelennek látod, lépj velünk kapcsolatba.',
    ],
    'profile'   => [
        'actions'       => [
            'update_profile'    => 'Profil módosítása',
        ],
        'avatar'        => 'Profilkép',
        'description'   => 'Profil módosítása',
        'success'       => 'A profilodat sikeresen módosítottuk.',
        'title'         => 'Személyes profil',
    ],
];
