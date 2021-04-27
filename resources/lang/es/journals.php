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
        'journal'   => 'Diario superior',
        'journals'  => 'Subdiarios',
        'name'      => 'Nombre',
        'relation'  => 'Relación',
        'type'      => 'Tipo',
    ],
    'helpers'       => [
        'journals'      => 'Muestra todos o solo los descendientes directos de este diario.',
        'nested_parent' => 'Mostrando los diarios de :parent.',
        'nested_without'=> 'Mostrando todos los diarios sin ningún superior. Haz clic sobre una fila para mostrar sus descendientes.',
    ],
    'index'         => [
        'add'           => 'Nuevo diario',
        'description'   => 'Gestiona los diarios de :name',
        'header'        => 'Diarios de :name',
        'title'         => 'Diarios',
    ],
    'journals'      => [
        'title' => 'Subdiarios del diario :name',
    ],
    'placeholders'  => [
        'author'    => 'Quién ha escrito el diario',
        'date'      => 'Fecha del diario',
        'journal'   => 'Elige un diario superior',
        'name'      => 'Nombre del diario',
        'type'      => 'Sesión, Borrador...',
    ],
    'show'          => [
        'description'   => 'Vista detallada del diario',
        'tabs'          => [
            'journals'  => 'Diarios',
        ],
        'title'         => 'Diario :name',
    ],
];
