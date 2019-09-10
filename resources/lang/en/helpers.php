<?php

return [
    'description'   => 'Some helpful tips and tricks to help you out',
    'dice'          => [
        'description'               => 'Generic dice rolling is possible by writting "d20", "4d4+4", "d%" for percentile and "df" for fudge.',
        'description_attributes'    => 'It is also possible to get a character\'s attribute by using the {character.attribute_name} syntax. For example, {character.level}d6+{character.wisdom}.',
        'more'                      => 'More options are available and explained on the dice roller plugin page.',
        'title'                     => 'Dice Rolls',
    ],
    'link'          => [
        'auto_update'   => 'Links to other entities will automatically be updated when the target\'s name or description is changed.',
        'description'   => 'You can easily link to other entities in your campaign using the following shorthands.',
        'limitations' => 'Please note that due to technical limitations, these shorthands don\'t work on android mobile devices.',
        'mentions' => 'Link to other entities by typing :code and the first few characters of an entity to search for it. This will inject :example in the text editor. To customise the name of the entity displayed, you can type :example_name. To set the entity\'s subpage, use :example_page. To set the entity\'s tab, use :example_tab.',
        'months' => 'Type :code to get a list of months from your calendars.',
        'title'         => 'Linking to other entries and shortcuts',
    ],
    'map'           => [
        'description'   => 'Uploading a map to a location will enable the `Map` menu on the Location\'s view page, and a direct link to the map from the campaign\'s locations page. From the map view, users who can edit the location can activate the \'Edit Mode\' which allows them to place Map Points on the map. These can link to an existing entity or be a label, and have various shapes and sizes.',
        'private'       => 'Members in the campaign\'s Admin role can make a map private. This allows users to view a location but for admins to keep the map a secret.',
        'title'         => 'Location Maps',
    ],
    'public'        => 'Watch a tutorial video on Youtube explaining public campaigns.',
    'title'         => 'Helpers',
];
