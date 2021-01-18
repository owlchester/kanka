<?php

return [
    'create'        => [
        'description'   => 'Skapa en ny konversation',
        'success'       => 'Konversation \':name\' skapad.',
        'title'         => 'Ny Konversation',
    ],
    'destroy'       => [
        'success'   => 'Konversation \':name\' borttagen.',
    ],
    'edit'          => [
        'description'   => 'Uppdatera konversationen.',
        'success'       => 'Konversation \':name\' uppdaterad.',
        'title'         => 'Konversation :name',
    ],
    'fields'        => [
        'messages'      => 'Meddelanden',
        'name'          => 'Namn',
        'participants'  => 'Deltagare',
        'target'        => 'Mål',
        'type'          => 'Typ',
    ],
    'hints'         => [
        'participants'  => 'Vänligen lägg till deltagare till din konversation genom att trycka på :icon ikonen uppe till höger.',
    ],
    'index'         => [
        'add'           => 'Ny Konversation',
        'description'   => 'Hantera kategorin av :name',
        'header'        => 'Konversationer i :name',
        'title'         => 'Konversationer',
    ],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Meddelande borttaget.',
        ],
        'is_updated'    => 'Uppdaterade',
        'load_previous' => 'Ladda föregående meddelanden',
        'placeholders'  => [
            'message'   => 'Ditt meddelande',
        ],
    ],
    'participants'  => [
        'create'        => [
            'success'   => 'Deltagare :entity tillagd till konversationen.',
        ],
        'description'   => 'Lägg till eller ta bort deltagare i en konversation',
        'destroy'       => [
            'success'   => 'Deltagare :entity borttagen från konversationen.',
        ],
        'modal'         => 'Deltagare',
        'title'         => 'Deltagare i :name',
    ],
    'placeholders'  => [
        'name'  => 'Name of the conversation',
        'type'  => 'I Spelet, Förberedande, Handling',
    ],
    'show'          => [
        'description'   => 'En detaljerad vy för en konversation',
        'title'         => 'Konversation :name',
    ],
    'tabs'          => [
        'conversation'  => 'Konversation',
        'participants'  => 'Deltagare',
    ],
    'targets'       => [
        'characters'    => 'Karaktärer',
        'members'       => 'Medlemmar',
    ],
];
