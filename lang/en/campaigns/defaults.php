<?php

return [
    'fields'    => [
        'character_personality_visibility'  => 'Default character personality visibility',
        'connections'                       => 'Entity connections view',
        'connections_mode'                  => 'Connection map style',
        'descendants'                       => 'Sublist filtering default',
        'entity_privacy'                    => 'New entity visibility',
        'gallery_visibility'                => 'Default gallery image visibility',
        'post_collapsed'                    => 'New post layout',
        'private_mention_visibility'        => 'Private entity mentions',
        'related_visibility'                => 'Related content visibility',
    ],
    'helpers'   => [
        'character_visibility'          => 'Sets visibility for personality traits when creating characters.',
        'connections'                   => 'Choose whether entity connections pages show a visual map or a list by default.',
        'connections_mode'              => 'Set the default layout style for connection maps (available with premium).',
        'descendants'                   => 'When viewing entity sublists (like a location\'s characters), show only direct children or all descendants.',
        'display'                       => 'Set default display options for entity pages.',
        'entity'                        => 'Controls what visibility Kanka applies automatically to new content.',
        'entity_privacy'                => 'Sets visibility for newly created characters, locations, etc.',
        'gallery_visibility'            => 'Default visibility value when uploading images to the gallery.',
        'post_collapsed'                => 'When creating posts on entities, set the post as collapsed or expanded.',
        'privacy'                       => 'Set default visibilities for new content. These settings apply when you create new content and can be changed for individual items.',
        'private_mention_visibility'    => 'When you mention a private entity in visible content, control whether the entity name is shown or hidden.',
        'related_visibility'            => 'Controls visibility for posts, attributes, connections added to entities.',
    ],
    'sections'  => [
        'display'   => 'Entity Display Defaults',
        'entity'    => 'Entity defaults',
        'media'     => 'Media defaults',
        'mention'   => 'Mention behaviour',
    ],
    'tutorial'  => 'Streamline content creation with smart defaults. Choose default visibility settings for entities, posts, images, and other content. These preferences will be automatically applied when you create new content, saving you time while keeping your campaign organised.',
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
            'explorer'  => 'Connections map (premium)',
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
