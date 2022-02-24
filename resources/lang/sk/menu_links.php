<?php

return [
    'create'            => [
        'success'       => 'Menu link :name vytvorený.',
        'title'         => 'Nový menu link',
    ],
    'destroy'           => [
        'success'   => 'Menu link :name odstránený.',
    ],
    'edit'              => [
        'success'       => 'Menu link :name upravený.',
        'title'         => 'Menu link :name',
    ],
    'fields'            => [
        'dashboard'     => 'Nástenka',
        'entity'        => 'Objekt',
        'filters'       => 'Filtre',
        'is_nested'     => 'Vnorené',
        'menu'          => 'Menu',
        'name'          => 'Názov',
        'position'      => 'Pozícia',
        'random'        => 'Náhodný',
        'random_type'   => 'Náhodný typ objektu',
        'selector'      => 'Konfigurácia Menu linkov',
        'tab'           => 'Karta',
        'type'          => 'Typ objektu',
    ],
    'helpers'           => [
        'dashboard' => 'Cieľ s rýchlym linkom na jednu z vlastných násteniek kampane.',
        'entity'    => 'Nastav tento menu link, aby smeroval priamo na daný objekt. Pole :tab kontroluje, ktorá z kariet objektu bude zobrazená automaticky. Pole :menu kontroluje, ktorá podstránka objektu bude zobrazená.',
        'position'  => 'Použi toto pole na kontrolu v akom poradí sa linky zoradia v menu.',
        'random'    => 'Použi toto pole pre rýchly link cielený na náhodný objekt. Môžeš nastaviť filter, aby smeroval na špecifické typy objektov.',
        'selector'  => 'Nastav, kam tento rýchly link bude smerovať, ak na neho užívateľ klikne v bočnej lište.',
        'type'      => 'Nastav tento menu link, aby sa po kliknutí naň zobrazil zoznam objektov. Skopíruj časť URL na filtrovanom zozname objektov, ktorá sa nachádza po :? a vlož ju do poľa :filter.',
    ],
    'index'             => [
        'add'           => 'Nový menu link',
        'title'         => 'Menu linky',
    ],
    'placeholders'      => [
        'entity'    => 'Vyber objekt',
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Podstránka (použi poslednú časť textu URL)',
        'name'      => 'Názov menu linku',
        'tab'       => 'Záznam, Vzťahy, Poznámky',
    ],
    'random_no_entity'  => 'Nebol nájdený žiaden náhodný objekt.',
    'random_types'      => [
        'any'   => 'Hociktorý objekt',
    ],
    'reorder'           => [
        'success'   => 'Menu linky zoradené.',
        'title'     => 'Zmeniť poradie menu liniek',
    ],
    'show'              => [
        'tabs'          => [
        ],
        'title'         => 'Menu link :name',
    ],
];
