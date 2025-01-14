<?php

return [
    'hard_delete' => env('APP_ENTITY_HARD_DELETE', 30),
    'hard_delete_posts' => env('APP_ENTITY_HARD_DELETE_POSTS', 30),
    'logs' => env('APP_ENTITY_FULL_LOGS', 30),
    'logs_delete' => env('APP_ENTITY_LOGS_DELETE', 365),
    // Experimental flag
    'custom' => env('APP_CUSTOM_ENTITIES', false),

    'ids' => [
        'character' => 1,
        'family' => 2,
        'location' => 3,
        'organisation' => 4,
        'item' => 5,
        'note' => 6,
        'event' => 7,
        'calendar' => 8,
        'race' => 9,
        'quest' => 10,
        'journal' => 11,
        'tag' => 12,
        'dice_roll' => 13,
        'conversation' => 14,
        'attribute_template' => 15,
        'ability' => 16,
        'map' => 17,
        'timeline' => 18,
        'bookmark' => 19,
        'creature' => 20,
    ],

    'classes' => [
        'ability' => 'App\Models\Ability',
        'character' => 'App\Models\Character',
        'calendar' => 'App\Models\Calendar',
        'conversation' => 'App\Models\Conversation',
        'creature' => 'App\Models\Creature',
        'event' => 'App\Models\Event',
        'family' => 'App\Models\Family',
        'item' => 'App\Models\Item',
        'journal' => 'App\Models\Journal',
        'location' => 'App\Models\Location',
        'map' => 'App\Models\Map',
        'note' => 'App\Models\Note',
        'organisation' => 'App\Models\Organisation',
        'quest' => 'App\Models\Quest',
        'race' => 'App\Models\Race',
        'tag' => 'App\Models\Tag',
        'timeline' => 'App\Models\Timeline',
        'attribute_template' => 'App\Models\AttributeTemplate',
        'dice_roll' => 'App\Models\DiceRoll',
        'bookmark' => 'App\Models\Bookmark',
        'relation' => 'App\Models\Relation',
    ],

    'classes-plural' => [
        'abilities' => 'App\Models\Ability',
        'characters' => 'App\Models\Character',
        'calendars' => 'App\Models\Calendar',
        'conversations' => 'App\Models\Conversation',
        'creatures' => 'App\Models\Creature',
        'events' => 'App\Models\Event',
        'families' => 'App\Models\Family',
        'items' => 'App\Models\Item',
        'journals' => 'App\Models\Journal',
        'locations' => 'App\Models\Location',
        'maps' => 'App\Models\Map',
        'notes' => 'App\Models\Note',
        'organisations' => 'App\Models\Organisation',
        'quests' => 'App\Models\Quest',
        'races' => 'App\Models\Race',
        'tags' => 'App\Models\Tag',
        'timelines' => 'App\Models\Timeline',
        'attribute_templates' => 'App\Models\AttributeTemplate',
        'dice_rolls' => 'App\Models\DiceRoll',
        'bookmarks' => 'App\Models\Bookmark',
        'relations' => 'App\Models\Relation',
    ],

    'icons' => [
        'character' => 'fa-duotone fa-user',
        'family' => 'fa-duotone fa-family',
        'location' => 'fa-duotone fa-circle-location-arrow',
        'organisation' => 'fa-duotone fa-screen-users',
        'item' => 'fa-duotone fa-gem',
        'note' => 'fa-duotone fa-book-open',
        'event' => 'fa-duotone fa-cake-candles',
        'calendar' => 'fa-duotone fa-calendar',
        'race' => 'fa-duotone fa-person-fairy',
        'quest' => 'fa-duotone fa-sign-hanging',
        'journal' => 'fa-duotone fa-books',
        'tag' => 'fa-duotone fa-tags',
        'dice_roll' => 'fa-duotone fa-dice',
        'conversation' => 'fa-duotone fa-comments',
        'attribute_template' => 'fa-duotone fa-file-export',
        'ability' => 'fa-duotone fa-fire',
        'map' => 'fa-duotone fa-map',
        'timeline' => 'fa-duotone fa-list-timeline',
        'bookmark' => 'fa-duotone fa-bookmark',
        'creature' => 'fa-duotone fa-deer',
    ]
];
