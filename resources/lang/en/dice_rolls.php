<?php

return [
    'create'        => [
        'description'   => 'Create a new dice roll',
        'success'       => 'Dice Roll \':name\' created.',
        'title'         => 'New Dice Roll',
    ],
    'destroy'       => [
        'success'   => 'Dice Roll \':name\' removed.',
    ],
    'edit'          => [
        'description'   => 'Edit an dice Roll',
        'success'       => 'Dice Roll \':name\' updated.',
        'title'         => 'Edit Dice Roll :name',
    ],
    'fields'        => [
        'parameters'    => 'Parameters',
        'name'          => 'Name',
        'results'       => 'Results',
    ],
    'hints'         => [
        'parameters' => 'What are my dice options?'
    ],
    'index'         => [
        'add'           => 'New Dice Roll',
        'description'   => 'Manage the dice Rolls of :name.',
        'header'        => 'Dice Rolls of :name',
        'title'         => 'Dice Rolls',
    ],
    'placeholders'  => [
        'name'  => 'Name of the Dice Roll',
        'parameters' => '4d6+3'
    ],
    'show'          => [
        'description'   => 'A detailed view of a Dice Roll',
        'tabs'          => [
            'results'    => 'Results',
        ],
        'title'         => 'Dice Roll :name',
    ],
];
