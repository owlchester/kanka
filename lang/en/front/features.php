<?php

return [
    'abilities'     => [
        'description'   => 'As with inventories, every entity can have abilities. Create abilities in your campaign, and attach them to your entities. These can be the powers of a character, the effects of a lair (location), a special ability granted from being part of a family, or a curse caused by eating a hag\'s cupcake. Abilities have charges to keep track of how often they were used, and can be combined with an entity\'s attributes.',
        'title'         => 'Abilities',
    ],
    'attributes'    => [
        'description'   => <<<'TEXT'
Probably the most confusing and complex feature of entities are their attributes. These can be little bits of information like tracking a character's HP, a location's population, a religion (organisation)'s number of shrines, etc. Attributes of an entity can reference each other to calculate values, for example a character's HP, where HP = Level * Constitution.

TEXT
,
        'secondary'     => 'An entity\'s attributes can also be styled to look like a TTRPG character sheet by using our  :marketplace.',
        'title'         => 'Attributes',
    ],
    'boosters'      => [
        'description'   => 'Some features are only available to boosted campaigns. When a user subscribes to Kanka, they gain a set number of boosts that they can attribute to one or several campaigns. These boosts can be moved around from one campaign to another, such as when a campaign ends. As long as a user stays a subscriber, they keep their boosts.',
        'link'          => 'See all boosted features on our pricing page.',
        'title'         => 'Campaign Boosters',
    ],
    'calendars'     => [
        'description'   => 'Create one or several calendars of your world, fully controlling the number of days in a year, the months, length of weeks, seasons, moons and their phases, and more. Attach events to your calendars linked to other entities, such as automatically calculating a character\'s age based on the calendar.',
    ],
    'collaborative' => [
        'description'   => 'We\'ve built Kanka to support worlds with multiple members and multiple campaigns. Add your friends to the campaign, assign them to one or several roles, and control what features and information they have access to. You can also  view the campaign as a member at any time, just to make sure you haven\'t left content visible that shouldn\'t be.',
    ],
    'dashboards'    => [
        'description'   => 'The dashboard is the central hub where you control your campaign. Each campaign can fully customise the dashboard, adding widgets from a long list of available options. For large campaigns with multiple groups, Boosted Campaigns can create multiple dashboards tailored to each role.',
        'title'         => 'Campaign Dashboards',
    ],
    'discover-all'  => 'Discover our amazing features',
    'editor'        => [
        'description'   => 'You won\'t need to learn programming to create beautiful texts. Thanks to :summernote, you can create rich text for all your texts. Best of all, we\'ve added support for mentions to other entities by using the :at-code symbol.',
        'title'         => 'Editor',
    ],
    'entity'        => [
        'description'   => 'Kanka is built around a list of around 20 different entities. These are the pre-defined types of core objects in a campaign. They include characters, locations, families, items, quests, journals, calendars, timelines, and more. They all share some functionality but are unique in their own way and interact with other elements of your campaign.',
        'title'         => 'Entities in Kanka',
    ],
    'free'          => [
        'description'   => 'Tired of having to pay for basic features like unlimited campaigns, having limits on the number of elements in a campaign, or not being able to control who sees what? We are too, which is why all core features of Kanka are absolutely free. We also have some :bonuses that are nice to have, though not essential.',
    ],
    'gm'            => [
        'title' => 'Game Masters',
    ],
    'inventory'     => [
        'description'   => 'Every entity can have its own inventory. This feature is used to manage a character\'s possessions, a shop\'s (location) sale inventory, a quest\'s reward for completion, a family\'s fortune, or any other scenarios you can think of. The inventory feature interacts with the items of your campaign, but is flexible and can be used without creating every item in your campaign.',
        'title'         => 'Inventory',
    ],
    'journals'      => [
        'description'   => 'Plan your session or write a session recap in the eyes of a character using our journals module. These can be attached to calendars to keep track of both a real world date and an in-game date where something happened.',
        'title'         => 'Journals',
    ],
    'links'         => [
        'description'   => 'Entities in a boosted campaign have a new type of asset that can be attached to it: links. These are displayed in the overview of an entity and allow to add external links, such as going to a character\'s DNDBeyond page.',
        'title'         => 'Links',
    ],
    'maps'          => [
        'description'   => 'Upload your beautiful maps to your Kanka campaign, and add layers and pins to them. Control who can see which pin, to avoid revealing the secret location of an infamous city to your players.',
    ],
    'marketplace'   => [
        'description'   => 'Boosted campaigns can install plugins from the :marketplace. These are themes, attribute templates or content packs, which are created by the community for the community.',
        'title'         => 'Marketplace',
    ],
    'modular'       => [
        'description'   => 'We\'ve focused our efforts on building about 20 different modules in Kanka that each focus on one aspect of playing a TTRPG or wordbuilding in general. In each campaign, you can create characters, locations, families, organisations, items, quests, journals, calendars, events, abilities and more. Don\'t need abilities? No problem, you can disable modules of your choice in each campaign, simplifying your setup to focus on what\'s important to you.',
    ],
    'other_features'=> 'Other features',
    'quests'        => [
        'description'   => 'Prepare and keep track of your game\'s quests, where they will take the players, who\'s involved, and what organisations are secretly pulling the strings. Once a quest is complete, flag it as such and move on to the next one.',
        'title'         => 'Quests',
    ],
    'register'      => 'Like what you see? Create a free account now',
    'relations'     => [
        'description'   => 'Need to keep track that Svynna is the rival of Mykel, or that Washington is the birthplace of Kyle? Use our relations tool to set up and keep track of all the connections between the entities of your world. Need a relation to be kept secret from your players? Easy, just set the relation to private!',
        'secondary'     => ':boosted-campaigns have access to a visual explorer for the relations of an entity.',
    ],
    'sections'      => [
        'boosted'       => 'Boosted features',
        'general'       => 'General',
        'rpg'           => 'RPGs',
        'worldbuilding' => 'Worldbuilding',
    ],
    'theming'       => [
        'description'   => 'Boosted campaigns can force the theme users see when viewing it, but also write their own CSS to fully customise the campaign\'s look and feel.',
        'title'         => 'Theming',
    ],
    'timelines'     => [
        'description'   => 'Timelines allow you to visually see and plan out a country\'s history, a family\'s rise to power, a character\'s story arc, and other options. Timelines are split in eras, and each era contains elements of text that can be attached to other entities of your campaign.',
    ],
    'updates'       => [
        'description'   => 'Kanka isn\'t just a :small-team consisting of two passionate worldbuilders. It\'s a huge community of dedicated users who help us shape and push frequent updates. We take pride in focusing on features that our community want and love. On average, we release two big updates every month to all users, and some months we spoil our users with more. We regularly go into detail about these upcoming updates and collect feedback on our Discord.',
        'small-team'    => 'team',
        'title'         => 'Frequent updates',
    ],
    'worldbuilding' => [
        'title' => 'Worldbuilders',
    ],
];
