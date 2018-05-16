<?php

return [
    'campaign' => [
        'leave' => ':user left the campaign :campaign.',
        'join' => ':user joined the campaign :campaign.',
    ],
    'header' => 'You have :count notifications',
    'index' => [
        'title' => 'Notifications',
        'description' => 'Your latest notifications.',
    ],
    'permissions'   => [
        'body'  => 'Hey, we want to let you know that we\'ve completely changed the permissions system for each campaign!</p><p>Campaigns can now have roles, and each role can have permissions to access, edit or delete entities. Each entity can also be fine-tuned with user-specific permissions, meaning Becky and Alfred can edit their own characters!</p><p>The only downside is that campaigns with several users will have to set their new permissions. If you are the Admin of a campaign, you can do that in the campaign management page. If you are part of a campaign, you won\'t see anything until the owner has taken care of it.',
        'title' => 'Permission Changes',
    ],
];
