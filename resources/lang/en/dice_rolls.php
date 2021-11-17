<?php

return [
    'create'        => [
        'success'   => 'Dice Roll \':name\' created.',
        'title'     => 'New Dice Roll',
    ],
    'destroy'       => [
        'dice_roll' => 'Dice roll removed.',
        'success'   => 'Dice Roll \':name\' removed.',
    ],
    'edit'          => [
        'success'   => 'Dice Roll \':name\' updated.',
        'title'     => 'Edit Dice Roll :name',
    ],
    'fields'        => [
        'created_at'    => 'Rolled At',
        'name'          => 'Name',
        'parameters'    => 'Parameters',
        'results'       => 'Results',
        'rolls'         => 'Rolls',
    ],
    'hints'         => [
        'parameters'    => 'What are my dice options?',
    ],
    'index'         => [
        'actions'   => [
            'dice'      => 'Dice Rolls',
            'results'   => 'Results',
        ],
        'add'       => 'New Dice Roll',
        'header'    => 'Dice Rolls of :name',
        'title'     => 'Dice Rolls',
    ],
    'placeholders'  => [
        'dice_roll' => 'Dice Roll',
        'name'      => 'Name of the Dice Roll',
        'parameters'=> '4d6+3',
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
        'title' => 'Dice Roll :name',
    ],
];
