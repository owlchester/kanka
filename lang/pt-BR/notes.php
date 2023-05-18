<?php

return [
    'create'        => [
        'title' => 'Nova Nota',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'notes' => 'Sub-Notas',
    ],
    'helpers'       => [
        'nested_without'    => 'Exibindo todas as notas que não tem uma nota primária. Clique em uma linha para ver as notas secundárias.',
    ],
    'hints'         => [
        'is_pinned' => 'Até 3 notas podem ser fixadas para ser exibidas no dashboard.',
    ],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Escolha uma nota primária',
        'type'  => 'Religião, Raça, Sistema Político',
    ],
    'show'          => [],
];
