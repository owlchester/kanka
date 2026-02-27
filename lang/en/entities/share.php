<?php

return [
    'title' => 'Share entry',
    'status' => [
        'hidden'    => 'Not visible to non-members',
        'public'    => 'Visible to non-members',
        'unlisted'  => 'Visible to anyone with the link',
        'private'   => 'This campaign is private',
    ],
    'helpers' => [
        'hidden_explanation'          => 'The campaign is public, but this entry is currently hidden from non-members.',
        'hidden_unlisted_explanation'  => 'The campaign is unlisted, only people with the link can find it.',
        'public_explanation'          => 'Both the campaign and this entry are public. Anyone with the link can view it.',
        'unlisted_explanation'        => 'The campaign is unlisted and this entry is visible. Anyone with the link can view it.',
        'private_explanation'         => 'Only members can can access this entry.',
        'campaign_access'               => 'To share this with the public, the campaign itself must be made public first.',
        'entity_permissions_warning'    => 'Making this campaign public lets anyone view it. Entries makes as private stay hidden.',
        'member-link'                   => 'Share this with members only',
    ],
    'fields' => [
        'visibility_mode' => 'Fix visibility',
        'campaign_access' => 'Campaign settings',
    ],
    'options' => [
        'make_entity_public'   => 'Show :name to non-members',
        'make_all_public'      => 'Show all :module to non-members',
        'keep_private'         => 'Keep campaign private',
        'make_campaign_public' => 'Make campaign public',
    ],
    'labels' => [
        'share_link'   => 'Share link',
        'member_link'  => 'Member-only link',
        'public_link'  => 'Public link',
    ],
    'buttons' => [
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
