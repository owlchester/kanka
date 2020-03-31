<?php

return [
    'actions' => [
        'recover' => 'Recover',
    ],
    'title' => 'Entity Recovery for :campaign',
    'fields' => [
        'deleted' => 'Deleted',
    ],
    'helper' => 'Deleted entities are recoverable for up to :count days when using this interface.',
    'success' => '{1} :count entity was recovered.|[2,*] :count entities were recovered.',
    'error' => 'An error occurred trying to recover entities.',

];
