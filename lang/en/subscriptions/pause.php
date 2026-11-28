<?php

return [
    'actions' => [
        'pause' => 'Pause subscription',
        'resume' => 'Resume billing now',
    ],
    'banner' => [
        'body' => 'Your subscription billing is paused until :date. Your perks and Premium Campaigns remain active during the pause.',
        'title' => 'Subscription paused',
    ],
    'cancel_modal' => [
        'helper' => 'Keep your Premium Campaigns and perks intact while taking a break. Billing automatically resumes after your pause.',
        'month' => ':count month|:count months',
        'title' => 'Take a break instead?',
    ],
    'errors' => [
        'ineligible' => 'Your subscription is not eligible to be paused right now.',
        'not_paused' => 'Your subscription is not currently paused.',
    ],
    'success' => [
        'paused' => 'Your subscription is now paused and will automatically resume on :date.',
        'resumed' => 'Your subscription billing has been resumed.',
    ],
];
