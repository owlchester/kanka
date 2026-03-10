<?php

return [
    'actions'       => [
        'create'    => 'Create a category',
        'customise' => 'Customise',
    ],
    'create'        => [
        'helper'    => 'Create a new custom category to store entries that don\'t fit in the other categories.',
        'success'   => 'New category created.',
        'title'     => 'New category',
    ],
    'delete'        => [
        'confirm'           => 'Write :code if you are sure you want to permanently delete the :name custom category.',
        'confirm-button'    => '{0} Permanently delete :name|{1} Permanently delete :name and :count entry|[2,*] Permanently delete :name and :count entries',
        'entities'          => '{1} This will permanently delete :count entry.|[2,*] This will permanently delete :count entries.',
        'helper'            => 'Are you sure you want to remove the :name custom category? This will also permanently delete all entries, bookmarks and widgets linked to this category.',
        'success'           => 'Category :name deleted.',
        'title'             => 'Category deletion',
    ],
    'errors'        => [
        'disabled'              => 'The :name category is disabled. :fix',
        'empty-custom'          => 'Add custom categories to organise data that doesn\'t fit in the default ones.',
        'limit'                 => 'Campaigns are currently limited to only :max custom categories while we iron out this new feature.',
        'limit-title'           => 'Custom category limit reached',
        'subscription-limit'    => 'The campaign has reached the maximum amount of custom categories available. The person unlocking premium features can subscribe to a higher tier to increase this limit.',
    ],
    'fields'        => [
        'icon'          => 'Category icon',
        'image'         => 'Placeholder image',
        'plural'        => 'Category plural name',
        'singular'      => 'Category singular name',
        'status'        => 'Category status',
        'update_name'   => 'Rename category bookmark with new name',
    ],
    'helpers'       => [
        'custom'    => 'This is a custom category.',
        'icon'      => 'Give this category a special :fontawesome icon, for example :example.',
        'plural'    => 'Used in navigation and lists (.e.g, "view all potions")',
        'roles'     => 'Select roles that should have permission to view entries of this new category. This can later be changed in the role permissions.',
        'singular'  => 'Used when referring to a single item (e.g., "new potion")',
        'status'    => 'Disabled categories are hidden from navigation and menus. No data is deleted.',
        'tutorial'  => 'Categories control which features are visible in the campaign. Enable the ones you use and hide the rest. Turning a category off never deletes data; it only removes it from navigation and creation menus.',
    ],
    'pitch'         => 'Rename this category and choose a custom icon to better match your theme and style. Perfect for tailoring the experience to your world and players.',
    'pitch-custom'  => 'Create custom category for any of your world\'s needs. Track deities, potions, succession laws, or whatever makes your campaign unique. Premium gives you complete flexibility.',
    'pitch-title'   => 'Unlock custom categories',
    'rename'        => [
        'helper'    => 'Customise how this category appears throughout the campaign. Leave fields blank to use default values.',
        'success'   => 'Category customised.',
        'title'     => 'Customise :module',
    ],
    'reset'         => [
        'default'   => 'This will only reset the default categories, not any custom ones.',
        'success'   => 'The campaign categories have been reset.',
        'title'     => 'Reset custom category names and icons',
        'warning'   => 'Are you sure you want to reset the campaign categories to their original names and icons?',
    ],
    'sections'      => [
        'custom'        => 'Custom categories',
        'default'       => 'Default categories',
        'early-access'  => 'Early access',
        'features'      => 'Features',
    ],
    'states'        => [
        'disable'   => 'Disable',
        'disabled'  => 'Category is disabled',
        'enable'    => 'Enable',
        'enabled'   => 'Category is enabled',
    ],
    'status'        => [
        'enabled'   => 'Category enabled',
    ],
];
