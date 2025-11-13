<?php

return [
    'create'        => [
        'title' => 'New Dice Roll',
    ],
    'destroy'       => [
        'dice_roll' => 'Dice roll removed.',
    ],
    'fields'        => [
        'created_at'    => 'Rolled At',
        'parameters'    => 'Parameters',
        'results'       => 'Results',
        'rolls'         => 'Rolls',
    ],
    'hints'         => [
        'parameters'    => 'What dice options are available?',
    ],
    'index'         => [
        'actions'   => [
            'results'   => 'Results',
        ],
    ],
    'lists'         => [
        'empty' => 'Create and save rolls for your campaign to keep track of results directly in Kanka.',
    ],
    'placeholders'  => [
        'name'          => 'Name of the Dice Roll',
        'parameters'    => '4d6+3',
    ],
    'results'       => [
        'actions'   => [
            'add'   => 'Roll',
        ],
        'error'     => 'Dice roll unsuccessful. Can\'t parse the parameters.',
        'fields'    => [
            'creator'   => 'Creator',
            'date'      => 'Date',
            'result'    => 'Result',
        ],
        'hint'      => 'All the rolls done for this dice roll template.',
        'success'   => 'Dice rolled.',
    ],
    'show'          => [
        'tabs'  => [
            'results'   => 'Results',
        ],
    ],
];
