<?php

return [
    'actions'       => [
        'add_appearance'    => 'Megjelenés hozzáadása',
        'add_organisation'  => 'Szervezet hozzáadása',
        'add_personality'   => 'Személyiség hozzáadása',
    ],
    'conversations' => [
        'description'   => 'Beszélgetések, amelyekben a karakter részt vesz.',
        'title'         => ':name karakter beszélgetései',
    ],
    'create'        => [
        'description'   => 'Új karakter létrehozása',
        'success'       => ':name karaktert létrehoztuk.',
        'title'         => 'Új karakter',
    ],
    'destroy'       => [
        'success'   => '\':name\' karaktert eltávolítottuk.',
    ],
    'dice_rolls'    => [
        'description'   => 'A dobásokat a karakterhez rendeltük.',
        'hint'          => 'A dobásokat egy karakterhez lehet rendelni a játék közbeni használat érdekében.',
        'title'         => ':name karakter dobásai',
    ],
    'edit'          => [
        'description'   => 'Karakter szerkesztése',
        'success'       => '\':name\' karaktert frissítettük.',
        'title'         => ':name karakter szerkesztése',
    ],
    'fields'        => [
        'age'                       => 'Kor',
        'family'                    => 'Család',
        'image'                     => 'Kép',
        'is_dead'                   => 'Halott',
        'is_personality_visible'    => 'Látható a személyiség',
        'life'                      => 'Élet',
        'location'                  => 'Helyszín',
        'name'                      => 'Név',
        'physical'                  => 'Fizikum',
        'race'                      => 'Faj',
        'relation'                  => 'Kapcsolat',
        'sex'                       => 'Nem',
        'title'                     => 'Titulus',
        'traits'                    => 'Jellemzők',
        'type'                      => 'Típus',
    ],
    'helpers'       => [
        'age'   => 'Összerendelheted ezt az entitást a kampányod egy naptárával, hogy az életkor automatikusan kerüljön számításra. :more.',
        'free'  => 'Hová tűnt a "Szabad" mező? Ha ennek a karakternek van egy, azt áttettük az új jegyzet fülre!',
    ],
    'hints'         => [
        'hide_personality'          => 'Ez a fület el lehet rejteni a nem "Admin" felhasználók elől, ha kikapcsoljuk a "Látható személyiség" opciót, amikor szerkesztjük ezt a karaktert.',
        'is_dead'                   => 'Ez a karakter halott.',
        'is_personality_visible'    => 'A teljes személyiség szekciót elrejtheted a nem "Admin" felhasználók elől.',
    ],
    'index'         => [
        'actions'       => [
            'random'    => 'Új véletlen karakter',
        ],
        'add'           => 'Új karakter',
        'description'   => ':name karakter kezelése',
        'header'        => 'Karakterek itt: :name',
        'title'         => 'Karakterek',
    ],
    'items'         => [
        'description'   => 'A karakter tárgyai.',
        'hint'          => 'A tárgyakat a karakterekhez rendelheted, és azokat itt mutatjuk meg.',
        'title'         => ':name karakter tárgyai',
    ],
    'journals'      => [
        'description'   => 'Irományok, amelyeknek a karakter a szerzője.',
        'title'         => ':name karakter irományai',
    ],
    'maps'          => [
        'description'   => 'Egy karakter kapcsolati térképe.',
        'title'         => ':name karakter kapcsolati térképe',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Szervezet hozzáadása',
        ],
        'create'        => [
            'description'   => 'Egy szervezet és egy karakter összekapcsolása',
            'success'       => 'A karaktert hozzáadtuk a szervezethez.',
            'title'         => ':name számára új szervezet',
        ],
        'description'   => 'Szervezetek, amelynek a karakter tagja.',
        'destroy'       => [
            'success'   => 'A karakter szervezetét eltávolítottuk.',
        ],
        'edit'          => [
            'description'   => 'Egy karakter szervezetének frissítése',
            'success'       => 'A karakter szervezetét frissítettük.',
            'title'         => 'Szervezet frissítése :name számára',
        ],
        'fields'        => [
            'organisation'  => 'Szervezet',
            'role'          => 'Szerep',
        ],
        'hint'          => 'A karakterek számos szervezet tagjai lehetnek, jelezve, hogy kinek dolgoznak, vagy hogy milyen titkos társaság tagjai.',
        'placeholders'  => [
            'organisation'  => 'Válassz egy szervezetet...',
        ],
        'title'         => ':name karakter szervezetei',
    ],
    'placeholders'  => [
        'age'               => 'Kor',
        'appearance_entry'  => 'Leírás',
        'appearance_name'   => 'Haj, szem, bőr, magasság',
        'family'            => 'Kérjük, válassz egy karaktert!',
        'image'             => 'Kép',
        'location'          => 'Kérjük, válassz egy helyszínt!',
        'name'              => 'Név',
        'personality_entry' => 'Részletek',
        'personality_name'  => 'Célok, viselkedés, félelmek, kötelékek',
        'physical'          => 'Fizikum',
        'race'              => 'Faj',
        'sex'               => 'Nem',
        'title'             => 'Titulus',
        'traits'            => 'Jellemzők',
        'type'              => 'NJK, játékos karakter, istenség',
    ],
    'quests'        => [
        'description'   => 'Küldetések, amelyeknek része a karakter.',
        'helpers'       => [
            'quest_giver'   => 'Küldetések, amelyeket a karakter ad.',
            'quest_member'  => 'Küldetések, amelyekben a karakter részt vesz.',
        ],
        'title'         => ':name karakter küldetései',
    ],
    'sections'      => [
        'appearance'    => 'Megjelenés',
        'general'       => 'Általános információk',
        'personality'   => 'Személyiség',
    ],
    'show'          => [
        'description'   => 'Egy karakter részletes megjelenítése',
        'tabs'          => [
            'conversations' => 'Beszélgetések',
            'dice_rolls'    => 'Dobások',
            'items'         => 'Tárgyak',
            'journals'      => 'Irományok',
            'map'           => 'Kapcsolati térkép',
            'organisations' => 'Szervezetek',
            'personality'   => 'Személyiség',
            'quests'        => 'Küldetések',
        ],
        'title'         => ':name karakter',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Nincs jogosultságod szerkeszteni ennek a karakternek a Személyiség jellemzőit.',
    ],
];
