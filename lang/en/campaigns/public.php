<?php

return [
    'helpers'   => [
        'main'  => 'Campaigns can be set to either be public or private. Public campaigns are visible to all users that have a link to the campaign, and also show up on in the :public-campaigns. This setting only controls access to the campaign. Permissions to view content of the campaigns still need to be set up through the :public-role role.',
    ],
    'title'     => 'Change the campaign\'s visibility',
    'update'    => [
        'private'   => 'The campaign is now private, and only visible to members of it.',
        'public'    => 'The campaign is now public. It might take some time to appear in the :public-campaigns page.',
    ],
];
