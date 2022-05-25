<?php

return [
    'actions' => [
        'export' => 'Export the campaign data',
    ],
    'errors'            => [
        'limit' => 'The campaign has already been exported once today. Please try again tomorrow.',
    ],
    'success' => 'The campaign export is being prepared. You will be notified in Kanka once it\'s ready for downloading.',
    'title' => 'Campaign Export',
    'helpers' => [
        'intro' => 'A campaign can be exported once a day by the campain\'s admins. This will generate two zip files in the backgroun. The first zip file contains all of the campaign\'s entities, while the second zip files contains all the images. You will receive a notification in Kanka as soon as the zip files are ready to be downloaded.',
        'json' => 'The exported content is provided in the JSON file format. JSON is a text-based format, and you can open it in a text editor or in the browser.',
        'import' => 'These exports cannot be re-imported, and are meant for your own peace of mind or if you no longer plan on using Kanka. For a more robust export and import experience, please look at the :api.'
    ],
];
