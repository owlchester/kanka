<?php

return [
    'create'        => [
        'description'   => 'Crear nuevo objeto',
        'success'       => 'Objeto ":name" creado.',
        'title'         => 'Nuevo objeto',
    ],
    'destroy'       => [
        'success'   => 'Objeto ":name" eliminado.',
    ],
    'edit'          => [
        'success'   => 'Objeto ":name" actualizado.',
        'title'     => 'Editar :name',
    ],
    'fields'        => [
        'character' => 'Personaje',
        'image'     => 'Imagen',
        'location'  => 'Localización',
        'name'      => 'Nombre',
        'price'     => 'Precio',
        'relation'  => 'Relación',
        'size'      => 'Tamaño',
        'type'      => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Nuevo objeto',
        'description'   => 'Gestiona los objetos de :name.',
        'header'        => 'Objetos de :name',
        'title'         => 'Objetos',
    ],
    'inventories'   => [
        'description'   => 'Los inventarios donde se encuentra este objeto.',
        'title'         => 'Inventarios del objeto :name',
    ],
    'placeholders'  => [
        'character' => 'Seleccionar personaje',
        'location'  => 'Elige un lugar',
        'name'      => 'Nombre del objeto',
        'price'     => 'Precio del objeto',
        'size'      => 'Tamaño, peso, dimensiones',
        'type'      => 'Arma, Poción, Artefacto...',
    ],
    'quests'        => [
        'description'   => 'Misiones en las que aparece el objeto.',
        'title'         => 'Misiones de :name',
    ],
    'show'          => [
        'description'   => 'Vista detallada del objeto',
        'tabs'          => [
            'information'   => 'Información',
            'inventories'   => 'Inventarios',
            'quests'        => 'Misiones',
        ],
        'title'         => 'Objeto :name',
    ],
];
