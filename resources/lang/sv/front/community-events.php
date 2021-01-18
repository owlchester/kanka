<?php

return [
    'actions'       => [
        'return'        => 'Tillbaka till alla event',
        'send'          => 'Delta',
        'show_ongoing'  => 'Visa Event & Delta',
        'show_past'     => 'Visa Event & Vinnare',
        'update'        => 'Uppdatera bidrag',
        'view'          => 'Visa bidrag',
    ],
    'description'   => 'Vi anordnar frekvent världsbyggnads event för vår Community och visar upp våra favorit bidrag.',
    'fields'        => [
        'comment'       => 'Kommentera',
        'entity_link'   => 'Länka till entiteten',
        'rank'          => 'Rank',
        'submitter'     => 'Bidragare',
    ],
    'index'         => [
        'ongoing'   => 'Pågående event',
        'past'      => 'Tidigare event',
    ],
    'participate'   => [
        'description'   => 'Känner du dig inspirerad av detta event? Skapa en entitet i en av dina offentliga kampanjer och skicka oss en länk till den i formuläret nedan. Du kan ändra eller ta bort ditt bidrag när som helst.',
        'login'         => 'Logga in på ditt konto för att delta i eventet.',
        'participated'  => 'Du har redan skickat ett bidrag för detta event. Du kan redigera det eller ta bort det.',
        'success'       => [
            'modified'  => 'Ändringar till ditt bidrag har sparats.',
            'removed'   => 'Ditt bidrag har tagits bort.',
            'submit'    => 'Ditt bidrag har skickats. Du kan redigera eller ta bort det när som helst.',
        ],
        'title'         => 'Delta i eventet',
    ],
    'placeholders'  => [
        'comment'       => 'Kommentar gällande ditt bidrag (valfritt)',
        'entity_link'   => 'Kopiera-klistra in länken till entiteten här',
    ],
    'results'       => [
        'description'       => 'Vår jury valde följande bidrag som vinnare för eventet.',
        'title'             => 'Event Vinnare',
        'waiting_results'   => 'Eventet är över! Event juryn kommer att titta på bidragen och så fort vinnare har valts så kommer de att visas här.',
    ],
    'show'          => [
        'participants'  => '{1} :number bidrag inskickade.|[2,*] :number bidrag inskickade.',
        'title'         => 'Event :name',
    ],
    'title'         => 'Event',
];
