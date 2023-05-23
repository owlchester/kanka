<?php

return [
    'create'        => [
        'title' => 'Nová poznámka',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'notes' => 'Podradená poznámka',
    ],
    'helpers'       => [
        'nested_without'    => 'Zobraziť všetky poznámky, ktoré nemajú nadradenú poznámku. Kliknutím na riadok zobrazíš podradené poznámky.',
    ],
    'hints'         => [
        'is_pinned' => 'Na nástenku môžete pripnúť max. 3 poznámky.',
    ],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Vybrať nadradenú poznámku',
        'type'  => 'náboženstvo, rasa, politický systém',
    ],
    'show'          => [],
];
