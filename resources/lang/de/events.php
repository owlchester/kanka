<?php

return [
    'create'        => [
        'description'   => 'Erstellen ein neues Ereignis',
        'success'       => 'Ereignis \':name\' erstellt',
        'title'         => 'Neues Ereignis erstellen',
    ],
    'destroy'       => [
        'success'   => 'Ereignis \':name\' entfernt.',
    ],
    'edit'          => [
        'success'   => 'Ereignis \':name\' aktualisiert.',
        'title'     => 'Bearbeite Ereignis :name',
    ],
    'fields'        => [
        'date'      => 'Datum',
        'image'     => 'Bild',
        'location'  => 'Ort',
        'name'      => 'Name',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'date'  => 'Dieses Feld kann alles enthalten und ist nicht mit den Kalendern der Kampagne verknüpft. Um dieses Ereignis mit einem Kalender zu verknüpfen, fügen Sie es im Kalender oder auf der Registerkarte Erinnerungen dieses Ereignisses hinzu.',
    ],
    'index'         => [
        'add'           => 'Neues Ereignis',
        'description'   => 'Verwalte die Ereignisse von :name',
        'header'        => 'Ereignisse von :name',
        'title'         => 'Ereignisse',
    ],
    'placeholders'  => [
        'date'      => 'Ein Datum für dein Ereginis',
        'location'  => 'Wähle einen Ort',
        'name'      => 'Name des Events',
        'type'      => 'Zeremonie, Fest, Katastrophe, Schlacht, Geburt',
    ],
    'show'          => [
        'description'   => 'Eine detaillierte Ansicht eines Ereignisses',
        'tabs'          => [
            'information'   => 'Informationen',
        ],
        'title'         => 'Ereignis :name',
    ],
    'tabs'          => [
        'calendars' => 'Kalendereinträge',
    ],
];
