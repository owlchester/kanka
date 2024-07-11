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
        'action'    => 'Elimina la campanya',
        'success'   => 'S\'ha eliminat la campanya.',
    ],
    'edit'                              => [
        'success'   => 'S\'ha actualitzat la campanya.',
        'title'     => 'Edició de la campanya :campaign',
    ],
    'entity_note_visibility'            => [],
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
    'export'                            => [],
    'fields'                            => [
        'boosted'                           => 'Millorada per',
        'character_personality_visibility'  => 'Visibilitat per defecte de la personalitat',
        'connections'                       => 'Mostra la taula de connexions d\'una entitat per defecte (en comptes de l\'explorador de relacions de les campanyes millorades)',
        'css'                               => 'CSS',
        'description'                       => 'Descripció',
        'entity_count'                      => 'Nombre d\'entitats',
        'entity_privacy'                    => 'Privacitat per defecte de noves entitats',
        'entry'                             => 'Descripció de la campanya',
        'excerpt'                           => 'Extracte',
        'followers'                         => 'Seguidors',
        'header_image'                      => 'Imatge de capçalera',
        'image'                             => 'Imatge',
        'locale'                            => 'Idioma',
        'name'                              => 'Nom',
        'open'                              => 'Oberta a sol·licituds',
        'post_collapsed'                    => 'Col·lapsa per defecte les anotacions noves de les entitats.',
        'public'                            => 'Visibilitat de la campanya',
        'public_campaign_filters'           => 'Filtres de les campanyes públiques',
        'related_visibility'                => 'Visibilitat dels elements relacionats',
        'superboosted'                      => 'Supermillorada per',
        'system'                            => 'Sistema',
        'theme'                             => 'Tema',
        'visibility'                        => 'Visibilitat',
    ],
    'following'                         => 'Seguint',
    'helpers'                           => [
        'boosted'                           => 'Algunes característiques estan desbloquejades perquè aquesta campanya està millorada. Per a saber-ne més, feu una ullada a la pàgina de :settings.',
        'character_personality_visibility'  => 'Fes que la personalitat dels nous personatges sigui privada per defecte per als administradors.',
        'css'                               => 'Escriviu CSS propi per a les pàgines de la campanya. Tingueu en compte que abusar d\'aquesta eina pot comportar l\'eliminació del CSS personalitzat. Els incompliments repetits o greus poden comportar l\'eliminació de la campanya.',
        'dashboard'                         => 'Personalitzeu la forma en què es mostra el widget al taulell mitjançant els següents camps.',
        'entity_privacy'                    => 'Fes que les entitats noves siguin privades per defecte per als administradors.',
        'excerpt'                           => 'L\'extracte de la campanya es mostrarà al taulell principal. Escriviu unes línies per introduïr el món.',
        'header_image'                      => 'Imatge mostrada com a fons a la capçalera de la campanya.',
        'hide_history'                      => 'Habiliteu aquesta opció per a amagar l\'historial d\'entitats als membres no administradors.',
        'hide_members'                      => 'Habiliteu aquesta opció per a amagar la llista de membres de la campanya als no administradors.',
        'locale'                            => 'L\'idioma en què està escrita la campanya. Això serveix per a agrupar les campanyes públiques.',
        'name'                              => 'La campanya/món pot tenir qualsevol nom, sempre i quan contingui al menys 4 lletres o números.',
        'permissions_tab'                   => 'Podeu controlar la privacitat i la visibilitat per defecte de nous elements mitjançant les opcions següents.',
        'public_campaign_filters'           => 'Per facilitar que altres trobin aquesta campanya entre la resta, proporcioneu la informació següent.',
        'public_no_visibility'              => 'Vigileu! La vostra campanya és pública, però el rol públic no té accés a res. :fix.',
        'related_visibility'                => 'La visibilitat per defecte en crear un nou element amb aquest camp (anotacions d\'entitat, relacions, habilitats, etc.)',
        'system'                            => 'Si la campanya és visible públicament, el sistema es mostrarà a la pàgina de :link.',
        'systems'                           => 'Per a evitar desordres, alguns elements de Kanka només estan disponibles amb sistemes de rol específics (per exemple, el bloc d\'stats de monstre de D&D 5e). Si trieu un sistema acceptat, s\'activaran aquests elements.',
        'theme'                             => 'Estableix un tema únic per a la campanya, tot anul·lant les preferències dels usuaris.',
        'view_public'                       => 'Per veure la campanya com ho faria un visitant públic, obriu un :link a una finestra d\'incògnit.',
        'visibility'                        => 'Fer pública una campanya implica que tots els qui tinguin l\'enllaç la podran veure.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Nova campanya',
            ],
        ],
    ],
    'invites'                           => [
        'actions'               => [
            'copy'  => 'Copia l\'enllaç al porta-retalls',
            'link'  => 'Nou enllaç',
        ],
        'create'                => [
            'buttons'       => [
                'create'    => 'Crea una invitació',
            ],
            'success_link'  => 'S\'ha creat l\'enllaç. :link',
            'title'         => 'Invitacions a la campanya',
        ],
        'destroy'               => [
            'success'   => 'S\'ha eliminat la invitació.',
        ],
        'error'                 => [
            'already_member'    => 'Ja sou membre d\'aquesta campanya.',
            'inactive_token'    => 'Aquest identificador ja s\'ha utilitzat o la campanya ja no existeix.',
            'invalid_token'     => 'L\'identificador ja no és vàlid.',
            'login'             => 'Inicieu sessió o registreu-vos per a unir-vos a la campanya.',
        ],
        'fields'                => [
            'created'   => 'Enviat',
            'role'      => 'Rol',
            'type'      => 'Tipus',
            'usage'     => 'Nombre màxim d\'usos',
        ],
        'unlimited_validity'    => 'Il·limitat',
        'usages'                => [
            'five'      => '5 usos',
            'no_limit'  => 'Sense límit',
            'once'      => '1 ús',
            'ten'       => '10 usos',
        ],
    ],
    'leave'                             => [
        'confirm'   => 'Segur que voleu abandonar la campanya :name? No hi tindreu accés a no ser que un administrador torni a convidar-vos-hi.',
        'error'     => 'No podeu abandonar la campanya.',
        'success'   => 'Heu abandonat la campanya.',
    ],
    'members'                           => [
        'actions'               => [
            'remove'        => 'Elimina de la campanya',
            'switch'        => 'Veu com',
            'switch-back'   => 'Torna al meu usuari',
        ],
        'create'                => [
            'title' => 'Afegeix un membre a la campanya',
        ],
        'edit'                  => [
            'title' => 'Edició del membre :name',
        ],
        'fields'                => [
            'joined'        => 'Inscrit',
            'last_login'    => 'Última connexió',
            'name'          => 'Usuari',
            'role'          => 'Rol',
            'roles'         => 'Rols',
        ],
        'helpers'               => [
            'switch'    => 'Veu com aquest usuari',
        ],
        'impersonating'         => [
            'message'   => 'Esteu veient la campanya com a un altre usuari. Algunes funcionalitats estan deshabilitades, però majorment veieu exactament allò que l\'usuari veuria. Per tornar al vostre usuari, cliqueu a «Torna al meu usuari», prop del botó de sortida.',
            'title'     => 'Esteu veient com a :name',
        ],
        'invite'                => [
            'description'   => 'Podeu convidar amics a la campanya si mitjançant un enllaç d\'invitació. Un cop acceptin la invitació, seran afegits amb el rol indicat. També podeu enviar-los la invitació per correu electrònic, sempre que no sigui una adreça de Hotmail, ja que sempre rebutgen els mails de Kanka.',
            'more'          => 'Es poden afegir més rols des de la :link.',
            'title'         => 'Invitacions',
        ],
        'manage_roles'          => 'Configuració de rols d\'usuari',
        'roles'                 => [
            'member'    => 'Membre',
            'owner'     => 'Administrador',
            'player'    => 'Jugador',
            'public'    => 'Públic',
            'viewer'    => 'Convidat',
        ],
        'switch_back_success'   => 'Heu tornat al vostre usuari.',
        'title'                 => 'Membres de la campanya :name',
        'updates'               => [
            'added'     => 'S\'ha afegit el rol :role a :user.',
            'removed'   => 'S\'ha tret el rol :role a :user.',
        ],
    ],
    'open_campaign'                     => [],
    'options'                           => [],
    'panels'                            => [
        'dashboard' => 'Taulell',
        'permission'=> 'Permisos',
        'setup'     => 'Configuració',
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
    'privacy'                           => [
        'hidden'    => 'Oculta',
        'private'   => 'Privada',
        'visible'   => 'Visible',
    ],
    'public'                            => [
        'helpers'   => [
            'introduction'  => 'Les campanyes són privades per defecte, però poden fer-se públiques. Així, tothom hi podrà accedir i apareixeran a la pàgina de :public-campaigns si tenen entitats visibles per al rol de :public-role. Una campanya pública serà visible per a tothom; no obstant això, per tal que el seu contingut es vegi, cal ajustar els permisos del rol :public role.',
        ],
    ],
    'roles'                             => [
        'actions'       => [
            'add'           => 'Afegeix un rol',
            'permissions'   => 'Configura els permisos',
            'rename'        => 'Canvia el nom del rol',
            'save'          => 'Desa el rol',
        ],
        'admin_role'    => 'rol d\'administrador',
        'create'        => [
            'success'   => 'S\'ha creat el rol.',
            'title'     => 'Crea un rol nou a :name',
        ],
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
            'role_permissions'      => 'Habilita el rol «:name» per a que pugui fer les accions següents a totes les entitats.',
        ],
        'members'       => 'Membres',
        'modals'        => [
            'details'   => [
                'campaign'  => 'Els permisos de la campanya permeten fer les següents accions.',
                'entities'  => 'A continuació hi ha un resum ràpid del que poden fer els membres d\'aquest rol.',
                'more'      => 'Per a més detalls, mireu el nostre tutorial a Youtube.',
                'title'     => 'Detalls sobre els permisos',
            ],
        ],
        'permissions'   => [
            'actions'   => [
                'add'           => 'Crear',
                'dashboard'     => 'Taulell',
                'delete'        => 'Eliminar',
                'edit'          => 'Editar',
                'entity-note'   => 'Anotacions',
                'manage'        => 'Configurar',
                'members'       => 'Membres',
                'permission'    => 'Administrar els permisos',
                'read'          => 'Veure',
                'toggle'        => 'Canvia-ho per a tots',
            ],
            'helpers'   => [
                'add'           => 'Permet crear entitats d\'aquest tipus. Automàticament podran veure i editar les entitats que hagin creat, tot i que no tinguin permisos de veure o editar.',
                'dashboard'     => 'Permet editar el taulell i els seus widgets.',
                'delete'        => 'Permet eliminar totes les entitats d\'aquest tipus.',
                'edit'          => 'Permet editar totes les entitats d\'aquest tipus.',
                'entity_note'   => 'Permet afegir i editar anotacions malgrat no puguin editar l\'entitat en si.',
                'manage'        => 'Permet editar la campanya com ho faria un administrador, sense permetre als membres que esborrin la campanya.',
                'members'       => 'Permet convidar nous membres a la campanya.',
                'permission'    => 'Permet configurar els permisos a les entitats d\'aquest tipus que puguin editar.',
                'read'          => 'Permet veure totes les entitats d\'aquest tipus que no siguin privades.',
            ],
        ],
        'placeholders'  => [
            'name'  => 'Nom del rol',
        ],
        'show'          => [
            'title' => 'Rol «:role»',
        ],
        'title'         => 'Rols de la campanya :name',
        'types'         => [
            'owner'     => 'Administrador',
            'public'    => 'Públic',
            'standard'  => 'Estàndard',
        ],
        'users'         => [
            'actions'   => [
                'add'       => 'Afegeix',
                'remove'    => ':user amb el rol :role',
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
        'actions'   => [
            'enable'    => 'Habilita',
        ],
        'boosted'   => 'Aquesta funció encara és en beta i només està disponible per a les :boosted.',
        'helpers'   => [
            'abilities'     => 'Crea habilitats, proeses, encanteris o poders i els assigna a entitats.',
            'calendars'     => 'El lloc per a definir els calendaris del món.',
            'characters'    => 'Les persones que viuen al món.',
            'conversations' => 'Converses fictícies entre personatges o entre usuaris de la campanya.',
            'dice_rolls'    => 'Una manera de gestionar les tirades de daus per a aquells que utilitzen Kanka per a campanyes de rol.',
            'events'        => 'Celebracions, festivaes, desastres, aniversaris, guerres...',
            'families'      => 'Clans o famílies, les seves relacions i membres.',
            'inventories'   => 'Gestioneu els inventaris de les entitats.',
            'items'         => 'Armes, vehicles, relíquies, pocions...',
            'journals'      => 'Observacions escrites pels personatges, o la preparació de la sessió del màster.',
            'locations'     => 'Planetes, continents, rius, estats, assentaments, temples, tavernes...',
            'maps'          => 'Pugeu mapes amb diferents capes i marcadors que hi indiquen altres entitats de la campanya.',
            'notes'         => 'Tradicions, religions, història, màgia, mecàniques...',
            'organisations' => 'Sectes, unitats militars, faccions, gremis...',
            'quests'        => 'Per a dur un seguiment de les missions amb personatges i localitzacions.',
            'races'         => 'Totes les races de la campanya d\'un cop d\'ull.',
            'tags'          => 'Cada entitat pot tenir diverses etiquetes que, al seu torn, també poden pertànyer a altres etiquetes. A més, les entitats poden filtrar-se per etiqueta.',
            'timelines'     => 'Per a representar la història del món amb eixos cronològics.',
        ],
    ],
    'show'                              => [
        'actions'   => [
            'edit'  => 'Edita la campanya',
            'leave' => 'Abandona la campanya',
        ],
        'menus'     => [
            'configuration'     => 'Configuració',
            'overview'          => 'General',
            'user_management'   => 'Usuaris',
        ],
        'tabs'      => [
            'achievements'      => 'Assoliments',
            'applications'      => 'Sol·licituds',
            'campaign'          => 'Campanya',
            'default-images'    => 'Imatges per defecte',
            'export'            => 'Exportació',
            'information'       => 'Informació',
            'members'           => 'Membres',
            'plugins'           => 'Connectors',
            'recovery'          => 'Recuperació',
            'roles'             => 'Rols',
            'styles'            => 'Temes',
        ],
        'title'     => 'Campanya :name',
    ],
    'superboosted'                      => [],
    'ui'                                => [
        'collapsed'         => [
            'collapsed' => 'Col·lapsar/Expandir',
            'default'   => 'Per defecte',
        ],
        'connections'       => [
            'explorer'  => 'Explorador de relacions (només per a campanyes millorades)',
            'list'      => 'Interfície de llista',
        ],
        'entity_history'    => [
            'hidden'    => 'Només visible per a administradors',
            'visible'   => 'Visible per a membres',
        ],
        'fields'            => [
            'connections'       => 'Interfície per defecte de les connexions de l\'entitat',
            'entity_history'    => 'Registre històric de l\'entitat',
            'entity_image'      => 'Imatge de l\'entitat',
            'member_list'       => 'Llista de membres de la campanya',
            'post_collapsed'    => 'Col·lapsar/expandir les noves anotacions d\'entitat',
        ],
        'helpers'           => [
            'connections'       => 'Seleccioneu quina interfície de connexions entre entitats es mostrarà a la subpàgina de connexions.',
            'other'             => 'Altres opcions visuals per a la campanya.',
            'post_collapsed'    => 'Seleccioneu el valor de col·lapsat/expandit per a les noves anotacions de les entitats.',
            'tooltip'           => 'Control·leu quina informació es mostra a la descripció emergent en passar el ratolí per sobre del nom de l\'entitat.',
        ],
        'members'           => [
            'hidden'    => 'Només visible per a administradors',
            'visible'   => 'Visible per a membres',
        ],
        'other'             => 'Altres',
    ],
    'visibilities'                      => [
        'private'   => 'Privada',
        'public'    => 'Pública',
        'review'    => 'Esperant revisió',
    ],
];
