<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Karakter hozzáadása a küldetéshez',
            'success'       => 'A karaktert hozzáadtuk a :name küldetéshez.',
            'title'         => 'Karakter hozzáadása a :name küldetéshez',
        ],
        'destroy'   => [
            'success'   => 'A karaktert eltávolítottuk a :name küldetésből.',
        ],
        'edit'      => [
            'description'   => 'A küldetéshez tartozó karakterek módosítása',
            'success'       => 'A karaktert frissítettük a :name küldetésben.',
            'title'         => 'Karakterek módosítása a :name küldetésben',
        ],
        'fields'    => [
            'character'     => 'Karakter',
            'description'   => 'Leírás',
        ],
        'title'     => 'A :name küldetésadója',
    ],
    'create'        => [
        'description'   => 'Új küldetés létrehozása',
        'success'       => 'A \':name\' küldetést létrehoztuk.',
        'title'         => 'Új küldetés',
    ],
    'destroy'       => [
        'success'   => 'A \':name\' küldetést eltávolítottuk.',
    ],
    'edit'          => [
        'description'   => 'Küldetés szerkesztése',
        'success'       => 'A \':name\' küldetést frissítettük.',
        'title'         => 'A :name küldetés szerkesztése',
    ],
    'fields'        => [
        'character'     => 'Küldetésadó',
        'characters'    => 'Karakterek',
        'description'   => 'Leírás',
        'image'         => 'Kép',
        'is_completed'  => 'Teljesítve',
        'items'         => 'Tárgyak',
        'locations'     => 'Helyszínek',
        'name'          => 'Megnevezés',
        'organisations' => 'Szervezetek',
        'quest'         => 'Főküldetés',
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
            'success'       => 'A tárgyat hozzáadtuk a :name küldetéshez',
            'title'         => 'Új tárgy a :name küldetéshez',
        ],
        'destroy'   => [
            'success'   => 'A tárgyat eltávolítottuk a :name küldetésből',
        ],
        'edit'      => [
            'description'   => 'Egy küldetés tárgyainak módosítása',
            'success'       => 'A tárgyat a :name küldetésben frissítettük',
            'title'         => 'A :name küldetés tárgyainak módosítása',
        ],
        'fields'    => [
            'description'   => 'Leírás',
            'item'          => 'Tárgyak',
        ],
        'title'     => 'Tárgyak a :name küldetésben',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Helyszín hozzáadása a küldetéshez',
            'success'       => 'A helyszínt a :name küldetéshez hozzáadtuk',
            'title'         => 'Új helyszín a :name küldetéshez',
        ],
        'destroy'   => [
            'success'   => 'A helyszínt eltávolítottuk a :name küldetésből',
        ],
        'edit'      => [
            'description'   => 'Küldetés helyszínének változtatása',
            'success'       => 'A :name küldetés helyszíneit frissítettük.',
            'title'         => 'A :name küldetés helyszíneinek módosítása',
        ],
        'fields'    => [
            'description'   => 'Leírás',
            'location'      => 'Helyszín',
        ],
        'title'     => 'Helyszínek a :name küldetésben',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Szervezet hozzáadása a küldetéshez',
            'success'       => 'A szervezetet hozzáadtuk a :name küldetéshez',
            'title'         => 'Új szervezet a :name küldetéshez',
        ],
        'destroy'   => [
            'success'   => 'A szervezetet eltávolítottuk a :name küldetésből',
        ],
        'edit'      => [
            'description'   => 'Küldetés szervezeteinek módosítása',
            'success'       => 'A :name küldetés szervezeteit frissítettük',
            'title'         => 'A :name küldetéshez tartozó szervezet módosítása',
        ],
        'fields'    => [
            'description'   => 'Leírás',
            'organisation'  => 'Szervezet',
        ],
        'title'     => 'Szervezetek a :name küldetésben',
    ],
    'placeholders'  => [
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
