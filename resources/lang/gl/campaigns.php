<?php

return [
    'create'                            => [
        'description'           => 'Crear unha nova campaña',
        'helper'                => [
            'first'     => 'Grazas por probar a nosa app! Antes de continuarmos, precisamos que nos digas unha cousa: <b>o nome da túa campaña</b>. Este será o nome do teu mundo que o diferencia dos demáis, polo tanto, precisa ser único. Se aínda non tes un bo nome, non te preocupes, <b>sempre podes cambialo máis tarde</b>, ou crear máis campañas.',
            'title'     => 'Benvida a :name',
            'welcome'   => <<<'TEXT'
Antes de continuar, escolle un nome para a campaña. Este é o nome do teu mundo. Se aínda non tes un bo nome, non te preocupes, sempre pode cambialo máis tarde ou crear máis campañas.

Grazas por unirte a Kanka, e benvida á nosa próspera comunidade!
TEXT
,
        ],
        'success'               => 'Campaña creada',
        'success_first_time'    => 'A túa campaña foi creada! Como é a túa primeira campaña, creamos unhas cantas cousas para axudarte a comezar e, con sorte, darche algunha idea do que podes facer.',
        'title'                 => 'Nova campaña',
    ],
    'destroy'                           => [
        'success'   => 'Campaña eliminada.',
    ],
    'edit'                              => [
        'description'   => 'Edita a túa campaña',
        'success'       => 'Campaña actualizada.',
        'title'         => 'Editar a campaña :campaign',
    ],
    'entity_personality_visibilities'   => [
        'private'   => 'As personaxes novas teñen a súa personalidade privada por defecto.',
    ],
    'entity_visibilities'               => [
        'private'   => 'As entidades novas son privadas',
    ],
    'errors'                            => [
        'access'        => 'Non tes acceso a esta campaña.',
        'unknown_id'    => 'Campaña descoñecida.',
    ],
    'export'                            => [
        'description'   => 'Exportar a campaña.',
        'errors'        => [
            'limit' => 'Excediches o número máximo de exportacións ao día. Por favor inténtao de novo mañá.',
        ],
        'helper'        => 'Exporta a túa campaña. Recibirás unha notificación coa ligazón de descarga.',
        'success'       => 'A exportación da túa campaña está sendo preparada. Recibirás unha notificación en Kanka para descargar un arquivo zip cando esté lista.',
        'title'         => 'Exportación da campaña :name',
    ],
    'fields'                            => [
        'boosted'                       => 'Potenciada por',
        'css'                           => 'CSS',
        'description'                   => 'Descrición',
        'entity_count'                  => 'Número de entidades',
        'entity_personality_visibility' => 'Visibilidade da personalidade da personaxe',
        'entity_visibility'             => 'Visibilidade da entidade',
        'excerpt'                       => 'Limiar',
        'followers'                     => 'Seguidoras',
        'header_image'                  => 'Imaxe de cabeceira',
        'hide_history'                  => 'Ocultar historial de entidades',
        'hide_members'                  => 'Ocultar membras da campaña',
        'image'                         => 'Imaxe',
        'locale'                        => 'Lingua',
        'name'                          => 'Nome',
        'public_campaign_filters'       => 'Filtros de campañas públicas',
        'rpg_system'                    => 'Sistemas RPG',
        'system'                        => 'Sistema',
        'theme'                         => 'Tema',
        'tooltip_family'                => 'Desactivar nomes de familia na previsualización emerxente',
        'tooltip_image'                 => 'Amosar a imaxe da entidade na previsualización emerxente',
        'visibility'                    => 'Visibilidade',
    ],
    'following'                         => 'Seguindo',
    'helpers'                           => [
        'boost_required'                => 'Esta función requer que a campaña sexa potenciada. Máis información na páxina de :settings.',
        'boosted'                       => 'Algunhas funcións están desbloqueadas porque esta campaña está potenciada. Máis información na páxina de :settings.',
        'css'                           => 'Escrebe o teu propio CSS para as páxinas da túa campaña. Ten en conta que calquer abuso desta ferramenta pode levar á eliminación do teu CSS personalizado. Ofensas repetidas ou graves poden levar á eliminación da túa campaña.',
        'entity_personality_visibility' => 'Ao crear unha nova personaxe, a opción "Personalidade visíbel" estará automáticamente deseleccionada.',
        'entity_visibility'             => 'Ao crear unha nova entidade, a opción "Privada" estará automáticamente seleccionada.',
        'excerpt'                       => 'O limiar da campaña será amosado no taboleiro principal. Escrebe unhas poucas liñas introducindo o teu mundo.',
        'hide_history'                  => 'Habilita está opción para ocultar o historial de entidades ás membras non administradoras da campaña.',
        'hide_members'                  => 'Habilita esta opción para ocultar a lista de membras da campaña ás membras non administradoras.',
        'locale'                        => 'A lingua na que está escrita a túa campaña. Isto úsase para xerar contido e agrupar campañas públicas.',
        'name'                          => 'A túa campaña ou mundo pode ter calquer nome sempre que conteña polo menos catro letras ou números.',
        'public_campaign_filters'       => 'Axuda a outras persoas a atopar a campaña entre outras campañas públicas proporcionando a seguinte información.',
        'system'                        => 'Se a túa campaña é públicamente visíbel, o sistema é mostrado na páxina de :link.',
        'systems'                       => 'Para evitar sobrecargar as usuarias con opcións, algunhas funcións de Kanka só están dispoñibles para sistemas RPG específicos (por exemplo, o bloque de estadísticas de monstros para D&D 5e). Engadir sistemas soportados aquí habilitará as súas funcións.',
        'theme'                         => 'Forza o tema da campaña, invalidando a preferencia da usuaria.',
        'view_public'                   => 'Para ver a túa campaña como a vería unha visitante pública, abre :link nunha xanela de incógnito.',
        'visibility'                    => 'Facer pública unha campaña significa que calquer persoa con unha ligazón a ela poderá vela.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Nova campaña',
            ],
        ],
        'title'     => 'Campañas',
    ],
    'invites'                           => [
        'actions'               => [
            'add'   => 'Convidar',
            'copy'  => 'Copiar a ligazón ao portapapeis',
            'link'  => 'Nova ligazón',
        ],
        'create'                => [
            'button'        => 'Convidar',
            'description'   => 'Convida unha amiga á túa campaña',
            'link'          => 'Ligazón creada: <a href=":url" target="_blank">:url</a>',
            'success'       => 'Convite enviado.',
            'title'         => 'Convida alguén á túa campaña.',
        ],
        'destroy'               => [
            'success'   => 'Convite eliminado.',
        ],
        'email'                 => [
            'link'      => '<a href=":link">Unirse á campaña de :name</a>',
            'subject'   => ':name convidoute a unirte á súa campaña ":campaign" en kanka.io! Usa a seguinte ligazón para aceptar o seu convite.',
            'title'     => 'Convite de :name',
        ],
        'error'                 => [
            'already_member'    => 'Xa es membra desta campaña.',
            'inactive_token'    => 'Este identificador xa foi usado, ou a campaña xa non existe.',
            'invalid_token'     => 'Este identificador xa non é válido.',
            'login'             => 'Por favor, inicia sesión ou rexístrate para unirte á campaña.',
        ],
        'fields'                => [
            'created'   => 'Enviado',
            'email'     => 'Correo electrónico',
            'role'      => 'Rol',
            'type'      => 'Tipo',
            'validity'  => 'Validez',
        ],
        'helpers'               => [
            'email'     => 'Os nosos correos son frecuentemente marcados como spam e poden tardar unhas horas ata aparecer na túa caixa de entrada.',
            'validity'  => 'Cantas usuarias poden usar esta ligazón antes de que se desactive. Déixao en branco para non ter límite.',
        ],
        'placeholders'          => [
            'email' => 'Dirección de correo electrónico da persoa que queres convidar',
        ],
        'types'                 => [
            'email' => 'Correo electrónico',
            'link'  => 'Ligazón',
        ],
        'unlimited_validity'    => 'Ilimitado',
    ],
    'leave'                             => [
        'confirm'   => 'Seguro que queres abandonar a campaña :name? Non poderás volver acceder a ela, excepto se unha administradora te convida de novo.',
        'error'     => 'Non foi posíbel abandonar a campaña.',
        'success'   => 'Abandonaches a campaña.',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'Ver como',
            'switch-back'   => 'Voltar ao meu usuario',
        ],
        'create'                => [
            'title' => 'Engade unha membra á túa campaña.',
        ],
        'description'           => 'Xerir as membras da campaña',
        'edit'                  => [
            'description'   => 'Edita unha membra da túa campaña',
            'title'         => 'Editar membra :name',
        ],
        'fields'                => [
            'joined'        => 'Uniuse',
            'last_login'    => 'Última conexión',
            'name'          => 'Usuario',
            'role'          => 'Rol',
            'roles'         => 'Roles',
        ],
        'help'                  => 'Non hai límite no número de membras que pode ter unha campaña.',
        'helpers'               => [
            'admin' => 'Como administradora da campaña, podes convidar novas membras, eliminar membras inactivas, e cambiar os seus permisos. Para probar os permisos que ten unha membra, usa o botón "Ver como". Podes ler máis sobre esta función en :link.',
            'switch'=> 'Ver como este usuario',
        ],
        'impersonating'         => [
            'message'   => 'Estás vendo a campaña como outro usuario. Algunhas funcións están desactivadas, mais o resto funciona exactamente igual que como o vería este usuario. Para voltar ao teu usuario, usa o votón "Voltar ao meu usuario" que se atopa onde normalmente está o botón de Cerrar sesión.',
            'title'     => 'Estás vendo como :name',
        ],
        'invite'                => [
            'description'   => 'Podes invitar amigas á unirse á túa campaña mediante unha ligazón de convite. Cando acepten o convite, serán engadidas como membra no rol correspondente. Tamén podes enviarlles un convite mediante correo electrónico, sempre e cando non sexa unha dirección de Hotmail, xa que Hotmail sempre rexeita os correos de Kanka.',
            'more'          => 'Podes engadir máis roles en :link',
            'roles_page'    => 'Páxina de roles',
            'title'         => 'Convidar',
        ],
        'roles'                 => [
            'member'    => 'Membra',
            'owner'     => 'Administradora',
            'player'    => 'Xogadora',
            'public'    => 'Público',
            'viewer'    => 'Espectadora',
        ],
        'switch_back_success'   => 'Voltaches ao teu usuario orixinal.',
        'title'                 => 'Membras da campaña :name',
        'your_role'             => 'O teu rol: <i>:role</i>',
    ],
    'panels'                            => [
        'boosted'   => 'Potenciada',
        'dashboard' => 'Taboleiro',
        'permission'=> 'Permisos',
        'sharing'   => 'Compartir',
        'systems'   => 'Sistemas',
        'ui'        => 'Interface',
    ],
    'placeholders'                      => [
        'description'   => 'Un breve resumo da túa campaña',
        'locale'        => 'Código de idioma',
        'name'          => 'O nome da túa campaña',
        'system'        => 'D&D, Pathfinder, Fate, DSA',
    ],
    'roles'                             => [
        'actions'       => [
            'add'   => 'Engadir un rol',
        ],
        'create'        => [
            'success'   => 'Rol creado.',
            'title'     => 'Crear un novo rol para :name',
        ],
        'description'   => 'Xerir os roles da campaña',
        'destroy'       => [
            'success'   => 'Rol eliminado.',
        ],
        'edit'          => [
            'success'   => 'Rol actualizado.',
            'title'     => 'Editar rol :name',
        ],
        'fields'        => [
            'name'          => 'Nome',
            'permissions'   => 'Permisos',
            'type'          => 'Tipo',
            'users'         => 'Usuarios',
        ],
        'helper'        => [
            '1' => 'Unha campaña pode ter tantos roles como quixeres. O rol de "Administradora" ten automaticamente acceso a todo dentro da campaña, pero todos os demáis roles poden ter permisos específicos en diferentes tipos de entidades (personaxes, lugares, etc.).',
            '2' => 'Podes asignar permisos máis específicos a unha entidade mediante a lapela "Permisos". Esta lapela aparece unha vez a túa campaña ten varios roles ou membras.',
            '3' => 'Pódese usar un sistema de exclusión, no que se da acceso a todas as entidades, e usar a casilla "Privada" nas entidades para ocultalas. Tamén se pode dar poucos permisos aos roles e configurar a visibilidade de cada entidade individualmente.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'O rol "Público" ten permisos pero a campaña é privada. Podes cambiar esta configuración na lapela "Compartir" ao editar a campaña.',
            'public'                => 'O rol "Público" é usado cando alguén visita a túa campaña pública. :more',
            'role_permissions'      => 'Activa o rol ":name" para que poida facer as seguintes accións en todas as entidades.',
        ],
        'members'       => 'Membras',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Crear',
                'delete'        => 'Eliminar',
                'edit'          => 'Editar',
                'entity-note'   => 'Nota de entidade',
                'permission'    => 'Permisos',
                'read'          => 'Ver',
                'toggle'        => 'Cambiar para todas',
            ],
            'helpers'   => [
                'entity_note'   => 'Isto permite que usuarios que non teñen permisos de edición nunha entidade poidan engadirlle notas de entidade.',
            ],
            'hint'      => 'Este rol ten automáticamente acceso a todo.',
        ],
        'placeholders'  => [
            'name'  => 'Nome do rol',
        ],
        'show'          => [
            'description'   => 'Membras e permisos dun rol da campaña',
            'title'         => 'Rol ":role"',
        ],
        'title'         => 'Roles da campaña :name',
        'types'         => [
            'owner'     => 'Administradora',
            'public'    => 'Público',
            'standard'  => 'Estándar',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Engadir unha membra',
            ],
            'create'    => [
                'success'   => 'Usuario engadido ao rol.',
                'title'     => 'Engade unha membra ao rol :name',
            ],
            'destroy'   => [
                'success'   => 'Usuario eliminado do rol.',
            ],
            'fields'    => [
                'name'  => 'Nome',
            ],
        ],
    ],
    'settings'                          => [
        'actions'       => [
            'enable'    => 'Activar',
        ],
        'boosted'       => 'Esta función está en acceso anticipado e actualmente só dispoñíbel para :boosted.',
        'description'   => 'Habilita ou deshabilita módulos da campaña.',
        'edit'          => [
            'success'   => 'Configuración da campaña actualizada.',
        ],
        'helper'        => 'Todos os módulos dunha campaña poden ser habilitados ou deshabilitados a vontade. Deshabilitar un módulo simplemente ocultará todos os elementos da interface relacionados con el, e as entidades preexistentes seguirán existindo pero ocultas, no caso de que cambies de parecer. Este cambio afecta a todos os usuarios nunha campaña, incluíndo os Administradores.',
        'helpers'       => [
            'abilities'     => 'Crea habilidades (talentos, feitizos, poderes...) que poden ser asignados a entidades.',
            'calendars'     => 'Un lugar para definir os calendarios do teu mundo.',
            'characters'    => 'A xente que habita no teu mundo.',
            'conversations' => 'Conversas ficticias entre personaxes ou entre membras da campaña. Este módulo está obsoleto.',
            'dice_rolls'    => 'Unha maneira de tirar dados para quen usa Kanka nas súas partidas de rol. Este módulo está obsoleto.',
            'events'        => 'Celebracións, festivais, desastres, aniversarios, guerras...',
            'families'      => 'Clans ou familias, as súas relacións e as súas membras.',
            'items'         => 'Armas, vehículos, reliquias, apócemas...',
            'journals'      => 'Observacións escritas por personaxes, ou notas de preparación para a directora de xogo.',
            'locations'     => 'Planetas, planos, continentes, ríos, estados, asentamentos, templos, tabernas...',
            'maps'          => 'Sube mapas con capas e marcadores señalando a outras entidades da campaña.',
            'menu_links'    => 'Ligazóns de menú personalizadas na barra lateral.',
            'notes'         => 'Tradicións, relixións, historia, maxia, razas...',
            'organisations' => 'Cultos, unidades militares, faccións, gremios...',
            'quests'        => 'Para levar seguimento de misións con personaxes e lugares asociados.',
            'races'         => 'Se a túa campaña ten máis de unha raza, isto axudarate a telas a man.',
            'tags'          => 'Cada entidade pode ter varias etiquetas. As etiquetas poden á súa vez pertencer a outras etiquetas, e as entradas poden ser filtradas por etiqueta.',
            'timelines'     => 'Representa a historia do teu mundo usando liñas temporais.',
        ],
        'title'         => 'Módulos da campaña :name',
    ],
    'show'                              => [
        'actions'       => [
            'boost' => 'Potenciar campaña',
            'edit'  => 'Editar campaña',
            'leave' => 'Abandonar campaña',
        ],
        'description'   => 'Unha vista detallada da campaña',
        'tabs'          => [
            'default-images'    => 'Imaxes por defecto',
            'export'            => 'Exportar',
            'information'       => 'Información',
            'members'           => 'Membras',
            'menu'              => 'Menú',
            'plugins'           => 'Complementos',
            'recovery'          => 'Recuperación',
            'roles'             => 'Roles',
            'settings'          => 'Módulos',
        ],
        'title'         => 'Campaña :name',
    ],
    'ui'                                => [
        'helper'    => 'Usa estas opcións para cambiar a maneira na que algúns elementos son mostrados na campaña.',
    ],
    'visibilities'                      => [
        'private'   => 'Privada',
        'public'    => 'Pública',
        'review'    => 'Esperando revisión',
    ],
];
