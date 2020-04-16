<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed'    => 'Rossz email-jelszó páros.',
    'helpers'   => [
        'password'  => 'Jelszó megmutatása / elrejtése',
    ],
    'login'     => [
        'fields'                => [
            'email'     => 'Email',
            'password'  => 'Jelszó',
        ],
        'login_with_facebook'   => 'Bejelentkezés Facebook segítségével',
        'login_with_google'     => 'Bejelentkezés Google segítségével',
        'login_with_twitter'    => 'Bejelentkezés Twitter segítségével',
        'new_account'           => 'Új felhasználói fiók regisztrálása',
        'or'                    => 'VAGY',
        'password_forgotten'    => 'Elfelejtetted a jelszavadat?',
        'remember_me'           => 'Emlékezz rám',
        'submit'                => 'Bejelentkezés',
        'title'                 => 'Bejelentkezés',
    ],
    'register'  => [
        'already_account'           => 'Már van felhasználói fiókod?',
        'email'                     => [
            'body'  => '<p>Üdvözöl a  kanka.io!</p><p>Az email-címedhez tartozó fiókodat létrehoztuk.</p>',
            'login' => 'Jelentkezz be',
            'title' => 'Üdvözöl a kanka.io!',
        ],
        'errors'                    => [
            'email_already_taken'   => 'Ehhez az email-hez már regisztráltak felhasználói fiókot.',
            'general_error'         => 'Hiba lépett fel a regisztráció folyamán. Kérlek, próbáld meg újra!',
        ],
        'fields'                    => [
            'email'     => 'Email',
            'name'      => 'Felhasználónév',
            'password'  => 'Jelszó',
            'tos'       => 'Egyetértek az <a href=":privacyUrl" target="_blank">Adatvédelmi politikával</a>.',
        ],
        'register_with_facebook'    => 'Regisztráció a Facebook segítségével',
        'register_with_google'      => 'Regisztráció a Google segítségével',
        'register_with_twitter'     => 'Regisztráció a Twitter segítségével',
        'submit'                    => 'Regisztráció',
        'title'                     => 'Regisztráció',
        'welcome_email'             => [
            'header'        => 'Üdvözlünk a Kankában, :name!',
            'header_sub'    => 'Gratulálunk, megtetted az első lépéseket a világod megalkotása felé itt: :kanka!',
            'section_1'     => 'Most merre?',
            'section_10'    => 'Támogatók (patrónusok)',
            'section_11'    => 'Hozd létre a világodat,',
            'section_2'     => 'A legfontosabb forrás a :discord, ahol tucatnyi elhivatott felhasználót találsz, egy elérhető csapatot, ahogy a Kanka alapítóját is, aki minden kérdésedre tud válaszolni.',
            'section_3'     => 'A :faq oldalon megtalálhatod a leggyakoribb kérdéseket.',
            'section_4'     => 'A :youtube csatornánkon megismerkedhetsz a Kanka alapjaival. Habár nincs még minden téma lefedve, rendszeresen készítünk új videókat.',
            'section_5'     => 'Youtube csatorna',
            'section_6'     => 'Lépj kapcsolatba velünk',
            'section_7'     => 'Ha nem találsz választ egy kérdésedre, vagy egyszerűen csak kapcsolatba akarsz lépni, megtalálsz minket a :facebook oldalon is, vagy levelet is tudsz küldeni ide: :email. Mi egy két barátból álló kis csapat vagyunk, de megbizonyosodunk róla, hogy minden levélre válaszolunk, úgyhogy ne hezitálj!',
            'section_8'     => 'Még egy utolsó dolog',
            'section_9'     => 'Biztosnak kell lennünk benne, hogy a Kanka minden központi eleme ingyenes, és az is maradjon. Azonban, ha támogatni szeretnéd a projektünket, csatlakozhatsz hozzánk :patrons ranggal, és hozzáférhetsz újabb lehetőségekhez, ahogy az örrökké tartó hálánk is üldözni fog!',
            'title'         => 'Kezdés a Kankával',
        ],
    ],
    'reset'     => [
        'fields'    => [
            'email'                 => 'Email-cím',
            'password'              => 'Jelszó',
            'password_confirmation' => 'Jelszó megerősítése',
        ],
        'send'      => 'Jelszó visszaállító link küldése',
        'submit'    => 'Jelszó visszaállítása',
        'title'     => 'Jelszó visszaállítása',
    ],
    'throttle'  => 'Túl sok próbálkozás. Kérjük, próbálja újra :seconds másodperc múlva!',
];
