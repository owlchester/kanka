<?php

return [
    'actions'       => [
        'create'    => 'Criar módulo',
        'customise' => 'Personalizar',
    ],
    'create'        => [
        'helper'    => 'Crie um novo módulo personalizado para armazenar entidades que não cabem nos outros módulos.',
        'success'   => 'Novo módulo criado.',
        'title'     => 'Novo módulo',
    ],
    'delete'        => [
        'confirm'   => 'Escreva :code se tiver certeza de que deseja excluir permanentemente o módulo personalizado :name.',
        'helper'    => 'Tem certeza de que deseja remover o módulo personalizado :name? Isso também excluirá permanentemente todas as entidades, favoritos e widgets vinculados a este módulo.',
        'success'   => 'Módulo :name removido.',
        'title'     => 'Remoção de módulo',
    ],
    'errors'        => [
        'disabled'  => 'O módulo :name está desabilitado. :fix',
        'limit'     => 'As campanhas estão atualmente limitadas apenas a :max módulos personalizados enquanto ajustamos esse novo recurso.',
    ],
    'fields'        => [
        'icon'      => 'Ícone do módulo',
        'plural'    => 'Nome plural do módulo',
        'singular'  => 'Nome singular do módulo',
    ],
    'helpers'       => [
        'custom'    => 'Esse é um módulo personalizado.',
        'icon'      => 'Dê a este módulo um ícone especial :fontawesome, por exemplo :example.',
        'info'      => 'Uma campanha é dividida em vários módulos que interagem entre si. Habilite ou desabilite aqueles que você não precisa. A desativação de um módulo não exclui nenhum de seus dados, apenas os oculta.',
        'plural'    => 'O nome plural das entidades do novo módulo. Por exemplo, poções',
        'roles'     => 'Selecione os cargos que devem ter permissão para visualizar entidades deste novo módulo. Isso pode ser alterado posteriormente nas permissões da função.',
        'singular'  => 'O nome singular de uma entidade do novo módulo. Por exemplo, poção',
    ],
    'pitch'         => 'Renomeie e altere o ícone associado a este módulo para toda a campanha.',
    'pitch-custom'  => 'Crie módulos personalizados para representar qualquer tipo de entidade no seu mundo. Sem limites, apenas criatividade.',
    'rename'        => [
        'helper'    => 'Altere o nome e o ícone do módulo ao longo da campanha. Deixe em branco para usar o padrão de Kanka.',
        'success'   => 'Módulo personalizado.',
        'title'     => 'Personalizar o módulo :module',
    ],
    'reset'         => [
        'default'   => 'Isso redefinirá apenas os módulos padrão, não os personalizados.',
        'success'   => 'Os módulos da campanha foram redefinidos.',
        'title'     => 'Redefinir nomes e ícones dos módulos personalizados',
        'warning'   => 'Tem certeza de que deseja redefinir os módulos de campanha para seus nomes e ícones originais?',
    ],
    'sections'      => [
        'custom'    => 'Módulos personalizado',
        'default'   => 'Módulos padrão',
        'features'  => 'Recursos',
    ],
    'states'        => [
        'disable'   => 'Desabilitar',
        'enable'    => 'Habilitar',
    ],
];
