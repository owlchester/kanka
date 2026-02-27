<?php

return [
    'title' => 'Share entry',
    'status' => [
        'hidden'    => 'Not visible to the public',
        'public'    => 'Visible to the public',
        'unlisted'  => 'Visible to anyone with the link',
        'private'   => 'This campaign is private',
    ],
    'helpers' => [
        'hidden_explanation'          => 'The campaign is public, but this entry is currently hidden from guests.',
        'hidden_unlisted_explanation'  => 'The campaign is unlisted, but this entry is currently hidden from guests.',
        'public_explanation'          => 'Both the campaign and this entry are public. Anyone with the link can view it.',
        'unlisted_explanation'        => 'The campaign is unlisted and this entry is visible. Anyone with the link can view it.',
        'private_explanation'         => 'Only invited members can view this entry because the campaign is private.',
        'visibility_mode'           => 'Choose how you want to expose this entry to the public.',
        'campaign_access'           => 'To share this with the public, the campaign itself must be made public first.',
        'entity_permissions_warning' => 'Making this campaign public allows anyone to browse it. Individual entry permissions still apply — entries marked as private will remain hidden.',
    ],
    'fields' => [
        'visibility_mode' => 'Public access settings',
        'campaign_access' => 'Campaign settings',
    ],
    'options' => [
        'make_entity_public'   => 'Make :name public',
        'make_all_public'      => 'Make all :module public',
        'keep_private'         => 'Keep campaign private',
        'make_campaign_public' => 'Make campaign public',
    ],
    'labels' => [
        'share_link'   => 'Share link',
        'member_link'  => 'Member-only link',
        'public_link'  => 'Public link',
    ],
    'buttons' => [
        'save'        => 'Save changes',
        'make_public' => 'Make campaign public',
        'copy'        => 'Copy link',
    ],
    'success' => [
        'copied'         => 'Link copied to clipboard!',
        'copied_public'  => 'Public link copied, anyone with the link can view the entry.',
        'copied_members' => 'Member-only link copied.',
        'updated'        => 'Visibility settings updated successfully.',
    ],
];