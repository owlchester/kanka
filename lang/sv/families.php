<?php

return [
    'create'        => [
        'title' => 'Ny Familj',
    ],
    'destroy'       => [],
    'edit'          => [],
    'families'      => [
        'title' => 'Familj :name Familjer',
    ],
    'fields'        => [
        'families'  => 'Underfamiljer',
        'family'    => 'Huvudfamilj',
        'members'   => 'Medlemmar',
    ],
    'helpers'       => [
        'descendants'   => 'Denna lista innehåller alla familjer som härstammar från denna familj och inte bara dom direkt under den.',
    ],
    'hints'         => [
        'members'   => 'Medlemmar av en familj är listade här. En karaktär kan läggas till i en familj genom att redigera karaktären och använda "Familj" nedrullningsmenyn.',
    ],
    'index'         => [],
    'members'       => [
        'helpers'   => [
            'all_members'       => 'Följande lista är alla karaktärer som är i denna familj och alla i familjer som härstammar från denna familj.',
            'direct_members'    => 'De flesta familjer har medlemmar som sköter den eller som gjorde den känd. Följande lista är karaktärer som är direkt i denna familj.',
        ],
        'title'     => 'Familj :name Medlemmar',
    ],
    'placeholders'  => [
        'location'  => 'Välj en plats',
        'name'      => 'Namn på familjen',
        'type'      => 'Kunglig, Adlig, Utdöd',
    ],
    'show'          => [
        'tabs'  => [
            'all_members'   => 'Alla Medlemmar',
            'families'      => 'Familjer',
            'members'       => 'Medlemmar',
        ],
    ],
];
