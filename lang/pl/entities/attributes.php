<?php

return [
    'actions'       => [
        'load'          => 'Wczytaj',
        'manage'        => 'Zarządzaj',
        'more'          => 'Więcej opcji',
        'remove_all'    => 'Usuń wszystko',
        'save_and_edit' => 'Zastosuj i edytuj',
        'save_and_story'=> 'Zastosuj i zobacz',
        'show_hidden'   => 'Pokaż ukryte cechy',
        'toggle_privacy'=> 'Prywatne/Publiczne',
    ],
    'errors'        => [
        'api'                   => 'Niewłaściwe dane',
        'loop'                  => 'W obliczeniu tej cechy występuje nie kończąca się pętla!',
        'no_attribute_selected' => 'Wybierz najpierw jedną lub więcej cech.',
        'too_many_v2'           => 'Maksymalna liczba pól (:count/max). Skasuj jakieś cechy przed dodaniem nowych.',
    ],
    'fields'        => [
        'community_templates'   => 'Szablony społeczności',
        'is_private'            => 'Szablony Tajne',
        'is_star'               => 'Przypięte',
        'preferences'           => 'Ustawienia',
        'template'              => 'Szablon',
        'value'                 => 'Wartość',
    ],
    'filters'       => [
        'name'  => 'Nazwa cechy',
        'value' => 'Wartość cechy',
    ],
    'helpers'       => [
        'delete_all'    => 'Czy na pewno chcesz usunąć cechy tego elementu?',
        'is_private'    => 'Tylko członkowie posiadający rolę :admin-role będą widzieć cechy elementu.',
        'setup'         => 'Element może posiadać cechy, na przykład Punkty Wytrzymałości albo Inteligencję. Cechę możesz ustalić i dodać ręcznie klikając na :manage albo zastosować szablon.',
    ],
    'hints'         => [],
    'index'         => [
        'success'   => 'Zaktualizowano cechy :entity',
        'title'     => 'Cechy :name',
    ],
    'labels'        => [
        'checkbox'  => 'Nazwa pola wyboru',
        'name'      => 'Nazwa cechy',
        'section'   => 'Nazwa sekcji',
        'value'     => 'Wartość cechy',
    ],
    'live'          => [
        'success'   => 'Zmieniono cechę :attribute.',
        'title'     => 'Zmiana cechy :attribute.',
    ],
    'placeholders'  => [
        'attribute' => 'Liczba zwycięstw, Skala Wyzwania, Inicjatywa, Populacja',
        'block'     => 'Nazwa bloku',
        'checkbox'  => 'Nazwa pola wyboru',
        'icon'      => [
            'class' => 'Klasa FontAwesome lub RPG Awesome: fas fa-users',
            'name'  => 'Nazwa ikony',
        ],
        'number'    => 'Rodzaj liczby',
        'random'    => [
            'name'  => 'Nazwa cechy',
            'value' => '1-100 lub lista wartości rozdzielonych przecinkiem',
        ],
        'section'   => 'Nazwa sekcji',
        'template'  => 'Wybierz szablon',
        'value'     => 'Wartość cechy',
    ],
    'ranges'        => [
        'text'  => 'Dostępne opcje: :options',
    ],
    'sections'      => [
        'unorganised'   => 'Nieprzypisane',
    ],
    'show'          => [
        'hidden'    => 'Ukryte cechy',
        'title'     => 'Cechy elementu :name',
    ],
    'template'      => [
        'load'      => [
            'success'   => 'Wczytano szablon',
            'title'     => 'Wczytaj szablon',
        ],
        'pitch'     => 'Załaduj cechy z szablonu albo dodatków zainstalowanych za pomocą :plugin.',
        'success'   => 'Zastosowano szablon cech :name dla :entity',
        'title'     => 'Zastosuj szablon cech dla :name',
    ],
    'title'         => 'Cechy',
    'toasts'        => [
        'bulk_deleted'  => 'Usunięto cechy',
        'bulk_privacy'  => 'Zmieniono ustawienia prywatności',
        'lock'          => 'Zablokowano',
        'pin'           => 'Przypięto',
        'unlock'        => 'Odblokowano',
        'unpin'         => 'Odpięto',
    ],
    'tutorials'     => [],
    'types'         => [
        'attribute' => 'Cecha',
        'block'     => 'Blok',
        'checkbox'  => 'Pole wyboru',
        'icon'      => 'Ikona',
        'number'    => 'Liczba',
        'random'    => 'Losowy',
        'section'   => 'Sekcja',
        'text'      => 'Kilka wierszy',
    ],
    'update'        => [
        'success'   => 'Zaktualizowano cechy elementu :entity.',
    ],
    'visibility'    => [
        'entry'     => 'Cecha wyświetlana na stronie głównej elementu.',
        'private'   => 'Cecha widoczna wyłącznie dla posiadaczy roli "administrator".',
        'public'    => 'Cecha widoczna dla wszystkich.',
        'tab'       => 'Cecha wyświetlana wyłącznie w zakładce Cechy.',
    ],
];
