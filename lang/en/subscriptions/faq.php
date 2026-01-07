<?php

return [
    'cancellation'  => [
        'answer'    => <<<'TEXT'
Absolutely! You'll find a cancel button right on this page if you're currently subscribed. All subscription benefits remain active until the end of your billing period. Please note that PayPal subscriptions automatically end at their conclusion as they don't support automatic renewal.

TEXT
,
        'question'  => 'Can I cancel my subscription at any time?',
    ],
    'cost'          => [
        'answer'    => 'Kanka offers three subscription tiers named after D&D monsters: Owlbear, Wyvern, and Elemental. Pricing varies based on your preferred currency (USD, EUR, or BRL). You\'ll enjoy two months for free when choosing an annual subscription instead of monthly billing.',
        'question'  => 'How much does a subscription cost?',
    ],
    'data'          => [
        'answer'    => 'Rest assured, we never delete your data when a subscription ends. Premium campaigns simply revert to standard functionality, with premium features temporarily disabled. When you resubscribe, all your premium settings and data are immediately restored exactly as you left them.',
        'question'  => 'What happens to my data if I cancel my subscription?',
    ],
    'discount'      => [
        'answer'    => 'Yes! We reward our annual subscribers with two months for free compared to monthly billing. This is our way of thanking you for your long-term commitment to Kanka.',
        'question'  => 'Are there any discounts for annual subscriptions?',
    ],
    'downgrade'     => [
        'answer'    => 'You can change your subscription tier anytime. When upgrading, we\'ll only charge you the difference between your current and new plan for the remainder of your billing period. When downgrading, your new lower rate takes effect at your next renewal date, with no interruption to your current benefits.',
        'question'  => 'How do I upgrade/downgrade my subscription?',
    ],
    'fail'          => [
        'answer'    => 'If a payment doesn\'t go through, we\'ll notify you by email right away and automatically attempt to charge your card up to three additional times. If these attempts are unsuccessful, your subscription will be paused. You can easily resolve this by updating your :billing information with a valid payment method.',
        'question'  => 'What happens if my payment fails?',
    ],
    'methods'       => [
        'answer'    => <<<'TEXT'
We accept credit card and PayPal payments in USD, EUR, and BRL. Your payment security is important to us; all credit card processing is handled securely by our trusted payment provider, :stripe.

TEXT
,
        'question'  => 'What payment methods are accepted?',
    ],
    'refund'        => [
        'answer'    => 'Yes! We offer a 14-day, no-questions-asked 100% refund policy for all yearly subscriptions. Simply drop us an email at :email asking for your refund, and we\'ll take care of everything for you.',
        'question'  => 'Do you offer refunds?',
    ],
    'renewal'       => [
        'answer'    => 'Yes, for credit card subscriptions, we\'ll automatically renew your plan at the same rate when your billing period ends. PayPal subscriptions are the exception, they require manual renewal as PayPal doesn\'t support automatic billing continuation for our service.',
        'question'  => 'Will I be charged automatically when my subscription renews?',
    ],
    'security'      => [
        'answer'    => 'Your financial security is our priority. We partner with :stripe, a PCI-compliant payment processor that maintains the highest standards in payment security. All sensitive payment details are handled and stored by Stripe under GDPR-compliant protocols, not on our servers.',
        'question'  => 'How secure is my payment information?',
    ],
    'sharing'       => [
        'answer'    => 'Absolutely! Your subscription allows you to enable premium campaigns that benefit everyone involved. All campaign members enjoy premium features within that campaign, regardless of their personal subscription status, making Kanka perfect for collaborative worldbuilding.',
        'question'  => 'Can I share my account/subscription with others?',
    ],
    'title'         => 'Frequently Asked Questions',
    'trial'         => [
        'answer'    => 'While we don\'t offer a traditional trial, Kanka\'s free version provides robust worldbuilding and campaign management tools to get you started. When you\'re ready for more, subscribing unlocks premium features like increased image upload limits, an ad-free experience, exclusive Discord roles, and additional enhancements to your worldbuilding toolkit.',
        'question'  => 'Is there a free trial available?',
    ],
    'update'        => [
        'answer'    => 'Updating your billing details is simple, just visit your :billing page in your account settings. There you can modify payment methods, update card information, or change billing addresses as needed.',
        'question'  => 'How do I update my billing information?',
    ],
    'why' => [
        'answer' => 'Kanka is built and maintained by a tiny, independent team. Subscriptions are what allow us to work on it long-term, improve it steadily, and keep it free of dark patterns. You\'re not paying a corporation, you\'re directly funding the people who design, build, and support the platform.',
        'question' => 'Why does Kanka charge for subscriptions?'
    ],
    'help' => [
        'answer' => 'Your subscription pays for our time, our servers, and the freedom to keep Kanka sustainable without chasing growth at all costs. It lets us fix bugs faster, build features we actually believe in, and stay responsive to the community instead of investors. Quite simply: it keeps Kanka alive and getting better.',
        'question' => 'How does my subscription help Kanka?',
    ],
];
