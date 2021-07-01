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
    ],
    'hints'         => [
        'is_private'    => 'Podeu amagar tots els atributs d\'una entitat a tots els membres no administradors fent-la privada.',
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
    'visibility'    => [
        'entry'     => 'L\'atribut es mostra al menú de l\'entitat.',
        'private'   => 'L\'atribut només és visible per a membres amb el rol "Admin".',
        'public'    => 'L\'atribut és visible per a tots els membres.',
        'tab'       => 'L\'atribut només es mostra a la pestanya d\'atributs.',
    ],
];
