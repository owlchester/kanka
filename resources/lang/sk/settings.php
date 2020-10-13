<?php

return [
    'account'       => [
        'actions'           => [
            'social'            => 'Prepnúť na prihlásenie do Kanky',
            'update_email'      => 'Aktualizovať e-mail',
            'update_password'   => 'Aktualizovať heslo',
        ],
        'description'       => 'Aktualizuj tvoje konto',
        'email'             => 'Zmeniť e-mail',
        'email_success'     => 'E-mail bol aktualizovaný.',
        'password'          => 'Zmeniť heslo',
        'password_success'  => 'Heslo bolo aktualizované.',
        'social'            => [
            'error'     => 'Pre toto konto už používaš prihlásenie v Kanke.',
            'helper'    => 'Tvoje konto je teraz spravované :provider. Môžeš ho prestať používať a prepnúť na štandardné prihlásenie pomocou Kanky nastavením hesla.',
            'success'   => 'Tvoje konto teraz používa prihlásenie v Kanke.',
            'title'     => 'Konto cez sociálnu sieť',
        ],
        'title'             => 'Konto',
    ],
    'api'           => [
        'experimental'          => 'Vitaj v API Kanky! Tieto funkcionality sú stále experimentálne, ale mali by byť dostatočne stabilné na komunikáciu s API rozhraním. Vytvor si osobný prístupový žetón a použi ho v dotazovaní na API alebo použi klientský žetón, ak chceš, aby mala tvoja aplikácia prístup k užívateľským údajom.',
        'help'                  => 'Kanka bude čoskoro poskytovať prístup cez RESTful API, aby sa na ňu vedeli pripojiť aplikácie tretích strán. Detaily ohľadom správy tvojich API kľúčov nájdeš na tomto mieste.',
        'link'                  => 'Čítať API dokumentáciu',
        'request_permission'    => 'Aktuálne pracujeme na silnej RESTful API, aby sa ku Kanke vedeli pripojiť aplikácie tretích strán. Zároveň ale obmedzujeme počet užívateľov, ktorí sa na rozhranie vedia pripojiť, dokiaľ na ňom pracujeme. Ak chceš prístup k API a vytvárať fajnové aplikácie, ktoré komunikujú s Kankou, kontaktuj nás a my ti zašleme všetky informácie, ktoré potrebuješ.',
        'title'                 => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Pripojiť',
            'remove'    => 'Odstrániť',
        ],
        'benefits'  => 'Kanka poskytuje niekoľko integrácií so službami tretích strán. Široká integrácia s aplikáciami tretích strán je plánovaná v budúcnosti.',
        'discord'   => [
            'errors'    => [
                'add'   => 'Pri prepojení tvojho Discord účtu s Kankou sa vyskytla chyba. Prosím, skús to ešte raz.',
            ],
            'success'   => [
                'add'       => 'Tvoje Discord konto bolo prepojené.',
                'remove'    => 'Tvoje Discord konto bolo odpojené.',
            ],
            'text'      => 'Pristupuj automaticky k tvojej roli predplatného.',
        ],
        'title'     => 'Integrácia aplikácie',
    ],
    'boost'         => [
        'benefits'      => [
            'first'     => 'Aby sme zabezpečili pre Kanku ďalší vývoj, niektoré funkcionality sa odomknú len pre boostnuté kampane. Boosty je možné získať pomocou predplatného. Hocikto, kto vie zobraziť danú kampaň, môže ju aj boostnuť, aby nemusel za ne platiť GM. Kampaň je boostnutá, dokedy ju daný užívateľ boostuje a je podporovateľ Kanky. Ak kampaň prestane byť boostnutá, dané údaje nie sú stratené, len skryté, dokiaľ nie je boostnutá opäť.',
            'header'    => 'Obrázky záhlaví objektov.',
            'images'    => 'Nastaviteľné štandardné obrázky objektov.',
            'more'      => 'Zisti viac o všetkých funkcionalitách.',
            'second'    => 'Boostnutie kampane odomkne nasledujúce výhody:',
            'theme'     => 'Nastaviteľnú tému a vizuálny štýl kampane.',
            'third'     => 'Ak chceš boostnuť kampaň, prejdi na stránku kampane a klikni na ":boost_button" tlačidlo nad ":edit_button" tlačidlom.',
            'tooltip'   => 'Nastaviteľné bubliny pre objekty.',
            'upload'    => 'Navýšená veľkosť pre nahrávanie súborov pre každého člena kampane.',
        ],
        'buttons'       => [
            'boost' => 'Boost',
        ],
        'campaigns'     => 'Boostnuté kampane :count / :max',
        'exceptions'    => [
            'already_boosted'   => 'Kampaň :name už je boostnutá.',
            'exhausted_boosts'  => 'Nemáš už žiadne boosty na rozdávanie. Odstráň najprv boost od existujúcej kampane pred priradením inej.',
        ],
        'success'       => [
            'boost' => 'Kampaň :name boostnutá',
            'delete'=> 'Boost z kampane :name odstránený.',
        ],
        'title'         => 'Boost',
    ],
    'countries'     => [
        'austria'       => 'Rakúsko',
        'belgium'       => 'Belgicko',
        'france'        => 'Francúzsko',
        'germany'       => 'Nemecko',
        'italy'         => 'Taliansko',
        'netherlands'   => 'Holandsko',
        'spain'         => 'Španielsko',
    ],
    'invoices'      => [
        'actions'   => [
            'download'  => 'Stiahnuť PDF',
            'view_all'  => 'Zobraziť všetky',
        ],
        'empty'     => 'Žiadne faktúry',
        'fields'    => [
            'amount'    => 'Množstvo',
            'date'      => 'Dátum',
            'invoice'   => 'Faktúra',
            'status'    => 'Stav',
        ],
        'header'    => 'Nižšie sa nachádza zoznam posledných 24 faktúr, ktoré si môžeš stiahnuť.',
        'status'    => [
            'paid'      => 'Zaplatená',
            'pending'   => 'Čaká sa na platbu',
        ],
        'title'     => 'Faktúry',
    ],
    'layout'        => [
        'success'   => 'Nastavenia schémy aktualizované.',
        'title'     => 'Schéma',
    ],
    'marketplace'   => [
        'fields'    => [
            'name'  => 'Meno pre trhovisko',
        ],
        'helper'    => 'Štandardne sa v :marketplace zobrazí tvoje meno. Prepísať ho môžeš nastavením v tomto poli.',
        'title'     => 'Nastavenia pre trhovisko',
        'update'    => 'Nastavenia pre trhovisko uložené.',
    ],
    'menu'          => [
        'account'               => 'Konto',
        'api'                   => 'API',
        'apps'                  => 'Apps',
        'billing'               => 'Spôsob platby',
        'boost'                 => 'Boost',
        'invoices'              => 'Faktúry',
        'layout'                => 'Schéma',
        'marketplace'           => 'Trhovisko',
        'other'                 => 'Iné',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Možnosti platby',
        'personal_settings'     => 'Osobné nastavenia',
        'profile'               => 'Profil',
        'subscription'          => 'Predplatné',
        'subscription_status'   => 'Stav predplatného',
    ],
    'patreon'       => [
        'actions'   => [
            'link'  => 'Prepojiť konto',
            'view'  => 'Navštív Kanku na Patreone',
        ],
    ],
];
