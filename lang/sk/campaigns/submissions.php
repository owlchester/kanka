<?php

return [
    'actions'       => [
        'accept'        => 'Schváliť',
        'applications'  => 'Prihlášky: :status',
        'change'        => 'Zmeniť',
        'reject'        => 'Odmietnuť',
    ],
    'apply'         => [
        'apply'         => 'Použiť',
        'help'          => 'Táto kampaň je otvorená pre nových členov. Prihlás sa do nej vyplnením tohto formulára. Obdržíš notifikáciu, keď sa administrátor kampane bude zaoberať tvojou prihláškou.',
        'remove_text'   => 'Tvoje podanie',
        'success'       => [
            'apply' => 'Tvoja prihláška bola uložená. Môžeš ju kedykoľvek zmeniť alebo odstrániť. Obdržíš notifikáciu, keď sa administrátor kampane bude zaoberať tvojou prihláškou.',
            'remove'=> 'Tvoja prihláška bola odstránená.',
            'update'=> 'Tvoja prihláška bola aktualizovaná. Môžeš ju kedykoľvek zmeniť alebo odstrániť. Obdržíš notifikáciu, keď sa administrátor kampane bude zaoberať tvojou prihláškou.',
        ],
        'title'         => 'Prihlásiť sa do :name',
    ],
    'errors'        => [
        'not_open'  => 'Kampaň nie je otvorená pre nových členov. Uprav nastavenia kampane, ak chceš, aby sa do nej užívatelia mohli prihlásiť.',
    ],
    'fields'        => [
        'application'   => 'Prihláška',
        'approval'      => 'Dôvod schválenia',
        'rejection'     => 'Dôvod odmietnutia',
    ],
    'helpers'       => [
        'filter-helper'     => 'Kampaň prijíma prihlášky!',
        'modal'             => 'Do kampane, ktorá je verejná a prijíma prihlášky, si môžu podať prihlášku noví užívatelia.',
        'no_applications'   => 'Aktuálne neevidujeme žiadne prihlášky do tvojej kampane. Užívatelia si môžu podať prihlášku navštívením nástenky a kliknutím na tlačidlo :button.',
        'not_open'          => 'Kampaň aktuálne neprijíma prihlášky.',
        'open_not_public'   => 'Kampaň prijíma prihlášky, ale nie je verejná, takže si nikto nevie prihlášku podať. Toto vieš zmeniť úpravou nastavení kampane.',
    ],
    'placeholders'  => [
        'note'  => 'Spíš tvoju prihlášku na vstup do kampane',
    ],
    'statuses'      => [
        'closed'    => 'Neprijíma',
        'open'      => 'Prijíma',
    ],
    'toggle'        => [
        'closed'    => 'Neprijímať prihlášky',
        'label'     => 'Stav',
        'open'      => 'Prijíma prihlášky',
        'success'   => 'Stav kampane ohľadom prihlášok aktualizovaný.',
        'title'     => 'Stav prihlášok',
    ],
    'update'        => [
        'approve'   => 'Vyber rolu užívateľa, ktorú bude mať v tvojej kampani.',
        'approved'  => 'Prihláška schválená',
        'reject'    => 'Spíš dobrovoľnú správu pre užívateľa, prečo bola prihláška odmietnutá.',
        'rejected'  => 'Prihláška odmietnutá',
    ],
];
