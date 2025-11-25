<?php

return [
    'campaign'      => [
        'name'  => ':user\'s world',
    ],
    'name' => ':name (example)',
    'character1'    => [
        'fears'     => 'James is scared of loud noises and explosions.',
        'history'   => 'This is an example character. Born to Mance Owlchester and Rige Dunton, James grew up in the countryside of Genory before moving to the capital city of Unria to work as a scribe for the king.',
        'name'      => 'James Owlchester',
        'race'      => 'Human',
        'sex'       => 'Male',
        'title'     => 'Grey Hunter',
        'traits'    => 'Will always bend the truth to his advantage.',
    ],
    'character2'    => [
        'fears'     => 'Create the biggest explosion possible',
        'history'   => 'This is an example character. From a young age, Irwie has always been fascinated by explosives, and has dedicated her career to the craft.',
        'name'      => 'Irwie Gemstone',
        'race'      => 'Gnome',
        'sex'       => 'Female',
        'title'     => 'Queen of Explosions',
        'traits'    => 'Want to track something else? We\'ve got you covered with this free text section!',
    ],
    'kingdom1'      => [
        'description'   => 'This is an example location created to show you what can be done with the app.',
        'history'       => '(example) The Kingdom of Genory was founded by Genorian tribesmen in the late 5th century after they invaded the lands from the Hottens.',
        'name'          => 'Genory',
        'type'          => 'Kingdom',
    ],
    'kingdom2'      => [
        'description'   => '(example) Ulyss is the capital city of the kingdom of Genory, and third biggest city of Agagir Alliance.',
        'history'       => '(example) Ulyss is the capital city of the kingdom of Genory. It was founded by Frasan Irwen and is located on the Unri river.',
        'name'          => 'Ulyss',
        'type'          => 'Capital',
    ],
    'note1'         => [
        'entry'         => <<<'TEXT'
Welcome to Kanka! Your first campaign has been created and we have included a couple of example entities as inspiration (you can delete them whenever).

You'll probably want to get started by adding some entities of your own, so chose a category from the left and get started. You can disable unneeded categories of entity from the campaign settings, this will hide them from the menu.

A few tips to get you started:
- You can type @entityName to link to specific entities. The displayed link text will automatically update if you rename or update the linked entity.
- You can configure account specific settings like themes and entities per page in your profile, accessible on the top right.
- You can set permissions on whole entity types as well as individually on each entity.
- There is a growing list of tutorials on :youtube. Tutorials include attributes and how to share your campaign with other people. The :faq may also be useful.

Last but not least:
- Have a look at :public for inspiration on how others use Kanka.
- If you have questions, suggestions or just want to chat, join us on :discord.
- Loving the app and want to support its growth? Consider supporting Kanka through :subscriptions.
TEXT
,
        'name'          => 'Welcome Note',
        'subscriptions' => 'Subscriptions',
    ],
];
