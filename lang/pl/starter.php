<?php

return [
    'campaign'      => [
        'name'  => 'Świat :user\'s',
    ],
    'character1'    => [
        'age'           => '[20/30/40]',
        'background'    => [
            'cur'       => 'Obecnie [zawód/rola]',
            'loc'       => 'Rodem z [miasto/region rodzinny]',
            'seeking'   => 'Poszukuje [cel/motywacja]',
            'title'     => 'Pochodzenie',
        ],
        'description'   => [
            'intro'     => '[krótki opis postaci - kim jest, skąd pochodzi i czego pragnie]',
            'template'  => 'To szablon postaci, który możesz zmieniać. Zastąp wypełniacze poniżej własnymi pomysłami. Możesz zawsze dodać potem kolejne pola.',
            'tip'       => 'Rada: Zacznij od imienia i jednowyrazowego opisu. Możesz dodać kolejne szczegoły w miarę budowania świata.',
        ],
        'name'          => '[Imię twojej postaci]',
        'personality'   => [
            'trait1'    => [
                'name'  => 'Właściwość 1',
                'value' => '[Odwaga/Ostrożność/Ambicja]',
            ],
            'trait2'    => [
                'name'  => 'Właściwość 2',
                'value' => '[Lojalność/Niezależność/Podstępność]',
            ],
            'trait3'    => [
                'name'  => 'Właściwość 3',
                'value' => '[Optymizm/Cynizm/Pragmatyzm]',
            ],
        ],
        'physical'      => [
            'build'     => [
                'name'  => 'Budowa ciała',
                'value' => '[Szczupła/Przeciętna/Muskularna]',
            ],
            'features'  => [
                'name'  => 'Cechy szczególne',
                'value' => '[Blizny/tatuaże/ubiór]',
            ],
        ],
    ],
    'character2'    => [
        'description'   => [
            'first' => 'Postać poboczna, która pomaga albo podróżuje z :mention. Zmień szczegóły by dopasować je do historii.',
            'second'=> 'Rada: Postaci drugoplanowe nie muszą mieć tylu szczegółów, co główne. Skup się na ich przydatnych albo interesujących cechach.',
        ],
        'name'          => '[Imię postaci drugoplanowej]',
        'relation'      => '[Przyjaciel/Mentor/Rywal]',
        'skills'        => [
            'first' => '[Umiejętność 1: Bojowa/Medyczna/Magiczna/Rzemieślnicza]',
            'second'=> '[Umiejętność 2: Społeczna/Akademicka/Techniczna]',
            'third' => '[Umiejętność 3: Niezwykły talent lub specjalność]',
            'title' => 'Umiejętności',
        ],
    ],
    'city'          => [
        'description'   => 'Bijące serce królestwa, gdzie na targach i wielkich placach miesza się tłum kupców, szlachty i pospólstwa. Stare mury wciąż stoją, ale miasto dawno się z nich wylało.',
        'districts'     => [
            'first' => 'Dzielnica szlachecka: posiadłości i ogrody',
            'fourth'=> 'Dzielnica portowa: Port rzeczny, magazyny',
            'second'=> 'Dzielnica kupiecka: Składy, warsztaty, tawerny',
            'third' => 'Stare Miasto: Pierwotne miasto w obrębie murów',
            'title' => 'Dzielnice',
        ],
        'locations'     => [
            'first' => 'Pałac Królewski (centrum dzielnicy szlacheckiej)',
            'second'=> 'Wielki Bazar (dzielnica kupiecka)',
            'third' => 'Pod Zardzewiałym Mieczem (popularne wśród awanturników)',
            'title' => 'Ważne miejsca',
        ],
        'name'          => '[Twoje miasto stołeczne]',
        'type'          => 'Stolica',
    ],
    'item1'         => [],
    'kingdom'       => [
        'description'   => 'Kwitnące królestwo sławne z żyznych pól i pradawnych puszcz. Rodzina królewska panuje od trzech pokoleń, zapewniając pokój dzięki dyplomacji i relacjom handlowym.',
        'features'      => [
            'capital'   => [
                'name'  => 'Stolica',
            ],
            'exp'       => [
                'name'  => 'Eksportuje głównie',
                'value' => 'Zboże, drewno',
            ],
            'gov'       => [
                'name'  => 'Ustrój',
                'value' => 'Monarchia dziedziczna',
            ],
            'pop'       => [
                'name'  => 'Populacja',
                'value' => '~50 000',
            ],
            'title'     => 'Ważne właściwości',
        ],
        'name'          => '[Nazwa twojego królestwa]',
        'recent'        => [
            'first' => 'Bandyci rozpanoszyli się na wschodnich gościńcach',
            'second'=> 'W południowych prowincjach panuje nieurodzaj',
            'title' => 'Ostatnie wydarzenia',
        ],
        'type'          => 'Królestwo',
    ],
    'kingdom1'      => [],
    'kingdom2'      => [],
    'name'          => ':name (przykład)',
    'note1'         => [],
];
