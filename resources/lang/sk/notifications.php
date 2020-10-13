<?php

return [
    'campaign'          => [
        'boost'         => [
            'add'           => 'Kampaň :campaign bola boostnutá používateľom :user.',
            'remove'        => 'Kampaň :campaign už nie je boostovaná používateľom :user.',
            'superboost'    => ':user superboostol kampaň :campaign.',
        ],
        'export'        => 'Export kampane je dostupný. Môžeš si ho stiahnuť kliknutím <a href=":link">sem</a>. Link je platný po dobu 30 minút.',
        'export_error'  => 'Počas exportu tvojej kampane došlo k chybe. Prosím, kontaktuj nás, ak problém pretrváva.',
        'join'          => ':user pristúpil do kampane :campaign.',
        'leave'         => ':user opustil kampaň :campaign.',
        'role'          => [
            'add'       => 'Bola ti pridaná rola :role v kampani :campaign.',
            'remove'    => 'Bola ti odobraná rola :role v kampani :campaign.',
        ],
    ],
    'header'            => '{1} Máš :count notifikáciu.|[2,4] Máš :count notifikácie.|[5,*] Máš :count notifikácií.',
    'index'             => [
        'description'   => 'Tvoje najnovšie notifikácie.',
        'title'         => 'Notifikácie',
    ],
    'no_notifications'  => 'Aktuálne neexistujú žiadne notifikácie.',
    'permissions'       => [
        'body'  => <<<'TEXT'
Ahoj, chceme ťa informovať, že sme úplne prepracovali systém oprávnení pre všetky kampane!</p>
<p>Kampane teraz môžu mať roly a každá rola môže mať prístup na objekty, možnosť ich čítať, upravovať alebo odstraňovať. Prístup na každý objekt môže byť presne nastavený aj na úrovni používateľa, čo znamená,  že Becky a Alfred môžu upraviť vlastné postavy!</p>
<p>Jedinou nevýhodou je, že kampane s viacerými užívateľmi budú musieť znovu nastaviť svoje oprávnenia. Ak si admin kampane, môžeš tak urobiť na stránke správy kampane. Ak si súčasťou kampane, neuvidíš nič, dokiaľ sa o to admin kampane nepostará.
TEXT
,
        'title' => 'Zmeny v oprávneniach',
    ],
    'subscriptions'     => [
        'charge_fail'   => 'Pri spracovaní tvojej platby došlo k chybe. Prosím, počkaj chvíľu, zatiaľ čo sa o jej spracovanie opäť pokúšame. Ak sa nič nezmení, kontaktuj nás.',
        'deleted'       => 'Tvoje predplatné Kanky bolo zrušené po viacerých neúspešných pokusoch o žiadosť o platbu prostredníctvom tvojej karty. Prosím, uprav detaily platby v Nastaveniach predplatného.',
        'ended'         => 'Tvoje predplatné Kanky bolo ukončené. Tvoje boosty kampaní a roly na Discorde boli odstránené. Dúfame, že sa čoskoro zasa uvidíme!',
        'failed'        => 'Tvoje predplatné Kanky bolo zrušené po prekročení limitu pokusov o spracovanie platby. Prosím, prejdi na Nastavenia predplatného a skús zmeniť tvoje detaily platby.',
        'started'       => 'Tvoje predplatné Kanky bolo spustené.',
    ],
];
