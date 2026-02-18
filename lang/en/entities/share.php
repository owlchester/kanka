<?php

return [
    'title' => 'Share entity',
    'status' => [
        'hidden'  => 'Not visible to the public',
        'public'  => 'Visible to the public',
        'private' => 'This campaign is private',
    ],
    'helpers' => [
        'hidden_explanation'        => 'The campaign is public, but this entity is currently hidden from guests.',
        'public_explanation'        => 'Both the campaign and this entity are public. Anyone with the link can view it.',
        'private_explanation'       => 'Only invited members can view this entity because the campaign is private.',
        'visibility_mode'           => 'Choose how you want to expose this entity to the public.',
        'campaign_access'           => 'To share this with the public, the campaign itself must be made public first.',
        'entity_permissions_warning' => 'Making this campaign public allows anyone to browse it. Individual entity permissions still apply — entities marked as private will remain hidden.',
    ],
    'fields' => [
        'visibility_mode' => 'Public Access Settings',
        'campaign_access' => 'Campaign Settings',
    ],
    'options' => [
        'make_entity_public'   => 'Make only this entity public',
        'make_all_public'      => 'Make all entities in this campaign public',
        'keep_private'         => 'Keep campaign private',
        'make_campaign_public' => 'Make campaign public',
    ],
    'labels' => [
        'share_link'   => 'Share Link',
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
        'copied_public'  => 'Public link copied, anyone with the link can view the entity.',
        'copied_members' => 'Member-only link copied.',
        'updated'        => 'Visibility settings updated successfully.',
    ],
];