<?php

return [
    'actions'       => [
        'entry' => 'Napiši proizvoljno polje za unos za ovaj marker.',
        'remove'=> 'Ukloni marker',
        'update'=> 'Uredi marker',
    ],
    'create'        => [
        'success'   => 'Kreiran marker :name.',
        'title'     => 'Novi marker',
    ],
    'delete'        => [
        'success'   => 'Obrisan marker :name.',
    ],
    'edit'          => [
        'success'   => 'Ažuriran marker :name.',
        'title'     => 'Uredi marker :name',
    ],
    'fields'        => [
        'circle_radius' => 'Polumjer kruga',
        'copy_elements' => 'Kopiraj elemente',
        'custom_icon'   => 'Proizvoljna ikona',
        'custom_shape'  => 'Proizvoljni oblik',
        'font_colour'   => 'Boja ikone',
        'group'         => 'Grupa markera',
        'is_draggable'  => 'Moguće povlačenje',
        'latitude'      => 'Geografska širina',
        'longitude'     => 'Geografska dužina',
        'opacity'       => 'Neprozirnost',
        'pin_size'      => 'Veličina markera',
        'polygon_style' => [
            'stroke'            => 'Boja poteza',
            'stroke-opacity'    => 'Neprozirnost poteza',
            'stroke-width'      => 'Širina poteza',
        ],
    ],
    'helpers'       => [
        'base'                      => 'Dodaj markere na kartu klikom na bilo koje mjesto.',
        'copy_elements'             => 'Kopiraj grupe, slojeve i markere.',
        'copy_elements_to_campaign' => 'Kopiraj grupe, slojeve i markere na kartama. Markeri povezane s entitetom pretvorit će se u standardne markere.',
        'custom_icon'               => 'Kopiraj HTML ikone iz :fontawesome ili :rpgawesome ili proizvoljne SVG ikone.',
        'custom_radius'             => 'Za samostalno definiranje veličine odaberi opciju proizvoljne veličine iz padajućeg izbornika.',
        'draggable'                 => 'Omogući za omogućavanje pomicanja markera u načinu istraživanja.',
        'label'                     => 'Oznaka se prikazuje kao blok teksta na karti. Sadržaj će biti ime markera imena entiteta.',
        'polygon'                   => [
            'edit'  => 'Kliknite na kartu da biste taj položaj dodali koordinatama poligona.',
            'new'   => 'Pomiči marker okolo po mapi kako bi se spremila pozicija na poligon.',
        ],
    ],
    'icons'         => [
        'custom'        => 'Proizvoljno',
        'entity'        => 'Entitet',
        'exclamation'   => 'Upozorenje',
        'marker'        => 'Marker',
        'question'      => 'Pitanje',
    ],
    'placeholders'  => [
        'custom_shape'  => '100,100 200,240 340,110',
        'name'          => 'Obavezno ako nije odabran nijedan entitet',
    ],
    'shapes'        => [
        '0' => 'Krug',
        '1' => 'Kvadrat',
        '2' => 'Trokut',
        '3' => 'Proizvoljno',
    ],
    'sizes'         => [
        '0' => 'Sićušno',
        '1' => 'Standardno',
        '2' => 'Maleno',
        '3' => 'Veliko',
        '4' => 'Golemo',
    ],
    'tabs'          => [
        'circle'    => 'Krug',
        'label'     => 'Natpis',
        'marker'    => 'Marker',
        'polygon'   => 'Poligon',
    ],
];
