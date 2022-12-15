<?php

return [
    'actions'       => [
        'add_element'   => 'Pridať prvok k obdobiu :era',
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
        'copy_eras'     => 'Kopírovať obdobie',
        'eras'          => 'Obdobia',
        'reverse_order' => 'Otočiť poradie období',
        'timeline'      => 'Nadradená časová os',
        'timelines'     => 'Časové osy',
    ],
    'helpers'       => [
        'nested_without'    => 'Zobrazujú sa všetky časové osy, ktoré nemajú nadradenú časovú os. Kliknutím na riadok zobrazíš podradené časové osy.',
        'no_era_v2'         => 'Táto časová os aktuálne nemá žiadne obdobia. Pridaj do nej jedno alebo viacero období, potom budeš do nich môcť pridať ďalšie privky.',
        'reverse_order'     => 'Aktivovaním zobrazíš obdobia v spätnom chronologickom poradí (najstaršie obdobie ako prvé).',
    ],
    'index'         => [],
    'placeholders'  => [
        'name'  => 'Názov časovej osy',
        'type'  => 'Primárna, Kronika sveta, Osud kráľovstva',
    ],
    'reorder'       => [
        'success'   => 'Časová os úspešne preskupená.',
        'title'     => 'Preskupiť časovú os',
    ],
    'show'          => [
        'tabs'  => [
            'reorder'   => 'Preskupenie časovej osi',
            'timelines' => 'Časové osi',
        ],
    ],
    'timelines'     => [
        'title' => 'Časové osy podradené :name',
    ],
];
