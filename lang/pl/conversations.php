<?php

return [
    'create'        => [
        'title' => 'Nowa konwersacja',
    ],
    'destroy'       => [],
    'edit'          => [
        'title' => 'Konwersacja :name',
    ],
    'fields'        => [
        'is_closed'     => 'Zamknięta',
        'messages'      => 'Wiadomości',
        'participants'  => 'Uczestnicy',
    ],
    'hints'         => [
        'participants'  => 'Dodawaj uczestników konwersacji naciskając ikonę :icon w prawym górnym rogu.',
    ],
    'index'         => [],
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
        'conversation'  => 'Konwersacja',
        'participants'  => 'Uczestnicy',
    ],
    'targets'       => [
        'characters'    => 'Postaci',
        'members'       => 'Gracze',
    ],
];
