<?php

return [
    'actions'   => [
        'show-old'  => 'Changes',
    ],
    'cta'       => 'Keep track of everything that\'s changed in your campaign with a detailed activity log of recent edits, additions, and updates.',
    'empty'     => 'No value',
    'filters'   => [
        'all-actions'   => 'All actions',
        'all-users'     => 'All members',
        'no-results'    => 'No results to display. Try with other filters, or come back after making changes to the campaign\'s entities.',
    ],
    'helpers'   => [
        'base'      => 'This interface contains recent changes to entities of the campaign for up to :amount months, showing the most recent changes first.',
        'changes'   => 'The following fields previously had these values.',
    ],
    'fields' => [
        'who' => 'Who',
        'when' => 'When',
        'action' => 'Action',
        'module' => 'Module',
        'details' => 'Details',
    ],
    'log'       => [
        'create'        => ':user created :entity',
        'create_post'   => ':user created a post on :entity',
        'delete'        => ':user deleted :entity',
        'delete_post'   => ':user deleted a post on :entity',
        'reorder_post'  => ':user reordered the posts of :entity',
        'restore'       => ':user restored :entity',
        'update'        => ':user updated :entity',
        'update_post'   => ':user updated a post on :entity',
    ],
    'title'     => 'History',
    'unknown'   => [
        'entity'    => 'an unknown entity',
    ],
];
