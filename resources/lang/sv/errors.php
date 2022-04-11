<?php

return [
    '403'       => [
        'body'  => 'Det ser ut som du inte har behörighet att komma åt denna sida!',
        'title' => 'Åtkomst Nekad',
    ],
    '403-form'  => [
        'help'  => 'Detta kan bero på att din session tar för lång tid. Vänligen försök logga in igen i ett annat fönster innan du sparar.',
    ],
    '404'       => [
        'body'  => 'Förlåt, sidan du letar efter kunde inte hittas.',
        'title' => 'Sidan Kunde Inte Hittas',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Ojdå, det ser ut som något gick fel.',
            '2' => 'En rapport med felet som inträffade har skickats till oss, men ibland kan det hjälpa om vi kan få veta lite mer om vad du höll på med.',
        ],
        'title' => 'Fel',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Kanka är för tillfället nere för underhåll, vilket oftast innebär att en uppdatering är på väg.',
            '2' => 'Beklagar besväret. Allt kommer återgå till det normala om bara några minuter.',
        ],
        'title' => 'Underhåll',
    ],
    '503-form'  => [],
    'footer'    => 'Om du behöver mer hjälp, vänligen kontakta oss, på engelska, på hello@kanka.io eller på :discord',
];
