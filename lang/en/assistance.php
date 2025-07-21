<?php

return [
    'fields'        => [
        'campaign'  => 'Campaign',
    ],
    'opening'       => 'A member of Kanka\'s team has sent you to this page with the goal of assisting you.',
    'placeholders'  => [
        'campaign'  => 'Select a campaign you are an admin of',
    ],
    'select'        => 'Select a campaign you are an admin of from the dropdown below to generate a special one-time usage token, which will allow a member of the Kanka team to temporarily join the campaign as an admin.',
    'success'       => [
        'opening'   => 'Your assistance token has been successfully generated. The Kanka team has been notified and will join your campaign shortly to help you out. We\'ll usually reach out via :discord if we need to coordinate anything directly.',
        'secret'    => 'Only a verified Kanka team member can use this token, it\'s useless to anyone else, so there\'s no need to treat it like a secret.',
        'token'     => 'Your assistance token:',
    ],
    'title'         => 'Assistance',
];
