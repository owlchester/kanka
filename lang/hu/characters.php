<?php

return [
    'actions'       => [
        'add_appearance'    => 'Megjelenés hozzáadása',
        'add_personality'   => 'Személyiség hozzáadása',
    ],
    'conversations' => [],
    'create'        => [
        'title' => 'Új karakter',
    ],
    'destroy'       => [],
    'dice_rolls'    => [],
    'edit'          => [],
    'fields'        => [
        'age'                       => 'Kor',
        'is_dead'                   => 'Halott',
        'is_personality_visible'    => 'Látható a személyiség',
        'life'                      => 'Élet',
        'physical'                  => 'Fizikum',
        'pronouns'                  => 'Névmások',
        'sex'                       => 'Nem',
        'title'                     => 'Titulus',
        'traits'                    => 'Jellemzők',
    ],
    'helpers'       => [
        'age'   => 'Összerendelheted ezt az entitást a kampányod egy naptárával, hogy az életkor automatikusan kerüljön számításra. :more.',
    ],
    'hints'         => [
        'is_dead'                   => 'Ez a karakter halott.',
        'is_personality_visible'    => 'A teljes személyiség szekciót elrejtheted a nem "Admin" felhasználók elől.',
        'personality_not_visible'   => 'Ennek a karakternek a személyes jellemzőit jelenleg csak az Admin láthatja.',
        'personality_visible'       => 'Ennek a karakternek a személyes jellemzőit mindenki láthatja.',
    ],
    'index'         => [],
    'items'         => [],
    'journals'      => [],
    'maps'          => [],
    'organisations' => [
        'create'    => [
            'success'   => 'A karaktert hozzáadtuk a szervezethez.',
            'title'     => ':name számára új szervezet',
        ],
        'destroy'   => [
            'success'   => 'A karakter szervezetét eltávolítottuk.',
        ],
        'edit'      => [
            'success'   => 'A karakter szervezetét frissítettük.',
            'title'     => 'Szervezet frissítése :name számára',
        ],
        'fields'    => [
            'role'  => 'Szerep',
        ],
    ],
    'placeholders'  => [
        'age'               => 'Kor',
        'appearance_entry'  => 'Leírás',
        'appearance_name'   => 'Haj, szem, bőr, magasság',
        'personality_entry' => 'Részletek',
        'personality_name'  => 'Célok, viselkedés, félelmek, kötelékek',
        'physical'          => 'Fizikum',
        'pronouns'          => 'Ő (férfi) , Ő (nő), Ők',
        'sex'               => 'Nem',
        'title'             => 'Titulus',
        'traits'            => 'Jellemzők',
        'type'              => 'NJK, játékos karakter, istenség',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Küldetések, amelyeket a karakter ad.',
            'quest_member'  => 'Küldetések, amelyekben a karakter részt vesz.',
        ],
    ],
    'sections'      => [
        'appearance'    => 'Megjelenés',
        'personality'   => 'Személyiség',
    ],
    'show'          => [],
    'warnings'      => [
        'personality_hidden'    => 'Nincs jogosultságod szerkeszteni ennek a karakternek a Személyiség jellemzőit.',
    ],
];
