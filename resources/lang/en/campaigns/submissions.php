<?php

return [
    'actions'       => [
        'accept'        => 'Accept',
        'applications'  => 'Applications: :status',
        'change'        => 'Change',
        'reject'        => 'Reject',
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
        'not_open'  => 'The campaign isn\'t open to new members. Edit the campaign\'s settings if you want to allow users applying to it.',
    ],
    'fields'        => [
        'application'   => 'Application',
        'rejection'     => 'Rejection reason',
        'approval'      => 'Approval reason',
    ],
    'helpers'       => [
        'filter-helper'     => 'This campaign is open to applications!',
        'modal'             => 'A campaign which is open to applications and public can have users apply to join the campaign.',
        'no_applications'   => 'There are currently no pending applications to join your campaign. Users can apply to join your campaign by visiting it\'s dashboard and clicking on the :button button.',
        'not_open'          => 'The campaign isn\'t currently accepting applications.',
        'open_not_public'   => 'The campaign is open to applications, but not public, meaning no one can apply to join it. This can be changed by editing the campaign\'s settings.',
    ],
    'placeholders'  => [
        'note'  => 'Write down your application to join the campaign',
    ],
    'statuses'      => [
        'closed'    => 'Closed',
        'open'      => 'Open',
    ],
    'toggle'        => [
        'closed'    => 'Closed to applications',
        'label'     => 'Status',
        'open'      => 'Open to applications',
        'success'   => 'Campaign application status updated.',
        'title'     => 'Application status',
    ],
    'update'        => [
        'approve'   => 'Select the role the user will be added as in your campaign.',
        'approved'  => 'Application approved.',
        'reject'    => 'Write an optional message to the user as to why you are rejecting their application.',
        'rejected'  => 'Application rejected',
    ],
];
