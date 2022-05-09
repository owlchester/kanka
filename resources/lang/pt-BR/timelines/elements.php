<?php

return [
    'create'        => [
        'success'   => 'Elemento adicionado à linha do tempo',
        'title'     => 'Novo elemento da linha do tempo',
    ],
    'delete'        => [
        'success'   => 'Elemento :name removido',
    ],
    'edit'          => [
        'success'   => 'Elemento atualizado',
        'title'     => 'Editar elemento da linha do tempo',
    ],
    'fields'        => [
        'date'              => 'Data',
        'era'               => 'Era',
        'icon'              => 'Ícone',
        'use_entity_entry'  => 'Exiba a entrada da entidade anexada abaixo. O texto deste elemento será exibido primeiro se estiver presente.',
    ],
    'helpers'       => [
        'entity_is_private' => 'O elemento da entidade está privada.',
        'icon'              => 'Copie o HTML de um ícone de :fontawesome ou :rpgawesome.',
        'is_collapsed'      => 'O elemento é exibido colapsado por padrão.',
    ],
    'placeholders'  => [
        'date'      => 'ex: 42 de Março ou 1332-1337',
        'name'      => 'Obrigatório se nenhuma entidade for selecionada',
        'position'  => 'Posição na lista de elementos da era. Deixe em branco para adicionar ao final.',
    ],
];
