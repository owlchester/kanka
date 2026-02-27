<?php

return [
    'create'        => [
        'title' => 'Neues Ereignis erstellen',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [
        'helper'    => 'Ereignisse, die dieses Objekt als übergeordnetes Ereignis haben, werden hier angezeigt.',
    ],
    'fields'        => [
        'date'  => 'Datum',
    ],
    'helpers'       => [
        'date'  => 'Dieses Feld kann alles enthalten und ist nicht mit den Kalendern der Kampagne verknüpft. Um dieses Ereignis mit einem Kalender zu verknüpfen, fügen Sie es im Kalender oder auf der Registerkarte Erinnerungen dieses Ereignisses hinzu.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Füge bedeutende Momente wie Schlachten, Krönungen oder Entdeckungen zur Geschichte deiner Welt hinzu.',
    ],
    'placeholders'  => [
        'date'  => 'Ein Datum für dein Ereginis',
        'type'  => 'Zeremonie, Fest, Katastrophe, Schlacht, Geburt',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Kalendereinträge',
    ],
];
