<?php

return [
    'applications'      => [
        'title' => 'Autoryzowane aplikacje',
    ],
    'clients'           => [
        'empty' => 'Nie stworzono żadnego klienta OAuth.',
        'form'  => [
            'name'                  => 'Nazwa klienta',
            'name_helper'           => 'Słowo, które twoi użytkownicy rozpoznają i mu zaufają.',
            'name_placeholder'      => 'Nazwa dla klienta',
            'redirect'              => 'Przekierowanie',
            'redirect_helper'       => 'Aplikacje z autoryzowanym wywołaniem zwrotnym.',
            'redirect_placeholder'  => 'http://my-super-app.com/callback',
        ],
        'new'   => 'Stwórz nowego klienta',
        'title' => 'Klienty OAuth',
        'update'=> 'Zmiana klienta',
    ],
    'fields'            => [
        'client'        => 'ID klienta',
        'client_name'   => 'Nazwa klienta',
        'scopes'        => 'Zakresy',
        'secret'        => 'Tajne',
        'token_name'    => 'Nazwa klucza',
    ],
    'new'               => [
        'copy'  => 'Klucz skopiowano do schowka',
        'title' => 'Twój nowy osobisty klucz dostępu:',
    ],
    'revoke'            => 'Wycofaj',
    'revoke-confirm'    => 'Potwierdź wycofanie',
    'tokens'            => [
        'empty' => 'Nie stworzono żadnego klucza dostępu.',
        'form'  => [
            'name'              => 'Nazwa klucza',
            'name_placeholder'  => 'Nazwa dla klucza',
        ],
        'new'   => 'Stwórz nowy klucz',
        'title' => 'Osobiste klucze dostępu',
    ],
];
