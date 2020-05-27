<?php

return [
    'create'        => [
        'description'   => 'Vytvor nový menu link',
        'success'       => 'Menu link :name vytvorený.',
        'title'         => 'Nový menu link',
    ],
    'destroy'       => [
        'success'   => 'Menu link :name odstránený.',
    ],
    'edit'          => [
        'description'   => 'Uprav menu link.',
        'success'       => 'Menu link :name upravený.',
        'title'         => 'Menu link :name',
    ],
    'fields'        => [
        'entity'    => 'Objekt',
        'filters'   => 'Filtre',
        'menu'      => 'Menu',
        'name'      => 'Názov',
        'position'  => 'Pozícia',
        'tab'       => 'Karta',
        'type'      => 'Typ objektu',
    ],
    'helpers'       => [
        'entity'    => 'Nastav tento menu link, aby smeroval priamo na daný objekt. Pole :tab kontroluje, ktorá z kariet objektu bude zobrazená automaticky. Pole :menu kontroluje, ktorá podstránka objektu bude zobrazená.',
        'position'  => 'Použi toto pole na kontrolu v akom poradí sa linky zoradia v menu.',
        'type'      => 'Nastav tento menu link, aby sa po kliknutí naň zobrazil zoznam objektov. Skopíruj časť URL na filtrovanom zozname objektov, ktorá sa nachádza po :? a vlož ju do poľa :filter.',
    ],
    'index'         => [
        'add'           => 'Nový menu link',
        'description'   => 'Spravuj menu linky objektu :name',
        'header'        => 'Menu link objektu :name',
        'title'         => 'Menu linky',
    ],
    'placeholders'  => [
        'entity'    => 'Vyber objekt',
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Podstránka (použi poslednú časť textu URL)',
        'name'      => 'Názov menu linku',
        'tab'       => 'Záznam, Prepojenia, Poznámky',
    ],
    'show'          => [
        'description'   => 'Detailný náhľad menu linku',
        'tabs'          => [
            'information'   => 'Informácie',
        ],
        'title'         => 'Menu link :name',
    ],
];
