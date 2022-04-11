<?php

return [
    'age'               => [
        'description'   => 'Es pot vincular un personatge a un calendari de la campanya des de la pestanya de recordatoris del personatge. Des d\'allà, afegiu un nou recordatori i doneu-li el tipus Naixement o Mort per a calcular automàticament l\'edat del personatge. Si totes dues dates són presents, es mostraran les dues juntament amb l\'edat de defunció. Si només s\'ha indicat el naixement, es mostraran la data i l\'edat actual. Si només s\'ha indicat la mort, es mostraran la data i els anys des de la mort.',
        'title'         => 'Edat i mort dels personatges',
    ],
    'api-filters'       => [
        'description'   => 'Els següents filtres estan disponibles per a l\'endpoint :name de l\'API.',
        'title'         => 'Filtres de l\'API',
    ],
    'attributes'        => [
        'con'               => 'Con',
        'description'       => 'Es poden usar atributs per representar valors no textuals associats a una entitat. Es poden referenciar altres entitats als atributs mitjançant la sintaxi de mencions avançada :mention. També es poden referenciar altres atributs amb la sintaxi d\':attribute.',
        'level'             => 'Nivell',
        'link'              => 'Opcions d\'atributs',
        'math'              => 'També es poden fer servir algunes matemàtiques bàsiques. Per exemple, :example fa la multiplicació dels atributs :level i :amb d\'aquesta entitat. Per a arrodonir el resultat cap amunt o abaix, utilitzeu :floor o :ceil respectivament.',
        'name'              => 'Podeu referenciar el nom de l\'entitat amb :name. Si existeix un atribut amb aquest nom, s\'utilitzarà aquest enlloc de l\'entitat.',
        'pinned'            => 'Per a mostrar un atribut al menú sota la imatge de l\'entitat, fixeu-lo amb la icona de :icon.',
        'private'           => 'Els atributs privats amb la icona de :icon només són visibles per als administradors de la campanya.',
        'random'            => 'Es poden definir atributs aleatoris en crear o editar una plantilla d\'atributs. Aquests poden ser, per una banda, valors aleatoris entre dos nombres separats per :dash; o bé un valor aleatori entre una llista de valors separats per :comma. El valor de l\'atribut es determina quan la plantilla s\'aplica a una entitat, o quan l\'entitat es guardi.',
        'random_examples'   => 'Per exemple, si voleu un nombre entre 1 i 100, feu servir :number. Si voleu un valor d\'entre una llista d\'opcions, feu servir :list.',
        'title'             => 'Atributs',
    ],
    'dice'              => [
        'description'               => 'Per a fer tirades de daus genèriques, escriviu "d20", "4d4+4", "d%" per a percentual i "df" per a fudge.',
        'description_attributes'    => 'També es pot obtenir l\'atribut d\'un personatge utilitzant el codi {character.nomeni_atribut}. Per exemple: {character.nivell}d6+{character.sabiduria}.',
        'more'                      => 'Per a veure més opcions disponibles, busqueu a la pàgina web del plugin de daus.',
        'title'                     => 'Tirades de daus',
    ],
    'entity_templates'  => [
        'description'   => 'Es poden crear noves entitats a partir d\'una plantilla en comptes de començar des d\'un formulari en blanc. Per a definir una entitat com a plantilla base, aneu-hi i cliqueu al :link al botó d\'accions :action a la cantonada superior dreta. Des de la llista d\'entitats, podeu accedir a les plantilles disponibles al costat del botó de :new. Podeu tenir múltiples plantilles per cada tipus d\'entitat.',
        'link'          => 'Com definir plantilles d\'entitat',
        'remove'        => 'Per a retirar una plantilla d\'entitat, cliqueu l\'acció de :remove que substituïrà l\'acció de :link explicada anteriorment.',
        'title'         => 'Plantilles d\'entitat',
    ],
    'filters'           => [
        'clipboard'     => 'Si hi ha cap filtre, el botó de copiar s\'activa i permet copiar els filtres, per a utilitzar-los després als widgets del taulell o filtrar els enllaços de l\'accés directe.',
        'description'   => 'Es poden usar els filtres per a limitar la quantitat de resultats mostrats a les llistes. Es pot filtrar per més d\'un camp per a controlar detalladament què s\'exclou amb els filtres.',
        'empty'         => 'En escriure :tag a un camp, es buscaran totes les entitats on aquest camp estigui buit.',
        'ending_with'   => 'Posant una :tag al final del text, es busquen totes les altres entitats amb aquest text.',
        'multiple'      => 'Es poden combinar les opcions de cerca als camps de text escrivint :syntax. Per exemple, :example.',
        'session'       => 'Els filtres i l\'ordre de les columnes a la llista d\'entitats es guarden a la vostra sessió, així que mentre estigueu connectat no cal tornar-les a configurar a cada pàgina.',
        'starting_with' => 'Afegint :tag abans del text es busca qualsevol entitat que no contingui el text en aquest camp.',
        'title'         => 'Com fer servir els filtres',
    ],
    'link'              => [
        'auto_update'       => 'Els enllaços a altres entitats s\'actualitzaran automàticament quan es canviï el nom o la descripció d\'aquestes.',
        'description'       => 'És fàcil enllaçar altres entitats usant les següents dreceres.',
        'formatting'        => [
            'text'  => 'La llista d\'etiquetes i atributs HTML permesos es troba a nostre :github.',
            'title' => 'Format',
        ],
        'friendly_mentions' => 'Per a enllaçar altres entitats, escriviu :code i els primers caràcters d\'una entitat per a buscar-la. Això inserirà :example en l\'editor de text, i es mostrarà com un enllaç a l\'entitat en veure-la.',
        'mention_helpers'   => 'Si el nom de l\'entitat té un espai, escriviu :example en comptes de l\'espai. Si voleu buscar una entitat amb exactament el mateix nom, escriviu :exact.',
        'mentions'          => 'Per a enllaçar altres entitats, escriviu :code i els primers caràcters d\'una entitat per a buscar-la. Això introduirà :example en l\'editor de text. Per a personalitzar el nom a mostrar, escriviu :example_name. Per a indicar una subpàgina concreta de l\'entitat, useu :example_page. Per a indicar una pestanya concreta, useu :example_tab.',
        'mentions_field'    => 'També podeu mostrar un camp de l\'entitat enlloc del seu nom al link amb :code.',
        'months'            => 'Escriviu :code per a obtenir una llista amb els mesos dels calendaris de la campanya.',
        'options'           => 'Algunes opcions són :options.',
        'title'             => 'Enllaçar a altres entitats i dreceres',
    ],
    'map'               => [
        'description'   => 'En pujar un mapa a un indret, s\'habilitarà el menú de Mapa a la pàgina d\'aquest lloc amb un enllaç directe al mapa. Des de la vista de mapa, els usuaris que tenen permís per a editar l\'indret podran, al seu torn, editar el mapa i afegir-hi punts. Aquests poden enllaçar a una entitat existent o ser simples etiquetes, i poden tenir diverses formes i grandàries.',
        'private'       => 'Els administradors de la campanya poden fer que un mapa sigui privat. Això permet que els usuaris puguin veure un indret, però els administradors puguin mantenir el mapa en secret.',
        'title'         => 'Mapes dels indrets',
    ],
    'pins'              => [
        'description'   => 'Les entitats poden tenir relacions i atributs fixats a la dreta de la vista d\'història. Per a fixar un element, editeu-ne la relació o els atributs i fixeu-lo.',
        'title'         => 'Xinxetes',
    ],
    'public'            => 'Mireu el vídeo tutorial a Youtube sobre les campanyes públiques.',
    'title'             => 'Ajuda',
    'troubleshooting'   => [
        'errors'            => [
            'token_exists'  => 'Ja existeix un token per a la campanya :campaign.',
        ],
        'save_btn'          => 'Genera un token',
        'select_campaign'   => 'Seleccioneu una campanya',
        'subtitle'          => 'Ajuda, siusplau!',
        'success'           => 'Copieu el següent token i envieu-lo a algú de l\'equip de Kanka.',
        'title'             => 'Solucionar errors',
    ],
    'widget-filters'    => [
        'description'   => 'Podeu filtrar les entitats mostrades al widget de les recentment modificades mitjançant una llista dels camps de l\'entitat i els seus valors. Per exemple, podeu usar :example per a filtrar per personatges morts de tipus NPC.',
        'link'          => 'filtres dels widgets',
        'more'          => 'Podeu copiar els valors de l\'URL de la llista d\'entitats. Per exemple, al visualitzar els personatges de la campanya, filtreu pel tipus de personatges que voleu mostrar, i copieu els valors que apareixen rere la :question a la URL.',
        'title'         => 'Filtres als widgets del taulell',
    ],
];
