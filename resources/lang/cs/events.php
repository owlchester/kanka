<?php

return [
    'create'        => [
        'description'   => 'Vytvořit novou událost',
        'success'       => 'Událost ":name" vytvořena.',
        'title'         => 'Nová událost',
    ],
    'destroy'       => [
        'success'   => 'Událost ":name" odstraněna.',
    ],
    'edit'          => [
        'success'   => 'Událost ":name" aktualizována.',
        'title'     => 'Upravit událost :name',
    ],
    'events'        => [
        'title' => 'Události podřazené události ::name',
    ],
    'fields'        => [
        'date'      => 'Kalendářní datum',
        'event'     => 'Nadřazená událost',
        'events'    => 'Události',
        'image'     => 'Obrázek',
        'location'  => 'Místo',
        'name'      => 'Název',
        'type'      => 'Typ',
    ],
    'helpers'       => [
        'date'          => 'Toto pole může může obsahovat cokoli a není propojené s kalendářem tažení. Pokud chceš tuto událost připojit k některému kalendáři, přidej ji ke kalendáři nebo do karty připomínky této události.',
        'nested_parent' => 'Zobrazuji události objektu :parent.',
        'nested_without'=> 'Zobrazit všechny události, které nemají nadřazenou událost. Klepnutím na danou událost zobrazíš podřízené události.',
    ],
    'index'         => [
        'add'           => 'Nová událost',
        'description'   => 'Spravovat události objektu :name.',
        'header'        => 'Události objektu :name',
        'title'         => 'Události',
    ],
    'placeholders'  => [
        'date'      => 'Kalendářní datum události',
        'location'  => 'Vyber si místo',
        'name'      => 'Název události',
        'type'      => 'Oslava, festival, pohroma, bitva, narozeniny',
    ],
    'show'          => [
        'description'   => 'Bližší popis události',
        'tabs'          => [
            'information'   => 'Informace',
        ],
        'title'         => 'Událost :name',
    ],
    'tabs'          => [
        'calendars' => 'Položky kalendáře',
    ],
];
