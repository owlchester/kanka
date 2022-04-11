<?php

return [
    'account-deletion'      => [
        'account_settings'  => 'Configuració del compte',
        'answer'            => 'Per a eliminar el compte, aneu a la pàgina del :account i baixeu fins la secció d\'eliminar el compte. Aquesta acció eliminarà el compte i totes les campanyes on en sigueu l\'únic membre.',
        'question'          => 'Com puc eliminar el meu compte?',
    ],
    'app_backup'            => [
        'answer'    => 'Fem dues còpies de seguretat al dia per a evitar cualsevol pèrdua de dades. Les nostres pròpies campanyes són al servidor, així que no volem córrer cap risc!',
        'question'  => 'Cada quant temps es fa una còpia de seguretat de les dades de Kanka?',
    ],
    'attribute-templates'   => [
        'answer'    => <<<'TEXT'
La millor manera d'explicar-ho és amb un exemple. Imagineu que el teu món té un munt d'indrets, i a moltes d'elles voleu recordar-vos de crear un atribut personalitzat de “Població”, “Clima”, “Nivell de criminalitat”...

Es podrien incloure manualment a cada indret, però pot ser un procés tediós i a vegades se us pot oblidar el “Nivell de criminalitat”. Aquí és on les plantilles d'atributs resulten útils.

Es pot crear una plantilla d'atributs amb aquells atributs (població, clima, nivell de criminalitat, etc.) i aplicar després aquesta plantilla als indrets. D'aquesta manera, s'aplicaran els atributs de la plantilla als indrets, i tot el que haureu de fer és canviar els valors sense haver de recordar-vos dels atributs!
TEXT
,
        'question'  => 'Què són les plantilles d\'atributs?',
    ],
    'backup'                => [
        'answer'    => 'Un cop al dia, es poden exportar totes les dades de la campanya en un arxiu ZIP. A l\'app, cliqueu a Campanya, al menú de l\'esquerra, i allà a exportar. No podreu pujar aquest arxiu a Kanka, sinó que està pensat perquè estigueu tranquil si no usareu més l\'app.',
        'question'  => 'Com es pot fer una còpia de seguretat o exportar la campanya?',
    ],
    'bugs'                  => [
        'answer'    => 'Uneiu-vos al nostre :discord i informeu de l\'error al canal #errors-and-bugs.',
        'question'  => 'Com es pot informar d\'un error?',
    ],
    'campaign-sync'         => [
        'answer'    => 'Kanka no té aquesta funcionalitat. No obstant això, si per tenir diversos grups al mateix món, podeu utilitzar la mateixa campanya i separar els grups mitjançant etiquetes, missions i permisos.',
        'question'  => 'Es poden sincronitzar entitats entre diverses campanyes?',
    ],
    'conversations'         => [],
    'custom'                => [
        'answer'    => 'Kanka ve amb un conjunt d\'entitats predefinides que interactuen entre elles. Permetre tipus d\'entitat personalitzats requeriria tornar a reconstruir l\'app des de zero i li llevaria el seu propòsit com a eina de creació. A més, la flexibilitat de Kanka permet que es pugui representar qualsevol tipus d\'entitat amb les etiquetes.',
        'question'  => 'Es poden crear tipus d\'entitat personalitzats?',
    ],
    'delete-campaign'       => [
        'answer'    => 'Al tauler de campanya, cliqueu a "Campanya" des del menú de l\'esquerra. Si sou l\'administrador de la campanya, apareixerà el botó d\'eliminar. Tingueu en compte que eliminar una campanya és una acció permanent que eliminarà totes les dades emmagatzemades als nostres servidors, incloent les imatges.',
        'question'  => 'Com s\'elimina una campanya?',
    ],
    'discord'               => [
        'answer'    => 'Per a vincular el compte de Kanka amb :discord, primer heu de clicar l\'avatar a la cantonada superior dreta de l\'aplicació i dirigir-vos al Perfil. Des d\'allà, navegueu a la subpàgina de :apps i cliqueu l\'opció de connectar.',
        'question'  => 'Com es vincula el compte de Kanka amb Discord?',
    ],
    'early-access'          => [
        'answer'    => 'L\'accés anticipat és la nostra manera de recompensar els nostres increïbles subscriptors, donant-los un període exclusiu de 30 dies en què poden provar les últimes novetats abans que la resta.',
        'question'  => 'Què és l\'accés anticipat?',
    ],
    'entity-notes'          => [
        'answer'    => 'Totes les entitats tenen una pestanya d\'anotacions, petits fragments de text que es poden configurar perquè només siguin visibles per al creador (genial per als co-màsters), només per a administradors o per a tots. També es pot donar permís als jugadors per a crear i editar aquestes anotacions sense donar-los accés també a editar l\'entitat completa.',
        'question'  => 'Com gestiona Kanka la informació oculta?',
    ],
    'fields'                => [
        'answer'    => 'Resposta',
        'category'  => 'Categoria',
        'locale'    => 'Locale',
        'order'     => 'Order',
        'question'  => 'Pregunta',
    ],
    'free'                  => [
        'answer'    => <<<'TEXT'

A més d'inlfuir sobre la direcció que prendrà Kanka, en donar-nos suport obtindreu un augment a la grandària dels arxius que podeu pujar, afegirem el vostre nom al mur de la fama, rebreu icones predefinides que fan goig, podreu votar quines funcions es prioritzen i molt més!
TEXT
,
        'question'  => 'L\'app continuarà sent gratis?',
    ],
    'gods-and-religions'    => [
        'answer'    => 'Recomanem crear els déus com a personatges i les religions com a organitzacions. Per a trobar a les deïtats ràpidament, podeu assenyalar-les amb l\'etiqueta o el tipus apropiats.',
        'question'  => 'On es poden crear déus i religions?',
    ],
    'help'                  => [
        'answer'    => 'Abans de res, gràcies per oferir-vos! Sempre estem interessats a acceptar ajuda amb les traduccions, provar noves funcions o ajudar els nous usuaris. També ens encanta quan la gent promociona Kanka perquè arribi a nous usuaris a llocs que mai havíem pensat. El millor curs d\'acció és unir-vos a nosaltres al :discord, on hi ha un canal dedicat a oferir ajuda. També estimem els nostres patrons en :patreon, si voleu donar-nos suport i accedir a alguns beneficis!',
        'question'  => 'Vull ajudar! Què puc fer?',
    ],
    'map'                   => [
        'answer'    => 'Cada localització pot contenir un mapa (PNG, JPG o SVG) al qual es poden afegir punts, personalitzant la seva grandària, forma, icona i color; i que enllacin a altres entitats o que simplement siguin etiquetes.',
        'question'  => 'Es poden pujar mapes a Kanka?',
    ],
    'mobile'                => [
        'answer'    => 'Actualment no hi ha cap app mòbil per a Kanka, però la web funciona perfectament en un dispositiu mòbil. L\'única limitació és que l\'eina d\'esments no funciona a l\'editor de textos. Si el suport de Patreon ho permet, espero poder pagar a algú perquè faci una app mòbil algun dia, però no ocorrerà en un futur pròxim.',
        'question'  => 'Hi ha una app mòbil? Hi ha alguna planejada?',
    ],
    'monsters'              => [
        'answer'    => 'Recomanem usar el mòdul de Races per a ètnies, espècies, monstres i qualsevol ser vivent que no sigui un personatge.',
        'question'  => 'On es poden crear monstres?',
    ],
    'multiworld'            => [
        'answer'    => 'No cal! Es poden crear tantes campanyes com es vulgui a l\'aplicació, i fer que cadascuna representi móns, escenaris o el que sigui. Una vegada es tinguin diverses campanyes, és molt fàcil canviar entre elles.',
        'question'  => 'Estic construint diversos móns en escenaris diferents. Necessito un compte diferent per a cada món?',
    ],
    'nested'                => [
        'answer'    => 'Si prefereiu veure les entitats en vista niada per defecte, podeu fer-ho des de les opcions de disseny, dins del perfil. Allà es pot seleccionar l\'opció "Vista niada per defecte". Això només afectarà el vostre compte.',
        'question'  => 'Es poden configurar les llistes perquè apareguin niades per defecte?',
    ],
    'permissions'           => [
        'answer'    => 'Per descomptat, per a això hem creat Kanka! Podeu convidar tots els vostres jugadors a les teves campanyes, i donar-los rols i permisos. Hem construït el sistema perquè sigui extremadament flexible (amb opció d\'incloure o d\'excloure) per a cobrir les màximes necessitats i situacions possibles.',
        'question'  => 'Vull utilitzar Kanka per a construir el meu món de rol, però vull que els meus jugadors tinguin accés a algunes de les entitats i editar els seus personatges. És possible?',
    ],
    'plans'                 => [
        'answer'    => <<<'TEXT'
Els plans a llarg termini per a Kanka inclouen construir del tot aquesta eina versàtil de creació de móns i gestió de campanyes de rol, mantenint-nos agnòstics (sense un sistema concret de RPG). La comunitat pot afegir contingut específic mitjançant les plantilles comunitàries. Un objectiu més ambiciós és arribar a integrar Kanka amb altres plataformes, com les de rol virtual.

Nosaltres mateixos utilitzem Kanka, així que no pensem deixar de desenvolupar-la i millorar-la. Malgrat això, per si de cas, el projecte és de codi obert i la comunitat podrà seguir treballant-hi si ens succeís algun imprevist.
TEXT
,
        'question'  => 'Quins són els plans a llarg termini?',
    ],
    'public-campaigns'      => [
        'answer'    => 'Podeu fer un cop d\'ull a les :public-campaigns per a veure com els altres fan servir Kanka a les seves campanyes.',
        'question'  => 'Com utilitzen Kanka altres persones?',
    ],
    'renaming-modules'      => [
        'answer'    => 'Encara que això seria fàcil de fer en anglès i altres llengues que no empren gèneres, canviar el nom dels mòduls trencaria la correcció gramatical i l\'experiència d\'usuari per una majoria d\'usuaris que utilitzen Kanka en altres idiomes.',
        'question'  => 'Puc reanomenar els mòduls? Per exemple, Clans en comptes de Famílies, o Faccions en comptes d\'Organitzacions?',
    ],
    'sections'              => [
        'community'     => 'Comunitat',
        'general'       => 'General',
        'other'         => 'Altres',
        'permissions'   => 'Permisos',
        'pricing'       => 'Tarifes',
        'worldbuilding' => 'Creació de móns',
    ],
    'show'                  => [
        'return'    => 'Torna a les FAQ',
        'timestamp' => 'Última actualizació el :date',
        'title'     => 'FAQ :name',
    ],
    'unboost'               => [
        'answer'    => 'En deixar de millorar una campanya, no s\'elimina cap dada, sinó que s\'amaga. Si tornes a millorar la campanya, tota la informació i funcionalitats tornaran a estar disponibles amb la mateixa configuració d\'abans.',
        'question'  => 'Què passa si una campanya deixa de millorar-se?',
    ],
    'user-switch'           => [
        'answer'    => 'Configurar els permisos pot ser complicat, sobretot a campanyes grans. L\'administrador de la campanya pot navegar per la pàgina de membres i clicar el botó de "Veure com" al costat de cada membre. D\'aquesta manera pot navegar per la campanya i veure-la com ells ho farien. Aquesta és la manera més fàcil de comprovar els permisos de la campanya.',
        'question'  => 'Els permisos de la campanya ja estan configurats, com puc comprovar-los?',
    ],
    'visibility'            => [
        'answer'    => 'Només les persones que convideu a la campanya poden veure-la i interactuar amb ella. Les vostres dades són privades i sempre estan sota control. D\'altra banda, podeu configurar la campanya com a pública perquè la vegin els usuaris no registrats.',
        'question'  => 'Qui pot veure el meu món?',
    ],
];
