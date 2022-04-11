<?php

return [
    'actions'       => [
        'apply_template'    => 'Zastosuj szablon cech',
        'manage'            => 'Zarządzaj',
        'more'              => 'Więcej opcji',
        'remove_all'        => 'Usuń wszystko',
    ],
    'errors'        => [
        'loop'      => 'W obliczeniu tej cechy występuje nie kończąca się pętla!',
        'too_many'  => 'Ten element ma zbyt wiele pól, nie można dodać kolejnych cech. Przed ich dodaniem usuń kilka istniejących.',
    ],
    'fields'        => [
        'attribute'             => 'Cecha',
        'community_templates'   => 'Szablony społeczności',
        'is_private'            => 'Szablony Tajne',
        'is_star'               => 'Przypięte',
        'template'              => 'Szablon',
        'value'                 => 'Wartość',
    ],
    'filters'       => [
        'name'  => 'Nazwa cechy',
        'value' => 'Wartość cechy',
    ],
    'helpers'       => [
        'delete_all'    => 'Czy na pewno chcesz usunąć cechy tego elementu?',
        'setup'         => 'Element może posiadać cechy, na przykład Punkty Wytrzymałości albo Inteligencję. Cechę możesz ustalić i dodać ręcznie klikając na :manage albo zastosować szablon.',
    ],
    'hints'         => [
        'is_private2'   => 'Po zaznaczeniu tylko członkowie w roli :admin-role będą widzieć cechy tej postaci.',
    ],
    'index'         => [
        'success'   => 'Zaktualizowano cechy :entity',
        'title'     => 'Cechy :name',
    ],
    'placeholders'  => [
        'attribute' => 'Liczba zwycięstw, Skala Wyzwania, Inicjatywa, Populacja',
        'block'     => 'Nazwa bloku',
        'checkbox'  => 'Nazwa pola wyboru',
        'icon'      => [
            'class' => 'Klasa FontAwesome lub RPG Awesome: fas fa-users',
            'name'  => 'Nazwa ikony',
        ],
        'random'    => [
            'name'  => 'Nazwa cechy',
            'value' => '1-100 lub lista wartości rozdzielonych przecinkiem',
        ],
        'section'   => 'Nazwa sekcji',
        'template'  => 'Wybierz szablon',
        'value'     => 'Wartość cechy',
    ],
    'show'          => [
        'title' => 'Cechy elementu :name',
    ],
    'template'      => [
        'success'   => 'Zastosowano szablon cech :name dla :entity',
        'title'     => 'Zastosuj szablon cech dla :name',
    ],
    'types'         => [
        'attribute' => 'Cecha',
        'block'     => 'Blok',
        'checkbox'  => 'Pole wyboru',
        'icon'      => 'Ikona',
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
