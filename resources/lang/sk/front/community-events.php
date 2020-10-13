<?php

return [
    'actions'       => [
        'return'        => 'Späť na všetky udalosti',
        'send'          => 'Zúčastniť sa',
        'show_ongoing'  => 'Zobraziť udalosť a zúčastniť sa',
        'show_past'     => 'Zobraziť udalosť a víťazov',
        'update'        => 'Aktualizovať príspevok',
        'view'          => 'Zobraziť príspevok',
    ],
    'description'   => 'Často usporadúvame udalosti pre tvorcov svetov z našej komunity, pričom následne prezentujeme najzaujímavejšie príspevky.',
    'fields'        => [
        'comment'       => 'Komentár',
        'entity_link'   => 'Link k objektu',
        'rank'          => 'Poradie',
        'submitter'     => 'Prispievateľ',
    ],
    'index'         => [
        'ongoing'   => 'Aktuálne udalosti',
        'past'      => 'Minulé udalosti',
    ],
    'participate'   => [
        'description'   => 'Inšpirovala ťa táto udalosť? Vytvor objekt v jednej z tvojich kampaní a zašli nám naň link pomocou formulára nižšie. Tvoj príspevok môžeš hocikedy zmeniť alebo odstrániť.',
        'login'         => 'Na účasť v udalosti sa musíš prihlásiť do tvojho konta',
        'participated'  => 'V tejto udalosti už máš jeden príspevok. Tento môžeš upraviť alebo odstániť.',
        'success'       => [
            'modified'  => 'Zmeny v tvojom príspevku boli uložené.',
            'removed'   => 'Tvoj príspevok bol odstránený.',
            'submit'    => 'Tvoj príspevok bol zaslaný. Môžeš ho teraz upraviť alebo odstrániť.',
        ],
        'title'         => 'Účasť na udalosti',
    ],
    'placeholders'  => [
        'comment'       => 'Komentár k tvojmu príspevku (voliteľné)',
        'entity_link'   => 'Skopíruj tvoj link k objektu a vlož ho sem',
    ],
    'results'       => [
        'description'       => 'Naša porota vybrala medzi víťazov nasledujúce príspevky',
        'title'             => 'Víťazi udalosti',
        'waiting_results'   => 'Táto udalosť skončila! Porota udalosti zhodnotí všetky príspevky a akonáhle vyberie víťazov, zobrazia sa títo na tomto mieste.',
    ],
    'show'          => [
        'participants'  => '{1} :number zaslaný príspevok.|[2,4] :number zaslané príspevky.|[5,*] :number zaslaných príspevkov.',
        'title'         => 'Udalosť :name',
    ],
    'title'         => 'Udalosti',
];
