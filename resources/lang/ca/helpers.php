<?php

return [
    'age'           => [
        'description'   => 'Es pot vincular un personatge a un calendari de la campanya des de la pestanya de recordatoris del personatge. Des d\'allà, afegiu un nou recordatori i doneu-li el tipus Naixement o Mort per a calcular automàticament l\'edat del personatge. Si totes dues dates són presents, es mostraran les dues juntament amb l\'edat de defunció. Si només s\'ha indicat el naixement, es mostraran la data i l\'edat actual. Si només s\'ha indicat la mort, es mostraran la data i els anys des de la mort.',
        'title'         => 'Edat i mort dels personatges',
    ],
    'attributes'    => [
        'con'           => 'Con',
        'description'   => 'Es poden usar atributs per representar valors no textuals associats a una entitat. Es poden referenciar altres entitats als atributs mitjançant la sintaxi de mencions avançada :mention. També es poden referenciar altres atributs amb la sintaxi d\':attribute.',
        'level'         => 'Nivell',
        'link'          => 'Opcions d\'atributs',
        'math'          => 'També es poden fer servir algunes matemàtiques bàsiques. Per exemple, :example fa la multiplicació dels atributs :level i :amb d\'aquesta entitat. Per a arrodonir el resultat cap amunt o abaix, utilitzeu :floor o :ceil respectivament.',
        'title'         => 'Atributs',
    ],
    'dice'          => [
        'description'               => 'Per a fer tirades de daus genèriques, escriviu "d20", "4d4+4", "d%" per a percentual i "df" per a fudge.',
        'description_attributes'    => 'També es pot obtenir l\'atribut d\'un personatge utilitzant el codi {character.nomeni_atribut}. Per exemple: {character.nivell}d6+{character.sabiduria}.',
        'more'                      => 'Per a veure més opcions disponibles, busqueu a la pàgina web del plugin de daus.',
        'title'                     => 'Tirades de daus',
    ],
    'filters'       => [
        'description'   => 'Es poden usar els filtres per a limitar la quantitat de resultats mostrats a les llistes. Es pot filtrar per més d\'un camp per a controlar detalladament què s\'exclou amb els filtres.',
        'empty'         => 'En escriure :tag a un camp, es buscaran totes les entitats on aquest camp estigui buit.',
        'ending_with'   => 'Posant una :tag al final del text, es busquen totes les altres entitats amb aquest text.',
        'session'       => 'Els filtres i l\'ordre de les columnes a la llista d\'entitats es guarden a la vostra sessió, així que mentre estigueu connectat no cal tornar-les a configurar a cada pàgina.',
        'starting_with' => 'Afegint :tag abans del text es busca qualsevol entitat que no contingui el text en aquest camp.',
        'title'         => 'Com fer servir els filtres',
    ],
    'link'          => [
        'attributes'        => 'Per a referenciar atributs de l\'entitat, escriviu :code. Això només funciona amb atributs ja existents a l\'entitat.',
        'auto_update'       => 'Els enllaços a altres entitats s\'actualitzaran automàticament quan es canviï el nom o la descripció d\'aquestes.',
        'description'       => 'És fàcil enllaçar altres entitats usant les següents dreceres.',
        'formatting'        => [
            'text'  => 'La llista d\'etiquetes i atributs HTML permesos es troba a nostre :github.',
            'title' => 'Format',
        ],
        'friendly_mentions' => 'Per a enllaçar altres entitats, escriviu :code i els primers caràcters d\'una entitat per a buscar-la. Això inserirà :example en l\'editor de text, i es mostrarà com un enllaç a l\'entitat en veure-la.',
        'limitations'       => 'Tingueu en compte que a causa de limitacions tècniques aquestes dreceres no funcionen en dispositius mòbils android, excepte al nou editor de text Summernote. Podeu canviar l\'editor a les preferències de disseny de la configuració.',
        'mentions'          => 'Per a enllaçar altres entitats, escriviu :code i els primers caràcters d\'una entitat per a buscar-la. Això introduirà :example en l\'editor de text. Per a personalitzar el nom a mostrar, escriviu :example_name. Per a indicar una subpàgina concreta de l\'entitat, useu :example_page. Per a indicar una pestanya concreta, useu :example_tab.',
        'months'            => 'Escriviu :code per a obtenir una llista amb els mesos dels calendaris de la campanya.',
        'title'             => 'Enllaçar a altres entitats i dreceres',
    ],
    'map'           => [
        'description'   => 'En pujar un mapa a un indret, s\'habilitarà el menú de Mapa a la pàgina d\'aquest lloc amb un enllaç directe al mapa. Des de la vista de mapa, els usuaris que tenen permís per a editar l\'indret podran, al seu torn, editar el mapa i afegir-hi punts. Aquests poden enllaçar a una entitat existent o ser simples etiquetes, i poden tenir diverses formes i grandàries.',
        'private'       => 'Els administradors de la campanya poden fer que un mapa sigui privat. Això permet que els usuaris puguin veure un indret, però els administradors puguin mantenir el mapa en secret.',
        'title'         => 'Mapes dels indrets',
    ],
    'public'        => 'Mireu el vídeo tutorial a Youtube sobre les campanyes públiques.',
    'title'         => 'Ajuda',
];
