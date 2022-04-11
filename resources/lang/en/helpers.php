<?php

return [
    'age'               => [
        'description'   => 'You can link a Character to a calendar of the campaign by viewing a Character and going to the reminders subpage. From there, add a new reminder and set the type to Birth or Death to automatically calculate the character\'s age. If both birth and death are present, both dates will be shown as well as the age at death. If only the birth is set, the date and the current age will be shown. If only the death is set, the date and the years since death will be shown.',
        'title'         => 'Character Age and Death',
    ],
    'api-filters'       => [
        'description'   => 'The following filters are available for the :name API endpoint.',
        'title'         => 'API Filters',
    ],
    'attributes'        => [
        'con'               => 'Con',
        'description'       => 'Use attributes to represent values attached to an entity that aren\'t text. You can reference entities in attributes using the advanced mentions syntax :mention. You can also reference other attributes by using the :attribute syntax.',
        'level'             => 'Level',
        'link'              => 'Attribute options',
        'math'              => 'You can also get creative with some basic math options. For example, :example will multiple the :level and :con attributes of this entity. If you want to round up or down, you can use :floor or :ceil',
        'name'              => 'You can reference the entity\'s name with :name. If an attribute exists with that name, the attribute will be used instead.',
        'pinned'            => 'Pinning an attribute using the :icon icon will make it appear in the entitiy\'s menu below its image.',
        'private'           => 'Private attributes using the :icon will make them only visible to members of the campaign\'s admin role.',
        'range'             => 'Number attributes can be set up to only allow value between a range of numbers. For example, use :example to limit the attribute between 1 and 10. The range values can also reference other attributes, for example with :reference. When saving an attribute, if the value is outside of the range, it will automatically revert to the closest range value.',
        'random'            => 'When creating or editing an attribute template, you can set random attributes. This can either be a random value between two numbers separated by :dash, or a random value from a list of values separated by :comma. The value for the attribute is determined when the template is applied to an entity, or when an entity is saved.',
        'random_examples'   => 'For example, if you want a number between 1 and 100, use :number. If you want a value from a list of options, use :list.',
        'title'             => 'Attributes',
    ],
    'dice'              => [
        'description'               => 'Generic dice rolling is possible by writting "d20", "4d4+4", "d%" for percentile and "df" for fudge.',
        'description_attributes'    => 'It is also possible to get a character\'s attribute by using the {character.attribute_name} syntax. For example, {character.level}d6+{character.wisdom}.',
        'more'                      => 'More options are available and explained on the dice roller plugin page.',
        'title'                     => 'Dice Rolls',
    ],
    'entity_templates'  => [
        'description'   => 'When creating new entities, you can create one based on a template instead of starting from an empty form. To set an entity as a template, view it and click on :link in the :action button next to the entity\'s name. When viewing a list of entities, templates of that entity type will be available next to the :new button. Multiple templates can be set for each entity type.',
        'link'          => 'How to set templates',
        'remove'        => 'To remove an entity as a template, click on the :remove action that replaces the :link action detailed above.',
        'title'         => 'Entity Templates',
    ],
    'filters'           => [
        'attributes'    => [
            'exclude'   => '!Level',
            'first'     => 'You can filter entities based on their attributes. The search fields are exact matches for both the name and value. When the value field is left empty, it looks for entities that have an attribute with that exact name. You can type :exclude to exclude entities with an attribute called Level.',
            'second'    => 'The filter doesn\'t evaluate attribute calculations. If an attribute has a value of :code, searching for the result of that calculation isn\'t possible.',
        ],
        'clipboard'     => 'When filters are active, the copy to clipboard button becomes active. This copies the filters to your clipboard, and you can use those for dashboard widget filters or for quick link filters.',
        'description'   => 'You can use filters to limit the amount of results shown in lists. Text fields support various options to control in further detail what is filtered out.',
        'empty'         => 'Writing :tag in a field will search for all entities where this field is empty.',
        'ending_with'   => 'By placing an :tag at the end of your text, you can search for every entity with exactly this text in the field.',
        'multiple'      => 'You can combine search options on text fields by writing :syntax. For example :example.',
        'session'       => 'Filters and ordered columns set for an entity list are saved into your session, so as long as you stay connected you don\'t need to re-set them on every page.',
        'starting_with' => 'By placing an :tag before your text, you can search for anything that doesn\'t contain the text in the field.',
        'title'         => 'How to use filters',
    ],
    'link'              => [
        'advanced'          => [
            'title' => 'Advanced mentions',
        ],
        'anchor'            => 'The advanced mention can also specify the HTML anchor the link should point to using :example.',
        'attribute'         => [
            'description'   => 'Referencing attributes of this entity is also possible. Simply type :code and three letters or more to display matching attributes on the entity.',
            'title'         => 'Attributes',
        ],
        'auto_update'       => 'Links to other entities will automatically be updated when the target\'s name or description is changed.',
        'description'       => 'You can easily link to other entities in your campaign using the following shorthands.',
        'filtering'         => [
            'description'   => 'Filtering for the exact entity you are looking for is easy.',
            'exact'         => 'Type :code to find an entity that has exactly that name.',
            'space'         => 'Type :code to find an entity with a space in the name.',
            'title'         => 'Filtering',
        ],
        'formatting'        => [
            'text'  => 'The list of allowed HTML tags and attributes can be seen on our :github.',
            'title' => 'Formatting',
        ],
        'friendly_mentions' => 'Link to other entities by typing :code and the first few characters of an entity to search for it. This will inject :example in the text editor, and render as a link to the entity when viewing said entity.',
        'mention_helpers'   => 'If your entity name has a space, use :example instead of space. If you want to search for an entity with exactly that name, type in :exact.',
        'mentions'          => 'Link to other entities by typing :code and the first few characters of an entity to search for it. This will inject :example in the text editor. To customise the name of the entity displayed, you can type :example_name. To set the entity\'s subpage, use :example_page.',
        'mentions_field'    => 'You can also display a field from the entity instead of its name in the link with :code.',
        'month'             => [
            'title' => 'Calendar months',
        ],
        'months'            => 'Type :code to get a list of months from your calendars.',
        'options'           => 'Some options are :options.',
        'overview'          => 'Easily link to existing entities of the campaign by typing :code and three letters or more.',
        'title'             => 'Linking to other entities with mentions',
    ],
    'map'               => [
        'description'   => 'Uploading a map to a location will enable the `Map` menu on the Location\'s view page, and a direct link to the map from the campaign\'s locations page. From the map view, users who can edit the location can activate the \'Edit Mode\' which allows them to place Map Points on the map. These can link to an existing entity or be a label, and have various shapes and sizes.',
        'private'       => 'Members in the campaign\'s Admin role can make a map private. This allows users to view a location but for admins to keep the map a secret.',
        'title'         => 'Location Maps',
    ],
    'pins'              => [
        'description'   => 'Entities can have relations and attributes pinned to the right of their overview. To pin an element, go and edit the relation or attributes and set the pinned value on those.',
        'title'         => 'Entity Pins',
    ],
    'public'            => 'Watch a tutorial video on Youtube explaining public campaigns.',
    'title'             => 'Helpers',
    'troubleshooting'   => [
        'description'       => 'A member of Kanka\'s team has sent you to this page. Select a campaign from the dropdown to generate a token so we can temporarily join your campaign as an admin.',
        'errors'            => [
            'token_exists'  => 'A token already exists for :campaign.',
        ],
        'save_btn'          => 'Generate token',
        'select_campaign'   => 'Select a campaign',
        'subtitle'          => 'Please send help!',
        'success'           => 'Please copy the following token and send it to someone on Kanka\'s team.',
        'title'             => 'Troubleshooting',
    ],
    'widget-filters'    => [
        'description'   => 'You can filter entities displayed on the recently modified widget by providing a list of fields of the entity and values. For example, you can use :example to filter on dead characters of the NPC type.',
        'link'          => 'widget filters',
        'more'          => 'You can copy values from the URL on entity lists. For example, when viewing the characters of the campaign, filter on the kind of characters you want to display, and copy values after the :question in the URL.',
        'title'         => 'Dashboard Widget Filters',
    ],
];
