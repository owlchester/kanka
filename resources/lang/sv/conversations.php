<?php

return [
    'create'        => [
        'success'   => 'Konversation \':name\' skapad.',
        'title'     => 'Ny Konversation',
    ],
    'destroy'       => [
        'success'   => 'Konversation \':name\' borttagen.',
    ],
    'edit'          => [
        'success'   => 'Konversation \':name\' uppdaterad.',
        'title'     => 'Konversation :name',
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
        'title' => 'Konversationer',
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
        'create'    => [
            'success'   => 'Deltagare :entity tillagd till konversationen.',
        ],
        'destroy'   => [
            'success'   => 'Deltagare :entity borttagen från konversationen.',
        ],
        'modal'     => 'Deltagare',
        'title'     => 'Deltagare i :name',
    ],
    'placeholders'  => [
        'name'  => 'Name of the conversation',
        'type'  => 'I Spelet, Förberedande, Handling',
    ],
    'show'          => [],
    'tabs'          => [
        'conversation'  => 'Konversation',
        'participants'  => 'Deltagare',
    ],
    'targets'       => [
        'characters'    => 'Karaktärer',
        'members'       => 'Medlemmar',
    ],
];
