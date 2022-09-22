<?php

return [
    'helpers'   => [
        'main'  => 'Public campaigns are visible to all users that have a link to the campaign or through the :public-campaigns page. Permissions for users viewing the campaign this way is controlled by the campaign\'s :public-role role.',
    ],
    'title'     => 'Change the campaign\'s visibility',
    'update'    => [
        'private'   => 'The campaign is now private, and only visible to members of it.',
        'public'    => 'The campaign is now public. It might take some time to appear in the :public-campaigns page.',
    ],
];
