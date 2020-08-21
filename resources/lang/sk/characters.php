<?php

return [
    'actions'       => [
        'add_appearance'    => 'Pridať výzor',
        'add_organisation'  => 'Pridať organizáciu',
        'add_personality'   => 'Pridať osobnosť',
    ],
    'conversations' => [
        'description'   => 'Diskusie, v ktorých sa postava účastní.',
        'title'         => 'Diskusie s postavou :name',
    ],
    'create'        => [
        'description'   => 'Vytvoriť novú postavu',
        'success'       => 'Postava :name vytvorená.',
        'title'         => 'Nová postava',
    ],
    'destroy'       => [
        'success'   => 'Postava :name odstránená.',
    ],
    'dice_rolls'    => [
        'description'   => 'Hody kockami priradené tejto postave.',
        'hint'          => 'Hody kockami môžu byť priradené postavy, aby ich mohla v hre používať.',
        'title'         => 'Hody kockami postavy :name',
    ],
    'edit'          => [
        'description'   => 'Upraviť postavu',
        'success'       => 'Postava :name upravená.',
        'title'         => 'Upraviť postavu :name',
    ],
    'fields'        => [
        'age'                       => 'Vek',
        'family'                    => 'Rod',
        'image'                     => 'Obrázok',
        'is_dead'                   => 'Po smrti',
        'is_personality_visible'    => 'Osobnosť viditeľná',
        'life'                      => 'Život',
        'location'                  => 'Umiestnenie',
        'name'                      => 'Meno',
        'physical'                  => 'Telesné črty',
        'race'                      => 'Rasa',
        'relation'                  => 'Vzťah',
        'sex'                       => 'Rod',
        'title'                     => 'Titul',
        'traits'                    => 'Vlastnosti',
        'type'                      => 'Typ',
    ],
    'helpers'       => [
        'age'   => 'Tento objekt môžeš referencovať v kalendári tvojej kampane a automaticky tak vypočítať vek. :more.',
        'free'  => 'Kde nájdem pole na voľný popis? Ak táto postava jedno mala, nájdeš ho v karte Poznámky.',
    ],
    'hints'         => [
        'hide_personality'          => 'Túto kartu môžeš ukryť pred užívateľmi, ktorí nemajú rolu Admin, deaktivovaním nastavenia "Osobnosť viditeľná".',
        'is_dead'                   => 'Táto postava je mŕtva.',
        'is_personality_visible'    => 'Celú sekciu o osobnosti vieš skryť pred užívateľmi, ktorí nemajú rolu Admin.',
    ],
    'index'         => [
        'actions'       => [
            'random'    => 'Nová náhodná postava',
        ],
        'add'           => 'Nová postava',
        'description'   => 'Upraviť postavy :name.',
        'header'        => 'Postavy v :name',
        'title'         => 'Postavy',
    ],
    'items'         => [
        'description'   => 'Predmety, ktoré nosí alebo vlastní daná postava.',
        'hint'          => 'Predmety môžu byť pridelené postavám a zobrazia sa na tomto mieste.',
        'title'         => 'Predmety postavy :name',
    ],
    'journals'      => [
        'description'   => 'Denníky, ktoré spísala postava.',
        'title'         => 'Denníky postavy :name',
    ],
    'maps'          => [
        'description'   => 'Mapa vzťahov postavy.',
        'title'         => 'Mapa vzťahov postavy :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Pridať organizáciu',
        ],
        'create'        => [
            'description'   => 'Priradiť organizáciu postave',
            'success'       => 'Postava priradená organizácii.',
            'title'         => 'Nová organizácia pre :name',
        ],
        'description'   => 'Organizácie, ku ktorým postava patrí.',
        'destroy'       => [
            'success'   => 'Postava odstránená z organizácie.',
        ],
        'edit'          => [
            'description'   => 'Upraviť organizácie postavy',
            'success'       => 'Organizácia postavy upravená.',
            'title'         => 'Upraviť organizáciu :name',
        ],
        'fields'        => [
            'organisation'  => 'Organizácia',
            'role'          => 'Rola',
        ],
        'hint'          => 'Postavy môžu byť súčasťou viacerých organizácií, ktoré hovoria o tom, pre koho pracujú alebo ku ktorému tajnému spolku patria.',
        'placeholders'  => [
            'organisation'  => 'Vybrať organizáciu...',
        ],
        'title'         => 'Organizácie postavy :name',
    ],
    'placeholders'  => [
        'age'               => 'Vek',
        'appearance_entry'  => 'Popis',
        'appearance_name'   => 'Vlasy, oči, pokožka, výška',
        'family'            => 'Prosím, vyber postavu',
        'image'             => 'Obrázok',
        'location'          => 'Prosím, vyber umiestnenie',
        'name'              => 'Meno',
        'personality_entry' => 'Detaily',
        'personality_name'  => 'Ciele, maniere, slabosti, vzťahy,...',
        'physical'          => 'Telesné črty',
        'race'              => 'Rasa',
        'sex'               => 'Rod',
        'title'             => 'Titul',
        'traits'            => 'Vlastnosti',
        'type'              => 'NPC, postava hráča, božstvo',
    ],
    'quests'        => [
        'description'   => 'Úlohy priradené postave.',
        'helpers'       => [
            'quest_giver'   => 'Úlohy, ktorých zadávateľom je táto postava.',
            'quest_member'  => 'Úlohy, ktorých členom je táto postava.',
        ],
        'title'         => 'Úlohy postavy :name',
    ],
    'sections'      => [
        'appearance'    => 'Výzor',
        'general'       => 'Všeobecné informácie',
        'personality'   => 'Osobnosť',
    ],
    'show'          => [
        'description'   => 'Detailné zobrazenie postavy',
        'tabs'          => [
            'conversations' => 'Diskusie',
            'dice_rolls'    => 'Hody kockami',
            'items'         => 'Predmety',
            'journals'      => 'Denníky',
            'map'           => 'Mapa vzťahov',
            'organisations' => 'Organizácie',
            'personality'   => 'Osobnosť',
            'quests'        => 'Úlohy',
        ],
        'title'         => 'Postava :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Nemáš povolené upravovať črty osobnosti tejto postavy.',
    ],
];
