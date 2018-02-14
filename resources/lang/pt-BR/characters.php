<?php

return [
    'attributes'    => [
        'actions'       => [
            'add'   => 'Adicionar um atributo',
        ],
        'create'        => [
            'description'   => 'Adicionar um atributo para um personagem',
            'success'       => 'Atributo adicionado a :name.',
            'title'         => 'Novo atributo para :name',
        ],
        'destroy'       => [
            'success'   => 'Atributo de :name removido.',
        ],
        'edit'          => [
            'success'   => 'Atributo de :name atualizado.',
            'title'     => 'Alterar atributo de :name',
        ],
        'fields'        => [
            'attribute' => 'Atributo',
            'value'     => 'Valor',
        ],
        'placeholders'  => [
            'attribute' => 'Numero de batalhas vencidas, dia de casamento, Iniciativa',
            'value'     => 'Valor do atributo',
        ],
    ],
    'create'        => [
        'success'   => 'Personagem \':name\' criado.',
        'title'     => 'Criar um novo personagem',
    ],
    'destroy'       => [
        'success'   => 'Personagem \':name\' removido.',
    ],
    'edit'          => [
        'success'   => 'Personagem \':name\' atualizado.',
        'title'     => 'Editar Personagem :name',
    ],
    'fields'        => [
        'age'                       => 'Idade',
        'eye'                       => 'Cor dos olhos',
        'family'                    => 'Família',
        'fears'                     => 'Medos',
        'free'                      => 'Texto livre',
        'goals'                     => 'Objetivos',
        'hair'                      => 'Cabelo',
        'height'                    => 'Altura',
        'history'                   => 'História',
        'image'                     => 'Imagem',
        'is_personality_visible'    => 'A personalidade é visível',
        'languages'                 => 'Idiomas',
        'location'                  => 'Local',
        'mannerisms'                => 'Maneirismos',
        'name'                      => 'Nome',
        'physical'                  => 'Físico',
        'race'                      => 'Raça',
        'relation'                  => 'Relação',
        'sex'                       => 'Sexo',
        'skin'                      => 'Pele',
        'title'                     => 'Título',
        'traits'                    => 'Traços de Personalidade',
        'weight'                    => 'Peso',
    ],
    'hints'         => [
        'is_personality_visible'    => 'Você pode ocultar toda a seção de personalidade dos seus Espectadores.',
    ],
    'index'         => [
        'actions'       => [
            'random'    => 'Novo Personagem Aleatório',
        ],
        'add'           => 'Novo Personagem',
        'description'   => 'Gerencie os personagens de :name.',
        'header'        => 'Personagens em :name',
        'title'         => 'Personagens',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Adicionar organização',
        ],
        'create'        => [
            'description'   => 'Associar uma organização a um personagem',
            'success'       => 'Personagem adicionado à organização',
            'title'         => 'Nova Organização para :name',
        ],
        'destroy'       => [
            'success'   => 'Organização do personagem removida.',
        ],
        'edit'          => [
            'success'   => 'Organização do personagem atualizada.',
            'title'     => 'Atualizar Organização para :name',
        ],
        'fields'        => [
            'organisation'  => 'Organização',
            'role'          => 'Função',
        ],
        'placeholders'  => [
            'organisation'  => 'Escolha uma organização...',
        ],
    ],
    'placeholders'  => [
        'age'       => 'Idade',
        'eye'       => 'Cor dos olhos',
        'family'    => 'Por favor selecione uma família',
        'fears'     => 'Medos',
        'free'      => 'Texto Livre',
        'goals'     => 'Objetivos',
        'hair'      => 'Cabelo',
        'height'    => 'Altura',
        'history'   => 'História',
        'image'     => 'Imagem',
        'languages' => 'Idiomas',
        'location'  => 'Por favor selecione um local',
        'mannerisms'=> 'Maneirismos',
        'name'      => 'Nome',
        'physical'  => 'Físico',
        'race'      => 'Raça',
        'sex'       => 'Sexo',
        'skin'      => 'Pele',
        'title'     => 'Título',
        'traits'    => 'Traços de Personalidade',
        'weight'    => 'Peso',
    ],
    'sections'      => [
        'appearance'    => 'Aparência',
        'general'       => 'Informações Gerais',
        'history'       => 'História',
        'personality'   => 'Personalidade',
    ],
    'show'          => [
        'description'   => 'Uma visão geral do personagem',
        'tabs'          => [
            'attributes'    => 'Atributos',
            'free'          => 'Texto Livre',
            'history'       => 'História',
            'organisations' => 'Organizações',
            'personality'   => 'Personalidade',
            'relations'     => 'Relações',
        ],
        'title'         => 'Personagem :name',
    ],
];
