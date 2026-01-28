<?php

return [
    'apps'              => [
        'discord'   => [
            'invalid'   => 'Your Discord token has expired. Please re-sync your Discord and Kanka account.',
        ],
    ],
    'campaign'          => [
        'application'       => [
            'approved'              => 'Your application to the :campaign has been approved.',
            'approved_message'      => 'Your application to the :campaign has been approved. Message provided: :reason',
            'new'                   => 'New application for :campaign.',
            'rejected'              => 'Your application to the :campaign has been rejected. Reason provided: :reason',
            'rejected_no_message'   => 'Your application to the :campaign has been rejected.',
        ],
        'asset_export'      => 'An export for :campaign\'s assets is available. The link is available for :time minutes.',
        'boost'             => [
            'add'           => ':user is now boosting :campaign.',
            'remove'        => ':user is no longer boosting :campaign.',
            'superboost'    => ':user is now superboosting :campaign.',
        ],
        'created'           => 'You have created :campaign.',
        'deleted'           => ':campaign was deleted.',
        'export'            => 'An export for :campaign is available. The link is available for :time minutes.',
        'export_error'      => 'An error occurred while exporting :campaign. Please contact us if this problem persists.',
        'hidden'            => 'The campaign :campaign is now hidden from the public campaigns page.',
        'import'            => [
            'failed'        => 'The import for :campaign failed.',
            'success'       => 'The import finished for :campaign.',
            'csv_success'   => 'Successfully imported :count entities via CSV import to :campaign.',
            'csv_ready'     => 'The CSV import for :campaign is ready.',
        ],
        'join'              => ':user joined :campaign.',
        'leave'             => ':user left :campaign.',
        'new_owner'         => 'You have been made an admin of :campaign.',
        'plugin'            => [
            'deleted'   => 'The plugin :plugin was deleted from the marketplace and removed from :campaign.',
        ],
        'premium'           => [
            'add'       => ':user has unlocked premium features for :campaign.',
            'remove'    => ':user has stopped unlocking premium features for :campaign.',
        ],
        'removed-image'     => 'The image or header of :entity was removed due to a copyright claim.',
        'role'              => [
            'add'       => 'You have been added to the :role role of :campaign.',
            'remove'    => 'You have been removed from the :role role of :campaign.',
        ],
        'troubleshooting'   => [
            'joined'    => 'The Kanka team-member :user joined :campaign.',
        ],
    ],
    'clear'             => [
        'action'    => 'Clear all',
        'success'   => 'Notifications removed.',
        'title'     => 'Clear notifications',
    ],
    'features'          => [
        'approved'  => 'Your idea :feature has been approved.',
        'finished'  => 'Your idea :feature is now available in Kanka!',
        'rejected'  => 'Your idea :feature has been rejected, reason: :reason.',
    ],
    'header'            => 'You have :count notifications',
    'index'             => [
        'title' => 'Notifications',
    ],
    'map'               => [
        'chunked'   => 'Map :name has finished chunking and is now usable.',
    ],
    'no_notifications'  => 'Notifications will appear here once you have some.',
    'plugins'           => [
        'comments'  => [
            'new_comment'   => ':user has left a new comment on the plugin :plugin.',
            'new_reply'     => ':user has replied to your comment in :plugin.',
        ],
    ],
    'subscriptions'     => [
        'charge_fail'   => 'An error occurred while processing your payment. Please wait a moment while we try again. If nothing changes, please contact us.',
        'deleted'       => 'Your subscription to Kanka was automatically cancelled after too many failed attempts to charge your card. Please go to your Subscription settings and try updating your payment details.',
        'ended'         => 'Your subscription to Kanka has ended. Your premium campaigns and Discord roles have been disabled. We hope to see you back soon!',
        'failed'        => 'We couldn\'t charge your payment details. Please update them in your Payment Method settings.',
        'started'       => 'Your subscription to Kanka has started.',
        'trial'         => 'Your free trial to Kanka has ended. We hope you loved it and hope to see you back soon!',
    ],
    'unread'            => 'New notification',
];
