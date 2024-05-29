<?php

return [
    'fraud_detection' => env('APP_FRAUD_DETECTION', false),
    'owlbear' => [
        'eur' => [
            'monthly' => env('STRIPE_OWLBEAR_EUR'),
            'yearly' => env('STRIPE_OWLBEAR_EUR_YEARLY'),
        ],
        'usd' => [
            'monthly' => env('STRIPE_OWLBEAR_USD'),
            'yearly' => env('STRIPE_OWLBEAR_USD_YEARLY'),
        ],
        'brl' => [
            'monthly' => env('STRIPE_OWLBEAR_BRL'),
            'yearly' => env('STRIPE_OWLBEAR_BRL_YEARLY'),
        ],
        'monthly' => [
            env('STRIPE_OWLBEAR_EUR'),
            env('STRIPE_OWLBEAR_EUR_OLD'),
            env('STRIPE_OWLBEAR_USD'),
            env('STRIPE_OWLBEAR_USD_OLD'),
            env('STRIPE_OWLBEAR_BRL'),
        ],
        'yearly' => [
            env('STRIPE_OWLBEAR_EUR_YEARLY'),
            env('STRIPE_OWLBEAR_EUR_YEARLY_OLD'),
            env('STRIPE_OWLBEAR_USD_YEARLY'),
            env('STRIPE_OWLBEAR_USD_YEARLY_OLD'),
            env('STRIPE_OWLBEAR_BRL_YEARLY'),
        ],
    ],
    'wyvern' => [
        'eur' => [
            'monthly' => env('STRIPE_WYVERN_EUR'),
            'yearly' => env('STRIPE_WYVERN_EUR_YEARLY'),
        ],
        'usd' => [
            'monthly' => env('STRIPE_WYVERN_USD'),
            'yearly' => env('STRIPE_WYVERN_USD_YEARLY'),
        ],
        'brl' => [
            'monthly' => env('STRIPE_WYVERN_BRL'),
            'yearly' => env('STRIPE_WYVERN_BRL_YEARLY'),
        ],
        'monthly' => [
            env('STRIPE_WYVERN_EUR'),
            env('STRIPE_WYVERN_EUR_OLD'),
            env('STRIPE_WYVERN_USD'),
            env('STRIPE_WYVERN_USD_OLD'),
            env('STRIPE_WYVERN_BRL'),
        ],
        'yearly' => [
            env('STRIPE_WYVERN_EUR_YEARLY'),
            env('STRIPE_WYVERN_EUR_YEARLY_OLD'),
            env('STRIPE_WYVERN_USD_YEARLY'),
            env('STRIPE_WYVERN_USD_YEARLY_OLD'),
            env('STRIPE_WYVERN_BRL_YEARLY'),
        ],
    ],
    'elemental' => [
        'eur' => [
            'monthly' => env('STRIPE_ELEMENTAL_EUR'),
            'yearly' => env('STRIPE_ELEMENTAL_EUR_YEARLY'),
        ],
        'usd' => [
            'monthly' => env('STRIPE_ELEMENTAL_USD'),
            'yearly' => env('STRIPE_ELEMENTAL_USD_YEARLY'),
        ],
        'brl' => [
            'monthly' => env('STRIPE_ELEMENTAL_BRL'),
            'yearly' => env('STRIPE_ELEMENTAL_BRL_YEARLY'),
        ],
        'monthly' => [
            env('STRIPE_ELEMENTAL_EUR'),
            env('STRIPE_ELEMENTAL_EUR_OLD'),
            env('STRIPE_ELEMENTAL_USD'),
            env('STRIPE_ELEMENTAL_USD_OLD'),
            env('STRIPE_ELEMENTAL_BRL'),
        ],
        'yearly' => [
            env('STRIPE_ELEMENTAL_EUR_YEARLY'),
            env('STRIPE_ELEMENTAL_EUR_YEARLY_OLD'),
            env('STRIPE_ELEMENTAL_USD_YEARLY'),
            env('STRIPE_ELEMENTAL_USD_YEARLY_OLD'),
            env('STRIPE_ELEMENTAL_BRL_YEARLY'),
        ],
    ],
    'old' => [
        'all' => [
            env('STRIPE_OWLBEAR_EUR_OLD'),
            env('STRIPE_OWLBEAR_EUR_YEARLY_OLD'),
            env('STRIPE_OWLBEAR_USD_OLD'),
            env('STRIPE_OWLBEAR_USD_YEARLY_OLD'),
            env('STRIPE_WYVERN_EUR_OLD'),
            env('STRIPE_WYVERN_EUR_YEARLY_OLD'),
            env('STRIPE_WYVERN_USD_OLD'),
            env('STRIPE_WYVERN_USD_YEARLY_OLD'),
            env('STRIPE_ELEMENTAL_EUR_OLD'),
            env('STRIPE_ELEMENTAL_EUR_YEARLY_OLD'),
            env('STRIPE_ELEMENTAL_USD_OLD'),
            env('STRIPE_ELEMENTAL_USD_YEARLY_OLD'),
        ],
        'oe' => env('STRIPE_OWLBEAR_EUR_OLD'),
        'oey' => env('STRIPE_OWLBEAR_EUR_YEARLY_OLD'),
        'ou' => env('STRIPE_OWLBEAR_USD_OLD'),
        'ouy' => env('STRIPE_OWLBEAR_USD_YEARLY_OLD'),
        'we' => env('STRIPE_WYVERN_EUR_OLD'),
        'wey' => env('STRIPE_WYVERN_EUR_YEARLY_OLD'),
        'wu' => env('STRIPE_WYVERN_USD_OLD'),
        'wuy' => env('STRIPE_WYVERN_USD_YEARLY_OLD'),
        'ee' => env('STRIPE_ELEMENTAL_EUR_OLD'),
        'eey' => env('STRIPE_ELEMENTAL_EUR_YEARLY_OLD'),
        'eu' => env('STRIPE_ELEMENTAL_USD_OLD'),
        'euy' => env('STRIPE_ELEMENTAL_USD_YEARLY_OLD'),
    ],
];
