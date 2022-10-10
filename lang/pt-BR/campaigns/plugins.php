<?php

return [
    'actions'       => [
        'bulks'             => [
            'disable'   => 'Desabilitar plugins',
            'enable'    => 'Habilitar plugins',
            'update'    => 'Atualizar plugins',
        ],
        'changelog'         => 'Histórico de registros',
        'disable'           => 'Desativar plug-in',
        'enable'            => 'Ativar plug-in',
        'go_to_marketplace' => 'Ir para o Mercado',
        'import'            => 'Importar',
        'remove'            => 'Remover plug-in',
        'update'            => 'Atualizar plug-in',
        'update_available'  => 'Atualização disponível!',
    ],
    'bulks'         => [
        'delete'    => '{1} Removido :count plugin.|[2,*] Removidos :count plugins.',
        'disable'   => '{1} Desabilitado :count plugin.|[2,*] Desabilitados :count plugins.',
        'enable'    => '{1} Habilitado :count plugin.|[2,*] Habilitados :count plugins.',
        'update'    => '{1} Atualizado :count plugin.|[2,*] Atualizados :count plugins.',
    ],
    'destroy'       => [
        'success'   => 'Plug-in :plugin removido',
    ],
    'disabled'      => [
        'success'   => 'Plug-in :plugin desativado',
    ],
    'empty_list'    => 'A campanha não tem nenhum plug-in no momento. Vá ao mercado para instalar alguns e volte para ativá-los.',
    'enabled'       => [
        'success'   => 'Plug-in :plugin ativado',
    ],
    'errors'        => [
        'invalid_plugin'    => 'Plug-in inválido',
    ],
    'fields'        => [
        'name'      => 'Nome do plug-in',
        'status'    => 'Status',
        'type'      => 'Tipo de plug-in',
    ],
    'import'        => [
        'button'                => 'Importar',
        'created'               => 'Criada as seguintes entidades:',
        'helper'                => 'Você está prestes a importar :count entidades do plugin :plugin. Se este plug-in foi importado anteriormente, as alterações feitas nas entidades importadas podem ser perdidas.',
        'no_new_entities'       => 'Não há novas entidades a serem importadas.',
        'option_only_import'    => 'Importe apenas novas entidades, pulando entidades importadas anteriormente.',
        'option_private'        => 'Importe todas as entidades como privadas.',
        'success'               => '{1} Importada :count entidades do plugin :plugin.|[2,*] Importada :count enidades do plugin :plugin.',
        'title'                 => 'Importar :plugin',
        'updated'               => 'Atualizadas as seguintes entidades:',
    ],
    'info'          => [
        'helper'        => 'Quando uma nova versão de um plug-in é liberada, você pode atualizá-lo para a nova versão para sua campanha.',
        'title'         => 'Atualizações do plug-in :plugin',
        'updates'       => 'Atualizações',
        'your_version'  => 'Sua versão',
    ],
    'pitch'         => 'Instale e gerencie plugins do :marketplace.',
    'status'        => [
        'disabled'  => 'Desativado',
        'enabled'   => 'Ativado',
    ],
    'templates'     => [
        'name'  => ':name por :user',
    ],
    'title'         => 'Plug-ins da campanha :name',
    'types'         => [
        'attribute' => 'Modelo de Atributo',
        'pack'      => 'Pacote de Conteúdo',
        'theme'     => 'Tema',
    ],
    'update'        => [
        'success'   => 'Plug-in :plugin atualizado',
    ],
];
