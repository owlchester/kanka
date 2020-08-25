<?php

return [
    'title' => 'Kanka Events',
    'description' => 'We hold frequent worldbuilding events for our community with our favourite entries showcased.',
    'participate' => [
        'title' => 'Participate in the event',
        'description' => 'Feel inspired by this event? Create an entity in one of your public campaigns and send us the link to the entity in the form below. You can change or delete your submission at any time.',
    ],
    'actions' => [
        'send' => 'Submit submission',
        'return' => 'Return to all events',
    ],
    'fields' => [
        'entity_link' => 'Link to the entity',
        'comment' => 'Comment',
    ],
    'placeholders' => [
        'entity_link' => 'Copy-paste the link to the entity here',
        'comment' => 'Comment regarding your submission (optional)',
    ],
    'show' => [
        'participants'    => '{1} :number entry submitted.|[2,*] :number entries submitted.',
    ]
];
