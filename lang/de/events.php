<?php

return [
    'create'        => [
        'title' => 'Neues Ereignis erstellen',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [
        'helper'    => 'Ereignisse, die dieses Objekt als übergeordnetes Ereignis haben, werden hier angezeigt.',
        'title'     => 'Ereignis :name Ereignisse',
    ],
    'fields'        => [
        'date'      => 'Datum',
        'event'     => 'übergeordnetes Ereignis',
        'events'    => 'Ereignisse',
    ],
    'helpers'       => [
        'date'              => 'Dieses Feld kann alles enthalten und ist nicht mit den Kalendern der Kampagne verknüpft. Um dieses Ereignis mit einem Kalender zu verknüpfen, fügen Sie es im Kalender oder auf der Registerkarte Erinnerungen dieses Ereignisses hinzu.',
        'nested_without'    => 'Anzeigen aller Ereignisse ohne übergeordnetes Ereignis. Klicken Sie auf eine Zeile, um die untergeordneten Ereignisse anzuzeigen.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Ein Datum für dein Ereginis',
        'name'  => 'Name des Events',
        'type'  => 'Zeremonie, Fest, Katastrophe, Schlacht, Geburt',
    ],
    'show'          => [
        'tabs'  => [
            'events'    => 'Ereignisse',
        ],
    ],
    'tabs'          => [
        'calendars' => 'Kalendereinträge',
    ],
];
