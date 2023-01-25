<?php

return [
    'cards' => [
        'description'   => 'You can subscribe using most credit and debit cards like Visa and Mastercard, as well as Giropay, Sofort, and PayPal for yearly subscriptions.',
    ],

    'faq' => [
        'title' => 'FAQ',
        'description' => 'Here are answers to the most frequent questions we get regarding our subscriptions.',
        'methods' => [
            'title' => 'What are the available payment methods?',
            'answer' => 'We accept most credit and debit cards like Visa, Mastercard and American Express. We also accept Giropay, Sofort, and PayPal for yearly subscriptions.'
        ],
        'security' => [
            'title' => 'Do you store my payment information?',
            'answer' => 'We use Stripe.com to securely handle your payment information, and we only store limited data regarding your payment method. We use this information to notify you when your card is about to expire, so that you can update it and not lose your subscription.',
        ],
        'cancellation' => [
            'title' => 'What happens if I cancel my subscription during a billing period?',
            'answer' => 'When cancelling your subscription, your bonuses stay active until the date of your next billing period.',
        ],
        'resub' => [
            'title' => 'What happens to my data when I resubscribe?',
            'answer' => 'When your subscription ends, all features and subscription related data is disabled but saved on our servers. This means that when you resubscribe, everything will go right back to the way you left it.',
        ],
        'refund' => [
            'title' => 'What is your refund policy?',
            'answer' => 'We offer a no questions asked :amount day refund policy for yearly subscriptions. Simply drop us an email at :email.',
        ],
        'gift' => [
            'title' => 'Can I gift subscriptions?',
            'answer' => 'Gifting subscriptions isn\'t possible, but you can boost any campaign you have access to, even if you aren\'t the campaign\'s admin.',
        ],
    ]
];
