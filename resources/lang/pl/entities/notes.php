<?php

return [
    'actions'       => [
        'add'       => 'Nowa notka',
        'add_user'  => 'Dodaj użytkownika',
    ],
    'create'        => [
        'description'   => 'Stwórz nową notkę',
        'success'       => 'Dodano notkę :name do elementu :entity.',
        'title'         => 'Nowa notka dla elementu :name.',
    ],
    'destroy'       => [
        'success'   => 'Usunięto notkę :name z elementu :entity.',
    ],
    'edit'          => [
        'description'   => 'Aktualizuj istniejąca notkę elementu.',
        'success'       => 'Zaktualizowano notkę :name elementu :entity.',
        'title'         => 'Aktualizacja notki elementu :name',
    ],
    'fields'        => [
        'creator'   => 'Twórca',
        'entry'     => 'Wpis',
        'is_pinned' => 'Przypięta',
        'name'      => 'Nazwa',
        'position'  => 'Kolejność przypięcia',
    ],
    'hint'          => 'Notkami elementu mogą być informacje, które nie mieszczą się w zwykłych polach opisu elementu albo które powinny pozostać tajne.',
    'hints'         => [
        'is_pinned' => 'Przypięte notki zostają wyświetlone pod polem opisu w głównym widoku elementu. Używaj pozycji "Kolejność przypięcia" by ustalić porządek ich wyświetlania.',
    ],
    'index'         => [
        'title' => 'Notki elementu :name',
    ],
    'placeholders'  => [
        'name'  => 'Nazwa notki elementu, spostrzeżenie lub uwaga',
    ],
    'show'          => [
        'advanced'  => 'Uprawnienia zaawansowane',
        'title'     => 'Notka elementu :entity',
    ],
];
