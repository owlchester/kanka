<?php

return [
    'applied'       => [
        'actions'       => [
            'retract'   => 'Retract application',
        ],
        'description'   => 'Your application has been submitted and is now under review. You will receive a notification when it has been approved or rejected.',
        'title'         => 'Application applied',
    ],
    'apply'         => [
        'errors'    => [
            'empty' => 'The question :field needs more content',
        ],
    ],
    'approved'      => [
        'description'   => 'Congratulations! Your application has been approved and is now featured on the :spotlight page.',
        'title'         => 'Application approved',
    ],
    'faq'           => [
        'finisher'  => 'Submitted doesn\'t guarantee selection. We read every application, but can\'t feature them all.',
        'how'       => [
            'a' => [
                'end'           => 'Not follower count. Not popularity. Not membership status',
                'lead'          => 'We select 1-3 campaigns per month.',
                'req1'          => 'Clear identity and themes',
                'req2'          => 'Thoughtful worldbuilding',
                'req3'          => 'Interesting stories or approaches',
                'requirements'  => 'Selection is editorial, not competitive. We look for:',
            ],
            'q' => 'How are campaigns selected?',
        ],
        'reapply'   => [
            'a' => 'Yes. If your campaign isn\'t selected, you\'re welcome to apply again later, especially if your world has evolved.',
            'q' => 'Can I apply more than once?',
        ],
        'selected'  => [
            'a' => [
                'end'   => 'You\'ll be notified before publication.',
                'lead'  => 'If selected:',
                'req1'  => 'Your campaign receives the Spotlighted Campaign achievement',
                'req2'  => 'We publish a feature on the :blog and :showcase',
                'req3'  => 'We might lightly edit your answers for clarity',
            ],
            'q' => 'What happens if my campaign is selected?',
        ],
        'what'      => [
            'a' => 'The Spotlight highlights exceptional campaigns built with Kanka. Selected campaigns are featured on the Kanka Showcase and in a short interview-style blog post.',
            'q' => 'What is the Spotlight?',
        ],
        'who'       => [
            'a' => [
                'end'           => 'No minimum size. No system restriction.',
                'lead'          => 'Any public campaign on Kanka can apply',
                'req1'          => 'Be publically accessible',
                'req2'          => 'Show active use (content, history, or players)',
                'req3'          => 'Represent the kind of worlds others can learn from',
                'requirements'  => 'Your campaign should:',
            ],
            'q' => 'Who can apply?',
        ],
    ],
    'form'          => [
        'actions'       => [
            'apply'     => 'Submit application',
            'retract'   => 'Retract application',
            'save'      => 'Save draft',
        ],
        'draft'         => 'This is a draft of your application. You can save it and come back to it later.',
        'not-public'    => 'This campaign isn\'t publically visible and cannot apply to the spotlight.',
        'preset'        => 'Tell us a little bit about :campaign and why you think it deserves to be featured. You can save and come back to these questions later.',
        'required'      => 'This field is required.',
        'title'         => 'Spotlight application form',
    ],
    'overview'      => [
        'cta'           => 'Apply for spotlight with :name',
        'not-public'    => ':name isn\'t a publically visible campaign.',
        'showcase'      => 'View Showcase',
    ],
    'placeholders'  => [
        'inspiration'   => 'Books, games, history, music, vibes',
        'kanka'         => 'Tell us a bit about why Kanka ended up being the right tool for your world',
        'proud'         => 'Could be lore, players, longevity, status',
        'stories'       => 'Tragedy, heroism, politics, found family, pure unadulterated chaos',
        'time'          => 'Months, years, decades, over the span of multiple lifetimes?',
        'world'         => 'Themes, emotions, conflicts (the hook)',
    ],
    'questions'     => [
        'inspiration'   => 'What inspires this world',
        'kanka'         => 'Why do you run games in Kanka?',
        'proud'         => 'What are you most proud of?',
        'share'         => 'Allow the Kanka team to use your answer in their marketing materials.',
        'stories'       => 'What kind of stories emerge at the table?',
        'time'          => 'How long have you been building this world?',
        'world'         => 'What is this world really about?',
    ],
    'rejected'      => [
        'description'   => 'Your application has been rejected. Please try again later.',
        'title'         => 'Application rejected',
    ],
    'retract'       => [
        'success'   => 'Your application has been successfully retracted. You can now edit your application again.',
    ],
    'rules'         => <<<'TEXT'
We select 1–3 campaigns each month to feature on the Kanka :showcase.
Selection isn’t guaranteed. Spotlighted campaigns receive a permanent achievement and a published interview.
TEXT
,
    'started'       => 'To get started, select one of your campaigns.',
    'title'         => 'Apply for the Spotlight',
];
