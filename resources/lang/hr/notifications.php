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
        'plugin'        => [
            'deleted'   => 'Dodatak :plugin je izbrisan s tržišta i uklonjen iz kampanje :campaign.',
        ],
        'role'          => [
            'add'       => 'Dodana ti je uloga :role u kampanji :campaign.',
            'remove'    => 'Uklonjena ti je uloga :role iz kampanje :campaign.',
        ],
    ],
    'header'            => 'Imate :count obavijesti',
    'index'             => [
        'title' => 'Obavijesti',
    ],
    'no_notifications'  => 'Trenutno nema obavijesti.',
    'subscriptions'     => [
        'charge_fail'   => 'Došlo je do pogreške tijekom obrade tvoje uplate. Pričekaj trenutak dok pokušavamo ponovo. Ako se ništa ne promijeni, kontaktiraj nas.',
        'deleted'       => 'Tvoja pretplata na Kanku je otkazana nakon previše neuspjelih pokušaja naplate tvoje kartice. Idi u postavke pretplate i pokušaj ažurirati svoje podatke o plaćanju.',
        'ended'         => 'Tvoja pretplata na Kanku je završila. Pojačanja tvoje kampanje i Discord uloge su uklonjene. Nadamo će te nam se uskoro vratiti!',
        'failed'        => 'Tvoja pretplata na Kanku je otkazana nakon previše neuspjelih pokušaja naplate tvoje kartice. Idi u postavke pretplate i pokušaj ažurirati svoje podatke o plaćanju.',
        'started'       => 'Tvoja pretplata na Kanku je započela.',
    ],
];
