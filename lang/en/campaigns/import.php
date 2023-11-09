<?php

return [
    'actions' => [
        'import' => 'Upload the export',
    ],
    'title' => 'Import',
    'fields' => [
        'file' => 'Export ZIP file',
    ],
    'status' => [
        'running' => 'Running',
        'queued' => 'Queued',
        'finished' => 'Finished',
        'failed' => 'Failed',
    ],
];
