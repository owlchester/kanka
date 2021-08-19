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
        'helper'                => 'Vitaj v API Kanky. Vytvor si Osobný prístupový žetón, ktorý budeš používať v tvojich požiadavkách na API s cieľom získať informácie o kampaniach, ku ktorým patríš.',
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
        'available_boosts'  => 'Dostupné boosty: :amount / :max',
        'benefits'          => [
            'campaign_gallery'  => 'Galéria kampane pre nahraté obrázky, ktoré môžeš v kampani opätovne použiť.',
            'entity_files'      => 'Možnosť nahrať až 10 súborov k objektu.',
            'entity_logs'       => 'Plné protokoly k objektom o tom, čo sa na objekte zmenilo pri každej úprave.',
            'first'             => 'Aby sme zabezpečili pre Kanku ďalší vývoj, niektoré funkcionality sa odomknú len pre boostnuté kampane. Boosty je možné získať pomocou predplatného. Hocikto, kto vie zobraziť danú kampaň, môže ju aj boostnuť, aby nemusel za ne platiť GM. Kampaň je boostnutá, dokedy ju daný užívateľ boostuje a je podporovateľ Kanky. Ak kampaň prestane byť boostnutá, dané údaje nie sú stratené, len skryté, dokiaľ nie je boostnutá opäť.',
            'header'            => 'Obrázky záhlaví objektov.',
            'headers'           => [
                'boosted'       => 'Výhody boostnutej kampane',
                'superboosted'  => 'Výhody superboostnutej kampane',
            ],
            'helpers'           => [
                'boosted'       => 'Boostnutie kampane pridelí kampani jeden boost.',
                'superboosted'  => 'Superboostnutie kampane pridelí kampani celkovo tri boosty.',
            ],
            'images'            => 'Nastaviteľné štandardné obrázky objektov.',
            'more'              => [
                'boosted'       => 'Všetky výhody boostnutej kampane',
                'superboosted'  => 'Všetky výhody superboostnutej kampane',
            ],
            'recovery'          => 'Obnovenie odstránených objektov do :amount dní.',
            'second'            => 'Boostnutie kampane odomkne nasledujúce výhody:',
            'superboost'        => 'Superboostnutie kampane použije 3 z tvojich boostov a odomkne ďalšie výhody nadmieru tých z boostnutej kampane.',
            'theme'             => 'Nastaviteľnú tému a vizuálny štýl kampane.',
            'third'             => 'Ak chceš boostnuť kampaň, prejdi na stránku kampane a klikni na tlačidlo ":boost_button" nad tlačidlom ":edit_button".',
            'tooltip'           => 'Nastaviteľné bubliny pre objekty.',
            'upload'            => 'Navýšená veľkosť pre nahrávanie súborov pre každého člena kampane.',
        ],
        'buttons'           => [
            'boost'         => 'Boost',
            'superboost'    => 'Superboost',
            'tooltips'      => [
                'boost'         => 'Boostnutie kampane používa :amount z tvojich boostov.',
                'superboost'    => 'Superboostnutie kampane používa :amount z tvojich boostov',
            ],
            'unboost'       => 'Zruš boostnutie',
        ],
        'campaigns'         => 'Boostnuté kampane :count / :max',
        'exceptions'        => [
            'already_boosted'       => 'Kampaň :name už je boostnutá.',
            'exhausted_boosts'      => 'Nemáš už žiadne boosty na rozdávanie. Odstráň najprv boost od existujúcej kampane pred priradením inej.',
            'exhausted_superboosts' => 'Došli ti boosty. Na superboostnutie kampane potrebuješ 3 boosty.',
        ],
        'modals'            => [
            'more'  => [
                'action'    => 'Viac boostov?',
                'body'      => 'Viac boostov môžeš získať navýšením tvojej úrovne predplatného, alebo odstránením z kampane. Zrušenie boostnutia kampane nezmaže žiadne boostnuté informácie, iba ich deaktivuje, dokiaľ ju opäť neboostneš.',
                'title'     => 'Získať viac boostov',
            ],
        ],
        'success'           => [
            'boost'         => 'Kampaň :name boostnutá',
            'delete'        => 'Boost z kampane :name odstránený.',
            'superboost'    => 'Kampaň :name superboostnutá',
        ],
        'title'             => 'Boost',
        'unboost'           => [
            'description'   => 'Naozaj chceš ukončiť boost kampane :tag?',
            'title'         => 'Ukončiť boost kampane',
        ],
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
        'settings'              => 'Nastavenia',
        'subscription'          => 'Predplatné',
        'subscription_status'   => 'Stav predplatného',
    ],
    'patreon'       => [
        'actions'           => [
            'link'  => 'Prepojiť konto',
            'view'  => 'Navštív Kanku na Patreone',
        ],
        'benefits'          => 'Ak nás podporíš na :patreon, odomknú sa ti rôzne :features pre tvoje kampane, a tiež nám pomôžeš, aby sme viac času mohli venovať Kanke.',
        'benefits_features' => 'úžasné funkcionality',
        'deprecated'        => 'Zastaralá funkcionalita - Ak chceš podporiť Kanku, urob tak cez :subscription. Prepojenie na Patreon je ešte stále aktívne pre osoby, ktoré nás podporili predtým, než sme z neho odišli.',
        'description'       => 'Synchronizácia s Patreonom',
        'linked'            => 'Ďakujeme, že podporuješ Kanku na Patreone! Tvoje konto je prepojené.',
        'pledge'            => 'Úroveň: :name',
        'remove'            => [
            'button'    => 'Zrušiť prepojenie s Patreonom',
            'success'   => 'Prepojenie s tvojím Patreon kontom bolo zrušené.',
            'text'      => 'Ak zrušíš prepojenie tvojho Patreon konta s Kankou, stratíš tvoje bonusy, meno v sieni slávy, boosty pre kampane a iné funkcionality získané vďaka podpore Kanky. Nestratíš ale žiaden obsah (napr. záhlavia objektov). Ak si nás neskôr zasa predplatíš, prístup k dátam sa ti obnoví, vrátane možnosti boostnuť predtým boostnuté kampane.',
            'title'     => 'Zrušiť prepojenie Patreon konta s Kankou',
        ],
        'success'           => 'Ďakujeme, že Kanku podporuješ na Patreone!',
        'title'             => 'Patreon',
        'wrong_pledge'      => 'Tvoju úroveň podpory nastavujeme ručne, takže nám na to prosím daj pár dní. Ak by nemala byť dlhší čas ešte stále správna, kontaktuj nás.',
    ],
    'profile'       => [
        'actions'   => [
            'update_profile'    => 'Aktualizovať profil',
        ],
        'avatar'    => 'Profilový obrázok',
        'success'   => 'Profil aktualizovaný.',
        'title'     => 'Osobný profil',
    ],
    'subscription'  => [
        'actions'               => [
            'cancel_sub'        => 'Ukončiť predplatné',
            'subscribe'         => 'Predplatiť',
            'update_currency'   => 'Uložiť preferovanú menu',
        ],
        'benefits'              => 'Ak nás podporíš, odomknú sa ti rôzne :features, a tiež nám pomôžeš, aby sme viac času mohli venovať Kanke. Neukladáme informácie o tvojej platobnej karte, ani s ňou nijak nenarábame. Všetky platby realizujeme cez :stripe.',
        'billing'               => [
            'helper'    => 'Tvoje platobné údaje sú spracované a uložené bezpečne na :stripe. Túto platobnú metódu používame pre všetky platby predplatného.',
            'saved'     => 'Uložený spôsob platby',
            'title'     => 'Upraviť spôsob platby',
        ],
        'cancel'                => [
            'text'  => 'Ľutujeme, že odchádzaš! Zrušením tvojho predplatného ostáva toto aktívne do ďalšieho platobného obdobia, po ktorom stratíš tvoje boosty kampaní a ostatné výhody vďaka podpore Kanky. Vyplnením následného formulára nám pomôžeš zistiť, čo by sme mali robiť lepšie, alebo čo ťa viedlo k tomuto rozhodnutiu.',
        ],
        'cancelled'             => 'Tvoje predplatné bolo zrušené. Môžeš ho obnoviť, keď ti aktívne predplatné skončí.',
        'change'                => [
            'text'  => [
                'monthly'   => 'Máte predplatenú úroveň :tier, splatnú mesačne vo výške :amount.',
                'yearly'    => 'Máte predplatenú úroveň :tier, splatnú ročne vo výške :amount.',
            ],
            'title' => 'Zmeniť úroveň predplatného',
        ],
        'currencies'            => [
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Zmeň tebou preferovanú menu',
        ],
        'errors'                => [
            'callback'      => 'Náš spracovateľ platieb nám nahlásil chybu. Prosím, skús ešte raz alebo nás kontaktuj, ak problém pretrváva.',
            'subscribed'    => 'Tvoje predplatné sa nám nepodarilo spracovať. Stripe nám poskytlo nasledujúcu informáciu prečo.',
        ],
        'fields'                => [
            'active_since'      => 'Aktívne od',
            'active_until'      => 'Aktívne do',
            'billing'           => 'Zúčtovanie',
            'currency'          => 'Mena zúčtovania',
            'payment_method'    => 'Spôsob platby',
            'plan'              => 'Súčasná úroveň',
            'reason'            => 'Dôvod',
        ],
        'helpers'               => [
            'alternatives'          => 'Zaplať za tvoje predplatné pomocou :method. Tento spôsob platby nebude automaticky obnovený na konci tvojho predplatného. :method je iba dostupný v eurách.',
            'alternatives_warning'  => 'Aktualizácia predplatného týmto spôsobom nie je možná. Prosím, vytvor nové predplatné, keď tvoje súčasné skončí.',
            'alternatives_yearly'   => 'Kvôli obmedzeniam ohľadom opakovaných platieb, :method je dostupný len pre ročné zúčtovanie.',
        ],
        'manage_subscription'   => 'Spravovať predplatné',
        'payment_method'        => [
            'actions'       => [
                'add_new'           => 'Pridať nový spôsob platby',
                'change'            => 'Zmeniť spôsob platby',
                'save'              => 'Uložiť spôsob platby',
                'show_alternatives' => 'Alternatívne možnosti platby',
            ],
            'add_one'       => 'Aktuálne nemáš uložený žiadny spôsob platby.',
            'alternatives'  => 'Predplatné môžeš zaplatiť aj týmito alternatívnymi platobnými možnosťami. Tvoje konto bude jednorázovo zaťažené a predplatné nebude automaticky predĺžené na konci mesiaca.',
            'card'          => 'Karta',
            'card_name'     => 'Meno na karte',
            'country'       => 'Krajina bydliska',
            'ending'        => 'Platná do',
            'helper'        => 'Táto karta bude použitá na všetky tvoje predplatné.',
            'new_card'      => 'Pridať nový spôsob platby',
            'saved'         => ':brand končiac na :last4',
        ],
        'placeholders'          => [
            'reason'    => 'Alternatívne nám daj vedieť, prečo už nepodporuješ Kanku. Chýbala ti nejaká funkcionalita? Zmenila sa tvoja finančná situácia?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':amount :currency účtovaných mesačne',
            'cost_yearly'   => ':amount :currency účtovaných ročne',
        ],
        'sub_status'            => 'Informácie o predplatnom',
        'subscription'          => [
            'actions'   => [
                'downgrading'       => 'Prosím, kontaktuj nás ohľadom zníženia úrovne',
                'rollback'          => 'Zmeniť na Kobolda',
                'subscribe'         => 'Zmeniť na :tier mesačný',
                'subscribe_annual'  => 'Zmeniť na :tier ročný',
            ],
        ],
        'success'               => [
            'alternative'   => 'Tvoja platba bola zaregistrovaná. Obdržíš oznámenie akonáhle bude spracovaná a tvoje predplatné aktívne.',
            'callback'      => 'Úspešne predplatené. Tvoje konto bude čoskoro aktualizované akonáhle nás spracovateľ platieb informuje o zmene (môže to pár minút trvať).',
            'cancel'        => 'Predplatné bolo zrušené. Aktívne bude do konca aktuálneho platobného obdobia.',
            'currency'      => 'Nastavenie preferovanej meny bolo aktualizované.',
            'subscribed'    => 'Úspešne predplatené. Nezabudni sa pridať do newsletteru Komunitných hlasovaní, aby sme ťa mohli informovať, keď bude hlasovanie otvorené. Nastavenie newsletteru si môžeš zmeniť v tvojom profile.',
        ],
        'tiers'                 => 'Úrovne predplatného',
        'trial_period'          => 'Ročné predplatné má 14-dňovú skúšobnú lehotu. Kontaktuj nás prostredníctvom :email, ak vypovieš tvoje ročné predplatné a požaduješ vrátenie peňazí.',
        'upgrade_downgrade'     => [
            'button'    => 'Informácie o zmene úrovne predplatného',
            'cancel'    => [
                'bullets'   => [
                    'bonuses'   => 'Tvoje bonusy ostanú aktívne do konca platobného obdobia.',
                    'boosts'    => 'To isté sa stane aj tvojim boostnutým kampaniam. Výhody boostnutia sa stanú neviditeľnými, ale nebudú odstránené, ak kampaň prestane byť boostnutá.',
                    'kobold'    => 'Ak chceš zrušiť tvoje predplatné, zmeň úroveň na Kobolda.',
                ],
                'title'     => 'Čo obnáša zrušenie predplatného',
            ],
            'downgrade' => [
                'bullets'   => [
                    'end'   => 'Tvoja aktuálna úroveň ostáva aktívna do konca aktuálneho platobného obdobia. Potom bude znížená na novú úroveň.',
                ],
                'title'     => 'Pri prechode na nižšiu úroveň',
            ],
            'upgrade'   => [
                'bullets'   => [
                    'immediate' => 'Vybraný spôsob platby bude okamžite zaťažený a hneď budeš mať prístup k novej úrovni.',
                    'prorate'   => 'Ak sa ti úroveň zvýši z Owlbear na Elemental, budeš musieť zaplatiť len rozdiel k vyššej úrovni.',
                ],
                'title'     => 'Pri prechode na vyššiu úroveň',
            ],
        ],
        'warnings'              => [
            'incomplete'    => 'Nepodarilo sa nám zaťažiť tvoju platobnú kartu. Prosím, aktualizuj tvoje platobné údaje karty a my sa o to pokúsime opäť o pár dní. Ak to nebude možné, tvoje predplatné bude zrušené.',
            'patreon'       => 'Tvoje konto je aktuálne prepojené s Patreonom. Prosím, odstráňte prepojenie v nastaveniach tvojho :patreon konta predtým, než zmeníš tvoje predplatné v Kanke.',
        ],
    ],
];
