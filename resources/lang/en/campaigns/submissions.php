<?php

return [
    'actions'       => [
        'accept'    => 'Accept',
        'reject'    => 'Reject',
    ],
    'apply'         => [
        'apply'         => 'Apply',
        'help'          => 'This campaign is open to new members. Apply to join is by filling out the form. You will be notified when the campaign admins review your application.',
        'remove_text'   => 'your submission',
        'success'       => [
            'apply' => 'Your application has been saved. You can still change it or cancel it at any time. You shall be notified when the campaign admins review it.',
            'remove'=> 'Your application has been removed.',
            'update'=> 'Your application has been updated. You can still change it or cancel it at any time. You shall be notified when the campaign admins review it.',
        ],
        'title'         => 'Join :name',
    ],
    'errors'        => [
        'not_open'  => 'The campaign isn\'t open to new members. Edit the campaign\'s settings if you want people to apply to joining it.',
    ],
    'fields'        => [
        'application'   => 'Application',
        'rejection'     => 'Rejection reason',
    ],
    'helpers'       => [
        'open_and_public'   => 'The campaign is accepting applications to join it. To stop this, edit the campaign and change the Open setting on the :tab tab.',
    ],
    'placeholders'  => [
        'note'  => 'Write down your application to join the campaign',
    ],
    'title'         => 'Campaign Applications',
    'update'        => [
        'approve'   => 'Select the role the user will be added as in your campaign.',
        'approved'  => 'Application approved.',
        'reject'    => 'Write an optional message to the user as to why you are rejecting their application.',
        'rejected'  => 'Application rejected',
    ],
];
