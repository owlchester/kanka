<?php

return [
    'actions'       => [
        'add_appearance'    => 'Adicionar uma aparência',
        'add_personality'   => 'Adicionar uma personalidade',
    ],
    'conversations' => [],
    'create'        => [
        'title' => 'Novo Personagem',
    ],
    'destroy'       => [],
    'dice_rolls'    => [],
    'edit'          => [],
    'families'      => [
        'title' => 'Gerenciar famílias de :name',
    ],
    'fields'        => [
        'age'                       => 'Idade',
        'is_appearance_pinned'      => 'Aparência fixada',
        'is_dead'                   => 'Morto',
        'is_personality_pinned'     => 'Personalidade fixada',
        'is_personality_visible'    => 'Personalidade visível',
        'life'                      => 'Vida',
        'physical'                  => 'Físico',
        'pronouns'                  => 'Pronomes',
        'sex'                       => 'Gênero',
        'title'                     => 'Título',
        'traits'                    => 'Características',
    ],
    'helpers'       => [
        'age'   => 'Você pode vincular essa entidade a um calendário de sua campanha para calcular automaticamente sua idade. :more.',
    ],
    'hints'         => [
        'is_appearance_pinned'      => 'Exiba os traços de aparência na página de visão geral.',
        'is_dead'                   => 'Este personagem está morto.',
        'is_personality_pinned'     => 'Exiba os traços de personalidade na página de visão geral.',
        'is_personality_visible'    => 'Os traços de personalidade são visíveis para todos, não apenas para os membros do cargo :admin.',
        'personality_not_visible'   => 'Traços de personalidade deste personagem estão atualmente visíveis apenas para usuários Admin.',
        'personality_visible'       => 'Traços de personalidade deste personagem estão visíveis para todos.',
    ],
    'index'         => [],
    'items'         => [],
    'journals'      => [],
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
    'maps'          => [],
    'organisations' => [
        'create'    => [
            'success'   => ':character adicionado à :organisation.',
            'title'     => 'Filiação',
        ],
        'destroy'   => [
            'success'   => 'Filiação removida.',
        ],
        'edit'      => [
            'success'   => 'Filiação atualizada.',
            'title'     => 'Atualizar filiação de :name',
        ],
        'fields'    => [
            'role'  => 'Função',
        ],
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
        'sex'               => 'Gênero',
        'title'             => 'Título',
        'traits'            => 'Traços',
        'type'              => 'NPC, Personagem de Jogador, Divindade',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Missões das quais o personagem delegou.',
            'quest_member'  => 'Missões das quais o personagem é membro.',
        ],
    ],
    'races'         => [
        'reorder'   => [
            'success'   => 'Raças de personagens atualizadas com sucesso',
        ],
        'title'     => 'Gerenciar raças de :name',
    ],
    'sections'      => [
        'appearance'    => 'Aparência',
        'personality'   => 'Personalidade',
    ],
    'show'          => [],
    'warnings'      => [
        'personality_hidden'    => 'Você não tem permissão para editar traços de personalidade deste personagem.',
    ],
];
