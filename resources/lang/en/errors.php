<?php

return [
    '403'       => [
        'body'  => 'It looks like you don\'t have permission to access this page!',
        'title' => 'Permission Denied',
    ],
    '403-form'  => [
        'help'  => 'This might be due to your session timing out. Please try logging in again in another window before saving.',
    ],
    '404'       => [
        'body'  => 'Sorry, the page you are looking for could not be found.',
        'title' => 'Page Not Found',
    ],
    '500'       => [
        'body'  => [
            '1' => 'Whoops, looks like something went wrong.',
            '2' => 'A report with the encountered error was sent to us, but sometimes it helps if we can know a little bit more about what you were doing.',
        ],
        'title' => 'Error',
    ],
    '503'       => [
        'body'  => [
            '1' => 'Kanka is currently under maintenance, which usually means an update is underway!',
            '2' => 'Sorry for the inconvenience. Everything will return to normal in just a few minutes.',
        ],
        'json'  => 'Kanka is currently under maintenance, please try again in a few minutes.',
        'title' => 'Maintenance',
    ],
    'footer'    => 'If you need further assistance, please contact us at hello@kanka.io or on the :discord',
];
