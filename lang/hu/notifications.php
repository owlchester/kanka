<?php

return [
    'campaign'          => [
        'application'   => [
            'approved'  => 'A :campaign kampányhoz való kérelmedet elfogadták.',
            'new'       => ':campaign kampányhoz új kérelem',
            'rejected'  => 'A :campaign kampányhoz való kérelmedet elutasították. Az okok: :reason',
        ],
        'asset_export'  => 'A kampány exportja elérhető. A link :time percig él.',
        'boost'         => [
            'add'           => 'A(z) :campaign kampány boost-olva lett :user által.',
            'remove'        => ':user nem boost-olja már tovább a(z) :campaign kampányt.',
            'superboost'    => ':campaign kampány szuperboost-olva van :user által!',
        ],
        'export'        => 'A kampány exportja elkészült. A hivatkozás :time percig lesz elérhető.',
        'export_error'  => 'Hiba történt a kampány exportálása során. Kérlek vedd fel velünk a kapcsolatot, ha a probléma továbbra is fennállna!',
        'join'          => ':user csatlakozott a :campaign kampányhoz.',
        'leave'         => ':user elhagyta a :campaign kampányt.',
        'plugin'        => [
            'deleted'   => 'A :plugin beépülőt törölték a piactérről és eltávolítottuk a :campaign kampányodból.',
        ],
        'role'          => [
            'add'       => 'Megkaptad a :role szerepet a :campaign kampányban.',
            'remove'    => 'Elvesztetted a :role szerepet a :campaign kampányban.',
        ],
    ],
    'header'            => ':count értesítésed van.',
    'index'             => [
        'title' => 'Értesítések',
    ],
    'no_notifications'  => 'Jelenleg nincs értesítésed.',
    'subscriptions'     => [
        'charge_fail'   => 'Hiba lépett fel a fizetés feldolgozása közben. Kérlek várj egy picit, újra megpróbáljuk. Ha nem történik változás, kérlek vedd fel a kapcsolatot velünk.',
        'deleted'       => 'A Kanka előfizetésed lemondásra került túl sok sikertelen próbálkozás után a bankkártyád megterhelésére. Kérlek navigálj az Előfizetések beállításodra a profilod alatt, és aktualizáld a fizetési beállításaid.',
        'ended'         => 'A Kanka előfizetésed lejárt. A kampány boost-jaid, és Discord szereped megszűntek. Reméljük hamarosan viszontláthatunk ismét!',
        'failed'        => 'A Kanka előfizetésed vissza lett utasítva, mivel túl sokszor sikertelen volt a bankkártyád megterhelése az előfizetés összegére. Kérlek látogasd meg a Előfizetés beállításaid, és próbáld meg frissíteni a fizetési beállításod részleteit.',
        'started'       => 'Kanka előfizetésed megkezdődött.',
    ],
];
