<?php

return [
    'actions'       => [
        'bulks'             => [
            'disable'   => 'Desactivar plugins',
            'enable'    => 'Activar plugins',
            'update'    => 'Actualizar plugins',
        ],
        'changelog'         => 'Registro de cambios',
        'disable'           => 'Desactivar plugin',
        'enable'            => 'Activar plugin',
        'go_to_marketplace' => 'Ir a la tienda',
        'import'            => 'Importar',
        'update'            => 'Actualizar plugin',
        'update_available'  => '¡Actualización disponible!',
    ],
    'bulks'         => [
        'delete'    => '{1} :count plugin eliminado.|[2,*] :count plugins eliminados.',
        'disable'   => '{1} :count plugin desactivado.|[2,*] :count plugins desactivados.',
        'enable'    => '{1} :count plugin activado.|[2,*] :count plugins activados.',
        'update'    => '{1} :count plugin actualizado.|[2,*] :count plugins actualizados.',
    ],
    'destroy'       => [
        'success'   => 'Se ha eliminado el plugin :plugin.',
    ],
    'disabled'      => [
        'success'   => 'Se ha desactivado el plugin :plugin.',
    ],
    'empty_list'    => 'Esta campaña no contiene ningún plugin actualmente. Dirígete a la tienda para instalar alguno y vuelve para activarlo.',
    'enabled'       => [
        'success'   => 'Se ha activado el plugin :plugin.',
    ],
    'errors'        => [
        'invalid_plugin'    => 'Plugin no válido.',
    ],
    'fields'        => [
        'name'      => 'Nombre del plugin',
        'obsolete'  => 'Este plugin ha sido marcado como obsoleto por el equipo de Kanka, lo que significa que ya no funciona como su creador pretendía originalmente.',
        'status'    => 'Estatus',
        'type'      => 'Tipo de plugin',
    ],
    'import'        => [
        'button'                => 'Importar',
        'created'               => 'Se han creado las siguientes entidades:',
        'helper'                => 'Se van a importar :count entidades del plugin :plugin. Si este plugin ya estaba importado, los cambios que hayas hecho a las entidades importadas podrían perderse.',
        'no_new_entities'       => 'No hay nuevas entidades que importar.',
        'option_only_import'    => 'Importa solo las entidades nuevas, omitiendo las previamente importadas.',
        'option_private'        => 'Importa todas las entidades como privadas.',
        'success'               => '{1} Se ha importado :count entidad del plugin :plugin.|[2,*] Se han importado :count entidades del plugin :plugin.',
        'title'                 => 'Importar :plugin',
        'updated'               => 'Se han actualizado las siguientes entidades:',
    ],
    'info'          => [
        'helper'        => 'Cuando salga una nueva versión de un plugin, puedes actualizarla a la nueva versión.',
        'title'         => 'Actualitzaciones del plugin :plugin',
        'updates'       => 'Actualizaciones',
        'your_version'  => 'Tu versión',
    ],
    'pitch'         => 'Instale y gestione plugins desde el :marketplace.',
    'status'        => [
        'disabled'  => 'Desactivado',
        'enabled'   => 'Activado',
    ],
    'templates'     => [
        'name'  => ':name hecha por :user',
    ],
    'title'         => 'Plugins de la campaña :name',
    'types'         => [
        'attribute' => 'Plantilla de atributos',
        'pack'      => 'Pack de contenido',
        'theme'     => 'Tema',
    ],
    'update'        => [
        'success'   => 'Se ha actualizado el plugin :plugin.',
    ],
];
