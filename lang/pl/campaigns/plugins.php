<?php

return [
    'actions'       => [
        'bulks'             => [
            'disable'   => 'Wyłącz dodatki',
            'enable'    => 'Aktywuj dodatki',
            'update'    => 'Aktualizuj dodatki',
        ],
        'changelog'         => 'Zmiany',
        'disable'           => 'Wyłącz dodatek',
        'enable'            => 'Aktywuj dodatek',
        'go_to_marketplace' => 'Idź na Targowisko',
        'import'            => 'Importuj',
        'update'            => 'Aktualizuj dodatek',
        'update_available'  => 'Dostępna aktualizacja!',
    ],
    'bulks'         => [
        'delete'    => '{1} Usunięto :count dodatek.|[2,4] Usunięto :count dodatki.|[5,*] Usunięto :count dodatków.',
        'disable'   => '{1} Wyłączono :count dodatek.|[2,4] Wyłączono :count dodatki.|[5,*] Wyłączono :count dodatków.',
        'enable'    => '{1} Aktywowano :count dodatek.|[2,4] Aktywowano :count dodatki.|[5,*] Aktywowano :count dodatków.',
        'update'    => '{1} Zaktualizowano :count dodatek.|[2,4] Zaktualizowano :count dodatki.|[5,*] Zaktualizowano :count dodatków.',
    ],
    'destroy'       => [
        'success'   => 'Usunięto dodatek :plugin',
    ],
    'disabled'      => [
        'success'   => 'Deaktywowano dodatek :plugin',
    ],
    'empty_list'    => 'Ta kampania nie ma na razie żadnych dodatków. Odwiedź targowisko, zainstaluj dodatki i wróć, by je aktywować.',
    'enabled'       => [
        'success'   => 'Aktywowano dodatek :plugin',
    ],
    'errors'        => [
        'invalid_plugin'    => 'Niewłaściwy dodatek.',
    ],
    'fields'        => [
        'name'      => 'Nazwa dodatku',
        'obsolete'  => 'Dodatek oznaczono jako przestarzały ponieważ przestał działać w sposób zamierzony przez twórców.',
        'status'    => 'Status',
        'type'      => 'Rodzaj dodatku',
    ],
    'import'        => [
        'button'                => 'Importuj',
        'created'               => 'Stworzono następujące elementy:',
        'helper'                => 'Zaimportujesz zaraz :elementów z dodatku :plugin. Jeżeli był importowany wcześniej, utracisz wszystkie zmiany wprowadzone w tych elementach.',
        'no_new_entities'       => 'Brak nowych elementów do zaimportowania.',
        'option_only_import'    => 'Importuj tylko nowe elementy i pomijaj już zaimportowanie.',
        'option_private'        => 'Importowane elementy są tajne.',
        'success'               => '{1} Zaimportowano :count element z dodatku :plugin.|[2,3,4] Zaimportowano :count elementy z dodatku :plugin.|[5,*] Zaimportowano :count elementów z dodatku :plugin.',
        'title'                 => 'Import :plugin',
        'updated'               => 'Zmieniono następujące elementy:',
    ],
    'info'          => [
        'helper'        => 'Wydano nowszą wersję tego dodatku - możesz go zaktualizować.',
        'title'         => 'Aktualizacje dodatku :plugin',
        'updates'       => 'Aktualizacje',
        'your_version'  => 'Używana wersja',
    ],
    'pitch'         => 'Instaluj i zarządzaj dodatkami z :marketplace.',
    'status'        => [
        'disabled'  => 'Niektywny',
        'enabled'   => 'Aktywny',
    ],
    'templates'     => [
        'name'  => ':name autorstwa :user',
    ],
    'title'         => 'Dodatki Kampanii :name',
    'types'         => [
        'attribute' => 'Szablon cech',
        'pack'      => 'Dodatkowa zawartość',
        'theme'     => 'Motyw',
    ],
    'update'        => [
        'success'   => 'Zaktualizowano dodatek :plugin',
    ],
];
