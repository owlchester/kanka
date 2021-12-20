<?php

return [
    'actions'       => [
        'apply_template'    => 'Aplica una plantilla d\'atributs',
        'manage'            => 'Administra',
        'more'              => 'Més opcions',
        'remove_all'        => 'Elimina\'ls tots',
    ],
    'errors'        => [
        'loop'  => 'Hi ha un bucle infinit en aquest càlcul d\'atributs!',
    ],
    'fields'        => [
        'attribute'             => 'Atribut',
        'community_templates'   => 'Plantilles de la comunitat',
        'is_private'            => 'Atributs privats',
        'is_star'               => 'Fixat',
        'template'              => 'Plantilla',
        'value'                 => 'Valor',
    ],
    'helpers'       => [
        'delete_all'    => '¿Segur que voleu eliminar tots els atributs d\'aquesta entitat?',
        'setup'         => 'Podeu representar elements com els punts de vida o la intel·ligència d\'una entitat mitjançant els atributs. Per a afegir-ne, cliqueu al botó de :manage, o apliqueu-los des d\'una plantilla d\'atributs.',
    ],
    'hints'         => [
        'is_private2'   => 'Si està seleccionat, només els membres amb el rol d\':admin podran veure els atributs d\'aquesta entitat.',
    ],
    'index'         => [
        'success'   => 'S\'han actualitzat els atributs de :entity.',
        'title'     => 'Atributs de :name',
    ],
    'placeholders'  => [
        'attribute' => 'Nombre de conquestes, Iniciativa, Població...',
        'block'     => 'Nom del bloc',
        'checkbox'  => 'Nom de la casella',
        'icon'      => [
            'class' => 'Classe de FontAwesome o RPG Awesome: fas fa-users',
            'name'  => 'Nom de la icona',
        ],
        'random'    => [
            'name'  => 'Nom de l\'atribut',
            'value' => '1-100 o una llista de valors separats per comes',
        ],
        'section'   => 'Nom de la secció',
        'template'  => 'Selecciona una plantilla',
        'value'     => 'Valor de l\'atribut',
    ],
    'show'          => [
        'title' => 'Atributs de :name',
    ],
    'template'      => [
        'success'   => 'S\'ha aplicat la plantilla d\'atributs :name a :entity',
        'title'     => 'Aplica una plantilla d\'atributs a :name',
    ],
    'types'         => [
        'attribute' => 'Atribut',
        'block'     => 'Bloc',
        'checkbox'  => 'Casella',
        'icon'      => 'Icona',
        'random'    => 'Aleatori',
        'section'   => 'Secció',
        'text'      => 'Text multilínia',
    ],
    'update'        => [
        'success'   => 'S\'han actualitzat els atributs de :entity.',
    ],
    'visibility'    => [
        'entry'     => 'L\'atribut es mostra al menú de l\'entitat.',
        'private'   => 'L\'atribut només és visible per a membres amb el rol "Admin".',
        'public'    => 'L\'atribut és visible per a tots els membres.',
        'tab'       => 'L\'atribut només es mostra a la pestanya d\'atributs.',
    ],
];
