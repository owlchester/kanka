<?php
/**
 * Description of
 *
 * @author Jeremy Payne hello@kanka.io
 * 24/04/2020
 */

return [
    'owlbear' => [
        'eur' => env('STRIPE_OWLBEAR_EUR'),
        'usd' => env('STRIPE_OWLBEAR_USD'),
    ],
    'elemental' => [
        'eur' => env('STRIPE_ELEMENTAL_EUR'),
        'usd' => env('STRIPE_ELEMENTAL_USD'),
    ],
];
