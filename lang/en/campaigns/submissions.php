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
    ],
    'helpers'       => [
        'modal'                 => 'A campaign which is open to applications and public can have users apply to join the campaign.',
        'no_applications'       => 'There are currently no pending applications to join the campaign. Users can apply to join the campaign by visiting it\'s dashboard and clicking on the :button button.',
        'no_applications_title' => 'No applications found',
        'reason'                => 'If provided, the applicant will be notified with this reason.',
        'role'                  => 'If approving, the role the applicant gets added to.',
    ],
    'open'          => [
        'closed'    => 'Campaign is closed',
        'open'      => 'Campaign is open',
        'title'     => 'Open campaign',
    ],
    'placeholders'  => [
        'note'      => 'Write down your application to join the campaign',
        'reason'    => 'Your reason',
    ],
    'public'        => [
        'private'   => 'Campaign is private',
        'public'    => 'Campaign is public',
        'title'     => 'Public campaign',
    ],
    'toggle'        => [
        'closed'    => 'Closed to applications',
        'label'     => 'Status',
        'open'      => 'Open to applications',
        'success'   => 'Campaign application status updated.',
        'title'     => 'Application status',
    ],
    'update'        => [
        'approve'   => 'Select the role the user will be added as in the campaign.',
        'approved'  => 'Application approved.',
        'reject'    => 'Write an optional message to the user as to why you are rejecting their application.',
        'rejected'  => 'Application rejected',
    ],
];
