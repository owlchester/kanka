<?php

return [
    'actions'       => [
        'add_appearance'    => 'Adicionar uma aparência',
        'add_personality'   => 'Adicionar uma personalidade',
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
        'hint'  => 'Rolagens de dados podem ser vinculadas a um personagem para uso no jogo.',
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
        'hint'  => 'Itens podem ser vinculados a personagens e serão mostrados aqui.',
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
    'sections'      => [
        'appearance'    => 'Aparência',
        'general'       => 'Informações Gerais',
        'personality'   => 'Personalidade',
    ],
    'show'          => [
        'description'   => 'Uma visão geral do personagem',
        'tabs'          => [
            'dice_rolls'    => 'Rolagem de Dados',
            'free'          => 'Texto Livre',
            'items'         => 'Itens',
            'journals'      => 'Jornais',
            'organisations' => 'Organizações',
            'personality'   => 'Personalidade',
            'quests'        => 'Missões',
        ],
        'title'         => 'Personagem :name',
    ],
];
