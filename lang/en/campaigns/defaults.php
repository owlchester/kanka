<?php

return [
    'fields'    => [
        'character_personality_visibility'  => 'Default character personality visibility',
        'connections'                       => 'Entry relations view',
        'connections_mode'                  => 'Relation map style',
        'descendants'                       => 'Sublist filtering default',
        'entity_privacy'                    => 'New entry visibility',
        'gallery_visibility'                => 'Default gallery image visibility',
        'post_collapsed'                    => 'New article layout',
        'private_mention_visibility'        => 'Private entry mentions',
        'related_visibility'                => 'Related content visibility',
    ],
    'helpers'   => [
        'character_visibility'          => 'Sets visibility for personality traits when creating characters.',
        'connections'                   => 'Choose whether entry relation pages show a visual map or a list by default.',
        'connections_mode'              => 'Set the default layout style for relation maps (available with premium).',
        'descendants'                   => 'When viewing entry sublists (like a location\'s characters), show only direct children or all descendants.',
        'display'                       => 'Set default display options for entry pages.',
        'entity'                        => 'Controls what visibility Kanka applies automatically to new content.',
        'entity_privacy'                => 'Sets visibility for newly created characters, locations, etc.',
        'gallery_visibility'            => 'Default visibility value when uploading images to the gallery.',
        'post_collapsed'                => 'When creating articles, set the article as collapsed or expanded.',
        'privacy'                       => 'Set default visibilities for new content. These settings apply when you create new content and can be changed for individual items.',
        'private_mention_visibility'    => 'When you mention a private entry in visible content, control whether the entry name is shown or hidden.',
        'related_visibility'            => 'Controls visibility for articles, properties, relations added to entries.',
    ],
    'sections'  => [
        'display'   => 'Entry Display Defaults',
        'entity'    => 'Entry defaults',
        'media'     => 'Media defaults',
        'mention'   => 'Mention behaviour',
    ],
    'tutorial'  => 'Streamline content creation with smart defaults. Choose default visibility settings for entries, articles, images, and other content. These preferences will be automatically applied when you create new content, saving you time while keeping your campaign organised.',
    'update'    => [
        'success'   => 'Campaign defaults updated.',
    ],
    'values'    => [
        'collapsed'     => [
            'collapsed' => 'Collapsed',
            'default'   => 'Default',
            'expanded'  => 'Expanded',
        ],
        'connections'   => [
            'explorer'  => 'Relation map (premium)',
            'list'      => 'List interface',
        ],
        'descendants'   => [
            'all'       => 'Show all descendants by default',
            'direct'    => 'Show direct descendants by default',
        ],
        'mentions'      => [
            'private'   => 'Hide target name',
            'visible'   => 'Show target name',
        ],
    ],
];
