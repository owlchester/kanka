<?php

return [
    'title' => 'Campaign deletion',
    'helper' => 'Deleting a campaign is a permanent action that cannot be reverted. This will remove all of the data related to the campaign from our servers, including images and assets. We recommend making a :backup before continuing.',
    'backup' => 'backup',
    'issue' => 'The following issue needs to be fixed before the campaign can be deleted.',
    'members' => 'All other members need to be removed from the campaign.',
    'success' => ':name was permanently deleted.',

    'confirm'           => 'If you are sure you want to permanently delete :campaign, write :code in the field below.',
    'confirm-button'    => 'Permanently delete :name',
];
