<?php

return [
    'actions'       => [
        'add'   => 'Adicionar novo grupo',
    ],
    'create'        => [
        'success'   => 'Grupo :name criado com sucesso',
        'title'     => 'Novo grupo',
    ],
    'delete'        => [
        'success'   => 'Grupo :name deletado',
    ],
    'edit'          => [
        'success'   => 'Grupo :name atualizado com sucesso',
        'title'     => 'Editar grupo :name',
    ],
    'fields'        => [
        'is_shown'  => 'Mostrar marcadores do grupo',
        'position'  => 'Posição',
    ],
    'helper'        => [
        'amount'            => 'Um marcador pode ser anexado a um grupo, permitindo que você mostre ou oculte todas as lojas de uma cidade. Um mapa pode ter até :amount de grupos..',
        'boosted_campaign'  => ':boosted pode ter até :amount grupos',
    ],
    'hints'         => [
        'is_shown'  => 'Se assinalado, os marcadores do grupo serão mostrados no mapa como padrão.',
    ],
    'placeholders'  => [
        'name'      => 'Lojas, Tesouros, NPCs',
        'position'  => 'Campo opcional para definir a ordem em que os grupos aparecem.',
    ],
];
