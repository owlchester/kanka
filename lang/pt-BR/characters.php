<?php

return [
    'actions'       => [
        'add_appearance'    => 'Adicionar uma aparência',
        'add_organisation'  => 'Adicionar uma organização',
        'add_personality'   => 'Adicionar uma personalidade',
    ],
    'conversations' => [
        'title' => 'Diálogos de :name',
    ],
    'create'        => [
        'title' => 'Novo Personagem',
    ],
    'destroy'       => [],
    'dice_rolls'    => [
        'hint'  => 'Rolagens de dados podem ser vinculadas a um personagem para uso no jogo.',
        'title' => 'Rolagens de Dados do personagem :name',
    ],
    'edit'          => [],
    'fields'        => [
        'age'                       => 'Idade',
        'families'                  => 'Famílias',
        'is_appearance_pinned'      => 'Aparência fixada',
        'is_dead'                   => 'Morto',
        'is_personality_pinned'     => 'Personalidade fixada',
        'is_personality_visible'    => 'Personalidade visível',
        'life'                      => 'Vida',
        'physical'                  => 'Físico',
        'pronouns'                  => 'Pronomes',
        'sex'                       => 'Sexo',
        'title'                     => 'Título',
        'traits'                    => 'Características',
    ],
    'helpers'       => [
        'age'   => 'Você pode vincular essa entidade a um calendário de sua campanha para calcular automaticamente sua idade. :more.',
    ],
    'hints'         => [
        'is_appearance_pinned'      => 'Se selecionado, os traços de aparência do personagem aparecerão abaixo da introdução na página de visão geral.',
        'is_dead'                   => 'Este personagem está morto',
        'is_personality_pinned'     => 'Se selecionado, os traços de personalidade do personagem aparecerão abaixo da introdução na página de visão geral.',
        'is_personality_visible'    => 'Desmarque esta opção para ocultar toda a seção de personalidade dos membros fora do cargo de :admin.',
        'personality_not_visible'   => 'Os traços de personalidade deste personagem estão visíveis apenas para os  usários Administradores.',
        'personality_visible'       => 'Os traços de personalidade deste personagem estão visíveis para todos.',
    ],
    'index'         => [],
    'items'         => [
        'hint'  => 'Itens podem ser vinculados a personagens e serão exibidos aqui.',
        'title' => 'Itens do Personagem :name',
    ],
    'journals'      => [
        'title' => 'Diários do Personagem :name',
    ],
    'labels'        => [
        'appearance'    => [
            'entry' => 'Descrição da aparência',
            'name'  => 'Nome da aparência',
        ],
        'personality'   => [
            'entry' => 'Descrição do traço de personalidade',
            'name'  => 'Nome do traço de personalidade',
        ],
    ],
    'maps'          => [
        'title' => 'Mapa de Relações do Personagem :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'       => 'Adicionar uma organização',
            'submit'    => 'Adicionar organização',
        ],
        'create'        => [
            'success'   => 'Personagem adicionado à organização.',
            'title'     => 'Nova Organização para :name',
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
        'hint'          => 'Personagens podem ser parte de diversas organizações, representando para quem eles trabalham ou qual sociedade secreta eles fazem parte.',
        'placeholders'  => [
            'organisation'  => 'Escolha uma organização...',
        ],
        'title'         => 'Organizações do Personagem :name',
    ],
    'placeholders'  => [
        'age'               => 'Idade',
        'appearance_entry'  => 'Descrição',
        'appearance_name'   => 'Cabelo, Olhos, Pele, Altura',
        'name'              => 'Nome do personagem',
        'personality_entry' => 'Detalhes',
        'personality_name'  => 'Objetivos, Maneirismos, Medos, Vínculos',
        'physical'          => 'Físico',
        'pronouns'          => 'Ele/Seu, Ela/Sua, Eles/Seus',
        'sex'               => 'Sexo',
        'title'             => 'Título',
        'traits'            => 'Características',
        'type'              => 'NPC, Personagem de Jogador, Divindade',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Missões das quais o personagem delegou.',
            'quest_member'  => 'Missões das quais o personagem é membro.',
        ],
    ],
    'sections'      => [
        'appearance'    => 'Aparência',
        'general'       => 'Informações gerais',
        'personality'   => 'Personalidade',
    ],
    'show'          => [
        'tabs'  => [
            'organisations' => 'Organizações',
        ],
    ],
    'warnings'      => [
        'personality_hidden'    => 'Você não tem permissão para editar traços de personalidade deste personagem.',
    ],
];
