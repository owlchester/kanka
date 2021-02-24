<?php

return [
    'create'        => [
        'description'   => 'Stwórz nowy przedmiot',
        'success'       => 'Stworzono przedmiot \':name\'.',
        'title'         => 'Nowy przedmiot',
    ],
    'destroy'       => [
        'success'   => 'Usunięto przedmiot \':name\'.',
    ],
    'edit'          => [
        'success'   => 'Zaktualizowano przedmiot \':name\'.',
        'title'     => 'Edycja przedmiotu :name',
    ],
    'fields'        => [
        'character' => 'Postać',
        'image'     => 'Obraz',
        'location'  => 'Miejsce',
        'name'      => 'Nazwa',
        'price'     => 'Cena',
        'relation'  => 'Relacja',
        'size'      => 'Rozmiar',
        'type'      => 'Rodzaj',
    ],
    'index'         => [
        'add'           => 'Nowy przedmiot',
        'description'   => 'Zarządzaj przedmiotami elementu :name.',
        'header'        => 'Przedmioty elementu :name.',
        'title'         => 'Przedmioty',
    ],
    'inventories'   => [
        'description'   => 'Ekwipunki innych elementów, w których znajduje się ten przedmiot.',
        'title'         => 'Ekwipunki przedmiotu :name',
    ],
    'placeholders'  => [
        'character' => 'Wybierz postać',
        'location'  => 'Wybierz miejsce',
        'name'      => 'Nazwa przedmiotu',
        'price'     => 'Cena przedmiotu',
        'size'      => 'Wielkość, ciężar, wymiary',
        'type'      => 'Broń, eliksir, artefakt',
    ],
    'quests'        => [
        'description'   => 'Misje, których częścią jest ten przedmiot.',
        'title'         => 'Misje przedmiotu :name.',
    ],
    'show'          => [
        'description'   => 'Szczegółowy widok przedmiotu',
        'tabs'          => [
            'information'   => 'Informacje',
            'inventories'   => 'Ekwipunki',
            'quests'        => 'Misje',
        ],
        'title'         => 'Przedmiot :name',
    ],
];
