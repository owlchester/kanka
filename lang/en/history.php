<?php

return [
    'actions'   => [
        'show-old'  => 'Changes',
    ],
    'cta'       => 'Keep track of everything that\'s changed in the campaign with a detailed activity log of recent edits, additions, and updates.',
    'empty'     => 'No value',
    'fields'    => [
        'action'    => 'Action',
        'details'   => 'Details',
        'module'    => 'Module',
        'when'      => 'When',
        'who'       => 'Who',
    ],
    'filters'   => [
        'all-actions'   => 'All actions',
        'all-users'     => 'All members',
        'no-results'    => 'No results to display. Try with other filters, or come back after making changes to the campaign\'s entities.',
    ],
    'helpers'   => [
        'base'      => 'This interface contains recent changes to entities of the campaign for up to :amount days, showing the most recent changes first.',
        'changes'   => 'The following fields previously had these values.',
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
        'update_tree'   => ':user updated the family tree of :entity',
    ],
    'title'     => 'History',
    'unknown'   => [
        'entity'    => 'an unknown entity',
    ],
];
