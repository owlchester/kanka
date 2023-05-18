<?php

return [
    'create'        => [
        'title' => 'Nova nota',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'notes' => 'Subnotas',
    ],
    'helpers'       => [
        'nested_without'    => 'Mostrando todas as notas que non teñen unha nota superior. Fai clic nunha fila para ver as súas descendentes.',
    ],
    'hints'         => [
        'is_pinned' => 'Pódense fixar ata 3 notas para ser mostradas no taboleiro.',
    ],
    'index'         => [],
    'placeholders'  => [
        'note'  => 'Elixe unha nota superior',
        'type'  => 'Relixión, raza, sistema político...',
    ],
    'show'          => [],
];
