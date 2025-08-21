<?php

return [
    'actions'       => [
        'bulks'             => [
            'disable'   => 'Desabilitar plugins',
            'enable'    => 'Habilitar plugins',
            'update'    => 'Atualizar plugins',
        ],
        'changelog'         => 'Histórico de alterações',
        'disable'           => 'Desativar plugin',
        'enable'            => 'Ativar plugin',
        'find-plugins'      => 'Encontrar plugins',
        'import'            => 'Importar',
        'update'            => 'Atualizar plug-in',
        'update-to'         => 'Atualizar para versão :version',
        'update_available'  => 'Atualização disponível!',
    ],
    'bulks'         => [
        'delete'    => '{1} Removido :count plugin.|[2,*] Removidos :count plugins.',
        'disable'   => '{1} Desabilitado :count plugin.|[2,*] Desabilitados :count plugins.',
        'enable'    => '{1} Habilitado :count plugin.|[2,*] Habilitados :count plugins.',
        'update'    => '{1} Atualizado :count plugin.|[2,*] Atualizados :count plugins.',
    ],
    'destroy'       => [
        'success'   => 'Plug-in :plugin removido.',
    ],
    'disabled'      => [
        'success'   => 'Plug-in :plugin desativado.',
    ],
    'empty_list'    => 'A campanha não tem nenhum plugin no momento. Vá ao mercado para instalar alguns e volte para ativá-los.',
    'enabled'       => [
        'success'   => 'Plugin :plugin ativado',
    ],
    'errors'        => [
        'invalid_plugin'    => 'Plugin inválido',
    ],
    'fields'        => [
        'name'      => 'Nome do plugin',
        'obsolete'  => 'Este plugin foi marcado como obsoleto pela equipe do Kanka, o que significa que não funciona mais como planejado originalmente por seu criador.',
        'status'    => 'Status',
        'type'      => 'Tipo de plugin',
    ],
    'import'        => [
        'button'                => 'Importar',
        'created'               => 'Criada as seguintes entidades:',
        'fields'                => [
            'only_new'  => 'Somente novas entidades',
            'private'   => 'Entidades privadas',
        ],
        'helper'                => 'Você está prestes a importar :count entidades do plugin :plugin. Se este plug-in foi importado anteriormente, as alterações feitas nas entidades importadas podem ser perdidas.',
        'no_new_entities'       => 'Não há novas entidades a serem importadas.',
        'option_only_import'    => 'Importe apenas novas entidades, ignorando entidades importadas anteriormente.',
        'option_private'        => 'Importe todas as entidades como privadas.',
        'success'               => '{1} Importada :count entidades do plugin :plugin.|[2,*] Importada :count enidades do plugin :plugin.',
        'title'                 => 'Importar :plugin',
        'updated'               => 'Atualizadas as seguintes entidades:',
    ],
    'info'          => [
        'description'   => 'Exibindo as últimas atualizações para o plugin :plugin.',
        'helper'        => 'Quando uma nova versão de um plugin é liberada, você pode atualizá-lo para a nova versão para sua campanha.',
        'installed'     => 'Instalado',
        'title'         => 'Atualizações do plug-in :plugin',
        'updates'       => 'Atualizações',
        'versions'      => 'Versões',
        'your_version'  => 'Sua versão',
    ],
    'pitch'         => 'Instale e gerencie plugins do :marketplace.',
    'status'        => [
        'always'    => 'Este tipo de plugin está sempre ativo, a menos que seja removido.',
        'disabled'  => 'Desativado',
        'enabled'   => 'Ativado',
    ],
    'templates'     => [
        'name'  => ':name por :user',
    ],
    'title'         => 'Plugins - :name',
    'types'         => [
        'attribute' => 'Modelo de Atributo',
        'pack'      => 'Pacote de Conteúdo',
        'theme'     => 'Tema',
    ],
    'update'        => [
        'success'   => 'Plugin :plugin atualizado.',
    ],
];
