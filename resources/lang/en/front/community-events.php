<?php

return [
    'actions'       => [
        'return'        => 'Return to all events',
        'send'          => 'Participate',
        'show_ongoing'  => 'View Event & Participate',
        'show_past'     => 'View Event & Winners',
        'update'        => 'Update submission',
        'view'          => 'View submission',
    ],
    'description'   => 'We hold frequent worldbuilding events for our community with our favourite entries showcased.',
    'fields'        => [
        'comment'       => 'Comment',
        'entity_link'   => 'Link to the entity',
        'rank'          => 'Rank',
        'submitter'     => 'Submitter',
    ],
    'index'         => [
        'ongoing'   => 'Ongoing events',
        'past'      => 'Past events',
    ],
    'participate'   => [
        'description'   => 'Feel inspired by this event? Create an entity in one of your public campaigns and send us the link to the entity in the form below. You can change or delete your submission at any time.',
        'login'         => 'Log into your account to participate in the event.',
        'participated'  => 'You have already sent a submission for this event. You can edit it or remove it.',
        'success'       => [
            'modified'  => 'Changes to your submission have been saved.',
            'removed'   => 'Your submission has been removed.',
            'submit'    => 'Your submission has been sent. You can edit or remove it at any time.',
        ],
        'title'         => 'Participate in the event',
    ],
    'placeholders'  => [
        'comment'       => 'Comment regarding your submission (optional)',
        'entity_link'   => 'Copy-paste the link to the entity here',
    ],
    'results'       => [
        'description'       => 'Our jury selected the following submissions as winners for the event.',
        'title'             => 'Event Winners',
        'waiting_results'   => 'The event is over! The event jury will look at the submissions and as soon as winners are selected, they will be displayed here.',
    ],
    'show'          => [
        'participants'  => '{1} :number entry submitted.|[2,*] :number entries submitted.',
        'title'         => 'Event :name',
    ],
    'title'         => 'Events',
];
