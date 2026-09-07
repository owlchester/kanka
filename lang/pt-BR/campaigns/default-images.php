<?php

return [
    'actions'           => [
        'add'   => 'Carregar uma nova imagem em miniatura',
    ],
    'call-to-action'    => 'Carregue uma imagem em miniatura personalizada para todos os personagens, locais ou outras entidades da campanha. Essas imagens são mostradas em várias listas.',
    'create'            => [
        'error'     => 'Erro ao salvar as novas imagens em miniatura padrões de entidade. O :type já está definido?',
        'helper'    => 'Carregue uma imagem que será usada como miniatura padrão para entidades do módulo selecionado.',
        'success'   => 'Nova imagem em miniatura para :type criada.',
        'title'     => 'Nova imagem em miniatura padrão',
    ],
    'destroy'           => [
        'success'   => 'Imagem em miniatura padrão para :type removida.',
    ],
    'empty'             => 'Nenhum módulo tem atualmente uma configuração de miniatura padrão.',
    'helper'            => 'Usado para todas as entidades deste módulo sem uma imagem.',
    'index'             => [],
    'reset'             => [
        'helper'    => 'Tem certeza de que deseja remover as imagens de espaço reservado de todas as categorias de campanha?',
        'success'   => 'Imagens de espaço reservado de todas as categorias removidas com sucesso.',
        'title'     => 'Redefinir imagens de espaço reservado',
        'warning'   => 'Esta ação é permanente e não pode ser desfeita.',
    ],
    'title'             => 'Imagens de espaço reservado',
    'tutorial'          => 'Defina imagens padrão para itens que não possuem imagens personalizadas. Essas miniaturas aparecem imediatamente em toda a campanha e mantêm a consistência visual das listas.',
];
