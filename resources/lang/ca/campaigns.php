<?php

return [
    'create'                            => [
        'description'           => 'Crea una nova campanya',
        'helper'                => [
            'title'     => 'Us donem la benvinguda a :name!',
            'welcome'   => <<<'TEXT'
Abans de continuar, cal un nom per a la campanya, pel món. Si no teniu un bon nom encara, no passa res, podreu canviar-lo més endavant o crear noves campanyes.

Gràcies per unir-vos a Kanka, i sigueu benvingut a la nostra comunitat!
TEXT
,
        ],
        'success'               => 'S\'ha creat la campanya.',
        'success_first_time'    => 'S\'ha creat la campanya! Com que és la vostra primera campanya, hem omplert algunes coses per a que us hi familiaritzeu i, amb sort, inspirar-vos perquè veieu tot el que es pot aconseguir.',
        'title'                 => 'Nova campanya',
    ],
    'destroy'                           => [
        'success'   => 'S\'ha eliminat la campanya.',
    ],
    'edit'                              => [
        'description'   => 'Edita la campanya',
        'success'       => 'S\'ha actualitzat la campanya.',
        'title'         => 'Edició de la campanya :campaign',
    ],
    'entity_personality_visibilities'   => [
        'private'   => 'La personalitat dels personatges nous és privada per defecte.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Noves entitats privades per defecte',
    ],
    'errors'                            => [
        'access'        => 'No teniu accés a aquesta campanya.',
        'unknown_id'    => 'Campanya desconeguda.',
    ],
    'export'                            => [
        'description'   => 'Exporta la campanya',
        'errors'        => [
            'limit' => 'Heu arribat al màxim d\'una exportació al dia. Torneu a intentar-ho demà.',
        ],
        'helper'        => 'Exporta la campanya. Rebreu una notificació amb l\'enllaç de descàrrega.',
        'success'       => 'S\'està preparant la campanya per l\'exportació. Rebreu una notificació a Kanka amb un zip descarregable en quant estigui llesta.',
        'title'         => 'Exporta la campanya :name',
    ],
    'fields'                            => [
        'boosted'                       => 'Millorada per',
        'css'                           => 'CSS',
        'description'                   => 'Descripció',
        'entity_count'                  => 'Nombre d\'entitats',
        'entity_personality_visibility' => 'Visibilitat de la personalitat',
        'entity_visibility'             => 'Visibilitat de l\'entitat',
        'excerpt'                       => 'Extracte',
        'followers'                     => 'Seguidors',
        'header_image'                  => 'Imatge de capçalera',
        'hide_history'                  => 'Amaga l\'historial d\'entitats',
        'hide_members'                  => 'Amaga els membres de la campanya',
        'image'                         => 'Imatge',
        'locale'                        => 'Idioma',
        'name'                          => 'Nom',
        'public_campaign_filters'       => 'Filtres de les campanyes públiques',
        'rpg_system'                    => 'Sistemes RPG',
        'system'                        => 'Sistema',
        'theme'                         => 'Tema',
        'tooltip_family'                => 'Deshabilita els noms familiars a la previsualització emergent',
        'tooltip_image'                 => 'Mostra la imatge de l\'entitat a la previsualització emergent',
        'visibility'                    => 'Visibilitat',
    ],
    'following'                         => 'Seguint',
    'helpers'                           => [
        'boost_required'                => 'Aquesta funcionalitat requereix millorar la campanya. Per a més informació, aneu a la pàgina de :settings.',
        'boosted'                       => 'Algunes característiques estan desbloquejades perquè aquesta campanya està millorada. Per a saber-ne més, feu una ullada a la pàgina de :settings.',
        'css'                           => 'Escriviu CSS propi per a les pàgines de la campanya. Tingueu en compte que abusar d\'aquesta eina pot comportar l\'eliminació del CSS personalitzat. Els incompliments repetits o greus poden comportar l\'eliminació de la campanya.',
        'entity_personality_visibility' => 'En crear un nou personatge, l\'opció de «Personalitat visible» estarà deseleccionada automàticament.',
        'entity_visibility'             => 'En crear una nova entitat, se seleccionarà automàticament l\'opció de «Privada».',
        'excerpt'                       => 'L\'extracte de la campanya es mostrarà al taulell principal. Escriviu unes línies per introduïr el món.',
        'hide_history'                  => 'Habiliteu aquesta opció per a amagar l\'historial d\'entitats als membres no administradors.',
        'hide_members'                  => 'Habiliteu aquesta opció per a amagar la llista de membres de la campanya als no administradors.',
        'locale'                        => 'L\'idioma en què està escrita la campanya. Això serveix per a agrupar les campanyes públiques.',
        'name'                          => 'La campanya/món pot tenir qualsevol nom, sempre i quan contingui al menys 4 lletres o números.',
        'public_campaign_filters'       => 'Per facilitar que altres trobin aquesta campanya entre la resta, proporcioneu la informació següent.',
        'system'                        => 'Si la campanya és visible públicament, el sistema es mostrarà a la pàgina de :link.',
        'systems'                       => 'Per a evitar desordres, alguns elements de Kanka només estan disponibles amb sistemes de rol específics (per exemple, el bloc d\'stats de monstre de D&D 5e). Si trieu un sistema acceptat, s\'activaran aquests elements.',
        'theme'                         => 'Estableix un tema únic per a la campanya, tot anul·lant les preferències dels usuaris.',
        'view_public'                   => 'Per veure la campanya com ho faria un visitant públic, obriu un :link a una finestra d\'incògnit.',
        'visibility'                    => 'Fer pública una campanya implica que tots els qui tinguin l\'enllaç la podran veure.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Nova campanya',
            ],
        ],
        'title'     => 'Campanyes',
    ],
    'invites'                           => [
        'actions'               => [
            'add'   => 'Convida',
            'copy'  => 'Copia l\'enllaç al porta-retalls',
            'link'  => 'Nou enllaç',
        ],
        'create'                => [
            'button'        => 'Convida',
            'description'   => 'Convideu amics a la campanya',
            'link'          => 'S\'ha creat l\'enllaç: <a href=":url" target="_blank">:url</a>',
            'success'       => 'S\'ha enviat la invitació.',
            'title'         => 'Invitacions a la campanya',
        ],
        'destroy'               => [
            'success'   => 'S\'ha eliminat la invitació.',
        ],
        'email'                 => [
            'link'      => '<a href=":link">Uniu-vos a la campanya de :name </a>',
            'subject'   => ':name us ha convidat a unir-vos a la seva campanya «:campaign» a kanka.io! Cliqueu el següent enllaç per acceptar la seva invitació.',
            'title'     => 'Invitació de :name',
        ],
        'error'                 => [
            'already_member'    => 'Ja sou membre d\'aquesta campanya.',
            'inactive_token'    => 'Aquest identificador ja s\'ha utilitzat o la campanya ja no existeix.',
            'invalid_token'     => 'L\'identificador ja no és vàlid.',
            'login'             => 'Inicieu sessió o registreu-vos per a unir-vos a la campanya.',
        ],
        'fields'                => [
            'created'   => 'Enviat',
            'email'     => 'Correu electrònic',
            'role'      => 'Rol',
            'type'      => 'Tipus',
            'validity'  => 'Validesa',
        ],
        'helpers'               => [
            'email'     => 'Pot ser que els nostres correus es marquin com a spam i poden trigar unes hores fins aparèixer a la safata d\'entrada.',
            'validity'  => 'Quants usuaris poden utilitzar aquest enllaç abans que es desactivi. Deixeu-ho en blanc perquè sigui il·limitat.',
        ],
        'placeholders'          => [
            'email' => 'Adreça electrònica de la persona a qui voleu convidar',
        ],
        'types'                 => [
            'email' => 'Correu electrònic',
            'link'  => 'Enllaç',
        ],
        'unlimited_validity'    => 'Il·limitat',
    ],
    'leave'                             => [
        'confirm'   => 'Segur que voleu abandonar la campanya :name? No hi tindreu accés a no ser que un administrador torni a convidar-vos-hi.',
        'error'     => 'No podeu abandonar la campanya.',
        'success'   => 'Heu abandonat la campanya.',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'Veu com',
            'switch-back'   => 'Torna al meu usuari',
        ],
        'create'                => [
            'title' => 'Afegeix un membre a la campanya',
        ],
        'description'           => 'Gestiona els membres de la campanya',
        'edit'                  => [
            'description'   => 'Edita un membre de la campanya',
            'title'         => 'Edició del membre :name',
        ],
        'fields'                => [
            'joined'        => 'Inscrit',
            'last_login'    => 'Última connexió',
            'name'          => 'Usuari',
            'role'          => 'Rol',
            'roles'         => 'Rols',
        ],
        'help'                  => 'No hi ha cap límit al nombre de membres que pot tenir una campanya.',
        'helpers'               => [
            'admin' => 'Com a administrador de la campanya, podeu convidar nous usuaris, eliminar-ne els inactius i cambiar els seus permisos. Per comprovar els permisos d\'un membre, cliqueu a «Veu com». Per saber més sobre aquesta eina, aneu a :link.',
            'switch'=> 'Veu com aquest usuari',
        ],
        'impersonating'         => [
            'message'   => 'Esteu veient la campanya com a un altre usuari. Algunes funcionalitats estan deshabilitades, però majorment veieu exactament allò que l\'usuari veuria. Per tornar al vostre usuari, cliqueu a «Torna al meu usuari», prop del botó de sortida.',
            'title'     => 'Esteu veient com a :name',
        ],
        'invite'                => [
            'description'   => 'Podeu convidar amics a la campanya si mitjançant un enllaç d\'invitació. Un cop acceptin la invitació, seran afegits amb el rol indicat. També podeu enviar-los la invitació per correu electrònic, sempre que no sigui una adreça de Hotmail, ja que sempre rebutgen els mails de Kanka.',
            'more'          => 'Es poden afegir més rols des de la :link.',
            'roles_page'    => 'Pàgina de rols',
            'title'         => 'Invitacions',
        ],
        'roles'                 => [
            'member'    => 'Membre',
            'owner'     => 'Administrador',
            'player'    => 'Jugador',
            'public'    => 'Públic',
            'viewer'    => 'Convidat',
        ],
        'switch_back_success'   => 'Heu tornat al vostre usuari.',
        'title'                 => 'Membres de la campanya :name',
        'your_role'             => 'El vostre rol: <i>:role</i>',
    ],
    'panels'                            => [
        'boosted'   => 'Millores',
        'dashboard' => 'Taulell',
        'permission'=> 'Permisos',
        'sharing'   => 'Compartir',
        'systems'   => 'Sistemes',
        'ui'        => 'Interfície',
    ],
    'placeholders'                      => [
        'description'   => 'Breu resume de la campanya',
        'locale'        => 'Codi d\'idioma',
        'name'          => 'Nom de la campanya',
        'system'        => 'D&D 5e, Pathfinder, GURPS, Fate...',
    ],
    'roles'                             => [
        'actions'       => [
            'add'   => 'Afegeix un rol',
        ],
        'create'        => [
            'success'   => 'S\'ha creat el rol.',
            'title'     => 'Crea un rol nou a :name',
        ],
        'description'   => 'Gestiona els rols de la campanya',
        'destroy'       => [
            'success'   => 'S\'ha eliminat el rol.',
        ],
        'edit'          => [
            'success'   => 'S\'ha actualitzat el rol.',
            'title'     => 'Edita el rol :name',
        ],
        'fields'        => [
            'name'          => 'Nom',
            'permissions'   => 'Permisos',
            'type'          => 'Tipus',
            'users'         => 'Usuaris',
        ],
        'helper'        => [
            '1' => 'Una campanya pot tenir rols il·limitats. Els administradors tenen accés automàticament a tot dins d\'una campanya, però cadascun dels altres rols pot tenir permisos específics a diferents tipus d\'entitats (personatges, indrets, etc).',
            '2' => 'Es poden afinar més els permisos de les entitats des de la pestanya de permisos de l\'entitat. Aquesta pestanya apareix quan la campanya té diversos rols o membres.',
            '3' => 'Es pot emprar un sistema d\'exclusió, on els rols tinguin accés a totes les entitats, i marcar la casella de «Privada» a les entitats que es vulguin ocultar. Per altra banda, també es poden donar pocs permisos als rols, i configurar cada entitat per a que sigui visible individualment.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'El rol públic té permisos, però la campanya és privada. Això pot ajustar-se a la pestanya de compartir en editar la campanya.',
            'public'                => 'El rol «Públic» és pels visitants de les campanyes públiques.',
            'role_permissions'      => 'Habilita el rol «:name» per a que pugui fer les accions següents a totes les entitats.',
        ],
        'members'       => 'Membres',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Crear',
                'delete'        => 'Eliminar',
                'edit'          => 'Editar',
                'entity-note'   => 'Anotacions',
                'permission'    => 'Administrar els permisos',
                'read'          => 'Veure',
                'toggle'        => 'Canvia-ho per a tots',
            ],
            'helpers'   => [
                'entity_note'   => 'Això permet que els usuaris que no tinguin permisos per a editar una entitat puguin afegir-hi anotacions.',
            ],
            'hint'      => 'Aquest rol té accés automàtic a tot.',
        ],
        'placeholders'  => [
            'name'  => 'Nom del rol',
        ],
        'show'          => [
            'description'   => 'Membres i permisos d\'un rol de la campanya',
            'title'         => 'Rol «:role»',
        ],
        'title'         => 'Rols de la campanya :name',
        'types'         => [
            'owner'     => 'Administrador',
            'public'    => 'Públic',
            'standard'  => 'Estàndard',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Afegeix',
            ],
            'create'    => [
                'success'   => 'S\'ha afegit el rol a l\'usuari.',
                'title'     => 'Afegeix el rol :name a un usuari',
            ],
            'destroy'   => [
                'success'   => 'S\'ha tret el rol a l\'usuari.',
            ],
            'fields'    => [
                'name'  => 'Nom',
            ],
        ],
    ],
    'settings'                          => [
        'actions'       => [
            'enable'    => 'Habilita',
        ],
        'boosted'       => 'Aquesta funció encara és en beta i només està disponible per a les :boosted.',
        'description'   => 'Habilita o deshabilita mòduls de la campanya.',
        'edit'          => [
            'success'   => 'S\'ha actualitzat la configuració de la campanya.',
        ],
        'helper'        => 'Es poden activar o desactivar fàcilment tots els mòduls d\'una campanya. Desactivar un mòdulo només n\'amaga els elements relacionats, no els elimina pas. Aquest canvi afecta a tots els usuaris d\'una campanya, inclosos els administradors.',
        'helpers'       => [
            'abilities'     => 'Crea habilitats, proeses, encanteris o poders i els assigna a entitats.',
            'calendars'     => 'El lloc per a definir els calendaris del món.',
            'characters'    => 'Les persones que viuen al món.',
            'conversations' => 'Converses fictícies entre personatges o entre usuaris de la campanya.',
            'dice_rolls'    => 'Una manera de gestionar les tirades de daus per a aquells que utilitzen Kanka per a campanyes de rol.',
            'events'        => 'Celebracions, festivaes, desastres, aniversaris, guerres...',
            'families'      => 'Clans o famílies, les seves relacions i membres.',
            'items'         => 'Armes, vehicles, relíquies, pocions...',
            'journals'      => 'Observacions escrites pels personatges, o la preparació de la sessió del màster.',
            'locations'     => 'Planetes, continents, rius, estats, assentaments, temples, tavernes...',
            'maps'          => 'Pugeu mapes amb diferents capes i marcadors que hi indiquen altres entitats de la campanya.',
            'menu_links'    => 'Enllaços directes personalitzats a la barra lateral.',
            'notes'         => 'Tradicions, religions, història, màgia, mecàniques...',
            'organisations' => 'Sectes, unitats militars, faccions, gremis...',
            'quests'        => 'Per a dur un seguiment de les missions amb personatges i localitzacions.',
            'races'         => 'Totes les races de la campanya d\'un cop d\'ull.',
            'tags'          => 'Cada entitat pot tenir diverses etiquetes que, al seu torn, també poden pertànyer a altres etiquetes. A més, les entitats poden filtrar-se per etiqueta.',
            'timelines'     => 'Per a representar la història del món amb eixos cronològics.',
        ],
        'title'         => 'Mòduls de la campanya :name',
    ],
    'show'                              => [
        'actions'       => [
            'boost' => 'Millora la campanya',
            'edit'  => 'Edita la campanya',
            'leave' => 'Abandona la campanya',
        ],
        'description'   => 'Vista detallada de la campanya',
        'tabs'          => [
            'default-images'    => 'Imatges per defecte',
            'export'            => 'Exportació',
            'information'       => 'Informació',
            'members'           => 'Membres',
            'menu'              => 'Menú',
            'plugins'           => 'Connectors',
            'recovery'          => 'Recuperació',
            'roles'             => 'Rols',
            'settings'          => 'Mòduls',
        ],
        'title'         => 'Campanya :name',
    ],
    'ui'                                => [
        'helper'    => 'Aquestes opcions canvien la forma en què es mostren alguns elements a la campanya.',
    ],
    'visibilities'                      => [
        'private'   => 'Privada',
        'public'    => 'Pública',
        'review'    => 'Esperant revisió',
    ],
];
