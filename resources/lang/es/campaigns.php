<?php

return [
    'create'                            => [
        'description'           => 'Crear nueva campaña',
        'helper'                => [
            'first' => '¡Gracias por probar nuestra web! Antes de que prosigamos, necesitamos que nos indiques algo muy simple: el nombre de tu <b> campaña </b>. El nombre de tu mundo que lo separa de los demás, así que tiene que ser único. Si aun no se te ocurre ninguno, no te preocupes, siempre <b>puedes cambiarlo despues</b>, o crear otras campañas.',
            'second'=> '¡Pero basta de parloteo! Así que... ¿cual escogerás?',
            'title' => '¡Bienvenid@ a :name!',
        ],
        'success'               => 'Campaña creada.',
        'success_first_time'    => '¡Tu campaña ha sido creada! Como es tu primera campaña, hemos rellenado algunas cosas para que te familiarices y con suerte proveerte con algo de inspiración, para que veas que puedes conseguir.',
        'title'                 => 'Nueva Campaña',
    ],
    'destroy'                           => [
        'success'   => 'Campaña eliminada',
    ],
    'edit'                              => [
        'description'   => 'Modifica tu campaña.',
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
        'helper'        => 'Exportar campaña. Recibirás una notificación con el enlace de descarga.',
        'success'       => 'Tu campaña se está preparando para exportar. Recibirás una notificación en Kanka a un zip descargable en cuanto esté lista.',
        'title'         => 'Exportar campaña :name',
    ],
    'fields'                            => [
        'description'                   => 'Descripción',
        'entity_count'                  => 'Número de entidades',
        'entity_personality_visibility' => 'Visibilidad de la personalidad',
        'entity_visibility'             => 'Visibilidad de la entidad',
        'header_image'                  => 'Imagen de cabecera',
        'image'                         => 'Imagen',
        'locale'                        => 'Idioma',
        'name'                          => 'Nombre',
        'system'                        => 'Sistema',
        'visibility'                    => 'Visibilidad',
    ],
    'helpers'                           => [
        'entity_personality_visibility' => 'Al crear un nuevo personaje, la opción de "Personalidad visible" estará deseleccionada automáticamente.',
        'entity_visibility'             => 'Al crear una nueva entidad, se seleccionará automáticamente la opción de "Privada".',
        'locale'                        => 'El idioma en que está escrita tu campaña. Esto se usa para generar contenido y agrupar campañas públicas.',
        'name'                          => 'Tu campaña/mundo puede tener cualquier nombre, siempre y cuando contenga al menos 4 letras o números.',
        'system'                        => 'Si tu campaña es visible públicamente, el sistema se mostrará en la página de :link.',
        'visibility'                    => 'Hacer pública una campaña implica que todos los que tengan el enlace a ella la podrán ver.',
    ],
    'index'                             => [
        'actions'       => [
            'new'   => [
                'description'   => 'Crear nueva campaña',
                'title'         => 'Nueva campaña',
            ],
        ],
        'add'           => 'Nueva campaña',
        'description'   => 'Gestionar tus campañas.',
        'list'          => 'Tus campañas',
        'select'        => 'Seleccionar una campaña',
        'title'         => 'Campañas',
    ],
    'invites'                           => [
        'actions'       => [
            'add'   => 'Invitar',
            'link'  => 'Nuevo enlace',
        ],
        'create'        => [
            'button'        => 'Invitar',
            'description'   => 'Invita a un amigo a tu campaña',
            'link'          => 'Enlace creado: <a href=":url" target="_blank">:url</a>',
            'success'       => 'Invitación enviada.',
            'title'         => 'Invita a alguien a tu campaña',
        ],
        'destroy'       => [
            'success'   => 'Invitación eliminada.',
        ],
        'email'         => [
            'link'      => '<a href=":link">Unirse a la campaña de :name </a>',
            'subject'   => '¡:name te ha invitado a que te unas a su campaña ":campaign" en kanka.io! Usa el siguiente enlace para aceptar su invitación.',
            'title'     => 'Invitación de :name',
        ],
        'error'         => [
            'already_member'    => 'Ya eres un miembro de esta campaña.',
            'inactive_token'    => 'Este identificador ya ha sido usado o la campaña ya no existe.',
            'invalid_token'     => 'El identificador ya no es valido.',
            'login'             => 'Por favor inicia sesión o registrate para unirte a la campaña.',
        ],
        'fields'        => [
            'created'   => 'Enviado',
            'email'     => 'Correo electrónico',
            'role'      => 'Rol',
            'type'      => 'Tipo',
            'validity'  => 'Validez',
        ],
        'helpers'       => [
            'validity'  => 'Cuántos usuarios pueden usar este enlace antes de que se desactive.',
        ],
        'placeholders'  => [
            'email' => 'Correo electrónico de la persona a la que quieres invitar',
        ],
        'types'         => [
            'email' => 'Correo electrónico',
            'link'  => 'Enlace',
        ],
    ],
    'leave'                             => [
        'confirm'   => '¿Seguro que quieres abandonar la campaña :name? No tendrás acceso a ella, a no ser que el dueño de la campaña te invite de nuevo.',
        'error'     => 'No puedes abandonar la campaña.',
        'success'   => 'Has abandonado la campaña.',
    ],
    'members'                           => [
        'actions'               => [
            'switch'        => 'Ver como',
            'switch-back'   => 'Volver a mi usuario',
        ],
        'create'                => [
            'title' => 'Añade un miembro a tu campaña.',
        ],
        'description'           => 'Gestionar miembros de la campaña',
        'edit'                  => [
            'description'   => 'Editar un miembro de tu campaña',
            'title'         => 'Editar miembro :name',
        ],
        'fields'                => [
            'joined'    => 'Inscrito',
            'name'      => 'Usuario',
            'role'      => 'Rol',
            'roles'     => 'Roles',
        ],
        'help'                  => 'No hay límite de miembros que puede tener una campaña, y como Administrador de la campaña, puedes eliminar miembros que ya no están activos.',
        'helpers'               => [
            'switch'    => 'Ver como este usuario',
        ],
        'impersonating'         => [
            'message'   => 'Estás viendo la campaña como otro usuario. Algunas funcionalidades están deshabilitadas, pero el resto actúa exactamente como el usuario lo vería. Para volver a tu usuario, usa el botón "Volver a mi usuario" cerca del botón de Cerrar Sesión.',
            'title'     => 'Estás viendo como :name',
        ],
        'invite'                => [
            'description'   => 'Puedes invitar a tus amigos a unirse a la campaña si provees su correo electrónico. Una vez acepten la invitación, les verás añadidos como "Visitante". Siempre puedes cancelar la invitación en cualquier momento.',
            'title'         => 'Invitar',
        ],
        'roles'                 => [
            'member'    => 'Miembro',
            'owner'     => 'Administrador',
            'public'    => 'Público',
            'viewer'    => 'Invitado',
        ],
        'switch_back_success'   => 'Has vuelto a tu usuario.',
        'title'                 => 'Miembros de la campaña :name',
        'your_role'             => 'Tu eres un <i>:role</i>',
    ],
    'panels'                            => [
        'permission'    => 'Permisos',
        'sharing'       => 'Compartir',
    ],
    'placeholders'                      => [
        'description'   => 'Corto resumen de tu campaña',
        'locale'        => 'Código de idioma',
        'name'          => 'Nombre de tu campaña',
        'system'        => 'D&D 5e, 3.5, Pathfinder, GURPS, DSA...',
    ],
    'roles'                             => [
        'actions'       => [
            'add'   => 'Añadir un rol',
        ],
        'create'        => [
            'success'   => 'Rol creado.',
            'title'     => 'Crear un nuevo rol para :name',
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
            '1' => 'Una campaña puede tener tantos roles como se quiera. El rol "Admin" tiene acceso automáticamente a todo dentro de una campaña, pero cada uno de los demás roles puede tener permisos específicos en diferentes tipos de entidades (personaje, localización, etc).',
            '2' => 'Las entidades pueden tener permisos más afinados mediante la pestaña "Permisos" de una entidad. Esta pestaña aparece cuando tu campaña tiene varios roles o miembros.',
            '3' => 'Se puede usar un sistema de "exclusión", donde los roles tienen acceso a todas las entidades, y usar la casilla de "Privado" en las entidades que se quieran ocultar. O bien, pueden darse pocos permisos a los roles, y configurar cada entidad para que sea visible individualmente.',
        ],
        'hints'         => [
            'public'            => 'El rol "Público" se usa para los que visitan tu campaña pública.',
            'role_permissions'  => 'Habilitar el rol \':name\' para realizar las siguientes acciones en todas las entidades.',
        ],
        'members'       => 'Miembros',
        'permissions'   => [
            'actions'   => [
                'add'           => 'Crear',
                'delete'        => 'Eliminar',
                'edit'          => 'Editar',
                'permission'    => 'Administrar permisos',
                'read'          => 'Ver',
            ],
            'hint'      => 'Este rol tiene acceso automático a todo.',
        ],
        'placeholders'  => [
            'name'  => 'Nombre del rol',
        ],
        'show'          => [
            'description'   => 'Miembros y permisos de un rol de campaña',
            'title'         => 'Roles de campaña',
        ],
        'title'         => 'Roles de la campaña :name',
        'types'         => [
            'owner'     => 'Propietario',
            'public'    => 'Público',
            'standard'  => 'Estándar',
        ],
        'users'         => [
            'actions'   => [
                'add'   => 'Añadir',
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
        'description'   => 'Habilitar o deshabilitar módulos de la campaña.',
        'edit'          => [
            'success'   => 'Ajustes de campaña actualizados.',
        ],
        'helper'        => 'Puedes activar o desactivar fácilmente todos los módulos de una campaña. Desactivar un módulo solo ocultará sus elementos relacionados, no los eliminará. Este cambio afecta a todos los usuarios de una campaña, incluyendo a los Administradores.',
        'helpers'       => [
            'calendars'     => 'El sitio para definir los calendarios de tu mundo.',
            'characters'    => 'Las personas que viven en tu mundo.',
            'conversations' => 'Conversaciones ficticias entre personajes o entre usuarios de la campaña.',
            'dice_rolls'    => 'Una manera de manejar las tiradas de dados para aquellos que usan Kanka para campañas de rol.',
            'events'        => 'Celebraciones, festivales, desastres, cumpleaños, guerras...',
            'families'      => 'Clanes o familias, sus relaciones y sus miembros.',
            'items'         => 'Armas, vehículos, reliquias, pociones...',
            'journals'      => 'Observaciones escritas por los personajes, o preparación de la sesión del máster.',
            'locations'     => 'Planetas, planos, continentes, ríos, estados, asentamientos, templos, tabernas...',
            'menu_links'    => 'Enlaces de menú personalizados en la barra lateral.',
            'notes'         => 'Tradiciones, religiones, historia, magia, razas...',
            'organisations' => 'Sectas, unidades militares, facciones, gremios...',
            'quests'        => 'Para llevar un seguimiento de varias misiones con personajes y localizaciones.',
            'races'         => 'Si tu campaña tiene más de una raza, de esta forma no las perderás de vista.',
            'tags'          => 'Cada entidad puede tener varias etiquetas. Éstas pueden pertenecer a otras etiquetas, y las entradas pueden filtrarse por etiqueta.',
        ],
        'title'         => 'Módulos de la campaña :name',
    ],
    'show'                              => [
        'actions'       => [
            'leave' => 'Abandonar campaña',
        ],
        'description'   => 'Vista detallada de la campaña',
        'tabs'          => [
            'export'        => 'Exportar',
            'information'   => 'Información',
            'members'       => 'Miembros',
            'menu'          => 'Menú',
            'roles'         => 'Roles',
            'settings'      => 'Módulos',
        ],
        'title'         => 'Campaña :name',
    ],
    'visibilities'                      => [
        'private'   => 'Privada',
        'public'    => 'Pública',
        'review'    => 'Esperando revisión',
    ],
];
