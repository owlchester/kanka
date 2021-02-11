<?php

return [
    'campaign'          => [
        'asset_export'  => 'En export av ett kampanj element är tillgängligt. Länken är tillgänglig i :time minuter.',
        'boost'         => [
            'add'           => 'Kampanjen :campaign blir boostad av :user.',
            'remove'        => ':user boostar inte längre kampanjen :campaign.',
            'superboost'    => 'Kampanjen :campaign blir superboostad av :user.',
        ],
        'export'        => 'En export av en kampanj är tillgänglig. Länken är tillgänglig i :time minuter.',
        'export_error'  => 'Ett fel inträffade medans vi exporterade din kampanj. Vänligen kontakta oss om problemet kvarstår.',
        'join'          => ':user gick med i kampanjen :campaign.',
        'leave'         => ':user lämnade kampanjen :campaign.',
        'role'          => [
            'add'       => 'Du har lagts till i :role rollen för :campaign kampanjen.',
            'remove'    => 'Du har tagits bort från :role rollen för :campaign kampanjen.',
        ],
    ],
    'header'            => 'Du har :count notifikationer',
    'index'             => [
        'description'   => 'Dina senaste notifikationer.',
        'title'         => 'Notifikationer',
    ],
    'no_notifications'  => 'Du har för tillfället inga notifikationer.',
    'permissions'       => [
        'body'  => 'Hallå, vi vill informera dig att vi har helt ändrat behörighetssystemet för alla kampanjer! </p><p>Kampanjer kan nu ha roller och varje roll kan ha behörigheter för att komma åt, redigera eller ta bort entiteter. Varje entitet kan också finjusteras med användarspecifika behörigheter, vilket betyder att Becky och Alfred kan redigera sina egna karaktärer!</p><p>Den enda nackdelen med detta är att många användare måste ställa in nya behörigheter. Om du är Adminen för en kampanj så kan du göra det på kampanjhanterings sidan. Om du är med i en kampanj så kommer du inte kunna se något förens en kampanj Admin har fixat det.',
        'title' => 'Behörighetsändringar',
    ],
    'subscriptions'     => [
        'charge_fail'   => 'Ett fel inträffade medans vi hanterade din betalning. Vänligen vänta ett ögonblick medans vi försöker igen. Om inget ändras, vänligen kontakta oss.',
        'deleted'       => 'Din prenumeration på Kanka har avbrutits efter för många misslyckade försök att ta betalt från ditt kort. Vänligen gå till dina Prenumerations inställningar och försök uppdatera dina betalningsuppgifter.',
        'ended'         => 'Din prenumeration på Kanka har tagit slut. Dina kampanj boostningar och Discord roller har tagits bort. Vi hoppas du kommer tillbaka snart!',
        'failed'        => 'Vi kunde inte ta betalt med dina betalningsuppgifter. Vänligen uppdatera dom under dina Betalningsmetod inställningar.',
        'started'       => 'Din prenumeration på Kanka har börjat.',
    ],
];
