<?php

return [
    '403'       => [
        'body'  => 'Het lijkt erop dat je geen toestemming hebt om deze pagina te openen!',
        'title' => 'Toestemming geweigerd',
    ],
    '403-form'  => [
        'help'  => 'Dit kan komen door de time-out van je sessie. Probeer opnieuw in te loggen in een ander venster voordat je opslaat.',
    ],
    '404'       => [
        'body'  => 'Sorry, de pagina die je zoekt, is niet gevonden.',
        'title' => 'Pagina niet gevonden',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Oeps, het ziet ernaar uit dat er iets is misgegaan.',
            '2' => 'Er is een rapport met de aangetroffen fout naar ons gestuurd, maar soms helpt het als we wat meer kunnen weten over wat je aan het doen was.',
        ],
        'title' => 'Fout',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Kanka is momenteel in onderhoud, wat meestal betekent dat er een update aan de gang is!',
            '2' => 'Excuses voor het ongemak. Alles zal binnen enkele minuten weer normaal worden.',
        ],
        'title' => 'Onderhoud',
    ],
    '503-form'  => [],
    'footer'    => 'Als je meer hulp nodig hebt, neem dan contact met ons op via hello@kanka.io of via :discord',
];
