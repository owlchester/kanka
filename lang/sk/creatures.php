<?php

return [
    'create'        => [
        'title' => 'Nový bytosť',
    ],
    'creatures'     => [
        'title' => 'Podradené bytosti k :name',
    ],
    'fields'        => [
        'creature'  => 'Nadradená bytosť',
        'creatures' => 'Podradené bytosti',
        'locations' => 'Miesta',
    ],
    'helpers'       => [
        'nested_without'    => 'Zobrazujú sa všetky bytosti, ktoré nemajú nadradenú bytosť. Kliknutím na riadok zobrazíte podradené bytosti.',
    ],
    'placeholders'  => [
        'name'  => 'Názov bytosti',
        'type'  => 'Bylinožravec, Morská, Mýtická',
    ],
    'show'          => [
        'tabs'  => [
            'creatures' => 'Podradené bytosti',
        ],
    ],
];
