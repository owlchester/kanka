<?php

return [
    'create'        => [
        'title' => 'Nowa konwersacja',
    ],
    'destroy'       => [],
    'edit'          => [],
    'fields'        => [
        'is_closed'     => 'Zamknięta',
        'messages'      => 'Wiadomości',
        'participants'  => 'Uczestnicy',
    ],
    'hints'         => [
        'empty'         => 'Nikt nie uczestniczy w tej konwersacji.',
        'participants'  => 'Dodawaj uczestników konwersacji naciskając ikonę :icon w prawym górnym rogu.',
    ],
    'index'         => [],
    'lists'         => [
        'empty' => 'Spisuj rozmowy, listy i wymianę poglodów między postaciami i całymi frakcjami.',
    ],
    'messages'      => [
        'destroy'       => [
            'success'   => 'Usunięto wiadomość.',
        ],
        'is_updated'    => 'Zaktualizowano',
        'load_previous' => 'Załaduj starsze wiadomości',
        'placeholders'  => [
            'message'   => 'Twoja wiadomość',
        ],
    ],
    'participants'  => [
        'create'    => [
            'success'   => 'Uczestnik :entity wypowiedział się w konwersacji.',
        ],
        'destroy'   => [
            'success'   => 'Usunięto uczestnika :entity z konwersacji.',
        ],
        'helper'    => 'Dodaje i usuwa uczestników :name.',
        'modal'     => 'Uczestnicy',
        'title'     => 'Uczestnicy :name',
    ],
    'placeholders'  => [
        'name'  => 'Nazwa konwersacji',
        'type'  => 'W grze, przygotowanie, omawianie intrygi',
    ],
    'show'          => [
        'is_closed' => 'Konwersacja jest zamknięta.',
    ],
    'tabs'          => [
        'participants'  => 'Uczestnicy',
    ],
    'targets'       => [
        'characters'    => 'Postaci',
        'members'       => 'Gracze',
    ],
];
