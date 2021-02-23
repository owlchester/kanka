<?php

return [
    'actions' => [
        'accept' => 'Accept',
        'reject' => 'Reject',
    ],
    'apply' => [
        'title' => 'Join :name',
        'help' => 'This campaign is open to new members. Apply to join is by filling out the form. You will be notified when the campaign admins review your application.',
        'apply' => 'Apply',
        'remove_text' => 'your submission',
        'success' => [
            'apply' => 'Your application has been saved. You can still change it or cancel it at any time. You shall be notified when the campaign admins review it.',
            'update' => 'Your application has been updated. You can still change it or cancel it at any time. You shall be notified when the campaign admins review it.',
            'remove' => 'Your application has been removed.',
        ]
    ],
    'errors' => [
        'not_open' => 'The campaign isn\'t open to new members. Edit the campaign\'s settings if you want people to apply to joining it. '
    ],
    'fields' => [
        'application' => 'Application',
        'rejection' => 'Rejection reason',
    ],
    'placeholders' => [
        'note' => 'Write down your application to join the campaign',
    ],
    'title' => 'Campaign Applications',
    'helpers' => [
        'open_and_public' => 'The campaign is accepting applications to join it. To stop this, edit the campaign and change the Open setting on the :tab tab.',
    ],
    'update' => [
        'approve' => 'Select the role the user will be added as in your campaign.',
        'approved' => 'Application approved.',
        'rejected' => 'Application rejected',
        'reject' => 'Write an optional message to the user as to why you are rejecting their application.',
    ],
];
