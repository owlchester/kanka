<?php

return [
    'campaign'          => [
        'application'   => [
            'approved'  => 'Odobrena je tvoja prijava na kampanju :campaign.',
            'new'       => 'Nova prijava za :campaign.',
            'rejected'  => 'Vaša prijava za kampanju :campaign je odbijena. Razlog naveden: :reason',
        ],
        'asset_export'  => 'Dostupan je izvoz sredstava kampanje. Poveznica je dostupna kroz :time minuta.',
        'boost'         => [
            'add'           => 'Kampanju :campaign je pojačao korisnik :user.',
            'remove'        => 'Korisnik :user više ne pojačava kampanju :campaign.',
            'superboost'    => 'Kampanju :campaign podupire :user.',
        ],
        'export'        => 'Dostupan je izvoz kampanje. Veza je dostupna :time minuta.',
        'export_error'  => 'Došlo je do pogreške prilikom izvoza kampanje. Molimo kontaktiraj nas ako se ovaj problem nastavi.',
        'join'          => ':user se priključio/la :campaign.',
        'leave'         => ':user je napustio/la :campaign.',
        'role'          => [
            'add'       => 'Dodana ti je uloga :role u kampanji :campaign.',
            'remove'    => 'Uklonjena ti je uloga :role iz kampanje :campaign.',
        ],
    ],
    'header'            => 'Imate :count obavijesti',
    'index'             => [
        'description'   => 'Tvoje posljednje obavijesti.',
        'title'         => 'Obavijesti',
    ],
    'no_notifications'  => 'Trenutno nema obavijesti.',
    'permissions'       => [
        'body'  => 'Hej, želimo te obavijestiti da smo u potpunosti promijenili sustav dopuštenja za svaku kampanju!</p><p>Kampanje sada mogu imati uloge i svaka uloga može imati ovlasti za pristup, uređivanje ili brisanje entiteta. Svaki entitet se također može prilagoditi specifičnim dopuštenjima za korisnika, što znači da Bojana i Ante mogu uređivati vlastite likove!</p><p>Jedina mana je da će kampanje s nekoliko korisnika morati postaviti svoja nova dopuštenja. Ako si administrator kampanje, to možeš učiniti na stranici za upravljanje kampanjom. Ako si dio kampanje, ništa nećeš vidjeti dok se administrator kampanje ne pobrine za to.',
        'title' => 'Promjene ovlasti',
    ],
    'subscriptions'     => [
        'charge_fail'   => 'Došlo je do pogreške tijekom obrade tvoje uplate. Pričekaj trenutak dok pokušavamo ponovo. Ako se ništa ne promijeni, kontaktiraj nas.',
        'deleted'       => 'Tvoja pretplata na Kanku je otkazana nakon previše neuspjelih pokušaja naplate tvoje kartice. Idi u postavke pretplate i pokušaj ažurirati svoje podatke o plaćanju.',
        'ended'         => 'Tvoja pretplata na Kanku je završila. Pojačanja tvoje kampanje i Discord uloge su uklonjene. Nadamo će te nam se uskoro vratiti!',
        'failed'        => 'Tvoja pretplata na Kanku je otkazana nakon previše neuspjelih pokušaja naplate tvoje kartice. Idi u postavke pretplate i pokušaj ažurirati svoje podatke o plaćanju.',
        'started'       => 'Tvoja pretplata na Kanku je započela.',
    ],
];
