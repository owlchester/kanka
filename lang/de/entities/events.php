<?php

return [
    'fields'    => [
        'type'  => 'Ereignistyp',
    ],
    'helpers'   => [
        'characters'    => 'Wenn Sie den Typ entweder als Geburts- oder als Todesdatum für diesen Charakter festlegen, wird automatisch dessen Alter berechnet. :more.',
        'founding'      => 'Wenn su den Typ als :type festlegst, wird das Alter des Objekts seit der Gründung automatisch berechnet.',
        'reminders'     => 'Erinnerungen, die mit :name verknüpft sind, werden hier angezeigt.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Erinnerung hinzufügen',
        ],
        'title'     => ':name Erinnerung',
    ],
    'types'     => [
        'birth'     => 'Geburt',
        'birthday'  => 'Geburtstag',
        'death'     => 'Tod',
        'founded'   => 'Gegründet',
        'primary'   => 'Primär',
    ],
    'years-ago' => '{1} :Jahr vor zählen|[2,*] :Jahr vor zählen',
];
