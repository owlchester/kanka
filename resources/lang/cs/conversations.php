<?php

return [
    'create'        => [
        'description'   => 'Vytvořit nový rozhovor',
        'success'       => 'Rozhovor ":name" vytvořen',
        'title'         => 'Nový rozhovor',
    ],
    'destroy'       => [
        'success'   => 'Rozhovor ":name" smazán.',
    ],
    'edit'          => [
        'description'   => 'Aktualizovat rozhovor',
        'success'       => 'Rozhovor ":name" aktualizován.',
        'title'         => 'Rozhovor ":name"',
    ],
    'fields'        => [
        'is_closed'     => 'Uzavřený',
        'messages'      => 'Zprávy',
        'name'          => 'Název',
        'participants'  => 'Účastníci',
        'target'        => 'Cíl',
        'type'          => 'Typ',
    ],
    'hints'         => [
        'participants'  => 'Účastníky rozhovoru přidáš klepnutím na ikonu :icon vpravo nahoře.',
    ],
    'index'         => [
        'add'           => 'Nový rozhovor',
        'description'   => 'Spravovat kategorii :name',
        'header'        => 'Rozhovory v :name',
        'title'         => 'Rozhovory',
    ],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Zpráva odstraněna',
        ],
        'is_updated'    => 'Aktualizováno',
        'load_previous' => 'Načíst předchozí zprávy',
        'placeholders'  => [
            'message'   => 'Tvá zpráva',
        ],
    ],
    'participants'  => [
        'create'        => [
            'success'   => 'Postava :entity se nyní účastní rozhovoru.',
        ],
        'description'   => 'Přidat nebo odstranit účastníky rozhovoru',
        'destroy'       => [
            'success'   => 'Postava :entity se nadále neúčastní rozhovoru.',
        ],
        'modal'         => 'Účastníci',
        'title'         => 'Účastníci rozhovoru :name',
    ],
    'placeholders'  => [
        'name'  => 'Název rozhovoru',
        'type'  => 'Ve hře, příprava, námět',
    ],
    'show'          => [
        'description'   => 'Podrobné zobrazení rozhovoru',
        'is_closed'     => 'Rozhovor skončil',
        'title'         => 'Rozhovor :name',
    ],
    'tabs'          => [
        'conversation'  => 'Rozhovor',
        'participants'  => 'Účastníci',
    ],
    'targets'       => [
        'characters'    => 'Postavy',
        'members'       => 'Členové',
    ],
];
