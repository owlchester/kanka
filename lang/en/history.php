<?php

return [
    'actions' => [
        'show-old' => 'Changes',
    ],
    'title' => 'History',
    'log' => [
        'update' => ':user updated :entity',
        'create' => ':user created :entity',
        'delete' => ':user deleted :entity',
        'restore' => ':user restored :entity',
    ],
    'unknown' => [
        'entity' => 'an unknown entity',
    ],
    'cta' => 'Display a log of all the recent changes to the campaign.',
    'helpers' => [
        'base' => 'This interface contains recent changes to entities of the campaign for up to :amount months, showing the most recent changes first.',
        'changes' => 'The following fields previously had these values.',
    ],
    'filters' => [
        'all-users' => 'All members',
        'all-actions' => 'All actions',
        'no-results' => 'No results to display. Try with other filters, or come back after making changes to the campaign\'s entities.',
    ],
];
