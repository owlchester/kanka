<?php

return [
    'actions'   => [
        'status'    => 'Stav: :status',
    ],
    'overview'  => [
        'limited'   => ':amount z :total rolí vytvorených.',
        'title'     => 'Dostupné role',
        'unlimited' => ':amount z nekonečna rolí vytvorených.',
    ],
    'public'    => [
        'campaign'      => [
            'private'   => 'Kampaň je aktuálne privátna.',
            'public'    => 'Kampaň je aktuálne verejná.',
        ],
        'description'   => 'Nastav oprávnenia pre verejnú rolu k zobrazeniu nasledujúcich objektov kampane. Užívateľ je automaticky zaradený k verejnej roli, ak zobrazujú kampaň bez toho, aby boli jej členom.',
        'test'          => 'Ak chceš otestovať oprávnenia verejnej role, otvor si :url kampane v inkognito okne.',
    ],
    'show'      => [
        'title' => 'Oprávnenia :role - :campaign',
    ],
    'toggle'    => [
        'disabled'  => 'Členovia role :role už nemôžu :action :entities.',
        'enabled'   => 'Členovia role :role už môžu :action :entities.',
    ],
    'warnings'  => [
        'adding-to-admin'   => 'Členovia role :name majú prístup ku všetkému v kampani a nemôžu byť odstránení inými členmi rovnakej roly. Po :amount minútach sa sami môžu odstrániť z tejto role.',
    ],
];
