<?php

return [
    'title' => 'Apply for the Spotlight',
    'rules' => 'We select 1–3 campaigns each month to feature on the Kanka Showcase.
Selection isn’t guaranteed. Spotlighted campaigns receive a permanent achievement and a published interview.',
    'started' => 'To get started, select one of your campaigns.',
    'apply' => [
        'errors' => [
            'empty' => 'The question :field needs more content',
        ],
    ],
    'form' => [
        'not-public' => 'This campaign isn\'t publically visible and cannot apply to the spotlight.',
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
        'description' => 'Your application has been submitted and is now under review. You will receive a notification when it has been approved or rejected.',
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
    'overview' => [
        'cta' => 'Apply for spotlight with :name',
        'not-public' => ':name isn\'t a publically visible campaign.',
        'showcase' => 'View Showcase',
    ],
    'faq' => [
        'what' => [
            'q' => 'What is the Spotlight?',
            'a' => 'The Spotlight highlights exceptional campaigns built with Kanka. Selected campaigns are featured on the Kanka Showcase and in a short interview-style blog post.'
        ],
        'who' => [
            'q' => 'Who can apply?',
            'a' => [
                'lead' => 'Any public campaign on Kanka can apply',
                'requirements' => 'Your campaign should:',
                'req1' => 'Be publically accessible',
                'req2' => 'Show active use (content, history, or players)',
                'req3' => 'Represent the kind of worlds others can learn from',
                'end' => 'No minimum size. No system restriction.'
            ]
        ],
        'how' => [
            'q' => 'How are campaigns selected?',
            'a' => [
                'lead' => 'We select 1-3 campaigns per month.',
                'requirements' => 'Selection is editorial, not competitive. We look for:',
                'req1' => 'Clear identity and themes',
                'req2' => 'Thoughtful worldbuilding',
                'req3' => 'Interesting stories or approaches',
                'end' => 'Not follower count. Not popularity. Not membership status',
            ]
        ],
        'selected' => [
            'q' => 'What happens if my campaign is selected?',
            'a' => [
                'lead' => 'If selected:',
                'req1' => 'Your campaign receives the Spotlighted Campaign achievement',
                'req2' => 'We publish a feature on the :blog and :showcase',
                'req3' => 'We might lightly edit your answers for clarity',
                'end' => 'You\'ll be notified before publication.'
            ],
        ],
        'reapply' => [
            'q' => 'Can I apply more than once?',
            'a' => 'Yes. If your campaign isn\'t selected, you\'re welcome to apply again later, especially if your world has evolved.',
        ],
        'finisher' => 'Submitted doesn\'t guarantee selection. We read every application, but can\'t feature them all.',
    ],
];
