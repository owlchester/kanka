<?php

return [
    'actions'           => [
        'customise' => 'Upraviť bočný panel',
    ],
    'create'            => [
        'title' => 'Nový menu link',
    ],
    'destroy'           => [],
    'edit'              => [
        'title' => 'Menu link :name',
    ],
    'fields'            => [
        'active'            => 'Aktívny',
        'dashboard'         => 'Nástenka',
        'default_dashboard' => 'Štandardná nástenka',
        'filters'           => 'Filtre',
        'menu'              => 'Menu',
        'position'          => 'Pozícia',
        'random_type'       => 'Náhodný typ objektu',
        'selector'          => 'Konfigurácia Menu linkov',
        'target'            => 'Cieľ',
    ],
    'helpers'           => [
        'active'            => 'Neaktívne rýchle linky sa v bočnom menu nezobrazia.',
        'dashboard'         => 'Cieľ s rýchlym linkom na jednu z vlastných násteniek kampane.',
        'default_dashboard' => 'Prelinkuj namiesto toho k štandardnej nástenke kampane. Ešte stále musíš ale zvoliť aj vlastnú nástenku.',
        'entity'            => 'Nastav tento menu link, aby smeroval priamo na daný objekt. Pole :tab kontroluje, ktorá z kariet objektu bude zobrazená automaticky. Pole :menu kontroluje, ktorá podstránka objektu bude zobrazená.',
        'position'          => 'Použi toto pole na kontrolu v akom poradí sa linky zoradia v menu.',
        'random'            => 'Použi toto pole pre rýchly link cielený na náhodný objekt. Môžeš nastaviť filter, aby smeroval na špecifické typy objektov.',
        'selector'          => 'Nastav, kam tento rýchly link bude smerovať, ak na neho užívateľ klikne v bočnej lište.',
        'type'              => 'Nastav tento menu link, aby sa po kliknutí naň zobrazil zoznam objektov. Skopíruj časť URL na filtrovanom zozname objektov, ktorá sa nachádza po :? a vlož ju do poľa :filter.',
    ],
    'index'             => [],
    'placeholders'      => [
        'filters'   => 'location_id=15&type=city',
        'menu'      => 'Podstránka (použi poslednú časť textu URL)',
        'tab'       => '(zastaralé)',
    ],
    'random_no_entity'  => 'Nebol nájdený žiaden náhodný objekt.',
    'random_types'      => [
        'any'   => 'Hociktorý objekt',
    ],
    'reorder'           => [
        'success'   => 'Menu linky usporiadané.',
        'title'     => 'Usporiadanie liniek v menu',
    ],
    'show'              => [],
    'visibilities'      => [
        'is_active' => 'Zobraziť rýchly link v bočnom paneli',
    ],
];
