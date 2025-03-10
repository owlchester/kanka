<?php

return [
    '403'               => [
        'body'  => 'Vyzerá to tak, že nemáš oprávnenie na zobrazenie tejto stránky!',
        'title' => 'Prístup zamietnutý',
    ],
    '403-form'          => [
        'help'  => 'Dôvod môže byť uplynutie doby prihlásenia. Prosím, skús sa opätovne prihlásiť v novom okne pred uložením zmien.',
    ],
    '404'               => [
        'body'  => 'Prepáč, ale hľadanú stránku sme nenašli.',
        'title' => 'Stránka nebola nájdená',
    ],
    '500'               => [
        'body'  => [
            '1' => 'Ojojoj, niečo sa pokazilo.',
            '2' => 'Report s popisom chyby nám už bol zaslaný, ale niekedy pomôže, ak vieme trochu viac o tom, čo sa vlastne dialo.',
        ],
        'title' => 'Chyba',
    ],
    '503'               => [
        'body'  => [
            '1' => 'Na Kanke sa práve pracuje, čo zvyčajne znamená, že nahrávame jej aktualizáciu!',
            '2' => 'Ospravedlňujeme sa za túto nepríjemnosť. Všetko bude o chvíľu zasa fungovať.',
        ],
        'json'  => 'Na Kanke sa aktuálne pracuje, prosím, skús to o pár minút.',
        'title' => 'Údržba',
    ],
    '503-form'          => [],
    'back-to-campaigns' => 'Vráť sa k jednej z tvojich kampaní',
    'footer'            => 'Ak potrebuješ ďalšiu pomoc, kontaktuj nás na hello@kanka.io alebo na :discord.',
    'log-in'            => 'Prihlásením sa do tvojho konta sa môže zobraziť, čo hľadáš.',
    'post_layout'       => 'Nesprávny vizuál poznámky.',
    'private-campaign'  => [
        'auth'  => [
            'helper'    => 'K tejto kampani nemáš prístup.',
        ],
        'guest' => [
            'helper'    => 'Kampaň, do ktorej sa chceš dostať, je súkromná a ty nie si prihlásený/á.',
            'login'     => 'Prihlásením môžeš získať prístup k obsahu.',
        ],
        'title' => 'Súkromná kampaň',
    ],
];
