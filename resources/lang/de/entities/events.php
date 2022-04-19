<?php

return [
    'fields'    => [
        'type'  => 'Ereignistyp',
    ],
    'helpers'   => [
        'characters'    => 'Wenn Sie den Typ entweder als Geburts- oder als Todesdatum für diesen Charakter festlegen, wird automatisch dessen Alter berechnet. :more.',
        'no_events'     => 'Diese Schnittstelle zeigt alle Kalender an, mit denen dieses Objekt über Erinnerungen verknüpft ist.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Erinnerung hinzufügen',
        ],
        'title'     => ':name Erinnerung',
    ],
    'types'     => [
        'birth'     => 'Geburt',
        'death'     => 'Tod',
        'primary'   => 'Primär',
    ],
];
