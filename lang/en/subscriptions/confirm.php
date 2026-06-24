<?php

return [
    'actions'   => [
        'pay'       => 'Pay :currency:amount now',
        'subscribe' => 'Subscribe for :currency:amount',
    ],
    'helpers'   => [
        'auto-renew'    => [
            'monthly'   => 'Your subscription auto-renews every month. Your next billing date is :date.',
            'yearly'    => 'Your subscription auto-renews every 12 months. Your next billing date is :date.',
        ],
        'refund'        => 'We offer a 14 day no-questions-asked refund policy on all yearly subscriptions. Simply email us at :email to initiate a refund process.',
        'tiny'          => 'Thanks for supporting a tiny team of passionate worldbuilders.',
    ],
    'title'     => ':name subscription',
];
