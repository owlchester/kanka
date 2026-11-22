<?php

return [
    'actions'       => [
        'status'    => 'Visibility: :status',
    ],
    'create'        => [
        'helper'    => 'Create a new role for the campaign.',
    ],
    'overview'      => [
        'limited'   => ':amount of :total roles created.',
        'title'     => 'Available roles',
        'unlimited' => ':amount of unlimited roles created.',
    ],
    'permissions'   => [
        'campaign-features' => 'Features',
        'content-modules'   => 'Content categories',
        'toggle'            => [
            'action'    => 'Toggle all',
            'tooltip'   => 'Toggle the :action permission for all categories.',
        ],
    ],
    'public'        => [
        'actions'               => [
            'disable_all'   => 'Disable all',
            'enable_all'    => 'Enable all',
        ],
        'disabled_categories'   => [
            'helper'    => 'These categories are currently disabled in your campaign settings. Public access changes here will apply if you re-enable them later.',
            'title'     => 'Disabled categories (:count)',
        ],
        'helpers'   => [
            'click'     => 'Click any category to toggle public access to all entries within it.',
            'intro'     => 'Control what non-members can see in the campaign.',
            'main'      => 'Select which categories are visible to anyone viewing the campaign, whether they\'re logged in or not. This includes both public visitors and Kanka users who aren\'t campaign members.',
            'preview'   => 'Preview as non-member',
        ],
        'private_notice'        => [
            'action'    => 'Change visibility',
            'body'      => 'Non-members cannot view anything yet. Changes you make here will take effect once you switch campaign visibility to Unlisted or Public.',
            'title'     => 'This campaign is currently private.',
        ],
        'status'                => [
            'hidden'    => 'Hidden from guests',
            'visible'   => 'Visible to guests',
        ],
        'summary'               => ':visible of :total categories visible',
        'toggle_all'            => [
            'disabled'  => 'All categories are now hidden from :role.',
            'enabled'   => 'All active categories are now visible to :role.',
        ],
    ],
    'show'          => [
        'title' => ':role permissions - :campaign',
    ],
    'toggle'        => [
        'disabled'  => 'Members of the :role role can no longer :action :entities',
        'enabled'   => 'Members of the :role role can now :action :entities',
    ],
    'warnings'      => [
        'adding-to-admin'   => 'Members of the :name role have access to everything in the campaign, and cannot be removed by other members of the role. After :amount minutes, only they can remove themselves from the role.',
    ],
];
