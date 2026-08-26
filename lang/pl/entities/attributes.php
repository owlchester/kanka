<?php

return [
    'actions'       => [
        'apply_kit'     => 'Zastosuj szablon cech',
        'load'          => 'Wczytaj',
        'manage'        => 'Zarządzaj',
        'more'          => 'Inne',
        'remove_all'    => 'Usuń wszystko',
        'save_and_edit' => 'Zastosuj i edytuj',
        'save_and_story'=> 'Zastosuj i zobacz',
        'show_hidden'   => 'Pokaż ukryte cechy',
        'toggle_privacy'=> 'Tajne/Jawne',
    ],
    'errors'        => [
        'api'                   => 'Niewłaściwe dane',
        'loop'                  => 'W obliczeniu tej cechy występuje nieskończona pętla!',
        'no_attribute_selected' => 'Wybierz najpierw jedną lub więcej cech.',
        'too_many_v2'           => 'Maksymalna liczba pól (:count/max). Skasuj jakieś cechy przed dodaniem nowych.',
    ],
    'fields'        => [
        'community_templates'   => 'Szablony społeczności',
        'is_private'            => 'Cechy tajne',
        'is_star'               => 'Przypięte',
        'kit'                   => 'Szablon',
        'preferences'           => 'Ustawienia',
        'property'              => 'Cecha',
        'value'                 => 'Wartość',
    ],
    'filters'       => [
        'name'  => 'Nazwa cechy',
        'value' => 'Wartość cechy',
    ],
    'helpers'       => [
        'delete_all'    => 'Czy na pewno chcesz usunąć wszystkie cechy tego elementu?',
        'is_private'    => 'Tylko uczestnicy posiadający rolę :admin-role będą widzieć cechy elementu.',
        'setup'         => 'Element może posiadać cechy, na przykład Punkty Wytrzymałości albo Inteligencję. Cechę możesz dodać ręcznie klikając na :manage albo zastosować szablon.',
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
        'block'     => 'Nazwa akapitu',
        'checkbox'  => 'Nazwa pola wyboru',
        'icon'      => [
            'class' => 'Klasa FontAwesome lub RPG Awesome: fas fa-users',
            'name'  => 'Nazwa ikony',
        ],
        'kit'       => 'Wybierz szablon',
        'number'    => 'Wartość liczbowa',
        'random'    => [
            'name'  => 'Nazwa cechy',
            'value' => '1-100 lub lista wartości rozdzielonych przecinkiem',
        ],
        'section'   => 'Nazwa sekcji',
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
        'title'     => 'Cechy :name',
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
        'bulk_deleted'  => 'Usunięto cechę',
        'bulk_privacy'  => 'Zmieniono ustawienia prywatności',
        'lock'          => 'Zablokowano cechę',
        'pin'           => 'Przypięto cechę',
        'unlock'        => 'Odblokowano cechę',
        'unpin'         => 'Odpięto cechę',
    ],
    'tutorials'     => [],
    'types'         => [
        'attribute' => 'Tekst',
        'block'     => 'Blok',
        'checkbox'  => 'Pole wyboru',
        'icon'      => 'Ikona',
        'kits'      => 'Szablony',
        'number'    => 'Liczba',
        'random'    => 'Losowo',
        'section'   => 'Sekcja',
        'text'      => 'Akapit',
    ],
    'update'        => [
        'success'   => 'Zmieniono cechy elementu :entity.',
    ],
    'visibility'    => [
        'entry'     => 'Cecha wyświetlana na stronie głównej elementu.',
        'private'   => 'Cecha widoczna tylko dla administratorów.',
        'public'    => 'Cecha widoczna dla wszystkich.',
        'tab'       => 'Cecha wyświetlana wyłącznie w zakładce Cechy.',
    ],
];
