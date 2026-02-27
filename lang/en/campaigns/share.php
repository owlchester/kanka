<?php

return [
    'title' => 'Share campaign',
    'status' => [
        'private'   => 'Private campaign',
        'public'    => 'Anyone with the link can view this campaign',
        'unlisted'  => 'Unlisted campaign',
    ],
    'helpers' => [
        'private_explanation'  => 'Only members can access private campaigns.',
        'public_explanation'   => 'This campaign is public. Anyone with the link can browse it.',
        'unlisted_explanation' => 'Anyone with the link can browse this campaign, but it doesn\'t appear in public directories.',
    ],
    'labels' => [
        'member_link' => 'Only members can open this',
        'public_link' => 'Public link',
    ],
    'buttons' => [
        'make_public' => 'Make public & copy link',
        'copy_public_link' => 'Copy public link',
        'change_visibility' => 'Change visibility',
        'copy' => 'Copy link',
        'close' => 'Close',
    ],
    'success' => [
        'copied_public' => 'Public link copied – anyone with the link can view.',
        'copied_members' => 'Member-only link copied.',
        'made_public' => 'Campaign is now public.',
    ],
];
