<?php

return [
    'buttons'   => [
        'copy'          => 'Copy link',
        'make_public'   => 'Make campaign public',
    ],
    'fields'    => [
        'campaign_access'   => 'Campaign settings',
        'visibility_mode'   => 'Fix visibility',
    ],
    'helpers'   => [
        'campaign_access'               => 'To share this with the public, the campaign itself must be made public first.',
        'entity_permissions_warning'    => 'Making this campaign public lets anyone view it. Entries makes as private stay hidden.',
        'hidden_explanation'            => 'The campaign is public, but this entry is currently hidden from non-members.',
        'hidden_unlisted_explanation'   => 'The campaign is unlisted, only people with the link can find it.',
        'member-link'                   => 'Share this with members only',
        'private_explanation'           => 'Only members can can access this entry.',
        'public_explanation'            => 'Both the campaign and this entry are public. Anyone with the link can view it.',
        'unlisted_explanation'          => 'The campaign is unlisted and this entry is visible. Anyone with the link can view it.',
    ],
    'labels'    => [
        'member_link'   => 'Member-only link',
        'public_link'   => 'Public link',
        'share_link'    => 'Share link',
    ],
    'options'   => [
        'keep_private'          => 'Keep campaign private',
        'make_all_public'       => 'Show all :module to non-members',
        'make_campaign_public'  => 'Make campaign public',
        'make_entity_public'    => 'Show :name to non-members',
    ],
    'status'    => [
        'hidden'    => 'Not visible to non-members',
        'private'   => 'This campaign is private',
        'public'    => 'Visible to non-members',
        'unlisted'  => 'Visible to anyone with the link',
    ],
    'success'   => [
        'copied'            => 'Link copied to clipboard!',
        'copied_members'    => 'Member-only link copied.',
        'copied_public'     => 'Public link copied, anyone with the link can view the entry.',
        'updated'           => 'Visibility settings updated successfully.',
    ],
    'title'     => 'Share entry',
];
