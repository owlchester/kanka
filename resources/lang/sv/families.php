<?php

return [
    'create'        => [
        'description'   => 'Skapa en ny familj',
        'success'       => 'Familj \':name\' skapad.',
        'title'         => 'Ny Familj',
    ],
    'destroy'       => [
        'success'   => 'Familj \':name\' borttagen.',
    ],
    'edit'          => [
        'success'   => 'Familj \':name\' uppdaterad.',
        'title'     => 'Redigera Familj :name',
    ],
    'families'      => [
        'title' => 'Familj :name Familjer',
    ],
    'fields'        => [
        'families'  => 'Underfamiljer',
        'family'    => 'Huvudfamilj',
        'image'     => 'Bild',
        'location'  => 'Plats',
        'members'   => 'Medlemmar',
        'name'      => 'Namn',
        'relation'  => 'Förbindelse',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'descendants'   => 'Denna lista innehåller alla familjer som härstammar från denna familj och inte bara dom direkt under den.',
        'nested'        => 'I Hierarkisk Vy så kan du se Familjer på ett hierarkiskt sätt. Familjer utan någon huvudfamilj visas som standard. Familjer med underfamiljer kan klickas på för att visa dem. Du kan fortsätta klicka tills det inte finns några fler underfamiljer att visa.',
    ],
    'hints'         => [
        'members'   => 'Medlemmar av en familj är listade här. En karaktär kan läggas till i en familj genom att redigera karaktären och använda "Familj" nedrullningsmenyn.',
    ],
    'index'         => [
        'add'           => 'Ny Familj',
        'description'   => 'Hantera familjerna för :name.',
        'header'        => 'Familjer för :name',
        'title'         => 'Familjer',
    ],
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
        'description'   => 'En detaljerad vy för en familj',
        'tabs'          => [
            'all_members'   => 'Alla Medlemmar',
            'families'      => 'Familjer',
            'members'       => 'Medlemmar',
            'relation'      => 'Förbindelser',
        ],
        'title'         => 'Familj :name',
    ],
];
