<?php

return [
    'create'        => [
        'title' => 'Nova bilješka',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'notes' => 'Bilješka dijete',
    ],
    'helpers'       => [
        'nested_without'    => 'Prikazuju se sve bilješke koje nemaju bilješku roditelj. Klikni redak da bi vidio/la bilješke djecu.',
    ],
    'hints'         => [],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Odaberite bilješku roditelja',
        'type'  => 'Religija, Rasa, Politički sustav',
    ],
    'show'          => [],
];
