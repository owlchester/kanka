<?php

return [
    'actions'           => [
        'add'   => 'Añadir un enlace',
    ],
    'call-to-action'    => 'Añade enlaces a recursos externos en esta entidad, como a DnDBeyond, y se mostrarán directamente en la vista general de la entidad.',
    'create'            => [
        'helper'    => 'Agrega un enlace externo a :name, por ejemplo, a su página de DnDBeyond.',
        'success'   => 'Enlace :name añadido a :entity.',
        'title'     => 'Añadir un enlace a :name',
    ],
    'destroy'           => [
        'success'   => 'Enlace :name eliminado de :entity.',
    ],
    'fields'            => [
        'icon'      => 'Icono',
        'name'      => 'Nombre',
        'position'  => 'Posición',
        'url'       => 'URL',
    ],
    'go'                => [
        'actions'       => [
            'confirm'   => 'Estoy segur@',
            'trust'     => 'No me preguntes otra vez',
        ],
        'description'   => 'Este enlace le llevará a :link. ¿Estás segur@ de que deseas ir allí?',
        'title'         => 'Saliendo de Kanka',
    ],
    'helpers'           => [
        'icon'      => 'Se puede personalizar el icono mostrado en el enlace con cualquiera de los iconos gratuitos de :fontawesome. Si se deja en blanco, se usará el icono por defecto.',
        'parent'    => 'Mostrar este enlace rápido después de un elemento de la barra lateral, en lugar de en la sección de enlaces rápidos de la barra lateral.',
    ],
    'placeholders'      => [
        'name'  => 'DNDBeyond',
        'url'   => 'https://dndbeyond.com/character-url',
    ],
    'show'              => [
        'helper'    => 'Las campañas mejoradas pueden añadir enlaces en las entidades que dirigen a webs externas.',
        'title'     => 'Enlaces de :name',
    ],
    'unboosted'         => [],
    'update'            => [
        'success'   => 'Enlace :name actualizado.',
        'title'     => 'Actualizar enlace de :name',
    ],
];
