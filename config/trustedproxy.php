<?php

return [
    'defined' => env('TRUSTED_PROXIES', false),
    'proxies' => explode(',', env('TRUSTED_PROXIES', '')),
];
