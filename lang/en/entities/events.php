<?php

return [
    'fields'    => [
        'type'  => 'Reminder Type',
    ],
    'helpers'   => [
        'characters'    => 'Setting the type as either the date of birth or of death for this character will automatically calculate their age. :more.',
        'founding'      => 'Setting the type as :type will automatically calculate the entity\'s age since founding.',
        'reminders'     => 'Reminders linked to :name will be displayed here.',
    ],
    'show'      => [
        'actions'   => [
            'add'   => 'Add reminder',
        ],
        'title'     => ':name Reminders',
    ],
    'types'     => [
        'birth'     => 'Birth',
        'birthday'  => 'Birthday',
        'death'     => 'Death',
        'founded'   => 'Founded',
        'primary'   => 'Primary',
    ],
    'years-ago' => '{1} :count year ago|[2,*] :count years ago',
];
