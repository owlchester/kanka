<?php

return [
    'actions'   => [
        'status'    => 'Visibility: :status',
    ],
    'create'    => [
        'helper'    => 'Create a new role for the campaign.',
    ],
    'overview'  => [
        'limited'   => ':amount of :total roles created.',
        'title'     => 'Available roles',
        'unlimited' => ':amount of unlimited roles created.',
    ],
    'public'    => [
        'helpers' => [
            'intro' => 'Control what non-members can see in the campaign.',
            'main' => 'Select which modules are visible to anyone viewing the campaign, whether they\'re logged in or not. This includes both public visitors and Kanka users who aren\'t campaign members.',
            'preview' => 'Preview as non-member',
            'click' => 'Click any module to toggle public access to all entities within it.',
        ],
    ],
    'show'      => [
        'title' => ':role permissions - :campaign',
    ],
    'toggle'    => [
        'disabled'  => 'Members of the :role role can no longer :action :entities',
        'enabled'   => 'Members of the :role role can now :action :entities',
    ],
    'warnings'  => [
        'adding-to-admin'   => 'Members of the :name role have access to everything in the campaign, and cannot be removed by other members of the role. After :amount minutes, only they can remove themselves from the role.',
    ],
];
