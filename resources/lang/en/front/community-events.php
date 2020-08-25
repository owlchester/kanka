<?php

return [
    'title' => 'Events',
    'description' => 'We hold frequent worldbuilding events for our community with our favourite entries showcased.',
    'participate' => [
        'title' => 'Participate in the event',
        'description' => 'Feel inspired by this event? Create an entity in one of your public campaigns and send us the link to the entity in the form below. You can change or delete your submission at any time.',
        'participated' => 'You have already sent a submission for this event. You can edit it or remove it.',
        'login' => 'Log into your account to participate in the event.',
        'success' => [
            'modified' => 'Changes to your submission have been saved.',
            'submit' => 'Your submission has been sent. You can edit or remove it at any time.',
            'removed' => 'Your submission has been removed.',
        ]
    ],
    'actions' => [
        'send' => 'Submit submission',
        'update' => 'Update submission',
        'return' => 'Return to all events',
        'view' => 'View submission',
        'show_past' => 'View Event & Winners',
        'show_ongoing' => 'View Event & Participate'
    ],
    'fields' => [
        'entity_link' => 'Link to the entity',
        'comment' => 'Comment',
        'submitter' => 'Submitter',
        'rank' => 'Rank',
    ],
    'placeholders' => [
        'entity_link' => 'Copy-paste the link to the entity here',
        'comment' => 'Comment regarding your submission (optional)',
    ],
    'show' => [
        'participants'    => '{1} :number entry submitted.|[2,*] :number entries submitted.',
        'title' => 'Event :name',
    ],
    'index' => [
        'ongoing' => 'Ongoing events',
        'past' => 'Past events',
    ],
    'results' => [
        'title' => 'Event Winners',
        'description' => 'Our jury selected the following submissions as winners for the event.',
        'waiting_results' => 'The event is over! The event jury will look at the submissions and as soon as winners are selected, they will be displayed here.',
    ]
];
