<?php

return [
    'actions'       => [
        'add_element'   => 'Pridať prvok k veku :era',
        'back'          => 'Späť k :name',
        'edit'          => 'Upraviť časovú os',
        'save_order'    => 'Uložiť nové poradie',
    ],
    'create'        => [
        'title' => 'Nová časová os.',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'copy_elements' => 'Kopírovať prvky',
        'copy_eras'     => 'Kopírovať vek',
        'eras'          => 'Veky',
        'name'          => 'Názov',
        'reverse_order' => 'Otočiť poradie veku',
        'timeline'      => 'Nadradená časová os',
        'timelines'     => 'Časové osy',
        'type'          => 'Typ',
    ],
    'helpers'       => [
        'nested_without'    => 'Zobrazujú sa všetky časové osy, ktoré nemajú nadradenú časovú os. Kliknutím na riadok zobrazíš podradené časové osy.',
        'no_era'            => 'Táto časová os nemá žiadne veky. Veky môžu byť pridané na časovú os v režime úprav a následne do nich vložené prvky na osi.',
        'reverse_order'     => 'Aktivovaním zobrazíš veky v spätnom chronologickom poradí (najstarší vek ako prvý).',
    ],
    'index'         => [
        'title' => 'Časové osy',
    ],
    'placeholders'  => [
        'name'  => 'Názov časovej osy',
        'type'  => 'Primárna, Kronika sveta, Osud kráľovstva',
    ],
    'reorder'       => [
        'success'   => 'Časová os úspešne usporiadaná.',
        'title'     => 'Usporiadať časovú os',
    ],
    'show'          => [
        'tabs'  => [
            'reorder'   => 'Usporiadanie časovej osi',
            'timelines' => 'Časové osi',
        ],
    ],
    'timelines'     => [
        'title' => 'Časové osy podradené :name',
    ],
];
