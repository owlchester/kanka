<?php

return [
    'fields'    => [
        'type'  => 'Event Type',
    ],
    'helpers'   => [
        'characters'    => 'Setting the type as either the date of birth or of death for this character will automatically calculate their age. :more.',
        'no_events'     => 'This interface displays all the calendars this entity is linked to using reminders.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Add reminder',
        ],
        'title'     => ':name Reminders',
    ],
    'types'     => [
        'birth'     => 'Birth',
        'death'     => 'Death',
        'primary'   => 'Primary',
    ],
];
