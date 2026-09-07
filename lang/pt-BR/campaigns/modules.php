<?php

return [
    'actions'       => [
        'create'    => 'Criar uma categoria',
        'customise' => 'Personalizar',
    ],
    'create'        => [
        'helper'    => 'Crie uma nova categoria personalizada para armazenar entidades que não cabem nas outras categorias.',
        'success'   => 'Nova categoria criada.',
        'title'     => 'Nova categoria',
    ],
    'delete'        => [
        'confirm'           => 'Escreva :code se tiver certeza de que deseja excluir permanentemente a categoria personalizada :name.',
        'confirm-button'    => '{0} Excluir permanentemente :name|{1} Excluir permanentemente :name e :count registro|[2,*] Excluir permanentemente :name e :count registros',
        'entities'          => '{1} Isso excluirá permanentemente :count registro.|[2,*] Isso excluirá permanentemente :count registros.',
        'helper'            => 'Tem certeza de que deseja remover a categoria personalizada :name? Isso também excluirá permanentemente todas as entidades, favoritos e widgets vinculados a esta categoria.',
        'success'           => 'Categoria :name removida.',
        'title'             => 'Remoção da categoria',
    ],
    'errors'        => [
        'disabled'              => 'A categoria :name está desabilitada. :fix',
        'empty-custom'          => 'Adicione categorias personalizadas para organizar dados que não se encaixam nas categorias padrão.',
        'limit'                 => 'As campanhas estão atualmente limitadas apenas a :max cateogias personalizadas enquanto ajustamos esse novo recurso.',
        'limit-title'           => 'Limite de categorias personalizadas atingido',
        'subscription-limit'    => 'A campanha atingiu o número máximo de categorias personalizadas disponíveis. A pessoa que desbloquear os recursos premium pode assinar um plano superior para aumentar esse limite.',
    ],
    'fields'        => [
        'icon'          => 'Ícone da categoria',
        'image'         => 'Imagem de espaço reservado',
        'plural'        => 'Nome plural da categoria',
        'singular'      => 'Nome singular da categoria',
        'status'        => 'Status da categoria',
        'update_name'   => 'Renomear a categoria favorita com o novo nome',
    ],
    'helpers'       => [
        'custom'    => 'Essa é uma categoria personalizada.',
        'icon'      => 'Dê a esta categoria um ícone especial :fontawesome, por exemplo :example.',
        'plural'    => 'Usado em navegação e listas (por exemplo, "ver todas as poções")',
        'roles'     => 'Selecione os cargos que devem ter permissão para visualizar entidades desta nova categoria. Isso pode ser alterado posteriormente nas permissões do cargo.',
        'singular'  => 'Usado ao se referir a um único item (por exemplo, "nova poção")',
        'status'    => 'Categorias desativadas são ocultadas da navegação e dos menus. Nenhum dado é excluído.',
        'tutorial'  => 'As categorias controlam quais recursos ficam visíveis na campanha. Ative as que você utiliza e oculte as demais. Desativar uma categoria nunca exclui dados; apenas os remove dos menus de navegação e de criação.',
    ],
    'pitch'         => 'Renomeie e altere o ícone associado a esta categoria para toda a campanha.',
    'pitch-custom'  => 'Crie categorias personalizadas para qualquer necessidade do seu mundo. Acompanhe divindades, poções, leis de sucessão ou o que quer que torne sua campanha única. O plano Premium oferece total flexibilidade.',
    'rename'        => [
        'helper'    => 'Personalize a forma como esta categoria é exibida ao longo da campanha. Deixe os campos em branco para usar os valores padrão.',
        'success'   => 'Categoria personalizada.',
        'title'     => 'Personalizar :module',
    ],
    'reset'         => [
        'default'   => 'Isso redefinirá apenas as categorias padrão, não as personalizadas.',
        'success'   => 'As categorias da campanha foram redefinidas.',
        'title'     => 'Redefinir nomes e ícones das categorias personalizadas',
        'warning'   => 'Tem certeza de que deseja redefinir as categorias da campanha para seus nomes e ícones originais?',
    ],
    'sections'      => [
        'custom'        => 'Categorias personalizadas',
        'default'       => 'Categorias padrão',
        'early-access'  => 'Acesso antecipado',
        'features'      => 'Recursos',
    ],
    'states'        => [
        'disable'   => 'Desabilitar',
        'disabled'  => 'A categoria está desativada.',
        'enable'    => 'Habilitar',
        'enabled'   => 'A categoria está ativada.',
    ],
    'status'        => [
        'enabled'   => 'Categoria ativada',
    ],
];
