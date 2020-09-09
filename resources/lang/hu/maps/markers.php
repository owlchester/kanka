<?php

return [
    'actions'       => [
        'remove'    => 'Térképjelző eltávolítása',
        'update'    => 'Térképjelző szerkesztése',
    ],
    'create'        => [
        'success'   => 'A \':name\' térképjelzőt létrehoztuk.',
        'title'     => 'Új térképjelző',
    ],
    'delete'        => [
        'success'   => 'A \':name\' térképjelzőt eltávolítottuk.',
    ],
    'edit'          => [
        'success'   => 'A \':name\' térképjelzőt frissítettük.',
        'title'     => ':name térképjelző szerkesztése',
    ],
    'fields'        => [
        'custom_icon'   => 'Egyedi ikon',
        'custom_shape'  => 'Egyedi alakzat',
        'group'         => 'Térképjelző csoport',
        'is_draggable'  => 'Húzható',
        'latitude'      => 'Szélesség',
        'longitude'     => 'Hosszúság',
        'opacity'       => 'Áttetszőség',
    ],
    'helpers'       => [
        'base'          => 'Adj térképjelzőket a térképhez, a kiválasztott helyre kattintva.',
        'custom_icon'   => 'Másold ki a HTML-jét egy ikonnak a :fontawesome-ról vagy :rpgawesome-ról, vagy egy egyedi SVG ikonnak.',
        'draggable'     => 'Pipáld ki, hogy felfedezés módban szabadon mozgatni tudd a térképjelzőt a térképen.',
    ],
    'icons'         => [
        'custom'        => 'Egyedi',
        'entity'        => 'Entitás',
        'exclamation'   => 'Felkiáltójel',
        'marker'        => 'Jelző',
        'question'      => 'Kérdőjel',
    ],
    'placeholders'  => [
        'custom_shape'  => '100,100 200,240 340,110',
        'name'          => 'Kötelező, ha nincs kijelölt entitás',
    ],
    'shapes'        => [
        '0' => 'Kör',
        '1' => 'Négyzet',
        '2' => 'Háromszög',
        '3' => 'Egyedi',
    ],
    'sizes'         => [
        '0' => 'Pöttöm',
        '1' => 'Normál',
        '2' => 'Kis',
        '3' => 'Nagy',
        '4' => 'Hatalmas',
    ],
    'tabs'          => [
        'circle'    => 'Kör',
        'label'     => 'Címke',
        'marker'    => 'Jelző',
        'polygon'   => 'Sokszög',
    ],
];
