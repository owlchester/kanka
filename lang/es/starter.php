<?php

return [
    'campaign'      => [
        'name'  => 'Mundo de :user',
    ],
    'character1'    => [
        'age'           => '[20s/30s/40s]',
        'background'    => [
            'cur'       => 'Actualmente [ocupación/rol]',
            'loc'       => 'Creció en [ciudad natal/región]',
            'seeking'   => 'Buscando [objetivo/motivación]',
            'title'     => 'Trasfondo',
        ],
        'description'   => [
            'intro'     => '[Una breve introducción a tu personaje: quién es, de dónde viene y qué quiere.]',
            'template'  => 'Este es un personaje de plantilla que puedes personalizar. Reemplaza los detalles de ejemplo a continuación con la información de tu propio personaje. Siempre puedes agregar más campos después.',
            'tip'       => 'Consejo: Comienza solo con un nombre y una descripción de una oración. Puedes ampliar los detalles conforme se desarrolla tu mundo.',
        ],
        'name'          => '[Nombre de tu personaje]',
        'personality'   => [
            'trait1'    => [
                'name'  => 'Rasgo 1',
                'value' => '[Valiente/Cauteloso/Ambicioso]',
            ],
            'trait2'    => [
                'name'  => 'Rasgo 2',
                'value' => '[Leal/Independiente/Astuto]',
            ],
            'trait3'    => [
                'name'  => 'Rasgo 3',
                'value' => '[Optimista/Cínico/Pragmático]',
            ],
        ],
        'physical'      => [
            'build'     => [
                'name'  => 'Complexión',
                'value' => '[Delgado/Promedio/Musculoso]',
            ],
            'features'  => [
                'name'  => 'Rasgos notables',
                'value' => '[Cicatrices, tatuajes, ropa distintiva]',
            ],
        ],
    ],
    'character2'    => [
        'description'   => [
            'first' => 'Un personaje secundario que ayuda o viaja con :mention. Personaliza estos detalles para que se adapten a tu historia.',
            'second'=> 'Consejo: Los personajes secundarios no necesitan tantos detalles como los protagonistas. Enfócate en lo que los hace útiles o interesantes para tu historia.',
        ],
        'name'          => '[Nombre del personaje aliado]',
        'relation'      => '[Amigo/Mentor/Rival]',
        'skills'        => [
            'first' => '[Habilidad 1: Combate/Magia/Sanación/Artesanía]',
            'second'=> '[Habilidad 2: Social/Conocimiento/Técnica]',
            'third' => '[Habilidad 3: Talento único o especialidad]',
            'title' => 'Habilidades y capacidades',
        ],
    ],
    'city'          => [
        'description'   => 'El corazón palpitante del reino, donde comerciantes, nobles y gente común se mezclan en bulliciosos mercados y grandes plazas. Los viejos muros de la ciudad aún se mantienen en pie, aunque la ciudad hace tiempo que creció más allá de ellos.',
        'districts'     => [
            'first' => 'Barrio noble: Casas señoriales y jardines',
            'fourth'=> 'Zona portuaria: Puerto fluvial, almacenes',
            'second'=> 'Distrito del mercado: Comercio, artesanía, tabernas',
            'third' => 'Ciudad vieja: Ciudad amurallada original',
            'title' => 'Distritos',
        ],
        'locations'     => [
            'first' => 'El Palacio Real (centro del Barrio Noble)',
            'second'=> 'El Gran Bazar (Distrito del mercado)',
            'third' => 'Posada La Espada Oxidada (punto de encuentro popular de aventureros)',
            'title' => 'Lugares notables',
        ],
        'name'          => '[Nombre de tu ciudad capital]',
        'type'          => 'Capital',
    ],
    'item1'         => [],
    'kingdom'       => [
        'description'   => 'Un reino próspero conocido por sus fértiles tierras de cultivo y bosques ancestrales. La familia real ha gobernado durante tres generaciones, manteniendo la paz mediante la diplomacia y el comercio.',
        'features'      => [
            'capital'   => [
                'name'  => 'Capital',
            ],
            'exp'       => [
                'name'  => 'Exportación principal',
                'value' => 'Grano, madera',
            ],
            'gov'       => [
                'name'  => 'Gobierno',
                'value' => 'Monarquía hereditaria',
            ],
            'pop'       => [
                'name'  => 'Población',
                'value' => '~50\'000',
            ],
            'title'     => 'Características notables',
        ],
        'name'          => '[Nombre de tu reino]',
        'recent'        => [
            'first' => 'Mayor actividad de bandidos en los caminos del este',
            'second'=> 'Cosecha fallida en las provincias del sur',
            'title' => 'Eventos recientes',
        ],
        'type'          => 'Reino',
    ],
    'kingdom1'      => [],
    'kingdom2'      => [],
    'name'          => ':name (ejemplo)',
    'note1'         => [],
];
