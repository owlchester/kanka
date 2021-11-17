<?php

return [
    'characters'    => [
        'create'    => [
            'description'   => 'Adicione um personagem à Missão',
            'success'       => 'Personagem adicionado a :name.',
            'title'         => 'Novo Personagem para :name',
        ],
        'destroy'   => [
            'success'   => 'Personagem removido da misão :name.',
        ],
        'edit'      => [
            'description'   => 'Atualizar o personagem da missão',
            'success'       => 'Personagem da Missão :name atualizado.',
            'title'         => 'Atualizar personagem em :name',
        ],
        'fields'    => [
            'character'     => 'Personagem',
            'description'   => 'Descrição',
        ],
        'title'     => 'Personagens em :name',
    ],
    'create'        => [
        'description'   => 'Criar uma nova missão',
        'success'       => 'Missão \':name\' criada.',
        'title'         => 'Criar nova missão',
    ],
    'destroy'       => [
        'success'   => 'Missão \':name\' removida.',
    ],
    'edit'          => [
        'description'   => 'Editar uma missão',
        'success'       => 'Missão \':name\' atualizada.',
        'title'         => 'Editar Missão :name',
    ],
    'elements'      => [
        'create'    => [
            'success'   => 'Entidade :entity adicionada à missão.',
            'title'     => 'Novo elemento para :name',
        ],
        'destroy'   => [
            'success'   => 'Elemento da missão :entity removido.',
        ],
        'edit'      => [
            'success'   => 'Elemento da missão :entity atualizado.',
            'title'     => 'Atualizar elementos da missão para :name',
        ],
        'fields'    => [
            'description'       => 'Descrição',
            'entity_or_name'    => 'Selecione uma entidade da campanha ou dê um nome para este elemento.',
            'name'              => 'Nome',
            'quest'             => 'Missão',
        ],
        'title'     => 'Elementos da Missão :name',
    ],
    'fields'        => [
        'character'     => 'Quem deu a missão',
        'characters'    => 'Personagem',
        'copy_elements' => 'Copiar elementos anexados na missão',
        'date'          => 'Data',
        'description'   => 'Descrição',
        'image'         => 'Imagem',
        'is_completed'  => 'Completa',
        'items'         => 'Itens',
        'locations'     => 'Locais',
        'name'          => 'Nome',
        'organisations' => 'Organizações',
        'quest'         => 'Missão Primária',
        'quests'        => 'Missões Secundárias',
        'role'          => 'Função',
        'type'          => 'Tipo',
    ],
    'helpers'       => [
        'nested'        => 'Quando em Visão Aninhada, você pode ver suas missões de maneira aninhada. Missões que não tenham uma Missão Primária serão mostradas de modo padrão. Missões que contém Missões Secundárias podem ser clicadas para mostrar as \'crianças\'. Você pode continuar clicando até não haverem mais \'crianças\' para clicar.',
        'nested_parent' => 'Mostrando as missões de :parent.',
        'nested_without'=> 'Mostrando todas as missões que não tem uma missão-pai. Clique em uma linha para ver as missões-filhos.',
    ],
    'hints'         => [
        'quests'    => 'Uma "teia" de missões interligadas pode ser construída usando o campo de Missão Principal',
    ],
    'index'         => [
        'add'           => 'Nova Missão',
        'description'   => 'Gerencie as missões de :name.',
        'header'        => 'Missões de :name',
        'title'         => 'Missões',
    ],
    'items'         => [
        'create'    => [
            'description'   => 'Adicionar um item à missão',
            'success'       => 'Item adicionado a :name',
            'title'         => 'Novo item para :name',
        ],
        'destroy'   => [
            'success'   => 'Item da missão :name removido',
        ],
        'edit'      => [
            'description'   => 'Atualize o item de uma missão',
            'success'       => 'Item da missão :name atualizado com sucesso.',
            'title'         => 'Atualizar item em :name',
        ],
        'fields'    => [
            'description'   => 'Descrição',
            'item'          => 'Item',
        ],
        'title'     => 'Itens em :name',
    ],
    'locations'     => [
        'create'    => [
            'description'   => 'Estabeleça um local para a Missão',
            'success'       => 'Local adicionado a :name',
            'title'         => 'Novo Local para :name',
        ],
        'destroy'   => [
            'success'   => 'Local da Missão :name removido.',
        ],
        'edit'      => [
            'description'   => 'Atualize o local de uma missão',
            'success'       => 'Local da Missão :name atualizado.',
            'title'         => 'Atualizar local para :name',
        ],
        'fields'    => [
            'description'   => 'Descrição',
            'location'      => 'Local',
        ],
        'title'     => 'Lugares em :name',
    ],
    'organisations' => [
        'create'    => [
            'description'   => 'Escolha uma Organização para a missão',
            'success'       => 'Organização adicionada a :name',
            'title'         => 'Nova organização para :name',
        ],
        'destroy'   => [
            'success'   => 'Organização removida da missão :name',
        ],
        'edit'      => [
            'description'   => 'Atualize uma organização da missão',
            'success'       => 'Organização da missão :name atualizada',
            'title'         => 'Atualizar organização para :name',
        ],
        'fields'    => [
            'description'   => 'Descrição',
            'organisation'  => 'Organização',
        ],
        'title'     => 'Organizações em :name',
    ],
    'placeholders'  => [
        'date'  => 'Data (mundo real) para a missão',
        'name'  => 'Nome da missão',
        'quest' => 'Missão Principal',
        'role'  => 'A função desta entidade na missão',
        'type'  => 'Arco de Personagem, Missão Secundária, Missão Principal',
    ],
    'show'          => [
        'actions'       => [
            'add_character'     => 'Adicionar um personagem',
            'add_element'       => 'Adicionar um elemento',
            'add_item'          => 'Adicionar um item',
            'add_location'      => 'Adicionar um local',
            'add_organisation'  => 'Adicionar uma organização',
        ],
        'description'   => 'Uma visão detalhada de uma missão',
        'tabs'          => [
            'characters'    => 'Personagens',
            'elements'      => 'Elementos',
            'information'   => 'Informações',
            'items'         => 'Itens',
            'locations'     => 'Locais',
            'organisations' => 'Organizações',
            'quests'        => 'Missões',
        ],
        'title'         => 'Missão :name',
    ],
];
