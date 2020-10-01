<?php

return [
    'app_backup'            => [
        'answer'    => 'We perform two backups a day to prevent any data loss. Our own campaigns are on the server, so we don’t want to take any risks!',
        'question'  => 'How often is the data on Kanka backed up?',
    ],
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
The best way we can explain Attribute Templates is with an example. Let's imagine that your world has lots of Locations, and on many of those locations, you want to remember to create a custom Attribute for "Population", "Climate", "Crime Level".

Now, you could easily do that on every Location, but it can get tedious, and you might forget sometimes to create the attribute "Crime Level". This is where Attribute Templates come into play.

You can create an Attribute Template with those attributes (Population, Climate, Crime Level, etc), and later apply that template to your locations. This will create the attributes from the template on the locations, so all you have to do is change the values and not have to remember about the attributes!
TEXT
,
        'question'  => 'Attribute Templates, what are they?',
    ],
    'backup'                => [
        'answer'    => 'Once a day, you can export all of your campaign\'s data as a ZIP file. In the app, click on "Campaign" on the left menu, and click on "Export". This will create an export that is available for 30 minutes. You can\'t upload this export to Kanka, it is only intended for your own peace of mind or if you no longer plan to use the app.',
        'question'  => 'How can I backup or export my campaign?',
    ],
    'bugs'                  => [
        'answer'    => 'Simply join our :discord server and report your bug in the #error-and-bugs channel.',
        'question'  => 'How can I report a bug?',
    ],
    'campaign-sync'         => [
        'answer'    => 'Kanka does not have this feature. However, if you\'re trying to have multiple play groups in the same world consider using the same campaign and separating your groups through a combination of quests, tags, and permissions',
        'question'  => 'Can I sync entities across multiple campaigns?',
    ],
    'conversations'         => [
        'answer'    => 'Conversations can be set up as talks between Characters or between Campaign Members. If for example you wish to document an important talk between NPCs and the PCs, you can do so using this module. You can also use them for play-by-post campaigns.',
        'question'  => 'What are Conversations?',
    ],
    'custom'                => [
        'answer'    => 'Kanka comes with a set of predefined entity types that interact with each other. Allowing custom entity types would require rebuilding the app from scratch and defeat the purpose of a tool with predefined types to help out people worldbuild rather than figure out how to organise things. Furthermore, Kanka is flexible with Tags that can represent most custom entity type scenarios.',
        'question'  => 'Can I create custom entity types?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Go to your campaign dashboard, and click on "Campaign" on the left menu. A "Delete" campaign button will appear if you are last member of the campaign. Deleting a campaign is a permanent action that will delete all the data stored on our servers, including images.',
        'question'  => 'How can I delete a campaign?',
    ],
    'early-access'          => [
        'answer'    => 'Early Access is a way for us to reward our amazing subscribers by giving them an exclusive 30 day period where they can try out the latest modules before anyone else.',
        'question'  => 'What is Early Access?',
    ],
    'entity-notes'          => [
        'answer'    => 'All entities have an \'Entity Notes\' tab that are little snippets of text that can be set to only visible by you (great when co-dming), only for members of the admin role, or visible to all. You can also give your players permission to create and edit entity notes on entities without having to allow them editing a whole entity.',
        'question'  => 'How does Kanka handle partially hidden information?',
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
Yes! We strongly believe that your financial situation shouldn't impact your enjoyment of RPGs or world building and we will always keep the core app free. However, if you wish to take a more active role in this journey, support us, and vote on the features that matter the most to you, you can do so through our subscriptions.

In addition to voting on the direction that Kanka takes, supporting us allows you to gain access to :boosters, increase file size upload limits, add your name to the hall of fame, have nicer default icons, and more!
TEXT
,
        'question'  => 'Will the app stay free?',
    ],
    'gods-and-religions'    => [
        'answer'    => 'We recommend creating Gods as Characters, and creating religions as Organisations. If you want to quickly find your deities, we recommend tagging them with an appropriate Tag and/or type.',
        'question'  => 'Where to create Gods and religions?',
    ],
    'help'                  => [
        'answer'    => 'Firstly, thank you for wanting to help out! We are always interested in people who can help out with translations, testing new features, or who can help out new users. We also love when people promote Kanka to reach new users in places we hadn\'t thought of. Your best course of action is to join us on the :discord where a channel is dedicated to helping out.',
        'question'  => 'How can I help?',
    ],
    'map'                   => [
        'answer'    => 'The Maps module supports PNG, JPG, and SVG images. These maps can have layers, groups, and markers pointing of various shapes and sizes that point to other entities in a campaign.',
        'question'  => 'Can I upload maps to Kanka?',
    ],
    'mobile'                => [
        'answer'    => 'There currently is no dedicated mobile app for Kanka, but most of the app works on a mobile device. We hope that the support through subscriptions will allows us to pay someone to build a mobile app one day, but don\'t foresee that happening in the near future.',
        'question'  => 'Is there a mobile app? Is one planned?',
    ],
    'monsters'              => [
        'answer'    => 'We recommend using the Races module for folks, species, monsters, and anything living that isn\'t a character.',
        'question'  => 'Where to create monsters?',
    ],
    'multiworld'            => [
        'answer'    => 'You can be a part of as many campaigns as you want, including those you\'ve created. To switch or create a new campaign, go to your campaign dashboard and in the top right you can click on your current campaign to display the campaign switcher interface.',
        'question'  => 'Can I have more than one campaign?',
    ],
    'nested'                => [
        'answer'    => 'If you prefer viewing your entities in a nested view by default (in example the Nested View button on the list of locations), you can do so by going into your Profile and Layout options. There you can check the Nested View option. This is only for your account and not for your campaigns.',
        'question'  => 'Can I set the lists to be nested by default?',
    ],
    'organise_play'         => [
        'answer'    => 'We\'ve partnered with :lfgm which allows you to organise your sessions with your group. You can sync your Kanka campaign with your LFGM campaign to show your next availabilities directly on the campaign dashboard.',
        'question'  => 'How can I manage when I run my sessions?',
    ],
    'permissions'           => [
        'answer'    => 'Absolutely, this is why we built Kanka! You can invite all your players to your campaigns, and give them roles and permissions. We built the system to be extremely flexible (you can both use an opt-in and opt-out configuration) to cover as many needs and situations as possible.',
        'question'  => 'Can I limit the information my players see in my campaign?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
The long-term plan for Kanka is to build a versatile worldbuilding and campaign management tool that is system agnostic with content managed by the community in the form of "Community Templates". Another goal of ours is to build tools that integrate with other platforms like Virtual Tabletop apps.

We use Kanka ourselves, so we have no plans to ever stop developing and improving it. However, just to be safe, the project is also open source and can be picked up by the community if something were to ever happen to us.
TEXT
,
        'question'  => 'What are the long term plans?',
    ],
    'public-campaigns'      => [
        'answer'    => 'You can browse the :public-campaigns page to see how others use Kanka for their campaigns.',
        'question'  => 'How do others use Kanka?',
    ],
    'renaming-modules'      => [
        'answer'    => 'While this would be easy to do for English and other languages that don\'t use gendered names, being able to change the name of modules would break the grammatical correctness and user experience for a majority of languages Kanka is also available in.',
        'question'  => 'Can I rename modules? For example Families into Clans, or Organisations into Factions?',
    ],
    'sections'              => [
        'community'     => 'Community',
        'general'       => 'General',
        'other'         => 'Other',
        'permissions'   => 'Permissions',
        'pricing'       => 'Pricing',
        'worldbuilding' => 'Worldbuilding',
    ],
    'show'                  => [
        'return'    => 'Return to the FAQ',
        'timestamp' => 'Last updated :date',
        'title'     => 'FAQ :name',
    ],
    'user-switch'           => [
        'answer'    => 'Permissions can get tricky, especially with large campaigns. As a campaign admin, you can navigate to the campaign\'s members page and click the "Switch" button which will appear next to non-admin members of the campaign. Doing so will log you in as that user and allow you to see the campaign as they would. This is the easiest way to check your campaign\'s permissions.',
        'question'  => 'My campaign permissions are set up, how can I test them?',
    ],
    'visibility'            => [
        'answer'    => 'Only the people that you invite to your campaign can see and interact with that you have created. Your data is private and always in your control. You can also set your campaign to public to allow unregistered users to view it.',
        'question'  => 'Can anyone see my world?',
    ],
];
