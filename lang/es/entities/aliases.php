<?php

return [
    'actions'       => [
        'add'   => 'Añadir un alias',
    ],
    'create'        => [
        'helper'    => 'Crea un alias para :name, que permitirá encontrarle en la búsqueda global y mediante menciones :code.',
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
    'pitch'         => 'Crea alias para esta entidad que te permitan encontrarla fácilmente a través de la búsqueda y de menciones.',
    'placeholders'  => [
        'name'  => 'Nuevo alias',
    ],
    'unboosted'     => [],
    'update'        => [
        'success'   => 'Alias :name de :entity actualizado.',
        'title'     => 'Actualizar alias de :name',
    ],
];
