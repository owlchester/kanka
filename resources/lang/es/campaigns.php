<?php

return [
    'create'                            => [
        'description'           => 'Crear nueva campaña',
        'helper'                => [
            'title'     => '¡Te damos la bienvenida a :name!',
            'welcome'   => <<<'TEXT'
Antes de continuar, necesitas un nombre para tu campaña. Este será el nombre de tu mundo. Si no tienes un buen nombre aún, no te preocupes, pues puedes cambiarlo más tarde o crear nuevas campañas.

¡Gracias por unirte a Kanka, y te damos la bienvenida a nuestra floreciente comunidad!
TEXT
,
        ],
        'success'               => 'Campaña creada.',
        'success_first_time'    => '¡La campaña ha sido creada! Como es tu primera campaña, hemos rellenado algunas cosas para que te familiarices y con suerte proveerte con algo de inspiración, para que veas que puedes conseguir.',
        'title'                 => 'Nueva campaña',
    ],
    'destroy'                           => [
        'success'   => 'Campaña eliminada.',
    ],
    'edit'                              => [
        'description'   => 'Modifica la campaña',
        'success'       => 'Campaña actualizada.',
        'title'         => 'Editar campaña :campaign',
    ],
    'entity_personality_visibilities'   => [
        'private'   => 'La personalidad de los personajes nuevos es privada por defecto.',
    ],
    'entity_visibilities'               => [
        'private'   => 'Nuevas entidades privadas por defecto',
    ],
    'errors'                            => [
        'access'        => 'No tienes acceso a esta campaña.',
        'unknown_id'    => 'Campaña desconocida.',
    ],
    'export'                            => [
        'description'   => 'Exportar la campaña',
        'errors'        => [
            'limit' => 'Has alcanzado el máximo de una exportación por día. Por favor, inténtalo de nuevo mañana.',
        ],
        'helper'        => 'Exporta la campaña. Recibirás una notificación con el enlace de descarga.',
        'success'       => 'Tu campaña se está preparando para exportar. Recibirás una notificación en Kanka a un zip descargable en cuanto esté lista.',
        'title'         => 'Exportar campaña :name',
    ],
    'fields'                            => [
        'boosted'                       => 'Mejorada por',
        'css'                           => 'CSS',
        'description'                   => 'Descripción',
        'entity_count'                  => 'Número de entidades',
        'entity_personality_visibility' => 'Visibilidad de la personalidad',
        'entity_visibility'             => 'Visibilidad de la entidad',
        'excerpt'                       => 'Extracto',
        'followers'                     => 'Seguidores',
        'header_image'                  => 'Imagen de cabecera',
        'hide_history'                  => 'Esconder historial de entidades',
        'hide_members'                  => 'Esconder miembros de la campaña',
        'image'                         => 'Imagen',
        'locale'                        => 'Idioma',
        'name'                          => 'Nombre',
        'public_campaign_filters'       => 'Filtros de las campañas públicas',
        'rpg_system'                    => 'Sistemas RPG',
        'system'                        => 'Sistema',
        'theme'                         => 'Tema',
        'tooltip_family'                => 'Deshabilitar nombres familiares en la previsualización emergente',
        'tooltip_image'                 => 'Mostrar la imagen de la entidad en la previsualización emergente',
        'visibility'                    => 'Visibilidad',
    ],
    'following'                         => 'Siguiendo',
    'helpers'                           => [
        'boost_required'                => 'Esta funcionalidad requiere mejorar la campaña. Más información en la página de :settings.',
        'boosted'                       => 'Algunas características están desbloqueadas porque esta campaña está mejorada. Para saber más sobre esto, echa un vistazo en la página de :settings.',
        'css'                           => 'Escribe tu propio CSS para las páginas de tu campaña. Ten en cuenta que abusar de esta herramienta puede llevar a la eliminación de tu CSS personalizado. Incumplimientos repetidos o graves pueden llevar a la eliminación de tu campaña.',
        'entity_personality_visibility' => 'Al crear un nuevo personaje, la opción de "Personalidad visible" estará deseleccionada automáticamente.',
        'entity_visibility'             => 'Al crear una nueva entidad, se seleccionará automáticamente la opción de "Privada".',
        'excerpt'                       => 'El extracto de la campaña se mostrará en el tablero principal. Escribe unas pocas líneas para introducir tu mundo.',
        'hide_history'                  => 'Habilita esta opción para esconder el historial de entidades a los miembros no administradores.',
        'hide_members'                  => 'Habilita esta opción para esconder la lista de miembros de la campaña a los no administradores.',
        'locale'                        => 'El idioma en que está escrita tu campaña. Esto se usa para generar contenido y agrupar campañas públicas.',
        'name'                          => 'Tu campaña/mundo puede tener cualquier nombre, siempre y cuando contenga al menos 4 letras o números.',
        'public_campaign_filters'       => 'Facilita que otros encuentren tu campaña entre las demás proporcionando la siguiente información.',
        'system'                        => 'Si tu campaña es visible públicamente, el sistema se mostrará en la página de :link.',
        'systems'                       => 'Para evitar líos, algunos elementos de Kanka solo están disponibles en sistemas RPG específicos (por ejemplo, el bloque de stats de monstruo de D&D 5e). Si eliges un sistema soportado, se activarán dichos elementos.',
        'theme'                         => 'Establece un tema único para la campaña, anulando las preferencias de los usuarios.',
        'view_public'                   => 'Para ver tu campaña como lo haría un visitante público, abre un :link en una ventana de incógnito.',
        'visibility'                    => 'Hacer pública una campaña implica que todos los que tengan el enlace a ella la podrán ver.',
    ],
    'index'                             => [
        'actions'   => [
            'new'   => [
                'title' => 'Nueva campaña',
            ],
        ],
        'title'     => 'Campañas',
    ],
    'invites'                           => [
        'actions'               => [
            'add'   => 'Invitar',
            'copy'  => 'Copiar el enlace al portapapeles',
            'link'  => 'Nuevo enlace',
        ],
        'create'                => [
            'button'        => 'Invitar',
            'description'   => 'Invita a un amigo a tu campaña',
            'link'          => 'Enlace creado: <a href=":url" target="_blank">:url</a>',
            'success'       => 'Invitación enviada.',
            'title'         => 'Invita a alguien a tu campaña',
        ],
        'destroy'               => [
            'success'   => 'Invitación eliminada.',
        ],
        'email'                 => [
            'link'      => '<a href=":link">Unirse a la campaña de :name </a>',
            'subject'   => '¡:name te ha invitado a que te unas a su campaña ":campaign" en kanka.io! Usa el siguiente enlace para aceptar su invitación.',
            'title'     => 'Invitación de :name',
        ],
        'error'                 => [
            'already_member'    => 'Ya eres miembro de esta campaña.',
            'inactive_token'    => 'Este identificador ya se ha usado o la campaña ya no existe.',
            'invalid_token'     => 'El identificador ya no es válido.',
            'login'             => 'Inicia sesión o regístrate para unirte a la campaña.',
        ],
        'fields'                => [
            'created'   => 'Enviado',
            'email'     => 'Correo electrónico',
            'role'      => 'Rol',
            'type'      => 'Tipo',
            'validity'  => 'Validez',
        ],
        'helpers'               => [
            'email'     => 'Puede ser que nuestros correos se marquen como spam y pueden tardar unas horas hasta aparecer en tu buzón de entrada.',
            'validity'  => 'Cuántos usuarios pueden usar este enlace antes de que se desactive. Déjalo en blanco para que sea ilimitado.',
        ],
        'placeholders'          => [
            'email' => 'Correo electrónico de la persona a la que quieres invitar',
        ],
        'types'                 => [
            'email' => 'Correo electrónico',
            'link'  => 'Enlace',
        ],
        'unlimited_validity'    => 'Ilimitado',
    ],
    'leave'                             => [
        'confirm'   => '¿Seguro que quieres abandonar la campaña :name? No tendrás acceso a ella, a no ser que un administrador te invite de nuevo.',
        'error'     => 'No puedes abandonar la campaña.',
        'success'   => 'Has abandonado la campaña.',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'Ver como',
            'switch-back'   => 'Volver a mi usuario',
        ],
        'create'                => [
            'title' => 'Añade un miembro a la campaña',
        ],
        'description'           => 'Gestionar miembros de la campaña',
        'edit'                  => [
            'description'   => 'Editar un miembro de la campaña',
            'title'         => 'Editar miembro :name',
        ],
        'fields'                => [
            'joined'        => 'Inscrito',
            'last_login'    => 'Última conexión',
            'name'          => 'Usuario',
            'role'          => 'Rol',
            'roles'         => 'Roles',
        ],
        'help'                  => 'No hay límite de miembros que puede tener una campaña.',
        'helpers'               => [
            'admin' => 'Como administrador de la campaña, puedes invitar a nuevos usuarios, eliminar usuarios inactivos y cambiar sus permisos. Para probar los permisos de un miembro, haz clic en "Ver como". Puedes leer más sobre esta herramienta en :link.',
            'switch'=> 'Ver como este usuario',
        ],
        'impersonating'         => [
            'message'   => 'Estás viendo la campaña como otro usuario. Algunas funcionalidades están deshabilitadas, pero el resto actúa exactamente como el usuario lo vería. Para volver a tu usuario, usa el botón "Volver a mi usuario" cerca del botón de Cerrar Sesión.',
            'title'     => 'Estás viendo como :name',
        ],
        'invite'                => [
            'description'   => 'Puedes invitar a tus amigos a unirse a la campaña mediante un enlace de invitación. Una vez acepten la invitación, se añadirán con su rol correspondiente. También puedes enviarles la invitación por correo electrónico, siempre y cuando no sea una dirección de Hotmail, ya que siempre rechazan los mails de Kanka.',
            'more'          => 'Puedes añadir más roles desde la :link.',
            'roles_page'    => 'Página de roles',
            'title'         => 'Invitaciones',
        ],
        'roles'                 => [
            'member'    => 'Miembro',
            'owner'     => 'Administrador',
            'player'    => 'Jugador',
            'public'    => 'Público',
            'viewer'    => 'Invitado',
        ],
        'switch_back_success'   => 'Has vuelto a tu usuario.',
        'title'                 => 'Miembros de la campaña :name',
        'your_role'             => 'Tu rol: <i>:role</i>',
    ],
    'panels'                            => [
        'boosted'   => 'Mejoras',
        'dashboard' => 'Tablero',
        'permission'=> 'Permisos',
        'sharing'   => 'Compartir',
        'systems'   => 'Sistemas',
        'ui'        => 'Interfaz',
    ],
    'placeholders'                      => [
        'description'   => 'Un breve resumen de tu campaña',
        'locale'        => 'Código de idioma',
        'name'          => 'El nombre de tu campaña',
        'system'        => 'D&D 5e, Pathfinder, Fate...',
    ],
    'roles'                             => [
        'actions'       => [
            'add'   => 'Añadir un rol',
        ],
        'create'        => [
            'success'   => 'Rol creado.',
            'title'     => 'Crear un nuevo rol en :name',
        ],
        'description'   => 'Gestionar los roles de la campaña',
        'destroy'       => [
            'success'   => 'Rol eliminado.',
        ],
        'edit'          => [
            'success'   => 'Rol actualizado.',
            'title'     => 'Editar rol :name',
        ],
        'fields'        => [
            'name'          => 'Nombre',
            'permissions'   => 'Permisos',
            'type'          => 'Tipo',
            'users'         => 'Usuarios',
        ],
        'helper'        => [
            '1' => 'Una campaña puede tener tantos roles como se quiera. El rol "Administrador" tiene acceso automáticamente a todo dentro de una campaña, pero cada uno de los demás roles puede tener permisos específicos en diferentes tipos de entidades (personajes, lugares, etc).',
            '2' => 'Las entidades pueden tener permisos más afinados mediante la pestaña "Permisos" de una entidad. Esta pestaña aparece cuando tu campaña tiene varios roles o miembros.',
            '3' => 'Se puede usar un sistema de "exclusión", donde los roles tienen acceso a todas las entidades, y usar la casilla de "Privado" en las entidades que se quieran ocultar. O bien, pueden darse pocos permisos a los roles, y configurar cada entidad para que sea visible individualmente.',
        ],
        'hints'         => [
            'campaign_not_public'   => 'El rol "Público" tiene permisos pero la campaña es privada. Puedes ajustar esto en la pestaña Compartir al editar la campaña.',
            'public'                => 'El rol "Público" se usa para los que visitan tu campaña pública.',
            'role_permissions'      => 'Habilitar el rol ":name" para que pueda hacer las siguientes acciones en todas las entidades.',
        ],
        'members'       => 'Miembros',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Crear',
                'delete'        => 'Eliminar',
                'edit'          => 'Editar',
                'entity-note'   => 'Notas de entidad',
                'permission'    => 'Administrar permisos',
                'read'          => 'Ver',
                'toggle'        => 'Cambiar para todos',
            ],
            'helpers'   => [
                'entity_note'   => 'Esto permite que los usuarios que no tengan permisos para editar una entidad puedan añadirle notas.',
            ],
            'hint'      => 'Este rol tiene acceso automático a todo.',
        ],
        'placeholders'  => [
            'name'  => 'Nombre del rol',
        ],
        'show'          => [
            'description'   => 'Miembros y permisos de un rol de campaña',
            'title'         => 'Rol ":role"',
        ],
        'title'         => 'Roles de la campaña :name',
        'types'         => [
            'owner'     => 'Administrador',
            'public'    => 'Público',
            'standard'  => 'Estándar',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Añadir miembro',
            ],
            'create'    => [
                'success'   => 'Usuario añadido al rol.',
                'title'     => 'Añadir un miembro al rol :name',
            ],
            'destroy'   => [
                'success'   => 'Usuario eliminado del rol.',
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
        'description'   => 'Habilitar o deshabilitar módulos de la campaña.',
        'edit'          => [
            'success'   => 'Ajustes de campaña actualizados.',
        ],
        'helper'        => 'Puedes activar o desactivar fácilmente todos los módulos de una campaña. Desactivar un módulo solo ocultará sus elementos relacionados, no los eliminará. Este cambio afecta a todos los usuarios de una campaña, incluyendo a los Administradores.',
        'helpers'       => [
            'abilities'     => 'Crea habilidades, proezas, hechizos o poderes y asígnalos a entidades.',
            'calendars'     => 'El sitio para definir los calendarios de tu mundo.',
            'characters'    => 'Las personas que viven en tu mundo.',
            'conversations' => 'Conversaciones ficticias entre personajes o entre usuarios de la campaña.',
            'dice_rolls'    => 'Una manera de manejar las tiradas de dados para aquellos que usan Kanka para campañas de rol.',
            'events'        => 'Celebraciones, festivales, desastres, cumpleaños, guerras...',
            'families'      => 'Clanes o familias, sus relaciones y sus miembros.',
            'items'         => 'Armas, vehículos, reliquias, pociones...',
            'journals'      => 'Observaciones escritas por los personajes, o preparación de la sesión del máster.',
            'locations'     => 'Planetas, planos, continentes, ríos, estados, asentamientos, templos, tabernas...',
            'maps'          => 'Sube mapas con diferentes capas y marcadores que señalen a otras entidades de la campaña.',
            'menu_links'    => 'Enlaces de menú personalizados en la barra lateral.',
            'notes'         => 'Tradiciones, religiones, historia, magia, razas...',
            'organisations' => 'Sectas, unidades militares, facciones, gremios...',
            'quests'        => 'Para llevar un seguimiento de varias misiones con personajes y localizaciones.',
            'races'         => 'Si tu campaña tiene más de una raza, de esta forma no las perderás de vista.',
            'tags'          => 'Cada entidad puede tener varias etiquetas. Éstas pueden pertenecer a otras etiquetas, y las entradas pueden filtrarse por etiqueta.',
            'timelines'     => 'Representa la historia de tu mundo con líneas de tiempo.',
        ],
        'title'         => 'Módulos de la campaña :name',
    ],
    'show'                              => [
        'actions'       => [
            'boost' => 'Mejorar campaña',
            'edit'  => 'Editar campaña',
            'leave' => 'Abandonar campaña',
        ],
        'description'   => 'Vista detallada de la campaña',
        'tabs'          => [
            'default-images'    => 'Imágenes por defecto',
            'export'            => 'Exportar',
            'information'       => 'Información',
            'members'           => 'Miembros',
            'menu'              => 'Menú',
            'plugins'           => 'Plugins',
            'recovery'          => 'Recuperación',
            'roles'             => 'Roles',
            'settings'          => 'Módulos',
        ],
        'title'         => 'Campaña :name',
    ],
    'ui'                                => [
        'helper'    => 'Estas opciones cambian la forma en la que algunos elementos se muestran en la campaña.',
    ],
    'visibilities'                      => [
        'private'   => 'Privada',
        'public'    => 'Pública',
        'review'    => 'Esperando revisión',
    ],
];
