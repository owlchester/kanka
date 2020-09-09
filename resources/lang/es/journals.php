<?php

return [
    'create'        => [
        'description'   => 'Crear nuevo diario',
        'success'       => 'Diario ":name" creado.',
        'title'         => 'Nuevo diario',
    ],
    'destroy'       => [
        'success'   => 'Diario ":name" eliminado.',
    ],
    'edit'          => [
        'success'   => 'Diario ":name" actualizado.',
        'title'     => 'Editar diario :name',
    ],
    'fields'        => [
        'author'    => 'Autor',
        'date'      => 'Fecha',
        'image'     => 'Imagen',
        'name'      => 'Nombre',
        'relation'  => 'Relación',
        'type'      => 'Tipo',
    ],
    'index'         => [
        'add'           => 'Nuevo diario',
        'description'   => 'Gestiona los diarios de :name',
        'header'        => 'Diarios de :name',
        'title'         => 'Diarios',
    ],
    'placeholders'  => [
        'author'    => 'Quién ha escrito el diario',
        'date'      => 'Fecha del diario',
        'name'      => 'Nombre del diario',
        'type'      => 'Sesión, Borrador...',
    ],
    'show'          => [
        'description'   => 'Vista detallada del diario',
        'title'         => 'Diario :name',
    ],
];
