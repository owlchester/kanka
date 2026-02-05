<?php

return [
    'actions'       => [
        'accept'    => 'Accept',
        'reject'    => 'Deny',
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
    'fields'        => [
        'application'   => 'Application',
        'reason'        => 'Approval / Rejection reason',
        'timezone' => 'Timezone',
        'schedule' => 'Schedule',
        'schedule-placeholder' => 'Every Friday at 7 PM',
        'player_count' => 'Number of Players',
        'playstyle_tags' => 'Play-styles',
        'intro' => 'Campaign Introduction',
    ],
    'helpers'       => [
        'modal'                 => 'A campaign which is open to applications and public can have users apply to join the campaign.',
        'no_applications'       => 'There are currently no pending requests to join the campaign. Users can apply to join the campaign by visiting it\'s dashboard and clicking on the :button button.',
        'no_applications_title' => 'No pending requests',
        'reason'                => 'If provided, the applicant will be notified with this reason.',
        'role'                  => 'If approving, the role the applicant gets added to.',
        'fill_setup'            => 'Please fill the public campaign setup form to be able to open your campaign to the public.',
    ],
    'open'          => [
        'closed'    => 'Campaign is closed',
        'open'      => 'Campaign is open',
        'title'     => 'Open campaign',
    ],
    'placeholders'  => [
        'note'          => 'Write down your application to join the campaign',
        'reason'        => 'Your reason',
        'player_count'  => '4-6 players',
        'intro'         => 'A brief explanation of what your campaign is all about, shown on top of the application form.'
    ],
    'public'        => [
        'private'   => 'Campaign is private.',
        'public'    => 'Campaign is public.',
        'title'     => 'Public campaign',
    ],
    'setup'         => [
        'title'     => 'Public campaign setup',
        'tutorial'  => 'Please fill the following fields to submit your campaign into our public campaign list.',
        'success'   => 'Public campaign settings updated.',
        'done'      => 'Public campaign settings filled.',
        'setup'     => 'Set up public campaign settings to open campaign to the public.',
    ],
    'title'         => 'Join requests',
    'toggle'        => [
        'closed'    => 'Closed to applications',
        'label'     => 'Status',
        'open'      => 'Open to applications',
        'success'   => 'Campaign application status updated.',
        'title'     => 'Application status',
    ],
    'tutorial'      => 'Campaign applications let people request access to this campaign. Applicants submit a short form, and campaign admins can review, accept, or decline each request. Approved users are added to the campaign with the role you assign during review.',
    'timezone'      => 'Timezone and Language',
    'update'        => [
        'approve'   => 'Select the role the user will be added as in the campaign.',
        'approved'  => 'Application approved.',
        'reject'    => 'Write an optional message to the user as to why you are rejecting their application.',
        'rejected'  => 'Application rejected',
    ],
];
