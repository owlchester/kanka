<?php

return [
    'create'        => [
        'title' => 'Nová událost',
    ],
    'destroy'       => [],
    'edit'          => [],
    'events'        => [],
    'fields'        => [
        'date'  => 'Kalendářní datum',
    ],
    'helpers'       => [
        'date'              => 'Toto pole může může obsahovat cokoli a není propojené s kalendářem tažení. Pokud chceš tuto událost připojit k některému kalendáři, přidej ji ke kalendáři nebo do karty připomínky této události.',
        'nested_without'    => 'Zobrazit všechny události, které nemají nadřazenou událost. Klepnutím na danou událost zobrazíš podřízené události.',
    ],
    'index'         => [],
    'placeholders'  => [
        'date'  => 'Kalendářní datum události',
        'type'  => 'Oslava, Festival, Pohroma, Bitva, Narozeniny',
    ],
    'show'          => [],
    'tabs'          => [
        'calendars' => 'Položky kalendáře',
    ],
];
