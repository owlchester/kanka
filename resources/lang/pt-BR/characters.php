<?php

return [
    'actions'       => [
        'add_appearance'    => 'Adicionar uma aparência',
        'add_organisation'  => 'Adicionar uma organização',
        'add_personality'   => 'Adicionar uma personalidade',
    ],
    'conversations' => [
        'description'   => 'Conversas das quais o personagem está participando',
        'title'         => 'Conversas de :name',
    ],
    'create'        => [
        'description'   => 'Criar um novo personagem',
        'success'       => 'Personagem \':name\' criado.',
        'title'         => 'Criar um novo personagem',
    ],
    'destroy'       => [
        'success'   => 'Personagem \':name\' removido.',
    ],
    'dice_rolls'    => [
        'description'   => 'Rolagens de dado atribuídas ao personagem',
        'hint'          => 'Rolagens de dados podem ser vinculadas a um personagem para uso no jogo.',
        'title'         => 'Rolagens de dado de :name',
    ],
    'edit'          => [
        'description'   => 'Editar um personagem',
        'success'       => 'Personagem \':name\' atualizado.',
        'title'         => 'Editar Personagem :name',
    ],
    'fields'        => [
        'age'                       => 'Idade',
        'family'                    => 'Família',
        'image'                     => 'Imagem',
        'is_dead'                   => 'Morto',
        'is_personality_visible'    => 'A personalidade é visível',
        'life'                      => 'Vida',
        'location'                  => 'Local',
        'name'                      => 'Nome',
        'physical'                  => 'Físico',
        'race'                      => 'Raça',
        'relation'                  => 'Relação',
        'sex'                       => 'Sexo',
        'title'                     => 'Título',
        'traits'                    => 'Traços de Personalidade',
        'type'                      => 'Tipo',
    ],
    'helpers'       => [
        'age'   => 'Você pode vincular essa entidade a um calendário de sua campanha para calcular automaticamente sua idade. :more.',
        'free'  => 'Onde o campo "Livre" foi parar? Se esse personagem possuía um, ele foi movido para a nova aba Anotações!',
    ],
    'hints'         => [
        'hide_personality'          => 'Essa aba pode ser escondida de usuários não "Administradores"  desabilitando a opção "Personalidade Visível" quando editando esse personagem.',
        'is_dead'                   => 'Esse personagem está morto',
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
    'items'         => [
        'description'   => 'Itens carregados ou que pertencem ao personagem',
        'hint'          => 'Itens podem ser vinculados a personagens e serão mostrados aqui.',
        'title'         => 'Itens de :name',
    ],
    'journals'      => [
        'description'   => 'Jornais dos quais o(a) personagem é autor(a)',
        'title'         => 'Jornais de :name',
    ],
    'maps'          => [
        'description'   => 'Mapa de relações de um personagem',
        'title'         => 'Mapa de relações de :name',
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
        'description'   => 'Organizações das queis o personagem é parte.',
        'destroy'       => [
            'success'   => 'Organização do personagem removida.',
        ],
        'edit'          => [
            'description'   => 'Atualize a organização de um personagem',
            'success'       => 'Organização do personagem atualizada.',
            'title'         => 'Atualizar Organização para :name',
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
        'race'              => 'Raça',
        'sex'               => 'Sexo',
        'title'             => 'Título',
        'traits'            => 'Traços de Personalidade',
        'type'              => 'NPC, Personagem de Jogador, Divindade',
    ],
    'quests'        => [
        'description'   => 'Missões das quais o personagem faz parte',
        'helpers'       => [
            'quest_giver'   => 'Missões que o personagem deu.',
            'quest_member'  => 'Missões das quais o personagem é membro.',
        ],
        'title'         => 'Missões de :name',
    ],
    'sections'      => [
        'appearance'    => 'Aparência',
        'general'       => 'Informações Gerais',
        'personality'   => 'Personalidade',
    ],
    'show'          => [
        'description'   => 'Uma visão geral do personagem',
        'tabs'          => [
            'conversations' => 'Conversas',
            'dice_rolls'    => 'Rolagem de Dados',
            'free'          => 'Texto Livre',
            'items'         => 'Itens',
            'journals'      => 'Jornais',
            'map'           => 'Mapa de relações',
            'organisations' => 'Organizações',
            'personality'   => 'Personalidade',
            'quests'        => 'Missões',
        ],
        'title'         => 'Personagem :name',
    ],
    'warnings'      => [
        'personality_hidden'    => 'Você não tem permissão para editar traços de personalidade neste personagem.',
    ],
];
