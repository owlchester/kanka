<?php

return [
    'account'       => [
        '2fa'               => [
            'actions'               => [
                'disable'           => 'Deaktivovať dvojstupňové overenie identity',
                'disable-confirm'   => 'Potvrď ešte jedným klikom',
                'finish'            => 'Dokončiť nastavenie a prihlásiť sa',
            ],
            'activation_helper'     => 'Na dokončenie nastavenia dvojstupňového overenia identity tvojho konta nasleduj tieto inštrukcie.',
            'disable'               => [
                'helper'    => 'Ak chceš deaktivovať dvojstupňové overenie identity, klikni na tlačidlo nižšie. Nezabudni, že toto ponechá tvoje konto zraniteľné v prípade, že niekto pozná tvoje prihlasovacie údaje.',
                'title'     => 'Deaktivovať dvojstupňové overenie identity',
            ],
            'enable_instructions'   => 'Ak chceš spustiť aktivačný proces, vygeneruj tvoj autentifikačný QR kód a zoskenuj ho do aplikácie Google Authenticator (:ios, :android) alebo inej podobnej autentifikačnej aplikácie.',
            'enabled'               => 'Dvojstupňové overenie identity je aktuálne pre tvoje konto aktivované.',
            'error_enable'          => 'Nesprávny kód, skús znovu.',
            'fields'                => [
                'otp'       => 'Zadaj jednorazové heslo poskytnuté autentifikačnou aplikáciou.',
                'qrcode'    => 'Zoskenuj nasledujúci QR kód tvojou autentifikačnou aplikáciou na vygenerovanie jednorazového hesla.',
            ],
            'generate_qr'           => 'Generovať QR kód',
            'helper'                => 'Dvojstupňové overenie identity posilňuje bezpečnosť prístupu požadovaním dvoch metód (stupňov) na overenie identity pri každom prihlásení.',
            'learn_more'            => 'Dozveď sa viac o dvojstupňovom overení identity.',
            'social'                => 'Dvojstupňové overenie identity v Kanke je aktívne iba pre osoby, ktoré sa prihlasujú pomocou ich e-mailu a hesla. Zmeň si metódu prihlasovania v tvojom konte predtým, ako aktivuješ toto nastavenie.',
            'success_disable'       => 'Dvojstupňové overenie identity úspešne deaktivované.',
            'success_enable'        => 'Dvojstupňové overenie identity úspešne aktivované. Prosím prihlás sa opäť na dokončenie nastavení.',
            'success_key'           => 'Tvoj QR kód bol úspešne vygenerovaný. Prosím dokonči nastavenie pre aktiváciu dvojstupňového overenia identity.',
            'title'                 => 'Dvojstupňové overenie identity',
        ],
        'actions'           => [
            'social'            => 'Prepnúť na prihlásenie do Kanky',
            'update_email'      => 'Aktualizovať e-mail',
            'update_password'   => 'Aktualizovať heslo',
        ],
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
        'helper'    => 'Vitaj v API Kanky. Vytvor si Osobný prístupový žetón, ktorý budeš používať v tvojich požiadavkách na API s cieľom získať informácie o kampaniach, ku ktorým patríš.',
        'link'      => 'Čítať API dokumentáciu',
        'title'     => 'API',
    ],
    'apps'          => [
        'actions'   => [
            'connect'   => 'Pripojiť',
            'remove'    => 'Odstrániť',
        ],
        'benefits'  => 'Kanka poskytuje niekoľko integrácií so službami tretích strán. Široká integrácia s aplikáciami tretích strán je plánovaná v budúcnosti.',
        'discord'   => [
            'confirm'   => 'Naozaj chceš odpojiť svoje konte z Discordu? Toto odstráni aj role, ktoré máš nastavené.',
            'errors'    => [
                'add'   => 'Pri prepojení tvojho Discord účtu s Kankou sa vyskytla chyba. Prosím, skús to ešte raz.',
            ],
            'success'   => [
                'add'       => 'Tvoje Discord konto bolo prepojené.',
                'remove'    => 'Tvoje Discord konto bolo odpojené.',
            ],
            'text'      => 'Pristupuj automaticky k tvojej roli predplatného.',
            'unlock'    => 'Odblokovať roly v Discorde',
        ],
        'title'     => 'Integrácia aplikácie',
    ],
    'billing'       => [
        'placeholder'   => 'Ak by bolo potrebné doplniť na potvrdenia dodatočné info alebo daňové informácie (firemná adresa, IČ DPH a pod.), vlož ich nižšie a zobrazia sa na všetkých tvojich potvrdenkách.',
        'save'          => 'Uložiť platobné informácie',
        'title'         => 'Platobné informácie',
    ],
    'boost'         => [
        'exceptions'    => [
            'already_boosted'       => 'Kampaň :name už je boostnutá.',
            'exhausted_boosts'      => 'Nemáš už žiadne boosty na rozdávanie. Odstráň najprv boost od existujúcej kampane pred priradením inej.',
            'exhausted_superboosts' => 'Došli ti boosty. Na superboostnutie kampane potrebuješ 3 boosty.',
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
    'invoices'      => [],
    'layout'        => [
        'title' => 'Schéma',
    ],
    'marketplace'   => [],
    'menu'          => [
        'account'               => 'Konto',
        'api'                   => 'API',
        'appearance'            => 'Vzhľad',
        'apps'                  => 'Apps',
        'boosters'              => 'Boosty',
        'notifications'         => 'Upozornenia',
        'other'                 => 'Iné',
        'patreon'               => 'Patreon',
        'payment_options'       => 'Možnosti platby',
        'personal_settings'     => 'Osobné nastavenia',
        'premium'               => 'Prémiové kampane',
        'profile'               => 'Profil',
        'settings'              => 'Nastavenia',
        'subscription'          => 'Predplatné',
        'subscription_status'   => 'Stav predplatného',
    ],
    'patreon'       => [
        'deprecated'    => 'Zastaralá funkcionalita - Ak chceš podporiť Kanku, urob tak cez :subscription. Prepojenie na Patreon je ešte stále aktívne pre osoby, ktoré nás podporili predtým, než sme z neho odišli.',
        'pledge'        => 'Úroveň: :name',
        'remove'        => [
            'button'    => 'Zrušiť prepojenie s Patreonom',
            'success'   => 'Prepojenie s tvojím Patreon kontom bolo zrušené.',
            'text'      => 'Ak zrušíš prepojenie tvojho Patreon konta s Kankou, stratíš tvoje bonusy, meno v sieni slávy, boosty pre kampane a iné funkcionality získané vďaka podpore Kanky. Nestratíš ale žiaden obsah (napr. záhlavia objektov). Ak si nás neskôr zasa predplatíš, prístup k dátam sa ti obnoví, vrátane možnosti boostnuť predtým boostnuté kampane.',
            'title'     => 'Zrušiť prepojenie Patreon konta s Kankou',
        ],
        'title'         => 'Patreon',
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
        'billing'               => [
            'helper'    => 'Tvoje platobné údaje sú spracované a uložené bezpečne na :stripe. Túto platobnú metódu používame pre všetky platby predplatného.',
            'saved'     => 'Uložený spôsob platby',
        ],
        'cancel'                => [
            'grace'     => [
                'text'  => 'Tvoje predplatné bude končiť k :date. Po danom dátume sa tvoje prémiové kampane vrátia do štandardnej formy a ostatné výhody spojené s podporou Kanky sa stanú neaktívne.',
                'title' => 'Kulantná doba',
            ],
            'options'   => [
                'competitor'        => 'Prechádzam ku konkurencii',
                'financial'         => 'Moja finančná situácia sa zmenila',
                'missing_features'  => 'Chýbajú mi funkcionality',
                'not_for'           => 'Predplatné nie je pre mňa',
                'not_playing'       => 'Už sa nehrá alebo je kampaň pozastavená.',
                'not_using'         => 'Aktuálne Kanku nevyužívam',
                'other'             => 'Iné',
            ],
            'text'      => 'Ľutujeme, že odchádzaš! Zrušením tvojho predplatného ostáva toto aktívne do ďalšieho platobného obdobia, po ktorom stratíš tvoje boosty kampaní a ostatné výhody vďaka podpore Kanky. Vyplnením následného formulára nám pomôžeš zistiť, čo by sme mali robiť lepšie, alebo čo ťa viedlo k tomuto rozhodnutiu.',
            'title'     => 'Zrušiť predplatné',
        ],
        'cancelled'             => 'Tvoje predplatné bolo zrušené. Môžeš ho obnoviť, keď ti aktívne predplatné skončí.',
        'change'                => [
            'text'  => [
                'monthly'           => 'Máš predplatenú úroveň :tier, splatnú mesačne vo výške :amount.',
                'upgrade_monthly'   => 'Upgradeuješ na úroveň :tier za :upgrade, takže bude mesačne splatných :amount.',
                'upgrade_paypal'    => 'Upgradeuješ na úroveň :tier za :upgrade do :date.',
                'upgrade_yearly'    => 'Upgradeuješ na úroveň :tier za :upgrade, takže bude ročne splatných :amount.',
                'yearly'            => 'Máš predplatenú úroveň :tier, splatnú ročne vo výške :amount.',
            ],
            'title' => 'Zmeniť úroveň predplatného',
        ],
        'coupon'                => [
            'check'         => 'Skontrolovať promo kód',
            'invalid'       => 'Neplatný promo kód.',
            'label'         => 'Promo kód',
            'percent_off'   => 'Tvoje prvé ročné predplatné bude zlacnené o :percent%!',
        ],
        'currencies'            => [
            'brl'   => 'BRL',
            'eur'   => 'EUR',
            'usd'   => 'USD',
        ],
        'currency'              => [
            'title' => 'Zmeň tebou preferovanú menu',
        ],
        'errors'                => [
            'callback'      => 'Náš spracovateľ platieb nám nahlásil chybu. Prosím, skús ešte raz alebo nás kontaktuj, ak problém pretrváva.',
            'failed'        => 'Aktuálne evidujeme problémy s naším platobným systémom. Ak potrebuješ pomôcť, kontaktuj nás na :email.',
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
            'reset'             => 'Resetovať informáciu platby',
            'reset_billing'     => 'Chápem, že zmenou meny stratím históriu platieb a budem vyžiadaný zadať môj spôsob platby znovu.',
        ],
        'helpers'               => [
            'alternatives'          => 'Zaplať za tvoje predplatné pomocou :method. Tento spôsob platby nebude automaticky obnovený na konci tvojho predplatného. :method je iba dostupný v eurách.',
            'alternatives-2'        => 'Zaplať za tvoje predplatné pomocou :method. Toto je jednorázová platba a nebude automaticky obnovená po skončení tvojho predplatného.',
            'alternatives_warning'  => 'Aktualizácia predplatného týmto spôsobom nie je možná. Prosím, vytvor nové predplatné, keď tvoje súčasné skončí.',
            'alternatives_yearly'   => 'Kvôli obmedzeniam ohľadom opakovaných platieb, :method je dostupný len pre ročné zúčtovanie.',
            'currency_block'        => 'Nie je možné zmeniť menu dokiaľ máš aktívne predplatné Kanky, svoju menu môžeš zmeniť po tom, čo tvoje predplatné skončí.',
            'currency_reset'        => 'Zmena tvojej meny odstráni históriu tvojich platieb a bude nutné zadať spôsob platby ešte raz.',
            'paypal_v3'             => 'Zaplať tvoje ročné predplatné bezpečne PayPalom.',
            'stripe'                => 'Tvoje platobné údaje sú spracované a uložené bezpečne prostredníctvom :stripe.',
        ],
        'manage_subscription'   => 'Spravovať predplatné',
        'payment_method'        => [
            'actions'       => [
                'add'               => 'Pridať',
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
        'periods'               => [
            'monthly'   => 'Mesačne',
            'yearly'    => 'Ročne',
        ],
        'placeholders'          => [
            'downgrade_reason'  => 'Alternatívne nám daj vedieť, prečo znižuješ úroveň tvojho predplatného.',
            'reason'            => 'Alternatívne nám daj vedieť, prečo už nepodporuješ Kanku. Chýbala ti nejaká funkcionalita? Zmenila sa tvoja finančná situácia?',
        ],
        'plans'                 => [
            'cost_monthly'  => ':amount :currency účtovaných mesačne',
            'cost_yearly'   => ':amount :currency účtovaných ročne',
        ],
        'sub_status'            => 'Informácie o predplatnom',
        'subscription'          => [
            'actions'   => [
                'cancel'            => 'Zrušiť predplatné',
                'downgrading'       => 'Prosím, kontaktuj nás ohľadom zníženia úrovne',
                'rollback'          => 'Zmeniť na Kobolda',
                'subscribe'         => 'Zmeniť na :tier mesačný',
                'subscribe_annual'  => 'Zmeniť na :tier ročný',
            ],
        ],
        'success'               => [
            'alternative'   => 'Tvoja platba bola zaregistrovaná. Obdržíš oznámenie akonáhle bude spracovaná a tvoje predplatné aktívne.',
            'callback'      => 'Úspešne predplatené. Tvoje konto bude čoskoro aktualizované akonáhle nás spracovateľ platieb informuje o zmene (môže to pár minút trvať).',
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
                    'premium'   => 'To isté sa stane aj tvojim prémiovým kampaniam. Výhody prémia sa stanú neviditeľnými, ale nebudú odstránené, ak kampaň prestane byť prémiová.',
                ],
                'title'     => 'Čo obnáša zrušenie predplatného',
            ],
            'downgrade' => [
                'bullets'           => [
                    'end'   => 'Tvoja aktuálna úroveň ostáva aktívna do konca aktuálneho platobného obdobia. Potom bude znížená na novú úroveň.',
                ],
                'provide_reason'    => 'Ak sa dá, daj nám prosím vedieť, prečo znižuješ úroveň tvojho predplatného.',
                'title'             => 'Pri prechode na nižšiu úroveň',
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
