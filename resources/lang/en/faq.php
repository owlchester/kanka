<?php

return [
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
The best way we can explain Attribute Templates is with an example. Let's imagine that your world has lots of Locations, and on many of those locations, you want to remember to create a custom Attribute for "Population", "Climate", "Crime Level". 

Now, you could easily do that on every Location, but it can get tedious, and you might forget sometimes to create the attribute "Crime Level". This is where Attribute Templates come into play.

You can create an Attribute Template with those attributes (Population, Climate, Crime Level, etc), and later apply that template our your locations. This will create the attributes from the template on the locations, so all you have to do is change the values and not have to remember about the attributes!
TEXT
,
        'question'  => 'Attribute Templates, what are they?',
    ],
    'fields'                => [
        'answer'    => 'Answer',
        'category'  => 'Category',
        'locale'    => 'Locale',
        'order'     => 'Order',
        'question'  => 'Question',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'
Yes! We believe that your financial situation shouldn't impact your enjoyment of role playing games or world building, and such will always keep the app free. Thanks to our generous Patrons on :patreon, we are able to cover the monthly server costs and keep the app ad free!
        
Supporting us on Patreon however allows you to increase file size upload limits, adds your name to the Patreon wall of fame, have nicer default icons, vote on prioritising what gets works on and more!
TEXT
,
        'question'  => 'Will the app stay free?',
    ],
    'help'                  => [
        'answer'    => 'Firstly, thank you for wanting to help out! We are always interested in people who can help out with translations, testing new features, or who can help out new users. We also love when people promote Kanka to reach new users in places we hadn\'t thought of. Your best course of action is to join us on the :discord where a channel is dedicated to helping out. We also love our patrons on Patreon if you wish to support us and get access to some perks!',
        'question'  => 'I want to help! What can I do?',
    ],
    'multiworld'            => [
        'answer'    => 'No you don\'t! You can create as many "campaigns" in the app as you want, and have them represent worlds, settings, or whatever you want. Once you have several campaigns, you can easily switch between them',
        'question'  => 'I am building several worlds in different settings, do I need a different account for each world?',
    ],
    'permissions'           => [
        'answer'    => 'Absolutely, this is why we built Kanka! You can invite all your players to your campaigns, and give them roles and permissions. We built the system to be extremely flexible (you can both use an opt-in and opt-out configuration) to cover as many needs and situations as possible.',
        'question'  => 'I want to use Kanka to build my RPG world, but want my players to have access to some of the entities and edit their characters. Is this possible?',
    ],
    'show'                  => [
        'return'    => 'Return to the FAQ',
        'timestamp' => 'Last updated :date',
        'title'     => 'FAQ :name',
    ],
    'visibility'            => [
        'answer'    => 'Only the people that you invite to your campaign can see and interact with that you have created. Your data is private and always in your control.',
        'question'  => 'Can anyone see my world?',
    ],
];
