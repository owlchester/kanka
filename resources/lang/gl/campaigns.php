<?php

return [
    'create'                            => [
        'description'           => 'Crear unha nova campaña',
        'helper'                => [
            'title'     => 'Dámosche a benvida a :name',
            'welcome'   => <<<'TEXT'
Antes de continuar, escolle un nome para a campaña. Este é o nome do teu mundo. Se aínda non tes un bo nome, non te preocupes, sempre pode cambialo máis tarde ou crear máis campañas.

Grazas por unirte a Kanka, dámosche a benvida á nosa próspera comunidade!
TEXT
,
        ],
        'success'               => 'Campaña creada',
        'success_first_time'    => 'A túa campaña foi creada! Como é a túa primeira campaña, creamos unhas cantas cousas para axudarte a comezar e, con sorte, darche algunha idea do que podes facer.',
        'title'                 => 'Nova campaña',
    ],
    'destroy'                           => [
        'action'    => 'Eliminar campaña',
        'helper'    => 'Só podes eliminar a campaña se non hai máis persoas nela.',
        'success'   => 'Campaña eliminada.',
    ],
    'edit'                              => [
        'description'   => 'Edita a túa campaña',
        'success'       => 'Campaña actualizada.',
        'title'         => 'Editar a campaña ":campaign"',
    ],
    'entity_note_visibility'            => [],
    'entity_personality_visibilities'   => [
        'private'   => 'As personaxes novas teñen a súa personalidade privada por defecto.',
    ],
    'entity_visibilities'               => [
        'private'   => 'As entidades novas son privadas',
    ],
    'errors'                            => [
        'access'        => 'Non tes acceso a esta campaña.',
        'superboosted'  => 'Esta funcionalidade só está dispoñíbel para campañas superpotenciadas.',
        'unknown_id'    => 'Campaña descoñecida.',
    ],
    'export'                            => [
        'description'       => 'Exportar a campaña.',
        'errors'            => [
            'limit' => 'Excediches o número máximo de exportacións ao día. Por favor, inténtao de novo mañá.',
        ],
        'helper'            => 'Exporta a túa campaña. Recibirás unha notificación coa ligazón de descarga.',
        'helper_secondary'  => 'Dous arquivos estarán dispoñíbeis, un coas entidades exportadas como JSON, e outro coas imaxes subidas ás entidades. Por favor, ten en conta que en campañas grandes, a exportación de imaxes pode non funcionar. Nese caso poden ser recuperadas usando a :api.',
        'success'           => 'A exportación da túa campaña está sendo preparada. Recibirás unha notificación en Kanka para descargar un arquivo zip cando esté lista.',
        'title'             => 'Exportación da campaña ":name"',
    ],
    'fields'                            => [
        'boosted'                   => 'Potenciada por',
        'connections'               => 'Mostra a táboa de conexións dunha entidade por defecto (no lugar de mostar o explorador, en campañas potenciadas)',
        'css'                       => 'CSS',
        'description'               => 'Descrición',
        'entity_count'              => 'Número de entidades',
        'entry'                     => 'Descrición da campaña',
        'excerpt'                   => 'Limiar',
        'followers'                 => 'Persoas que a seguen',
        'header_image'              => 'Imaxe de cabeceira',
        'hide_history'              => 'Ocultar historial de entidades',
        'hide_members'              => 'Ocultar integrantes da campaña',
        'image'                     => 'Imaxe',
        'locale'                    => 'Lingua',
        'name'                      => 'Nome',
        'nested'                    => 'Mostrar as listaxes de entidades en árbore, cando sexa posíbel',
        'open'                      => 'Aberta a solicitudes',
        'public_campaign_filters'   => 'Filtros de campañas públicas',
        'related_visibility'        => 'Visibilidade de elementos relacionados',
        'rpg_system'                => 'Sistemas RPG',
        'superboosted'              => 'Superpotenciada por',
        'system'                    => 'Sistema',
        'theme'                     => 'Tema',
        'tooltip_family'            => 'Desactivar nomes de familia na previsualización emerxente',
        'tooltip_image'             => 'Amosar a imaxe da entidade na previsualización emerxente',
        'visibility'                => 'Visibilidade',
    ],
    'following'                         => 'Seguindo',
    'helpers'                           => [
        'boost_required'            => 'Esta función requer que a campaña sexa potenciada. Máis información na páxina de :settings.',
        'boosted'                   => 'Algunhas funcións están desbloqueadas porque esta campaña está potenciada. Máis información na páxina de :settings.',
        'css'                       => 'Escrebe o teu propio CSS para as páxinas da túa campaña. Ten en conta que calquer abuso desta ferramenta pode levar á eliminación do teu CSS personalizado. Ofensas repetidas ou graves poden levar á eliminación da túa campaña.',
        'dashboard'                 => 'Personaliza a forma na que se mostra o taboleiro da campaña completando os seguintes campos.',
        'excerpt'                   => 'O limiar da campaña mostrarase no taboleiro principal. Escrebe unhas poucas liñas introducindo o teu mundo. Se este campo está baleiro, os primeiros 1000 caracteres da descrición da campaña serán usados.',
        'header_image'              => 'Imaxe mostrada como fondo no taboleiro da campaña.',
        'hide_history'              => 'Habilita está opción para que o historial das entidades só sexa visíbel pola administración da campaña.',
        'hide_members'              => 'Habilita esta opción para que a lista de integrantes da campaña só sexa visíbel pola administración da campaña.',
        'locale'                    => 'A lingua na que está escrita a túa campaña. Isto úsase para xerar contido e agrupar campañas públicas.',
        'name'                      => 'A túa campaña ou mundo pode ter calquer nome sempre que conteña polo menos catro letras ou números.',
        'public_campaign_filters'   => 'Axuda a outras persoas a atopar a campaña entre outras campañas públicas proporcionando a seguinte información.',
        'public_no_visibility'      => 'Coidado! A túa campaña é pública, pero o rol Público da campaña non pode acceder nada. :fix.',
        'related_visibility'        => 'A visibilidade por defecto ao crear un elemento con este campo (entradas, relacións, habilidades, etc.)',
        'system'                    => 'Se a túa campaña é públicamente visíbel, o sistema é mostrado na páxina de :link.',
        'systems'                   => 'Para evitar unha sobrecarga de opcións, algunhas funcións de Kanka só están dispoñibles para sistemas RPG específicos (por exemplo, o bloque de estadísticas de monstros para D&D 5e). Engadir sistemas soportados aquí habilitará as súas funcións.',
        'theme'                     => 'Forza o tema da campaña, invalidando a preferencia da persoa usuaria.',
        'view_public'               => 'Para ver a túa campaña como a vería unha persoa externa, abre :link nunha xanela de incógnito.',
        'visibility'                => 'Facer pública unha campaña significa que calquera persoa cunha ligazón a ela poderá vela.',
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
            'add'   => 'Convidar por correo electrónico',
            'copy'  => 'Copiar a ligazón ao portapapeis',
            'link'  => 'Nova ligazón',
        ],
        'create'                => [
            'buttons'       => [
                'create'    => 'Crear convite',
                'send'      => 'Enviar convite',
            ],
            'description'   => 'Convida unha amizade á túa campaña',
            'success'       => 'Convite enviado.',
            'success_link'  => 'Ligazón creada: :link',
            'title'         => 'Convida alguén á túa campaña.',
        ],
        'destroy'               => [
            'success'   => 'Convite eliminado.',
        ],
        'email'                 => [
            'link_text' => 'Unirse á campaña de :name',
            'subject'   => ':name convidoute a unirte á súa campaña ":campaign" en kanka.io! Usa a seguinte ligazón para aceptar o seu convite.',
            'title'     => 'Convite de :name',
        ],
        'error'                 => [
            'already_member'    => 'Xa es integrante desta campaña.',
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
            'validity'  => 'Cantas persoas poden usar esta ligazón antes de que se desactive. Déixao en branco para que non haxa límite.',
        ],
        'placeholders'          => [
            'email' => 'Enderezo de correo electrónico da persoa que queres convidar',
        ],
        'types'                 => [
            'email' => 'Correo electrónico',
            'link'  => 'Ligazón',
        ],
        'unlimited_validity'    => 'Ilimitado',
    ],
    'leave'                             => [
        'confirm'   => 'Seguro que queres abandonar a campaña ":name"? Non poderás volver acceder a ela, excepto se alguén da administración te convida de novo.',
        'error'     => 'Non foi posíbel abandonar a campaña.',
        'success'   => 'Abandonaches a campaña.',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'Ver como',
            'switch-back'   => 'Voltar á miña conta',
        ],
        'create'                => [
            'title' => 'Engade unha persoa á túa campaña.',
        ],
        'description'           => 'Administar as persoas integrantes da campaña',
        'edit'                  => [
            'description'   => 'Edita alguén da túa campaña',
            'title'         => 'Editar integrante :name',
        ],
        'fields'                => [
            'joined'        => 'Uniuse',
            'last_login'    => 'Última conexión',
            'name'          => 'Conta',
            'role'          => 'Rol',
            'roles'         => 'Roles',
        ],
        'help'                  => 'Non hai límite no número de integrantes que pode ter unha campaña.',
        'helpers'               => [
            'admin' => 'Como parte da administración da campaña, podes convidar novas persoas, eliminar integrantes inactivas, e cambiar os seus permisos. Para probar os permisos que ten unha integrante, usa o botón "Ver como". Podes ler máis sobre esta función en :link.',
            'switch'=> 'Ver como esta conta',
        ],
        'impersonating'         => [
            'message'   => 'Estás vendo a campaña como outra conta. Algunhas funcións están desactivadas, mais o resto funciona exactamente igual que como o vería esta persoa. Para voltar á túa conta, usa o botón "Voltar á miña conta" que se atopa onde normalmente está o botón de Pechar sesión.',
            'title'     => 'Estás vendo como :name',
        ],
        'invite'                => [
            'description'   => 'Podes invitar amizades a unirse á túa campaña mediante unha ligazón de convite. Cando acepten o convite, serán engadidas como integrante no rol correspondente. Tamén podes enviarlles un convite mediante correo electrónico, sempre e cando non sexa un enderezo de Hotmail, xa que Hotmail sempre rexeita os correos de Kanka.',
            'more'          => 'Podes engadir máis roles en :link',
            'roles_page'    => 'Páxina de roles',
            'title'         => 'Convidar',
        ],
        'manage_roles'          => 'Administrar roles',
        'roles'                 => [
            'member'    => 'Integrante',
            'owner'     => 'Administración',
            'player'    => 'Xogante',
            'public'    => 'Público',
            'viewer'    => 'Espectadora',
        ],
        'switch_back_success'   => 'Voltaches á túa conta orixinal.',
        'title'                 => 'Integrantes da campaña ":name"',
        'updates'               => [
            'added'     => 'Rol :role engadido a :user.',
            'removed'   => 'Rol :role eliminado de :user.',
        ],
        'your_role'             => 'O teu rol: <i>:role</i>',
    ],
    'open_campaign'                     => [
        'helper'    => 'Unha campaña pública marcada como aberta permitirá que a xente envíe solicitudes para unirse a ela. Encontra a lista de solicitudes na nosa páxina :link.',
        'link'      => 'solicitudes na campaña',
        'title'     => 'Campaña aberta',
    ],
    'options'                           => [
        'entity_personality_visibility' => 'Establecer que as novas personaxes teñan a súa personalidade privada por defecto.',
        'entity_visibility'             => 'Establecer que as novas entidades sexan privadas por defecto.',
    ],
    'panels'                            => [
        'boosted'   => 'Potenciada',
        'dashboard' => 'Taboleiro',
        'permission'=> 'Permisos',
        'setup'     => 'Configuración',
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
            'add'           => 'Engadir un rol',
            'permissions'   => 'Xestionar permisos',
            'rename'        => 'Renomear rol',
        ],
        'admin_role'    => 'rol de administración',
        'create'        => [
            'success'   => 'Rol creado.',
            'title'     => 'Crear un novo rol para :name',
        ],
        'description'   => 'Administrar os roles da campaña',
        'destroy'       => [
            'success'   => 'Rol eliminado.',
        ],
        'edit'          => [
            'success'   => 'Rol actualizado.',
            'title'     => 'Editar rol ":name"',
        ],
        'fields'        => [
            'name'          => 'Nome',
            'permissions'   => 'Permisos',
            'type'          => 'Tipo',
            'users'         => 'Integrantes',
        ],
        'helper'        => [
            '1' => 'Unha campaña pode ter tantos roles como queiras. As persoas co rol de "Administración" teñen automaticamente acceso a todo dentro da campaña, pero todos os demáis roles poden ter permisos específicos en diferentes tipos de entidades (personaxes, lugares, etc.).',
            '2' => 'Podes asignar permisos máis específicos a unha entidade mediante a lapela "Permisos". Esta lapela aparece unha vez a túa campaña ten varios roles ou integrantes.',
            '3' => 'Pódese usar un sistema de exclusión, no que se da acceso a todas as entidades, e marcar a caixa "Privada" nas entidades para ocultalas. Tamén se pode dar poucos permisos aos roles e configurar a visibilidade de cada entidade individualmente.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'O rol "Público" ten permisos pero a campaña é privada. Podes cambiar esta configuración na lapela "Compartir" ao editar a campaña.',
            'public'                => 'O rol "Público" é usado cando alguén visita a túa campaña pública. :more',
            'role_permissions'      => 'Activa o rol ":name" para que poida facer as seguintes accións en todas as entidades.',
        ],
        'members'       => 'Integrantes',
        'modals'        => [
            'details'   => [
                'button'    => 'Axuda',
                'campaign'  => 'Os permisos de campaña permiten o seguinte.',
                'entities'  => 'Este é un resumo do que poden facer as integrantes deste rol cando un permiso é establecido.',
                'more'      => 'Para máis detalles, mira o noso vídeo tutorial en Youtube',
                'title'     => 'Detalles do permiso',
            ],
        ],
        'permissions'   => [
            'actions'   => [
                'add'           => 'Crear',
                'dashboard'     => 'Taboleiro',
                'delete'        => 'Eliminar',
                'edit'          => 'Editar',
                'entity-note'   => 'Entrada',
                'manage'        => 'Configurar',
                'members'       => 'Integrantes',
                'permission'    => 'Permisos',
                'read'          => 'Ver',
                'toggle'        => 'Cambiar para todos',
            ],
            'helpers'   => [
                'add'           => 'Permite crear entidades deste tipo. Poderán ver e editar entidades que creen se non teñen permisos para ver ou editar.',
                'dashboard'     => 'Permite editar os taboleiros e os seus complementos.',
                'delete'        => 'Permite eliminar todas as entidades deste tipo.',
                'edit'          => 'Permite editar todas as entidades deste tipo.',
                'entity_note'   => 'Isto permite que persoas que non teñen permisos de edición nunha entidade poidan engadirlle entradas.',
                'manage'        => 'Permite editar a campaña da mosma forma que pode a administración, pero sen permitir eliminala.',
                'members'       => 'Permite convidar novas integrantes á campaña.',
                'permission'    => 'Permite establecer permisos en entidades deste tipo que poidan editar.',
                'read'          => 'Permite ver todas as entidades deste tipo que non sexan privadas.',
            ],
            'hint'      => 'Este rol ten automáticamente acceso a todo.',
        ],
        'placeholders'  => [
            'name'  => 'Nome do rol',
        ],
        'show'          => [
            'description'   => 'Integrantes e permisos dun rol da campaña',
            'title'         => 'Rol ":role"',
        ],
        'title'         => 'Roles da campaña :name',
        'types'         => [
            'owner'     => 'Administración',
            'public'    => 'Público',
            'standard'  => 'Estándar',
        ],
        'users'         => [
            'actions'   => [
                'add'       => 'Engadir',
                'remove'    => ':user do rol :role',
            ],
            'create'    => [
                'success'   => 'Persoa engadida ao rol.',
                'title'     => 'Engade unha persoa ao rol ":name"',
            ],
            'destroy'   => [
                'success'   => 'Persoa eliminada do rol.',
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
        'helper'        => 'Todos os módulos dunha campaña poden ser habilitados ou deshabilitados a vontade. Deshabilitar un módulo simplemente ocultará todos os elementos da interface relacionados con el, e as entidades preexistentes seguirán existindo pero ocultas, no caso de que cambies de parecer. Este cambio afecta a todas as persoas integrantes dunha campaña, incluíndo a Administración.',
        'helpers'       => [
            'abilities'     => 'Crea habilidades (talentos, feitizos, poderes...) que poden ser asignados a entidades.',
            'calendars'     => 'Un lugar para definir os calendarios do teu mundo.',
            'characters'    => 'A xente que habita no teu mundo.',
            'conversations' => 'Conversas ficticias entre personaxes ou entre integrantes da campaña. Este módulo está obsoleto.',
            'dice_rolls'    => 'Un xeito de tirar dados para quen usa Kanka nas súas partidas de rol. Este módulo está obsoleto.',
            'events'        => 'Celebracións, festivais, desastres, aniversarios, guerras...',
            'families'      => 'Clans ou familias, as súas relacións e as persoas que as forman.',
            'inventories'   => 'Xestiona inventarios nas túas entidades.',
            'items'         => 'Armas, vehículos, reliquias, apócemas...',
            'journals'      => 'Observacións escritas por personaxes, ou notas de preparación para dirixir partidas.',
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
        'title'         => 'Módulos da campaña ":name"',
    ],
    'show'                              => [
        'actions'       => [
            'boost' => 'Potenciar campaña',
            'edit'  => 'Editar campaña',
            'leave' => 'Abandonar campaña',
        ],
        'description'   => 'Vista detallada da campaña',
        'menus'         => [
            'configuration'     => 'Configuración',
            'overview'          => 'Visión xeral',
            'user_management'   => 'Xestión de integrantes',
        ],
        'tabs'          => [
            'achievements'      => 'Logros',
            'applications'      => 'Solicitudes',
            'campaign'          => 'Campaña',
            'default-images'    => 'Imaxes por defecto',
            'export'            => 'Exportar',
            'information'       => 'Información',
            'members'           => 'Integrantes',
            'menu'              => 'Menú',
            'plugins'           => 'Complementos',
            'recovery'          => 'Recuperación',
            'roles'             => 'Roles',
            'settings'          => 'Módulos',
            'styles'            => 'Estilo',
        ],
        'title'         => 'Campaña ":name"',
    ],
    'superboosted'                      => [
        'gallery'   => [
            'error' => [
                'text'  => 'Subir imaxes no editor de texto só é posíbel para :superboosted.',
                'title' => 'Subida de imaxes á galería da campaña',
            ],
        ],
    ],
    'ui'                                => [
        'helper'    => 'Usa estas opcións para cambiar a maneira na que algúns elementos son mostrados na campaña.',
        'other'     => 'Miscelánea',
    ],
    'visibilities'                      => [
        'private'   => 'Privada',
        'public'    => 'Pública',
        'review'    => 'Esperando revisión',
    ],
];
