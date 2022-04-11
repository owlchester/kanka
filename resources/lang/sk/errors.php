<?php

return [
    '403'       => [
        'body'  => 'Vyzerá to tak, že nemáš oprávnenie na zobrazenie tejto stránky!',
        'title' => 'Prístup zamietnutý',
    ],
    '403-form'  => [
        'help'  => 'Dôvod môže byť uplynutie doby prihlásenia. Prosím, skús sa opätovne prihlásiť v novom okne pred uložením zmien.',
    ],
    '404'       => [
        'body'  => 'Prepáč, ale hľadanú stránku sme nenašli.',
        'title' => 'Stránka nebola nájdená',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Ojojoj, niečo sa pokazilo.',
            '2' => 'Report s popisom chyby nám už bol zaslaný, ale niekedy pomôže, ak vieme trochu viac o tom, čo sa vlastne dialo.',
        ],
        'title' => 'Chyba',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Na Kanke sa práve pracuje, čo zvyčajne znamená, že nahrávame jej aktualizáciu!',
            '2' => 'Ospravedlňujeme sa za túto nepríjemnosť. Všetko bude o chvíľu zasa fungovať.',
        ],
        'title' => 'Údržba',
    ],
    '503-form'  => [],
    'footer'    => 'Ak potrebuješ ďalšiu pomoc, kontaktuj nás na hello@kanka.io alebo na :discord.',
];
