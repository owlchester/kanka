<?php

return [
    'tokens' => [
        'admin' => env('BRAGI_ADMIN_LIMIT', 99),
        'elemental' => env('BRAGI_ELEMENTAL_LIMIT', 30),
        'wyvern' => env('BRAGI_WYVERN_LIMIT', 15),
        'all' => 0
    ],
    'limit' => [
        'prompt' => 180,
    ],
    /**
     * Decimal point after 0 of a chance of being a disciple of Kankappy.
     */
    'kankappy' => 5,
];
