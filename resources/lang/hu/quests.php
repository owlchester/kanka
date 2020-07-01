<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Karakter hozzáadása a küldetéshez',
            'success'       => 'A karaktert hozzáadtuk :name küldetéshez.',
            'title'         => 'Karakter hozzáadása :name küldetéshez',
        ],
        'destroy'   => [
            'success'   => 'A karaktert eltávolítottuk :name küldetésből.',
        ],
        'edit'      => [
            'description'   => 'A küldetéshez tartozó karakterek módosítása',
            'success'       => 'A karaktert frissítettük :name küldetésben.',
            'title'         => 'Karakterek módosítása :name küldetésben',
        ],
        'fields'    => [
            'character'     => 'Karakter',
            'description'   => 'Leírás',
        ],
        'title'     => ':name küldetésadója',
    ],
    'create'        => [
        'description'   => 'Új küldetés létrehozása',
        'success'       => '\':name\' küldetést létrehoztuk.',
        'title'         => 'Új küldetés',
    ],
    'destroy'       => [
        'success'   => '\':name\' küldetést eltávolítottuk.',
    ],
    'edit'          => [
        'description'   => 'Küldetés szerkesztése',
        'success'       => '\':name\' küldetést frissítettük.',
        'title'         => ':name küldetés szerkesztése',
    ],
    'fields'        => [
        'character'     => 'Küldetésadó',
        'characters'    => 'Karakterek',
        'date'          => 'Dátum',
        'description'   => 'Leírás',
        'image'         => 'Kép',
        'is_completed'  => 'Teljesítve',
        'items'         => 'Tárgyak',
        'locations'     => 'Helyszínek',
        'name'          => 'Megnevezés',
        'organisations' => 'Szervezetek',
        'quest'         => 'Szülő Küldetés',
        'quests'        => 'Alküldetések',
        'role'          => 'Szerep',
        'type'          => 'Típus',
    ],
    'helpers'       => [
        'nested'    => 'Hierarchikus nézetben a küldetéseidet alá-fölérendeltségi viszonyukban tekintheted meg. A legfelső szinten azokat a küldetéseket láthatod, amiknek nincs főküldetése, rájuk kattintva pedig megtekintheted alküldetéseiket. Amennyiben az egyes alküldetéseknek saját alküldetéseik vannak, azokra kattintva őket is megtekintheted.',
    ],
    'hints'         => [
        'quests'    => 'A főküldetés és az alküldetések mezők használatával összefüggő küldetések hálóját építheted fel.',
    ],
    'index'         => [
        'add'           => 'Új küldetés',
        'description'   => ':name küldetéseinek kezelése',
        'header'        => ':name küldetései',
        'title'         => 'Küldetések',
    ],
    'items'         => [
        'create'    => [
            'description'   => 'Tárgy hozzáadása a küldetéshez',
            'success'       => 'A tárgyat hozzáadtuk :name küldetéshez',
            'title'         => 'Új tárgy :name küldetéshez',
        ],
        'destroy'   => [
            'success'   => 'A tárgyat eltávolítottuk :name küldetésből',
        ],
        'edit'      => [
            'description'   => 'Egy küldetés tárgyainak módosítása',
            'success'       => 'A tárgyat :name küldetésben frissítettük',
            'title'         => ':name küldetés tárgyainak módosítása',
        ],
        'fields'    => [
            'description'   => 'Leírás',
            'item'          => 'Tárgyak',
        ],
        'title'     => 'Tárgyak :name küldetésben',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Helyszín hozzáadása a küldetéshez',
            'success'       => 'A helyszínt :name küldetéshez hozzáadtuk',
            'title'         => 'Új helyszín :name küldetéshez',
        ],
        'destroy'   => [
            'success'   => 'A helyszínt eltávolítottuk :name küldetésből',
        ],
        'edit'      => [
            'description'   => 'Küldetés helyszínének változtatása',
            'success'       => ':name küldetés helyszíneit frissítettük.',
            'title'         => ':name küldetés helyszíneinek módosítása',
        ],
        'fields'    => [
            'description'   => 'Leírás',
            'location'      => 'Helyszín',
        ],
        'title'     => 'Helyszínek :name küldetésben',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Szervezet hozzáadása a küldetéshez',
            'success'       => 'A szervezetet hozzáadtuk :name küldetéshez',
            'title'         => 'Új szervezet :name küldetéshez',
        ],
        'destroy'   => [
            'success'   => 'A szervezetet eltávolítottuk a :name küldetésből',
        ],
        'edit'      => [
            'description'   => 'Küldetés szervezeteinek módosítása',
            'success'       => ':name küldetés szervezeteit frissítettük',
            'title'         => ':name küldetéshez tartozó szervezet módosítása',
        ],
        'fields'    => [
            'description'   => 'Leírás',
            'organisation'  => 'Szervezet',
        ],
        'title'     => 'Szervezetek :name küldetésben',
    ],
    'placeholders'  => [
        'date'  => 'A küldetés valós világbéli dátuma',
        'name'  => 'A küldetés neve',
        'quest' => 'Főküldetés',
        'role'  => 'Az entitás szerepe a küldetésben',
        'type'  => 'Karaktertörténet, mellékszál, főszál',
    ],
    'show'          => [
        'actions'       => [
            'add_character'     => 'Karakter hozzáadása',
            'add_item'          => 'Tárgy hozzáadása',
            'add_location'      => 'Helyszín hozzáadása',
            'add_organisation'  => 'Szervezet hozzáadása',
        ],
        'description'   => 'A küldetés részletes nézete',
        'tabs'          => [
            'characters'    => 'Karakterek',
            'information'   => 'Információ',
            'items'         => 'Tárgyak',
            'locations'     => 'Helyszínek',
            'organisations' => 'Szervezetek',
            'quests'        => 'Küldetések',
        ],
        'title'         => ':name küldetés',
    ],
];
