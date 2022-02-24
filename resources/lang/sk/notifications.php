<?php

return [
    'campaign'          => [
        'application'           => [
            'approved'  => 'Tvoja prihláška do kampane :campaign bola schválená.',
            'new'       => 'Nová prihláška pre :campaign.',
            'rejected'  => 'Tvoja prihláška do kampane :campaign bola odmietnutá. Uvedený dôvod: :reason',
        ],
        'asset_export'          => 'Export materiálov kampane je dostupný. Link je dostupný na :time min.',
        'asset_export_error'    => 'Vyskytla sa chyba pri exportovaní obsahu kampane. Táto je obvyklá pri veľkých kampaniach.',
        'boost'                 => [
            'add'           => 'Kampaň :campaign bola boostnutá používateľom :user.',
            'remove'        => 'Kampaň :campaign už nie je boostovaná používateľom :user.',
            'superboost'    => ':user superboostol kampaň :campaign.',
        ],
        'deleted'               => 'Kampaň :campaign bola zmazaná.',
        'export'                => 'Export kampane je dostupný. Link je platný po dobu :time minút.',
        'export_error'          => 'Počas exportu tvojej kampane došlo k chybe. Prosím, kontaktuj nás, ak problém pretrváva.',
        'join'                  => ':user pristúpil do kampane :campaign.',
        'leave'                 => ':user opustil kampaň :campaign.',
        'plugin'                => [
            'deleted'   => 'Plugin :plugin bol odstránený z trhoviska a tvojej kampane :campaign.',
        ],
        'role'                  => [
            'add'       => 'Bola ti pridaná rola :role v kampani :campaign.',
            'remove'    => 'Bola ti odobraná rola :role v kampani :campaign.',
        ],
        'troubleshooting'       => [
            'joined'    => 'Člen tímu Kanky :user pristúpil do kampane :campaign.',
        ],
    ],
    'clear'             => [
        'action'    => 'Vymazať všetky',
        'confirm'   => 'Naozaj chceš odstrániť všetky notifikácie? Táto akcia nemôže byť vrátená späť.',
        'success'   => 'Notifikácie vymazané.',
    ],
    'header'            => '{1} Máš :count notifikáciu.|[2,4] Máš :count notifikácie.|[5,*] Máš :count notifikácií.',
    'index'             => [
        'title' => 'Notifikácie',
    ],
    'no_notifications'  => 'Aktuálne neexistujú žiadne notifikácie.',
    'subscriptions'     => [
        'charge_fail'   => 'Pri spracovaní tvojej platby došlo k chybe. Prosím, počkaj chvíľu, zatiaľ čo sa o jej spracovanie opäť pokúšame. Ak sa nič nezmení, kontaktuj nás.',
        'deleted'       => 'Tvoje predplatné Kanky bolo zrušené po viacerých neúspešných pokusoch o žiadosť o platbu prostredníctvom tvojej karty. Prosím, uprav detaily platby v Nastaveniach predplatného.',
        'ended'         => 'Tvoje predplatné Kanky bolo ukončené. Tvoje boosty kampaní a roly na Discorde boli odstránené. Dúfame, že sa čoskoro zasa uvidíme!',
        'failed'        => 'Tvoje predplatné Kanky bolo zrušené po prekročení limitu pokusov o spracovanie platby. Prosím, prejdi na Nastavenia predplatného a skús zmeniť tvoje detaily platby.',
        'started'       => 'Tvoje predplatné Kanky bolo spustené.',
    ],
    'unread'            => 'Nová notifikácia',
];
