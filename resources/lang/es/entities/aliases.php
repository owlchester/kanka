<?php

return [
    'actions'       => [
        'add'   => 'Añadir un alias',
    ],
    'create'        => [
        'success'   => 'Alias :name añadido a :entity.',
        'title'     => 'Añadir un alias a :name',
    ],
    'destroy'       => [
        'success'   => 'Alias :name eliminado.',
    ],
    'fields'        => [
        'name'  => 'Nombre',
    ],
    'helpers'       => [
        'primary'   => 'Añade uno o más alias a una entidad para encontrarla mediante la búsqueda global (en la barra superior) o las menciones.',
    ],
    'placeholders'  => [
        'name'  => 'Nuevo alias',
    ],
    'unboosted'     => [
        'text'  => 'La funcionalidad de alias para búsquedas y menciones está reservada para :boosted-campaigns.',
    ],
    'update'        => [
        'success'   => 'Alias :name de :entity actualizado.',
        'title'     => 'Actualizar alias de :name',
    ],
];
