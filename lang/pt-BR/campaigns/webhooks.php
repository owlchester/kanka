<?php

return [
    'actions'       => [
        'action'    => 'Alterar status',
        'add'       => 'Criar webhook',
        'bulks'     => [
            'delete_success'    => '{1} :count webhook removido.|[2,*] :count webhook removidos.',
            'disable'           => 'Desativar',
            'disable_success'   => '{1} :count webhook desativado.|[2,*] :count webhook desativados.',
            'enable'            => 'Ativar',
            'enable_success'    => '{1} :count webhook ativado.|[2,*] :count webhook ativados.',
        ],
        'test'      => 'Testar webhook',
        'update'    => 'Atualizar webhook',
    ],
    'create'        => [
        'success'   => 'Webhook criado com sucesso',
        'title'     => 'Adicionar novo webhook',
    ],
    'destroy'       => [
        'success'   => 'Webhook removido com sucesso',
    ],
    'edit'          => [
        'success'   => 'Webhook atualizado com sucesso',
        'title'     => 'Atualizar webhook',
    ],
    'fields'        => [
        'enabled'           => 'Ativado',
        'event'             => 'Evento',
        'events'            => [
            'deleted'   => 'Entidade removida',
            'edited'    => 'Entidade editada',
            'new'       => 'Nova entidade',
        ],
        'message'           => 'Mensagem',
        'private_entities'  => [
            'helper'    => 'Não acione o webhook ao atualizar entidades privadas.',
            'skip'      => 'Pular entidades privadas',
        ],
        'type'              => 'Tipo',
        'types'             => [
            'custom'    => 'Mensagem',
            'payload'   => 'Payload',
        ],
        'url'               => 'Url',
    ],
    'helper'        => [
        'active'    => 'Se o webhook estiver ativo no momento',
        'message'   => 'Adicione uma mensagem personalizada com suporte para mapeamentos',
        'status'    => 'Alternar o status ativo do webhook',
    ],
    'pitch'         => 'Crie webhooks personalizados para receber atualizações personalizadas sempre que uma entidade da campanha for atualizada.',
    'placeholders'  => [
        'message'   => '{who} fez alterações em {name}, confira em {url}',
        'url'       => 'Url do webhook de destino',
    ],
    'test'          => [
        'success'   => 'Requisição de teste enviada',
    ],
    'title'         => 'Webhooks',
];
