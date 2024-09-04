<?php

return [
    'actions'       => [
        'action'    => 'Zmień status',
        'add'       => 'Stwórz webhook',
        'bulks'     => [
            'delete_success'    => '{1} Usunięto :count webhook.|[2,4] Usunięto :count webhooki.|[5,*] Usunięto :count webhooków.',
            'disable'           => 'Wyłącz',
            'disable_success'   => '{1} Wyłączono :count webhook.|[2,4] Wyłączono :count webhooki.|[5,*] Wyłączono :count webhooków',
            'enable'            => 'Aktywuj',
            'enable_success'    => '{1} Aktywowano :count webhook.|[2,4] Aktywowano :count webhooki.|[5,*] Aktywowano :count webhooków',
        ],
        'test'      => 'Testuj webhook',
        'update'    => 'Edytuj webhook',
    ],
    'create'        => [
        'success'   => 'Stworzono webhook',
        'title'     => 'Tworzenie webhooka',
    ],
    'destroy'       => [
        'success'   => 'Usunięto webhook',
    ],
    'edit'          => [
        'success'   => 'Zmieniono webhook',
        'title'     => 'Edycja webhooka',
    ],
    'fields'        => [
        'enabled'           => 'Aktywny',
        'event'             => 'Sytuacja',
        'events'            => [
            'deleted'   => 'Usunięcie elementu',
            'edited'    => 'Edycja elementu',
            'new'       => 'Nowy element',
        ],
        'message'           => 'Wiadomość',
        'private_entities'  => [
            'helper'    => 'Nie używaj webhooka podczas edycji elementów prywatnych.',
            'skip'      => 'Omijaj prywatne',
        ],
        'type'              => 'Rodzaj',
        'types'             => [
            'custom'    => 'Wiadomość',
            'payload'   => 'Payload',
        ],
        'url'               => 'Adres url',
    ],
    'helper'        => [
        'active'    => 'Jeśli webhook jest aktywny',
        'message'   => 'Dodaj własną wiadomość z możliwością mapowania',
        'status'    => 'Aktywuje i wyłącza webhook',
    ],
    'pitch'         => 'Twórz własne webhooki i otrzymuj powiadomienia o zmianach elementów kampanii.',
    'placeholders'  => [
        'message'   => '{who} wprowadził/a zmiany w {name}, znajdziesz je tu: {url}',
        'url'       => 'Docelowy adres url webhooka',
    ],
    'test'          => [
        'success'   => 'Wysłano zapytanie testowe',
    ],
    'title'         => 'Webhooki',
];
