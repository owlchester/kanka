<?php

return [
    'actions'       => [
        'add'       => 'Nowy komentarz',
        'add_user'  => 'Dodaj użytkownika',
    ],
    'create'        => [
        'description'   => 'Stwórz nowy komentarz',
        'success'       => 'Dodano komentarz :name do elementu :entity.',
        'title'         => 'Nowy komentarz do elementu :name.',
    ],
    'destroy'       => [
        'success'   => 'Usunięto komentarz :name do elementu :entity.',
    ],
    'edit'          => [
        'description'   => 'Aktualizuj komentarz do elementu.',
        'success'       => 'Zmieniono komentarz :name do elementu :entity.',
        'title'         => 'Edycja komentarza do elementu :name',
    ],
    'fields'        => [
        'collapsed' => 'Domyślnie zamykaj przypięte komentarze',
        'creator'   => 'Twórca',
        'entry'     => 'Szczegóły',
        'is_pinned' => 'Przypięta',
        'name'      => 'Nazwa',
        'position'  => 'Kolejność przypięcia',
    ],
    'hint'          => 'Komentarze to informacje, które nie mieszczą się w zwykłych polach opisu elementu albo które powinny pozostać tajne.',
    'hints'         => [
        'is_pinned' => 'Przypięte komentarze zostają wyświetlone pod polem opisu w głównym widoku elementu. Używaj pozycji "Kolejność przypięcia" by ustalić porządek ich wyświetlania.',
        'reorder'   => 'Możesz zmieniać kolejność komentarzy po kliknięciu na ikonę :icon obok pozycji "historia" w menu elementu',
    ],
    'index'         => [
        'title' => 'Komentarze do elementu :name',
    ],
    'placeholders'  => [
        'name'  => 'Nazwa uwagi, spostrzeżenia lub komentarza',
    ],
    'show'          => [
        'advanced'  => 'Uprawnienia zaawansowane',
        'title'     => 'Komentarz do elementu :entity',
    ],
];
