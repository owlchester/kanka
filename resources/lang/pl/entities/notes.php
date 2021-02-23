<?php

return [
    'actions'       => [
        'add'       => 'Nowa uwaga',
        'add_user'  => 'Dodaj użytkownika',
    ],
    'create'        => [
        'description'   => 'Stwórz nową uwagę',
        'success'       => 'Dodano uwagę :name do elementu :entity.',
        'title'         => 'Nowa uwaga dla elementu :name.',
    ],
    'destroy'       => [
        'success'   => 'Usunięto uwagę :name z elementu :entity.',
    ],
    'edit'          => [
        'description'   => 'Aktualizuj istniejąca uwagę o elemencie.',
        'success'       => 'Zmieniono uwagę :name elementu :entity.',
        'title'         => 'Edycja uwagi elementu :name',
    ],
    'fields'        => [
        'collapsed' => 'Domyślnie zamykaj przypięte uwagi',
        'creator'   => 'Twórca',
        'entry'     => 'Wpis',
        'is_pinned' => 'Przypięta',
        'name'      => 'Nazwa',
        'position'  => 'Kolejność przypięcia',
    ],
    'hint'          => 'Uwagi to informacje, które nie mieszczą się w zwykłych polach opisu elementu albo które powinny pozostać tajne.',
    'hints'         => [
        'is_pinned' => 'Przypięte uwagi zostają wyświetlone pod polem opisu w głównym widoku elementu. Używaj pozycji "Kolejność przypięcia" by ustalić porządek ich wyświetlania.',
    ],
    'index'         => [
        'title' => 'Uwagi elementu :name',
    ],
    'placeholders'  => [
        'name'  => 'Nazwa uwagi, spostrzeżenia lub komentarza',
    ],
    'show'          => [
        'advanced'  => 'Uprawnienia zaawansowane',
        'title'     => 'Uwaga elementu :entity',
    ],
];
