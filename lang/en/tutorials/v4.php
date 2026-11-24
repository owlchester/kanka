<?php

return [
    'dashboard' => [
        'actions'   => [
            'dismiss'   => 'Got it, thanks',
            'start'     => 'Take a quick tour',
        ],
        'body'      => 'We redesigned Kanka to feel cleaner, less cluttered, and stay out of your way while you build your worlds. A few navigation buttons moved, so we put together a quick tour to show you where things are now.',
        'steps'     => [
            'campaigns'     => [
                'body_desktop'  => 'Click your campaign name at the top of the sidebar (or the world icon when collapsed) to switch campaigns or create a new one.',
                'body_mobile'   => 'Open the Account tab at the bottom to switch between your campaigns or start a new one.',
                'title'         => 'Campaign switcher',
            ],
            'profile'       => [
                'body_desktop'  => 'Your account, settings, and notifications now live here. Click your name or avatar to open the menu.',
                'body_mobile'   => 'Your account, settings, and notifications live in the Account tab at the bottom of your screen.',
                'title'         => 'Your profile and notifications',
            ],
            'search_create' => [
                'body_desktop'              => 'Jump to anything with Search (press K) or use the + button (press N) to quickly create a new entry from anywhere.',
                'body_desktop_search_only'  => 'Jump to anything in this campaign with Search (press K).',
                'body_mobile'               => 'Use Search to find anything in your campaign, or tap Create to quickly add a new entry.',
                'body_mobile_search_only'   => 'Use Search at the bottom of your screen to find anything in this campaign.',
                'title'                     => 'Search and quick create',
                'title_search_only'         => 'Search your campaign',
            ],
        ],
        'title'     => 'Welcome to Kanka v4',
        'tour'      => [
            'back'      => 'Back',
            'done'      => 'Done',
            'next'      => 'Next',
            'skip'      => 'Skip tour',
            'step_of'   => 'Step :current of :total',
        ],
    ],
    'entry_form'=> [
        'actions'   => [
            'dismiss'   => 'No thanks',
            'try'       => 'Try it out',
        ],
        'body'      => 'We built a cleaner, writing-focused layout for creating and editing entries. Want to try it out? You can switch back anytime in your Appearance settings.',
        'title'     => 'Try the new entry editor layout',
    ],
];
