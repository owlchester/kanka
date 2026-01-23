<?php

return [
    'title' => 'Spotlight application',
    'rules' => 'We feature 1-3 campaigns per month. Submitting doesn\'t guarantee selection, but every featured campaign gets a permanent achievement and spotlight.',
    'started' => 'To get started, select one of your campaigns.',
    'apply' => [
        'errors' => [
            'empty' => 'The question :field needs more content',
        ],
    ],
    'form' => [
        'title' => 'Spotlight application form',
        'preset' => 'Tell us a little bit about :campaign and why you think it deserves to be featured. You can save and come back to these questions later.',
        'actions' => [
            'save' => 'Save draft',
            'apply' => 'Submit application',
            'retract' => 'Retract application',
        ],
        'required' => 'This field is required.',
        'draft' => 'This is a draft of your application. You can save it and come back to it later.',
    ],
    'applied' => [
        'title' => 'Application applied',
        'description' => 'Your application has been submitted and is now under review. You will receive an email when it has been approved or rejected.',
        'actions' => [
            'retract' => 'Retract application',
        ],
    ],
    'questions' => [
        'time' => 'How long have you been building this world?',
        'world' => 'What is this world really about?',
        'proud' => 'What are you most proud of?',
        'inspiration' => 'What inspires this world',
        'stories' => 'What kind of stories emerge at the table?',
        'kanka' => 'Why do you run games in Kanka?',
        'share' => 'Allow the Kanka team to use your answer in their marketing materials.',
    ],
    'placeholders' => [
        'time' => 'Months, years, decades, over the span of multiple lifetimes?',
        'world' => 'Themes, emotions, conflicts (the hook)',
        'proud' => 'Could be lore, players, longevity, status',
        'inspiration' => 'Books, games, history, music, vibes',
        'stories' => 'Tragedy, heroism, politics, found family, pure unadulterated chaos',
        'kanka' => 'Tell us a bit about why Kanka ended up being the right tool for your world',
    ],
    'retract' => [
        'success' => 'Your application has been successfully retracted. You can now edit your application again.',
    ],
    'approved' => [
        'title' => 'Application approved',
        'description' => 'Congratulations! Your application has been approved and is now featured on the :spotlight page.',
    ],
    'rejected' => [
        'title' => 'Application rejected',
        'description' => 'Your application has been rejected. Please try again later.',
    ],
];
