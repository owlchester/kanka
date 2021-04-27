<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Dodaj postać do misji',
            'success'       => 'Dodano postać do misji :name.',
            'title'         => 'Nowa postać w misji :name.',
        ],
        'destroy'   => [
            'success'   => 'Usunięto postać z misji :name.',
        ],
        'edit'      => [
            'description'   => 'Aktualizuj postać w misji',
            'success'       => 'Zmieniono postać w misji :name.',
            'title'         => 'Aktualizacja postaci w misji :name',
        ],
        'fields'    => [
            'character'     => 'Postać',
            'description'   => 'Opis',
        ],
        'title'     => 'Postaci w misji :name.',
    ],
    'create'        => [
        'description'   => 'Tworzenie nowej misji',
        'success'       => 'Stworzono misję \':name\'.',
        'title'         => 'Nowa misja',
    ],
    'destroy'       => [
        'success'   => 'Usunięto misję \':name\'.',
    ],
    'edit'          => [
        'description'   => 'Edycja misji',
        'success'       => 'Zmieniono misję \':name\'.',
        'title'         => 'Edycja misji :name',
    ],
    'fields'        => [
        'character'     => 'Donator',
        'characters'    => 'Postaci',
        'copy_elements' => 'Kopiuj elementy związane z misją',
        'date'          => 'Data',
        'description'   => 'Opis',
        'image'         => 'Obraz',
        'is_completed'  => 'Ukończona',
        'items'         => 'Przedmioty',
        'locations'     => 'Miejsca',
        'name'          => 'Nazwa',
        'organisations' => 'Organizacje',
        'quest'         => 'Misja źródłowa',
        'quests'        => 'Misje pochodne',
        'role'          => 'Rola',
        'type'          => 'Rodzaj',
    ],
    'helpers'       => [
        'nested'        => 'W widoku hierarchii najpierw wyświetlane są misje, które nie mają źródła. Po kliknięciu na wiersz misji zobaczysz jej pochodne. Możesz schodzić niżej, póki nie skończą się poziomy hierarchii.',
        'nested_parent' => 'Wyświetlono misje pochodzące od :parent.',
        'nested_without'=> 'Wyświetlono wszystkie misje nie posiadające źródła. Kliknij na rząd, by wyświetlić misje pochodne.',
    ],
    'hints'         => [
        'quests'    => 'Przy użyciu pola Misji źródłowej można stworzyć sieć zazębiających się misji.',
    ],
    'index'         => [
        'add'           => 'Nowa misja',
        'description'   => 'Zarządzaj misjami elementu :name.',
        'header'        => 'Misje elementu :name.',
        'title'         => 'Misje',
    ],
    'items'         => [
        'create'    => [
            'description'   => 'Dodaj przedmiot do misji',
            'success'       => 'Dodano przedmiot do misji :name.',
            'title'         => 'Nowy przedmiot w misji :name',
        ],
        'destroy'   => [
            'success'   => 'Usunięto przedmiot z misji :name.',
        ],
        'edit'      => [
            'description'   => 'Zaktualizuj przedmiot w misji',
            'success'       => 'Zmieniono przedmiot w misji :name.',
            'title'         => 'Aktualizuj przedmiot w misji :name.',
        ],
        'fields'    => [
            'description'   => 'Opis',
            'item'          => 'Przedmiot',
        ],
        'title'     => 'Przedmioty w misji :name.',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Dodaj miejsce do misji',
            'success'       => 'Dodno miejsce do misji :name.',
            'title'         => 'Nowe miejsce w misji :name',
        ],
        'destroy'   => [
            'success'   => 'Usunięto miejsce z misji :name.',
        ],
        'edit'      => [
            'description'   => 'Zaktualizuj miejsca w misji',
            'success'       => 'Zmieniano miejsce w misji :name.',
            'title'         => 'Aktualizacja miejsce w misji :name',
        ],
        'fields'    => [
            'description'   => 'Opis',
            'location'      => 'Miejsce',
        ],
        'title'     => 'Miejsca w misji :name',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Dodaj organizację do misji',
            'success'       => 'Dodano organizację do misji :name.',
            'title'         => 'Nowa organizacja w misji :name',
        ],
        'destroy'   => [
            'success'   => 'Usunięto organizację z misji :name.',
        ],
        'edit'      => [
            'description'   => 'Zaktualizuj organizację w misji',
            'success'       => 'Zmieniono organizację w misji :name.',
            'title'         => 'Zaktualizuj organizację w misji :name',
        ],
        'fields'    => [
            'description'   => 'Opis',
            'organisation'  => 'Organizacja',
        ],
        'title'     => 'Organizacje w misji :name',
    ],
    'placeholders'  => [
        'date'  => 'Data misji w prawdziwym świecie',
        'name'  => 'Nazwa misji',
        'quest' => 'Misja źródłowa',
        'role'  => 'Rola elementu w tej misji',
        'type'  => 'Wątek osobisty, misja poboczna, misja główna',
    ],
    'show'          => [
        'actions'       => [
            'add_character'     => 'Dodaj postać',
            'add_item'          => 'Dodaj przedmiot',
            'add_location'      => 'Dodaj miejsce',
            'add_organisation'  => 'Dodaj organizację',
        ],
        'description'   => 'Szczegółowy widok misji',
        'tabs'          => [
            'characters'    => 'Postaci',
            'information'   => 'Informacje',
            'items'         => 'Przedmioty',
            'locations'     => 'Miejsca',
            'organisations' => 'Organizacje',
            'quests'        => 'Misje',
        ],
        'title'         => 'Misja :name',
    ],
];
