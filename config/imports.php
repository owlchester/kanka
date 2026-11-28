<?php

return [
    // Days before imports are pruned.
    'prune' => env('CAMPAIGN_IMPORTS_PRUNE', 90),

    'max_size_zip_mb' => env('CAMPAIGN_IMPORTS_MAX_ZIP_MB', 512),

    'max_size_csv_mb' => env('CAMPAIGN_IMPORTS_MAX_CSV_MB', 50),
];
