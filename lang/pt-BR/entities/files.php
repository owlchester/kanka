<?php

return [
    'call-to-action'    => [
        'max'       => [
            'helper'    => 'Não é possível anexar mais arquivos a menos que você remova um existente.',
            'limit'     => 'Esta entidade atingiu seu limite de arquivos',
        ],
        'upgrade'   => [
            'limit'     => 'Você atingiu o limite de :limit arquivos para esta entidade',
            'upgrade'   => 'Atualize para uma campanha premium para anexar até :limit arquivos e desbloquear ainda mais flexibilidade criativa.',
        ],
    ],
    'create'            => [
        'helper'            => 'Adicione um arquivo a :name. O arquivo será contabilizado no limite de armazenamento da galeria.',
        'success_plural'    => '{1} Arquivo :name adicionado.|[2,*] :count arquivos adicionados.',
        'title'             => 'Novo arquivo para :entity',
    ],
    'destroy'           => [
        'success'   => 'Arquivo :file removido.',
    ],
    'fields'            => [
        'file'  => 'Arquivo',
        'files' => 'Arquivos',
        'name'  => 'Nome do arquivo',
    ],
    'max'               => [
        'title' => 'Limite alcançado',
    ],
    'update'            => [
        'success'   => 'Arquivo :file atualizado.',
        'title'     => 'Atualizar arquivo',
    ],
];
