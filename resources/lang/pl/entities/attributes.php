<?php

return [
    'actions'       => [
        'apply_template'    => 'Zastosuj szablon cech',
        'manage'            => 'Zarządzaj',
        'more'              => 'Więcej opcji',
        'remove_all'        => 'Usuń wszystko',
    ],
    'errors'        => [
        'loop'  => 'W obliczeniu tej cechy występuje nie kończąca się pętla!',
    ],
    'fields'        => [
        'attribute'             => 'Cecha',
        'community_templates'   => 'Szablony społeczności',
        'is_private'            => 'Szablony Tajne',
        'is_star'               => 'Przypięte',
        'template'              => 'Szablon',
        'value'                 => 'Wartość',
    ],
    'helpers'       => [
        'delete_all'    => 'Czy na pewno chcesz usunąć cechy tego elementu?',
    ],
    'hints'         => [
        'is_private'    => 'Oznaczając cechy jako tajne ukrywasz je przed graczami nie posiadającymi roli administratora.',
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
    'visibility'    => [
        'entry'     => 'Cecha wyświetlana na stronie głównej elementu.',
        'private'   => 'Cecha widoczna wyłącznie dla posiadaczy roli "administrator".',
        'public'    => 'Cecha widoczna dla wszystkich.',
        'tab'       => 'Cecha wyświetlana wyłącznie w zakładce Cechy.',
    ],
];
