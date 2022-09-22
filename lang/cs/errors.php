<?php

return [
    '403'       => [
        'body'  => 'Zdá se, že nemáš oprávnění pro přístup k této stránce!',
        'title' => 'Přístup zamítnut',
    ],
    '403-form'  => [
        'help'  => 'Možná vypršela doba tvého přihlášení. Zkus se před uložením znovu přihlásit v jiném okně.',
    ],
    '404'       => [
        'body'  => 'Hledanou stránku nelze nalézt.',
        'title' => 'Stránka nenalezena',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Ajta, něco se nepovedlo.',
            '2' => 'Systém nám poslal záznam chyby, ale pro nalezení problému pomůže vědět, co přesně se stalo.',
        ],
        'title' => 'Chyba',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Systém Kanka nyní podstupuje údržbu, což obvykle znamená, že se blíží aktualizace systému.',
            '2' => 'Omlouváme se za nepříjemnost. Za pár minut bude opět vše v pořádku.',
        ],
        'title' => 'Údržba',
    ],
    '503-form'  => [],
    'footer'    => 'Pokud potřebuješ pomoc, napiš nám na hello@kanka.io nebo se nám ozvi na serveru :discord',
];
