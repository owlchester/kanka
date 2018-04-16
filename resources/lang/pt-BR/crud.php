<?php

return [
    'actions'       => [
        'back'  => 'Voltar',
        'copy'  => 'Copiar',
        'move'  => 'Mover',
        'new'   => 'Novo',
    ],
    'add'           => 'Adicionar',
    'attributes'    => [
        'actions'       => [
            'add'               => 'Adicionar um atributo',
            'apply_template'    => 'Aplicar um Modelo de Atributo',
            'manage'            => 'Gerenciar',
        ],
        'create'        => [
            'description'   => 'Criar um novo atributo',
            'success'       => 'Atributo :name adicionado a :entity',
            'title'         => 'Novo Atributo para :name',
        ],
        'destroy'       => [
            'success'   => 'Atributo :name para :entity removido',
        ],
        'edit'          => [
            'description'   => 'Atualizar um atributo existente',
            'success'       => 'Atributo :name para :entity atualizado',
            'title'         => 'Atualizar atributo para :name',
        ],
        'fields'        => [
            'attribute' => 'Atributo',
            'template'  => 'Modelo',
            'value'     => 'Valor',
        ],
        'index'         => [
            'success'   => 'Atributos de :entity atualizados.',
            'title'     => 'Atributos de :name',
        ],
        'placeholders'  => [
            'attribute' => 'Número de conquistas, Nível de Desafio, Iniciativa, População',
            'template'  => 'Selecione um modelo',
            'value'     => 'Valor do atributo',
        ],
        'template'      => [
            'success'   => 'Modelo de Atributo :name aplicado em :entity',
            'title'     => 'Aplicar um Modelo de Atributo a :name',
        ],
    ],
    'cancel'        => 'Cancelar',
    'clear_filters' => 'Limpar Filtros',
    'click_modal'   => [
        'close'     => 'Fechar',
        'confirm'   => 'Confirmar',
        'title'     => 'Confirmar sua ação',
    ],
    'create'        => 'Criar',
    'delete_modal'  => [
        'close'         => 'Fechar',
        'delete'        => 'Deletar',
        'description'   => 'Tem certeza que deseja remover :tag?',
        'title'         => 'Confirmação de apagamento',
    ],
    'destroy_many'  => [
        'success'   => 'Deletado :count entity|Deletado :count entities.',
    ],
    'edit'          => 'Editar',
    'fields'        => [
        'character'     => 'Personagem',
        'description'   => 'Descrição',
        'entity'        => 'Entidade',
        'history'       => 'História',
        'image'         => 'Imagem',
        'is_private'    => 'Privado',
        'location'      => 'Local',
    ],
    'filter'        => 'Filtro',
    'filters'       => 'Filtros',
    'hidden'        => 'Esconder',
    'hints'         => [
        'is_private'    => 'Esconder de "Espectadores"',
    ],
    'image'         => [
        'error' => 'Nós não fomos capazes de conseguir a imagem requisitada. Pode ser que o site não autorize o download da imagem por nós (tipicamente para Squarespace e DeviantArt), ou o link não está mais válido.',
    ],
    'is_private'    => 'Essa entidade é privada e não visível para usuários espectadores.',
    'linking_help'  => 'Como eu posso vincular a outras entidades?',
    'move'          => [
        'description'   => 'Mover a entidade para outro lugar',
        'fields'        => [
            'target'    => 'Novo tipo',
        ],
        'hints'         => [
            'target'    => 'Esteja ciente que alguns dados podem ser perdidos ao mudar um elemento de um tipo para outro.',
        ],
        'success'       => 'Entidade :name movida.',
        'title'         => 'Mover :name para outro lugar',
    ],
    'new_entity'    => [
        'error' => 'Por favor cheque seus valores',
        'fields'=> [
            'name'  => 'Nome',
        ],
        'title' => 'Nova entidade',
    ],
    'or_cancel'     => 'ou <a href=":url">cancel</a>',
    'panels'        => [
        'appearance'            => 'Aparência',
        'description'           => 'Descrição',
        'general_information'   => 'Informações Gerais',
        'history'               => 'História',
        'move'                  => 'Mover',
    ],
    'permissions'   => [
        'action'    => 'Ação',
        'actions'   => [
            'delete'    => 'Deletar',
            'edit'      => 'Editar',
            'read'      => 'Ler',
        ],
        'allowed'   => 'Permitido',
        'fields'    => [
            'member'    => 'Membro',
            'role'      => 'Cargo',
        ],
        'helper'    => 'Use essa interface para escolher quais usuários e cargos podem interagir com essa entidade.',
        'success'   => 'Permissões salvas.',
        'title'     => 'Permissões',
    ],
    'placeholders'  => [
        'character' => 'Escolha um personagem',
        'image_url' => 'Você também pode dar upload de uma imagem por uma URL',
        'location'  => 'Escolha um local',
    ],
    'relations'     => [
        'actions'   => [
            'add'   => 'Adicionar uma relação',
        ],
        'fields'    => [
            'location'  => 'Local',
            'name'      => 'Nome',
            'relation'  => 'Relação',
        ],
    ],
    'remove'        => 'Remover',
    'save'          => 'Salvar',
    'save_and_new'  => 'Salvar e Novo',
    'search'        => 'Buscar',
    'select'        => 'Selecionar',
    'tabs'          => [
        'attributes'    => 'Atributos',
        'permissions'   => 'Permissões',
        'relations'     => 'Relações',
    ],
    'update'        => 'Atualizar',
    'view'          => 'Ver',
];
