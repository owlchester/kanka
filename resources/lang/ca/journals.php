<?php

return [
    'create'        => [
        'success'   => 'S\'ha creat la crònica «:name».',
        'title'     => 'Nova crònica',
    ],
    'destroy'       => [
        'success'   => 'S\'ha eliminat la crònica «:name».',
    ],
    'edit'          => [
        'success'   => 'S\'ha actualitzat la crònica «:name».',
        'title'     => 'Edita la crònica :name',
    ],
    'fields'        => [
        'author'    => 'Autor',
        'date'      => 'Data',
        'image'     => 'Imatge',
        'journal'   => 'Crònica superior',
        'journals'  => 'Subcròniques',
        'name'      => 'Nom',
        'relation'  => 'Relació',
        'type'      => 'Tipus',
    ],
    'helpers'       => [
        'journals'      => 'Mostra totes o només les descendents directes d\'aquesta crònica.',
        'nested_parent' => 'S\'estan mostrant les cròniques de :parent.',
        'nested_without'=> 'S\'estan mostrant les cròniques sense pare. Feu clic a la fila d\'una família per a mostrar-ne les subcròniques.',
    ],
    'index'         => [
        'add'       => 'Nova crònica',
        'header'    => 'Cròniques de :name',
        'title'     => 'Cròniques',
    ],
    'journals'      => [
        'title' => 'Subcròniques de la crònica :name',
    ],
    'placeholders'  => [
        'author'    => 'Qui ha escrit la crònica',
        'date'      => 'Data de la crònica',
        'journal'   => 'Trieu una crònica superior',
        'name'      => 'Nom de la crònica',
        'type'      => 'Sessió, esborrany...',
    ],
    'show'          => [
        'tabs'  => [
            'journals'  => 'Cròniques',
        ],
        'title' => 'Crònica :name',
    ],
];
