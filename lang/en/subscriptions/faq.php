<?php

return  [
    'title' => 'Frequently Asked Questions',
    'cost' => [
        'question' => 'How much does a subscription cost?',
        'answer' => 'Kanka offers three subscription tiers named after D&D monsters: Owlbear, Wyvern, and Elemental. Pricing varies based on your preferred currency (USD, EUR, or BRL). You\'ll enjoy a 20% discount when choosing an annual subscription instead of monthly billing.'
    ],
    'methods' => [
        'question' => 'What payment methods are accepted?',
        'answer' => 'We accept credit card and PayPal payments in USD, EUR, and BRL. Your payment security is important to us; all credit card processing is handled securely by our trusted payment provider, :stripe.
'
    ],
    'cancellation' => [
        'question' => 'Can I cancel my subscription at any time?',
        'answer' => 'Absolutely! You\'ll find a cancel button right on this page if you\'re currently subscribed. All subscription benefits remain active until the end of your billing period. Please note that PayPal subscriptions automatically end at their conclusion as they don\'t support automatic renewal.
',
    ],
    'trial' => [
        'question' => 'Is there a free trial available?',
        'answer' => 'While we don\'t offer a traditional trial, Kanka\'s free version provides robust worldbuilding and campaign management tools to get you started. When you\'re ready for more, subscribing unlocks premium features like increased image upload limits, an ad-free experience, exclusive Discord roles, and additional enhancements to your worldbuilding toolkit.',
    ],
    'renewal' => [
        'question' => 'Will I be charged automatically when my subscription renews?',
        'answer' => 'Yes, for credit card subscriptions, we\'ll automatically renew your plan at the same rate when your billing period ends. PayPal subscriptions are the exception—they require manual renewal as PayPal doesn\'t support automatic billing continuation for our service.',
    ],
    'downgrade' => [
        'question' => 'How do I upgrade/downgrade my subscription?',
        'answer' => 'You can change your subscription tier anytime. When upgrading, we\'ll only charge you the difference between your current and new plan for the remainder of your billing period. When downgrading, your new lower rate takes effect at your next renewal date, with no interruption to your current benefits.',
    ],
    'data' => [
        'question' => 'What happens to my data if I cancel my subscription?',
        'answer' => 'Rest assured, we never delete your data when a subscription ends. Premium campaigns simply revert to standard functionality, with premium features temporarily disabled. When you resubscribe, all your premium settings and data are immediately restored exactly as you left them.',
    ],
    'refund' => [
        'question' => 'Do you offer refunds?',
        'answer' => 'Yes! We offer a 14-day, no-questions-asked 100% refund policy for all yearly subscriptions. Simply drop us an email at :email asking for your refund, and we\'ll take care of everything for you.',
    ],
    'discount' => [
        'question' => 'Are there any discounts for annual subscriptions?',
        'answer' => 'Yes! We reward our annual subscribers with a 20% discount compared to monthly billing. This is our way of thanking you for your long-term commitment to Kanka.',
    ],
    'sharing' => [
        'question' => 'Can I share my account/subscription with others?',
        'answer' => 'Absolutely! Your subscription allows you to enable premium campaigns that benefit everyone involved. All campaign members enjoy premium features within that campaign, regardless of their personal subscription status, making Kanka perfect for collaborative worldbuilding.',
    ],
    'security' => [
        'question' => 'How secure is my payment information?',
        'answer' => 'Your financial security is our priority. We partner with :stripe, a PCI-compliant payment processor that maintains the highest standards in payment security. All sensitive payment details are handled and stored by Stripe under GDPR-compliant protocols, not on our servers.',
    ],
    'update' => [
        'question' => 'How do I update my billing information?',
        'answer' => 'Updating your billing details is simple, just visit your :billing page in your account settings. There you can modify payment methods, update card information, or change billing addresses as needed.'
    ],
    'fail' => [
        'question' => 'What happens if my payment fails?',
        'answer' => 'If a payment doesn\'t go through, we\'ll notify you by email right away and automatically attempt to charge your card up to three additional times. If these attempts are unsuccessful, your subscription will be paused. You can easily resolve this by updating your :billing information with a valid payment method.',
    ],

];
