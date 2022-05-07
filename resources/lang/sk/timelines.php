<?php

return [
    'actions'       => [
        'add_element'   => 'Pridať prvok k veku :era',
        'back'          => 'Späť k :name',
        'edit'          => 'Upraviť časovú os',
        'reorder'       => 'Upraviť poradie',
        'save_order'    => 'Uložiť nové poradie',
    ],
    'create'        => [
        'success'   => 'Časová os :name vytvorená.',
        'title'     => 'Nová časová os.',
    ],
    'destroy'       => [
        'success'   => 'Časová os :name odstránená.',
    ],
    'edit'          => [
        'success'   => 'Časová os aktualizovaná.',
        'title'     => 'Upraviť časovú os :name.',
    ],
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
        'nested_parent'     => 'Zobraziť časové osy :parent.',
        'nested_without'    => 'Zobrazujú sa všetky časové osy, ktoré nemajú nadradenú časovú os. Kliknutím na riadok zobrazíš podradené časové osy.',
        'no_era'            => 'Táto časová os nemá žiadne veky. Veky môžu byť pridané na časovú os v režime úprav a následne do nich vložené prvky na osi.',
        'reorder'           => 'Pretiahni prvky vo veku pomocou Drag & Drop a usporiadaj ich podľa seba.',
        'reorder_tooltip'   => 'Kliknutím aktivuješ ručné usporiadanie prvkov pomocou Drag & Drop.',
        'reverse_order'     => 'Aktivovaním zobrazíš veky v spätnom chronologickom poradí (najstarší vek ako prvý).',
    ],
    'index'         => [
        'title' => 'Časové osy',
    ],
    'placeholders'  => [
        'name'  => 'Názov časovej osy',
        'type'  => 'Primárna, Kronika sveta, Osud kráľovstva',
    ],
    'show'          => [
        'tabs'  => [
            'timelines' => 'Časové osi',
        ],
    ],
    'timelines'     => [
        'title' => 'Časové osy podradené :name',
    ],
];
