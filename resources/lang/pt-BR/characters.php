<?php

return [
    'actions'       => [
        'add_appearance'    => 'Adicionar uma aparência',
        'add_organisation'  => 'Adicionar uma organização',
        'add_personality'   => 'Adicionar uma personalidade',
    ],
    'conversations' => [
        'title' => 'Conversas de :name',
    ],
    'create'        => [
        'success'   => 'Personagem \':name\' criado.',
        'title'     => 'Criar um novo personagem',
    ],
    'destroy'       => [
        'success'   => 'Personagem \':name\' removido.',
    ],
    'dice_rolls'    => [
        'hint'  => 'Rolagens de dados podem ser vinculadas a um personagem para uso no jogo.',
        'title' => 'Rolagens de dado de :name',
    ],
    'edit'          => [
        'success'   => 'Personagem \':name\' atualizado.',
        'title'     => 'Editar Personagem :name',
    ],
    'fields'        => [
        'age'                       => 'Idade',
        'families'                  => 'Famílias',
        'family'                    => 'Família',
        'image'                     => 'Imagem',
        'is_dead'                   => 'Morto',
        'is_personality_visible'    => 'A personalidade é visível',
        'life'                      => 'Vida',
        'location'                  => 'Local',
        'name'                      => 'Nome',
        'physical'                  => 'Físico',
        'pronouns'                  => 'Pronomes',
        'race'                      => 'Raça',
        'races'                     => 'Raças',
        'relation'                  => 'Relação',
        'sex'                       => 'Sexo',
        'title'                     => 'Título',
        'traits'                    => 'Traços de Personalidade',
        'type'                      => 'Tipo',
    ],
    'helpers'       => [
        'age'   => 'Você pode vincular essa entidade a um calendário de sua campanha para calcular automaticamente sua idade. :more.',
    ],
    'hints'         => [
        'is_dead'                   => 'Esse personagem está morto',
        'is_personality_visible'    => 'Você pode ocultar toda a seção de personalidade dos seus Espectadores.',
        'personality_not_visible'   => 'Os traços de personalidade deste personagem estão visíveis apenas para os Administradores.',
        'personality_visible'       => 'Os traços de personalidade deste personagem estão visíveis para todos.',
    ],
    'index'         => [
        'actions'   => [
            'random'    => 'Novo Personagem Aleatório',
        ],
        'add'       => 'Novo Personagem',
        'header'    => 'Personagens em :name',
        'title'     => 'Personagens',
    ],
    'items'         => [
        'hint'  => 'Itens podem ser vinculados a personagens e serão mostrados aqui.',
        'title' => 'Itens de :name',
    ],
    'journals'      => [
        'title' => 'Jornais de :name',
    ],
    'maps'          => [
        'title' => 'Mapa de relações de :name',
    ],
    'organisations' => [
        'actions'       => [
            'add'   => 'Adicionar organização',
        ],
        'create'        => [
            'success'   => 'Personagem adicionado à organização',
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
        'title'         => 'Organizações de :name',
    ],
    'placeholders'  => [
        'age'               => 'Idade',
        'appearance_entry'  => 'Descrição',
        'appearance_name'   => 'Cabelo, Olhos, Pele, Altura',
        'family'            => 'Por favor selecione uma família',
        'image'             => 'Imagem',
        'location'          => 'Por favor selecione um local',
        'name'              => 'Nome',
        'personality_entry' => 'Detalhes',
        'personality_name'  => 'Objetivos, Maneirismos, Medos, Ligações',
        'physical'          => 'Físico',
        'pronouns'          => 'Ele/Seu, Ela/Sua, Eles/Seus',
        'race'              => 'Raça',
        'races'             => 'Escolha as raças',
        'sex'               => 'Sexo',
        'title'             => 'Título',
        'traits'            => 'Traços de Personalidade',
        'type'              => 'NPC, Personagem de Jogador, Divindade',
    ],
    'quests'        => [
        'helpers'   => [
            'quest_giver'   => 'Missões que o personagem deu.',
            'quest_member'  => 'Missões das quais o personagem é membro.',
        ],
    ],
    'sections'      => [
        'appearance'    => 'Aparência',
        'general'       => 'Informações Gerais',
        'personality'   => 'Personalidade',
    ],
    'show'          => [
        'tabs'  => [
            'map'           => 'Mapa de relações',
            'organisations' => 'Organizações',
        ],
    ],
    'warnings'      => [
        'personality_hidden'    => 'Você não tem permissão para editar traços de personalidade neste personagem.',
    ],
];
