<?php

return [
    'actions'       => [
        'entry'             => 'Írj egy saját bejegyzést ehhez a jelölőhöz.',
        'remove'            => 'Térképjelző eltávolítása',
        'save_and_explore'  => 'Mentés és felfedezés',
        'update'            => 'Térképjelző szerkesztése',
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
        'circle_radius' => 'Körsugár',
        'copy_elements' => 'Elemek másolása',
        'custom_icon'   => 'Egyedi ikon',
        'custom_shape'  => 'Egyedi alakzat',
        'font_colour'   => 'Ikon színe',
        'group'         => 'Térképjelző csoport',
        'is_draggable'  => 'Húzható',
        'latitude'      => 'Szélesség',
        'longitude'     => 'Hosszúság',
        'opacity'       => 'Áttetszőség',
        'pin_size'      => 'Kitűző mérete',
        'polygon_style' => [
            'stroke'            => 'Ecset színe',
            'stroke-opacity'    => 'Ecset átlátszatlansága',
            'stroke-width'      => 'Ecset szélessége',
        ],
    ],
    'helpers'       => [
        'base'                      => 'Adj térképjelzőket a térképhez, a kiválasztott helyre kattintva.',
        'copy_elements'             => 'Csoportok, rétegek és jelölők másolása',
        'copy_elements_to_campaign' => 'A térképek csoportjainak, rétegeinek és jelölőinek másolása. A valamilyen entitáshoz kapcsolt jelölők sztenderd jelölőkké lesznek átalakítva.',
        'custom_icon'               => 'Másold ki a HTML-jét egy ikonnak a :fontawesome-ról vagy :rpgawesome-ról, vagy egy egyedi SVG ikonnak.',
        'custom_radius'             => 'Válasz egyéni méretet a legördülőből a méret definiálásához.',
        'draggable'                 => 'Pipáld ki, hogy felfedezés módban szabadon mozgatni tudd a térképjelzőt a térképen.',
        'label'                     => 'Egy címke szövegblokként jelenik meg a térképen. A tartalma az entitás és a jelölő neve lesz.',
        'polygon'                   => [
            'edit'  => 'Klikkelj a térképre, hogy hozzáadd ezt a pozíciót a poligon koordinátáihoz.',
            'new'   => 'Mozgasd a jelölőt a térképen, hogy kijelöld a poligon pozícióját.',
        ],
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
