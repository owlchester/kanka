<?php

return [
    'actions'                           => [],
    'create'                            => [
        'success'   => 'Campaña creada.',
        'title'     => 'Nueva campaña',
    ],
    'destroy'                           => [],
    'edit'                              => [
        'success'   => 'Campaña actualizada.',
    ],
    'entity_note_visibility'            => [],
    'entity_personality_visibilities'   => [
        'private'   => 'La personalidad de los personajes nuevos es privada por defecto.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Nuevas entidades privadas por defecto',
    ],
    'errors'                            => [
        'access'        => 'No tienes acceso a esta campaña.',
        'premium'       => 'Esta función sólo está disponible para las campañas premium.',
        'unknown_id'    => 'Campaña desconocida.',
    ],
    'export'                            => [],
    'fields'                            => [
        'boosted'                           => 'Mejorada por',
        'character_personality_visibility'  => 'Visibilidad por defecto de la personalidad',
        'connections'                       => 'Mostrar la tabla de conexiones de la entidad por defecto (en lugar del explorador de relaciones de las campañas mejoradas)',
        'css'                               => 'CSS',
        'description'                       => 'Descripción',
        'entity_count'                      => 'Número de entidades',
        'entity_privacy'                    => 'Privacidad por defecto de nuevas entidades',
        'entry'                             => 'Descripción de la campaña',
        'excerpt'                           => 'Extracto',
        'followers'                         => 'Seguidores',
        'gallery_visibility'                => 'Visibilidad predeterminada de las imágenes de la galería',
        'genre'                             => 'Género(s)',
        'header_image'                      => 'Imagen de cabecera',
        'image'                             => 'Imagen',
        'is_discreet'                       => 'Discreta',
        'locale'                            => 'Idioma',
        'name'                              => 'Nombre',
        'open'                              => 'Inscripciones abiertas',
        'post_collapsed'                    => 'Los nuevos posts en las entidades están colapsados por defecto.',
        'premium'                           => 'Premium desbloqueado por :name',
        'private_mention_visibility'        => 'Menciones privadas',
        'public'                            => 'Visibilidad de la campaña',
        'public_campaign_filters'           => 'Filtros de las campañas públicas',
        'related_visibility'                => 'Visibilidad de elementos relacionados',
        'superboosted'                      => 'Supermejorada por',
        'system'                            => 'Sistema',
        'theme'                             => 'Tema',
        'vanity'                            => 'URL personalizada',
        'visibility'                        => 'Visibilidad',
    ],
    'following'                         => 'Siguiendo',
    'helpers'                           => [
        'boosted'                           => 'Algunas características están desbloqueadas porque esta campaña está mejorada. Para saber más sobre esto, echa un vistazo en la página de :settings.',
        'character_personality_visibility'  => 'Selecciona la privacidad por defecto para los rasgos de personalidad al crear un nuevo personaje como administrador.',
        'css'                               => 'Escribe tu propio CSS para las páginas de tu campaña. Ten en cuenta que abusar de esta herramienta puede llevar a la eliminación de tu CSS personalizado. Incumplimientos repetidos o graves pueden llevar a la eliminación de tu campaña.',
        'dashboard'                         => 'Personaliza la forma en que el widget se muestra en el tablero rellenando los campos siguientes.',
        'entity_count_v3'                   => 'Este número se recalcula cada :amount horas.',
        'entity_privacy'                    => 'Selecciona la privacidad por defecto al crear nuevas entidades como administrador.',
        'excerpt'                           => 'El extracto de la campaña se mostrará en el tablero principal. Escribe unas pocas líneas para introducir tu mundo. Si lo dejas en blanco, se mostrarán los primeros 1.000 caracteres de la descripción de la campaña.',
        'gallery_visibility'                => 'Visibilidad por defecto al subir imágenes a la galería.',
        'header_image'                      => 'La imagen que se muestra como fondo en el widget de la cabecera del tablero.',
        'hide_history'                      => 'Habilita esta opción para esconder el historial de entidades a los miembros no administradores.',
        'hide_members'                      => 'Habilita esta opción para esconder la lista de miembros de la campaña a los no administradores.',
        'is_discreet'                       => 'Si se activa cuando la campaña es pública, no se mostrará en las :public-campaigns.',
        'is_discreet_locked'                => 'Las campañas Premium pueden configurarse para que sean visibles públicamente, pero no aparezcan en las :public-campaigns.',
        'locale'                            => 'El idioma en que está escrita tu campaña. Esto se usa para generar contenido y agrupar campañas públicas.',
        'name'                              => 'Tu campaña/mundo puede tener cualquier nombre, siempre y cuando contenga al menos 4 letras o números.',
        'no_entry'                          => '¡Parece que la campaña aún no tiene una descripción! Arreglemos eso.',
        'permissions_tab'                   => 'Controla la privacidad y visibilidad de nuevos elementos mediante las opciones siguientes.',
        'premium'                           => 'Algunas funciones están disponibles porque las funciones premium de esta campaña están desbloqueadas. Más información en la página de :settings.',
        'private_mention_visibility'        => 'Controla si las menciones a entidades privadas se mantienen ocultas o se muestran sus nombres.',
        'public_campaign_filters'           => 'Facilita que otros encuentren tu campaña entre las demás proporcionando la siguiente información.',
        'public_no_visibility'              => '¡Ojo! Tu campaña es pública, pero el rol público no tiene acceso a nada. :fix.',
        'related_visibility'                => 'La visibilidad por defecto al crear un elemento con este campo (notas de entidad, relaciones, habilidades, etc.)',
        'system'                            => 'Si tu campaña es visible públicamente, el sistema se mostrará en la página de :link.',
        'systems'                           => 'Para evitar líos, algunos elementos de Kanka solo están disponibles en sistemas RPG específicos (por ejemplo, el bloque de stats de monstruo de D&D 5e). Si eliges un sistema soportado, se activarán dichos elementos.',
        'theme'                             => 'Establece un tema único para la campaña, anulando las preferencias de los usuarios.',
        'view_public'                       => 'Para ver tu campaña como lo haría un visitante público, abre un :link en una ventana de incógnito.',
        'visibility'                        => 'Hacer pública una campaña implica que todos los que tengan el enlace a ella la podrán ver.',
    ],
    'index'                             => [],
    'invites'                           => [
        'actions'               => [
            'copy'  => 'Copiar el enlace al portapapeles',
            'link'  => 'Nuevo enlace',
        ],
        'create'                => [
            'buttons'       => [
                'create'    => 'Crear invitación',
            ],
            'success_link'  => 'Link creado. :link',
            'title'         => 'Invita a alguien a tu campaña',
        ],
        'destroy'               => [
            'success'   => 'Invitación eliminada.',
        ],
        'error'                 => [
            'inactive_token'    => 'Este identificador ya se ha usado o la campaña ya no existe.',
            'invalid_token'     => 'El identificador ya no es válido.',
            'join'              => 'Inicia sesión o registra una nueva cuenta para unirte a :campaign.',
        ],
        'fields'                => [
            'created'   => 'Enviado',
            'role'      => 'Rol',
            'token'     => 'Token',
            'type'      => 'Tipo',
            'usage'     => 'Número máximo de usos',
        ],
        'helpers'               => [
            'role'  => 'Los usuarios tienen que unirse antes de que puedan ser ascendidos al rol de administrador.',
            'usage' => 'Cuántas veces se puede utilizar el enlace de invitación antes de que quede inactivo.',
        ],
        'unlimited_validity'    => 'Ilimitado',
        'usages'                => [
            'five'      => '5 usos',
            'no_limit'  => 'Ilimitado',
            'once'      => '1 uso',
            'ten'       => '10 usos',
        ],
    ],
    'leave'                             => [
        'action'            => 'Salir de la campaña',
        'confirm'           => '¿Seguro que quieres abandonar la campaña :name? No tendrás acceso a ella, a no ser que un administrador te invite de nuevo.',
        'confirm-button'    => 'Sí, abandonar la campaña',
        'error'             => 'No puedes abandonar la campaña.',
        'fix'               => 'Ir a los miembros de la campaña',
        'no-admin-left'     => 'No es posible salir de la campaña porque hacerlo la dejaría sin administradores. Agrega otro miembro al rol de administrador primero.',
        'success'           => 'Has abandonado la campaña.',
        'title'             => 'Saliendo de la campaña',
    ],
    'members'                           => [
        'actions'               => [
            'remove'        => 'Quitar de la campaña',
            'switch'        => 'Ver como',
            'switch-back'   => 'Volver a mi usuario',
            'switch-entity' => 'Ver como',
        ],
        'fields'                => [
            'banned'        => 'El usuario está baneado',
            'joined'        => 'Inscrito',
            'last_login'    => 'Última conexión',
            'name'          => 'Usuario',
            'role'          => 'Rol',
            'roles'         => 'Roles',
        ],
        'helpers'               => [
            'switch'    => 'Ver como este usuario',
        ],
        'impersonating'         => [
            'message'   => 'Estás viendo la campaña como otro usuario. Algunas funcionalidades están deshabilitadas, pero el resto actúa exactamente como el usuario lo vería. Para volver a tu usuario, usa el botón "Volver a mi usuario" cerca del botón de Cerrar Sesión.',
            'title'     => 'Estás viendo como :name',
        ],
        'invite'                => [
            'description'   => 'Puedes invitar a tus amigos a unirse a la campaña mediante un enlace de invitación. Una vez acepten la invitación, se añadirán con su rol correspondiente. También puedes enviarles la invitación por correo electrónico, siempre y cuando no sea una dirección de Hotmail, ya que siempre rechazan los mails de Kanka.',
            'more'          => 'Puedes añadir más roles desde la :link.',
            'title'         => 'Invitaciones',
        ],
        'removal'               => 'Estás eliminando a ":member" de la campaña.',
        'roles'                 => [
            'member'    => 'Miembro',
            'owner'     => 'Administrador',
            'player'    => 'Jugador',
            'public'    => 'Público',
            'viewer'    => 'Invitado',
        ],
        'switch_back_success'   => 'Has vuelto a tu usuario.',
    ],
    'mentions'                          => [
        'private'   => 'Ocultar el nombre del objetivo',
        'visible'   => 'Mostrar el nombre del objetivo',
    ],
    'modules'                           => [
        'permission-disabled'   => 'Este módulo está deshabilitado.',
    ],
    'open_campaign'                     => [],
    'options'                           => [],
    'overview'                          => [
        'entity-count'      => '{0} Sin entidades|{1} :amount entidad|[2,*] :amount entidades',
        'follower-count'    => '{0} Sin seguidores|{1} :amount seguidor|[2,*] :amount seguidores',
    ],
    'panels'                            => [
        'dashboard' => 'Tablero',
        'permission'=> 'Permisos',
        'setup'     => 'Configuración',
        'sharing'   => 'Compartir',
        'systems'   => 'Sistemas',
        'ui'        => 'Interfaz',
    ],
    'placeholders'                      => [
        'locale'    => 'Código de idioma',
        'name'      => 'El nombre de tu campaña',
        'system'    => 'D&D 5e, Pathfinder, Fate...',
    ],
    'privacy'                           => [
        'hidden'    => 'Oculta',
        'private'   => 'Privada',
        'visible'   => 'Visible',
    ],
    'public'                            => [
        'helpers'   => [
            'introduction'  => 'Las campañas son privadas por defecto, pero se pueden hacer públicas. De esta forma todo el mundo podrá acceder a ellas y aparecerán en la página de :public-campaigns si tienen entidades visibles para el rol :public-role. Una campaña pública es visible para todos, pero para que su contenido se pueda ver, hay que configurar los permisos del rol :public-role.',
        ],
    ],
    'roles'                             => [
        'actions'       => [
            'add'           => 'Añadir un rol',
            'duplicate'     => 'Duplicar rol',
            'permissions'   => 'Configurar permisos',
            'rename'        => 'Renombrar rol',
            'save'          => 'Guardar rol',
        ],
        'admin_role'    => 'rol de administrador',
        'bulks'         => [
            'delete'    => '{1} :count rol eliminado.|[2,*] :count roles eliminados.',
            'edit'      => '{1} :count rol actualizado.|[2,*] :count roles actualizados.',
        ],
        'create'        => [
            'success'   => 'Rol creado.',
            'title'     => 'Crear un nuevo rol en :name',
        ],
        'destroy'       => [
            'success'   => 'Rol eliminado.',
        ],
        'edit'          => [
            'success'   => 'Rol actualizado.',
            'title'     => 'Editar rol :name',
        ],
        'fields'        => [
            'copy_permissions'  => 'Copiar permisos',
            'name'              => 'Nombre',
            'permissions'       => 'Permisos',
            'type'              => 'Tipo',
            'users'             => 'Usuarios',
        ],
        'helper'        => [
            '1'                     => 'Una campaña puede tener tantos roles como se quiera. El rol "Administrador" tiene acceso automáticamente a todo dentro de una campaña, pero cada uno de los demás roles puede tener permisos específicos en diferentes tipos de entidades (personajes, lugares, etc).',
            '2'                     => 'Las entidades pueden tener permisos más afinados mediante la pestaña "Permisos" de una entidad. Esta pestaña aparece cuando tu campaña tiene varios roles o miembros.',
            '3'                     => 'Se puede usar un sistema de "exclusión", donde los roles tienen acceso a todas las entidades, y usar la casilla de "Privado" en las entidades que se quieran ocultar. O bien, pueden darse pocos permisos a los roles, y configurar cada entidad para que sea visible individualmente.',
            '4'                     => 'Las campañas mejoradas pueden tener una cantidad ilimitada de roles.',
            'permissions_helper'    => 'Duplicar todos los permisos del rol, tanto en módulos como en entidades.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'El rol "Público" tiene permisos pero la campaña es privada. Puedes ajustar esto en la pestaña Compartir al editar la campaña.',
            'empty_role'            => 'El rol aún no tiene miembros.',
            'role_admin'            => 'Los miembros del rol :name automáticamente pueden acceder a todas las entidades y características de la campaña.',
            'role_permissions'      => 'Habilitar el rol ":name" para que pueda hacer las siguientes acciones en todas las entidades.',
        ],
        'members'       => 'Miembros',
        'modals'        => [
            'details'   => [
                'campaign'  => 'Los permisos de la campaña permiten lo siguiente.',
                'entities'  => 'A continuación se muestra un resumen de los permisos de este rol.',
                'more'      => 'Para más detalles, mira nuestro tutorial en Youtube.',
                'title'     => 'Detalles de permisos',
            ],
        ],
        'permissions'   => [
            'actions'   => [
                'add'           => 'Crear',
                'dashboard'     => 'Tablero',
                'delete'        => 'Eliminar',
                'edit'          => 'Editar',
                'entity-note'   => 'Notas de entidad',
                'gallery'       => [
                    'browse'    => 'Navegar',
                    'manage'    => 'Control absoluto',
                    'upload'    => 'Subir',
                ],
                'manage'        => 'Configurar',
                'members'       => 'Miembros',
                'permission'    => 'Administrar permisos',
                'read'          => 'Ver',
                'toggle'        => 'Cambiar para todos',
            ],
            'helpers'   => [
                'add'           => 'Permite crear entidades de este tipo. Podrán ver y editar las entidades que creen aunque no tengan el permiso de ver o editar.',
                'dashboard'     => 'Permite editar los tableros y sus widgets.',
                'delete'        => 'Permite eliminar todas las entidades de este tipo.',
                'edit'          => 'Permite editar todas las entidades de este tipo.',
                'entity_note'   => 'Esto permite que los usuarios que no tengan permisos para editar una entidad puedan añadirle notas.',
                'gallery'       => [
                    'browse'    => 'Permite ver la galería y establecer la imagen de una entidad desde la galería.',
                    'manage'    => 'Permite todo en la galería como un administrador puede, incluyendo la edición y eliminación de imágenes.',
                    'upload'    => 'Permite subir imágenes a la galería. Sólo verá las imágenes que han subido si no se combina con el permiso de navegación.',
                ],
                'manage'        => 'Permite editar la campaña como un administrador, excepto eliminar la campaña.',
                'members'       => 'Permite invitar nuevos miembros a la campaña.',
                'not_public'    => 'La campaña no es pública. Se pueden establecer permisos para el rol público, pero serán ignorados. Edita la campaña para hacerla pública.',
                'permission'    => 'Permite configurar los permisos de las entidades de este tipo que puedan editar.',
                'read'          => 'Permite visualizar todas las entidades de este tipo que no sean privadas.',
            ],
        ],
        'placeholders'  => [
            'name'  => 'Nombre del rol',
        ],
        'title'         => 'Roles de la campaña :name',
        'types'         => [
            'owner'     => 'Administrador',
            'public'    => 'Público',
            'standard'  => 'Estándar',
        ],
        'users'         => [
            'actions'   => [
                'add'           => 'Añadir miembro',
                'remove'        => ':user del rol :role',
                'remove_user'   => 'Quitar usuario del rol',
            ],
            'create'    => [
                'success'   => 'Usuario añadido al rol.',
                'title'     => 'Añadir un miembro al rol :name',
            ],
            'destroy'   => [
                'success'   => 'Usuario eliminado del rol.',
            ],
            'errors'    => [
                'cant_kick_admins'  => 'Para evitar abusos, no es posible eliminar a otros miembros del rol de :admin de la campaña. En caso de problemas, contáctanos en :discord o en :email.',
                'needs_more_roles'  => 'Debes agregarte a otro rol en la campaña antes de poder eliminarte del rol de :admin.',
            ],
            'fields'    => [
                'name'  => 'Nombre',
            ],
        ],
    ],
    'settings'                          => [
        'actions'       => [
            'enable'    => 'Habilitar',
        ],
        'boosted'       => 'Esta función está en beta y actualmente solo está disponible para las :boosted.',
        'deprecated'    => [
            'help'  => 'Este módulo está obsoleto, lo que significa que ya no recibe mantenimiento y que no se prueba con cada nueva actualización. Usa este módulo con el conocimiento de que eventualmente se eliminará de Kanka.',
            'title' => 'Obsoleto',
        ],
        'disabled'      => 'El módulo :module está deshabilitado.',
        'enabled'       => 'El módulo :module está habilitado.',
        'errors'        => [
            'module-disabled'   => 'El módulo solicitado está actualmente deshabilitado en la configuración de la campaña. :fix.',
        ],
        'helpers'       => [
            'abilities'         => 'Crea habilidades, proezas, hechizos o poderes y asígnalos a entidades.',
            'assets'            => 'Sube archivos, establece enlaces y define alias para entidades individuales.',
            'bookmarks'         => 'Crea marcadores de entidades o listas filtradas que aparezcan en la barra lateral.',
            'calendars'         => 'El sitio para definir los calendarios de tu mundo.',
            'characters'        => 'Las personas que viven en tu mundo.',
            'conversations'     => 'Conversaciones ficticias entre personajes o entre usuarios de la campaña.',
            'creatures'         => 'Crea las criaturas, animales y monstruos de tu mundo con el módulo de criaturas.',
            'dice_rolls'        => 'Una manera de manejar las tiradas de dados para aquellos que usan Kanka para campañas de rol.',
            'entity_attributes' => 'Lleva un control de los atributos de las entidades de la campaña, por ejemplo, HP o VELOCIDAD.',
            'events'            => 'Celebraciones, festivales, desastres, cumpleaños, guerras...',
            'families'          => 'Clanes o familias, sus relaciones y sus miembros.',
            'inventories'       => 'Gestiona el inventario de tus entidades.',
            'items'             => 'Armas, vehículos, reliquias, pociones...',
            'journals'          => 'Observaciones escritas por los personajes, o preparación de la sesión del máster.',
            'locations'         => 'Planetas, planos, continentes, ríos, estados, asentamientos, templos, tabernas...',
            'maps'              => 'Sube mapas con diferentes capas y marcadores que señalen a otras entidades de la campaña.',
            'notes'             => 'Tradiciones, religiones, historia, magia, razas...',
            'organisations'     => 'Sectas, unidades militares, facciones, gremios...',
            'quests'            => 'Para llevar un seguimiento de varias misiones con personajes y localizaciones.',
            'races'             => 'Si tu campaña tiene más de una raza, de esta forma no las perderás de vista.',
            'tags'              => 'Cada entidad puede tener varias etiquetas. Éstas pueden pertenecer a otras etiquetas, y las entradas pueden filtrarse por etiqueta.',
            'timelines'         => 'Representa la historia de tu mundo con líneas de tiempo.',
        ],
    ],
    'sharing'                           => [
        'filters'   => 'Las campañas públicas son visibles en la página :public-campaigns. Rellenar estos campos facilita que las personas descubran la campaña.',
        'language'  => 'El idioma en el que está escrito el contenido de la campaña.',
        'system'    => 'Si juegas un TTRPG, el sistema usado para jugar en la campaña.',
    ],
    'show'                              => [
        'actions'   => [
            'edit'  => 'Editar campaña',
        ],
        'tabs'      => [
            'achievements'      => 'Logros',
            'applications'      => 'Solicitudes',
            'customisation'     => 'Personalización',
            'danger'            => 'Peligro',
            'data'              => 'Datos',
            'default-images'    => 'Imágenes por defecto',
            'deletion'          => 'Eliminación',
            'export'            => 'Exportar',
            'import'            => 'Importar',
            'logs'              => 'Registros',
            'management'        => 'Gestión',
            'members'           => 'Miembros',
            'modules'           => 'Módulos',
            'plugins'           => 'Plugins',
            'recovery'          => 'Recuperación',
            'roles'             => 'Roles',
            'sidebar'           => 'Configuración de la barra lateral',
            'stats'             => 'Estadísticas',
            'styles'            => 'Personalización',
            'webhooks'          => 'Webhooks',
        ],
        'title'     => 'Campaña :name',
    ],
    'status'                            => [
        'free'      => 'Funciones Premium desactivadas.',
        'legacy'    => [
            'title' => 'Funciones mejoradas (antiguas)',
        ],
        'premium'   => 'Funciones premium desbloqueadas por :name.',
        'title'     => 'Funciones Premium',
    ],
    'superboosted'                      => [],
    'themes'                            => [
        'none'  => 'Ninguno (el valor predeterminado es configuraciónes de usuario)',
    ],
    'ui'                                => [
        'collapsed'         => [
            'collapsed' => 'Colapsar/Expandir',
            'default'   => 'Por defecto',
        ],
        'connections'       => [
            'explorer'  => 'Explorador de relaciones (solo campañas mejoradas)',
            'list'      => 'Interfaz de lista',
        ],
        'descendants'       => [
            'all'       => 'Mostrar todos los descendientes por defecto',
            'direct'    => 'Mostrar descendientes directos por defecto',
        ],
        'entity_history'    => [
            'hidden'    => 'Solo visible para los administradores de campaña',
            'visible'   => 'Visible para los miembros',
        ],
        'fields'            => [
            'connections'       => 'Interfaz de conexiones entre entidades por defecto',
            'connections_mode'  => 'Modo del explorador de relaciones predeterminado',
            'descendants'       => 'Filtrado de los descendientes',
            'entity_history'    => 'Registros históricos de la entidad',
            'member_list'       => 'Lista de miembros de la campaña',
            'post_collapsed'    => 'Valor de colapsado/expandido por defecto de los posts',
        ],
        'helpers'           => [
            'connections'       => 'Al hacer clic en la subpágina de conexiones de una entidad, selecciona la interfaz por defecto.',
            'connections_mode'  => 'Al ver el explorador de relaciones de una entidad, defina el modo seleccionado por defecto.',
            'descendants'       => 'Controla el filtrado por defecto al cargar una sublista. Por ejemplo, los personajes de una ubicación.',
            'entity-history'    => 'Controla quién puede ver los cambios realizados recientemente en cada entidad de la campaña.',
            'member-list'       => 'Controla quién puede ver a los miembros de la campaña.',
            'other'             => 'Otras opciones visuales para la campaña.',
            'post_collapsed'    => 'Al crear un nuevo post en una entidad, selecciona si estará colapsado o expandido por defecto.',
            'theme'             => 'Muestra la campaña en el tema del usuario u oblíguela mostrarse en uno de los siguientes temas.',
        ],
        'members'           => [
            'hidden'    => 'Solo visible para administradores de campaña',
            'visible'   => 'Visible para miembros',
        ],
        'other'             => 'Otros',
    ],
    'visibilities'                      => [
        'private'   => 'Privada',
        'public'    => 'Pública',
        'review'    => 'Esperando revisión',
    ],
    'warning'                           => [],
];
