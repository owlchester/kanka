<?php

return [
    'actions'       => [
        'current'   => 'Tema actual: :theme',
        'disable'   => 'Desactivar',
        'enable'    => 'Activar',
        'new'       => 'Nuevo estilo',
    ],
    'bulks'         => [
        'delete'    => '{1} :count estilo eliminados.|[2,*] :count estilos eliminados .',
        'disable'   => '{1} :count estilo desactivado.|[2,*] :count estilos desactivados.',
        'enable'    => '{1} :count estilo activado.|[2,*] :count estilos activados.',
    ],
    'create'        => [
        'success'   => 'Se ha creado el nuevo estilo.',
        'title'     => 'Nuevo estilo',
    ],
    'delete'        => [
        'success'   => 'Se ha eliminado el estilo :name.',
    ],
    'errors'        => [
        'max_content'   => 'La regla CSS no puede tener más de :amount caracteres.',
        'max_reached'   => 'Número máximo de estilos (:max) alcanzado.',
    ],
    'fields'        => [
        'content'       => 'Regla CSS',
        'is_enabled'    => 'Habilitado',
        'length'        => 'Longitud',
        'modified'      => 'Modificado',
        'name'          => 'Nombre',
        'order'         => 'Orden',
    ],
    'helpers'       => [
        'here'          => 'en nuestro blog',
        'is_enabled'    => 'Habilita este tema en todas las páginas.',
        'main'          => 'Puedes crear estilos CSS personalizados para tu campaña mejorada. Estos estilos se cargan después de los temas del marketplace que hayas habilitado para la campaña. Puedes saber más sobre cómo aplicar estilos a tu campaña :here.',
    ],
    'pitch'         => 'Crea estilos CSS personalizados para cambiar por completo el aspecto de la campaña.',
    'placeholders'  => [
        'name'  => 'Nombre del estilo',
    ],
    'reorder'       => [
        'save'      => 'Guardar nuevo orden',
        'success'   => '{1} :count estilos reordenados.|[2,*] :count estilos reordenados.',
        'title'     => 'Reordenar estilos',
    ],
    'theme'         => [
        'none'      => 'Utilizar las preferencias del usuario',
        'override'  => 'Sobrescribir tema',
        'success'   => 'Tema de campaña actualizado.',
        'title'     => 'Actualizar el tema de la campaña',
    ],
    'title'         => 'Personalizar la campaña',
    'update'        => [
        'success'   => 'Se ha actualizado el estilo :name.',
        'title'     => 'Actualizar estilo',
    ],
];
