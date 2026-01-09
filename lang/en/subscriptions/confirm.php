<?php

return [
    'actions'   => [
        'pay'       => 'Pay :currency:amount now',
        'paypal'    => 'Pay :currency:amount with PayPal',
        'subscribe' => 'Subscribe for :currency:amount',
    ],
    'helpers'   => [
        'tiny' => 'Thanks for supporting a tiny team of passionate worldbuilders.',
        'auto-renew'    => [
            'monthly'   => 'Your subscription auto-renews every month. Your next billing date is :date.',
            'none'      => 'Paying with PayPal is a one-time payment and doesn\'t auto-renew. You can resubscribe once your subscription ends after :date.',
            'yearly'    => 'Your subscription auto-renews every 12 months. Your next billing date is :date.',
        ],
        'paypal'        => 'You will be redirected to PayPal to complete this transaction.',
        'refund'        => 'We offer a 14 day no-questions-asked refund policy on all yearly subscriptions. Simply email us at :email to initiate a refund process.',
    ],
    'title'     => ':name subscription',
];
